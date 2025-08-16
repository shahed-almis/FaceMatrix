from datetime import datetime
import mysql.connector
import os
import cv2
import numpy as np
import face_recognition
import pygame

# إعداد pygame mixer
pygame.mixer.init()
alarm_sound = pygame.mixer.Sound('mixkit-classic-alarm-995.wav')

# Establish a database connection
mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="face_recognition_db",
    port=3307,
)

mycursor = mydb.cursor()

# Function to store images in the database
def store_images_in_db(path):
    for filename in os.listdir(path):
        if filename.endswith(".jpg") or filename.endswith(".png"):
            image_path = os.path.join(path, filename)

            # Read the image file as binary data
            with open(image_path, "rb") as file:
                binary_data = file.read()

            name, ref_no = filename.split(".")[0], filename.split(".")[1]

            sql = "INSERT INTO faces (name, ref_no, data) VALUES (%s, %s, %s)"
            val = (name, ref_no, binary_data)
            try:
                mycursor.execute(sql, val)
                mydb.commit()
                print(f"Inserted {filename} into the database.")
            except mysql.connector.Error as err:
                print(f"Error: {err}")

# Uncomment this line if you need to store images in the database
# store_images_in_db('path_to_your_images')

# Function to retrieve and process images for face recognition
def retrieve_and_process_images():
    mycursor.execute("SELECT name, ref_no, id, data FROM faces")
    results = mycursor.fetchall()

    images = []
    classNames = []
    ref_nos = []
    ids = []

    for row in results:
        ref_no = row[1]
        name = row[0]
        image_data = row[3]
        face_id = row[2]

        if image_data is not None:
            np_image = np.frombuffer(image_data, dtype=np.uint8)
            img = cv2.imdecode(np_image, cv2.IMREAD_COLOR)

            if img is not None:
                images.append(img)
                classNames.append(name)
                ref_nos.append(ref_no)
                ids.append(face_id)

    return images, classNames, ref_nos, ids

def findEncodings(images):
    encodeList = []
    for img in images:
        img = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
        img = cv2.GaussianBlur(img, (5, 5), 0)
        encode = face_recognition.face_encodings(img)
        if encode:
            encodeList.append(encode[0])
    return encodeList

# استرجاع الصور وتشفيرها
images, classNames, ref_nos, ids = retrieve_and_process_images()
encodeListKnown = findEncodings(images)
print('Encoding Complete.')

# Real-time face recognition
cap = cv2.VideoCapture(0)

if not cap.isOpened():
    print("Error: Could not open camera.")
else:
    recognized_toggle = True
    unrecognized_toggle = True
    threshold = 0.7

    while True:
        success, img = cap.read()
        if not success:
            print("Error: Failed to capture image.")
            break

        imgS = cv2.resize(img, (0, 0), None, 0.25, 0.25)
        imgS = cv2.cvtColor(imgS, cv2.COLOR_BGR2RGB)

        faceCurentFrame = face_recognition.face_locations(imgS, model="cnn")
        encodeCurentFrame = face_recognition.face_encodings(imgS, faceCurentFrame)

        for encodeface, faceLoc in zip(encodeCurentFrame, faceCurentFrame):
            matches = face_recognition.compare_faces(encodeListKnown, encodeface)
            faceDis = face_recognition.face_distance(encodeListKnown, encodeface)

            if len(faceDis) > 0:
                matchIndex = np.argmin(faceDis)
                if matches[matchIndex] and faceDis[matchIndex] < threshold:
                    name = classNames[matchIndex].upper()
                    face_id = ids[matchIndex]  
                    y1, x2, y2, x1 = faceLoc
                    y1, x2, y2, x1 = y1 * 4, x2 * 4, y2 * 4, x1 * 4
                    cv2.rectangle(img, (x1, y1), (x2, y2), (0, 255, 0), 2)
                    cv2.rectangle(img, (x1, y2 - 35), (x2, y2), (0, 255, 0), cv2.FILLED)
                    cv2.putText(img, name, (x1 + 6, y2 - 6), cv2.FONT_HERSHEY_COMPLEX, 1, (255, 255, 255), 2)

                    category = "ENTER" if recognized_toggle else "LEAVE"
                    recognized_toggle = not recognized_toggle

                    snapshot = cv2.imencode('.jpg', img)[1].tobytes()


                    sql = "INSERT INTO recognized_faces (face_id, snapshot, category) VALUES (%s, %s, %s)"
                    val = (face_id, snapshot, category)
                    try:
                        mycursor.execute(sql, val)
                        mydb.commit()
                        print(f"Inserted recognized face for {name} into recognized_faces with category '{category}'.")
                    except mysql.connector.Error as err:
                        print(f"Error: {err}")

                else:
                    # Capture snapshot of the unknown face
                    y1, x2, y2, x1 = faceLoc
                    y1, x2, y2, x1 = y1 * 4, x2 * 4, y2 * 4, x1 * 4
                    cv2.rectangle(img, (x1, y1), (x2, y2), (0, 0, 255), 2)
                    cv2.rectangle(img, (x1, y2 - 35), (x2, y2), (0, 0, 255), cv2.FILLED)
                    cv2.putText(img, "Unknown", (x1 + 6, y2 - 6), cv2.FONT_HERSHEY_COMPLEX, 1, (255, 255, 255), 2)

                    alarm_sound.play()

                    category = "ENTER" if unrecognized_toggle else "LEAVE"
                    unrecognized_toggle = not unrecognized_toggle

                    snapshot = cv2.imencode('.jpg', img)[1].tobytes()

                    sql = "INSERT INTO unrecognized_faces (snapshot, category) VALUES (%s, %s)"
                    val = (snapshot, category)
                    try:
                        mycursor.execute(sql, val)
                        mydb.commit()
                        print("Inserted unrecognized face into unrecognized_faces.")
                    except mysql.connector.Error as err:
                        print(f"Error: {err}")

        cv2.namedWindow('Face Recognition', cv2.WINDOW_NORMAL)
        cv2.imshow('Face Recognition', img)
        if cv2.waitKey(1) & 0xFF == ord('q'):
            break

cap.release()
cv2.destroyAllWindows()

mycursor.close()
mydb.close()