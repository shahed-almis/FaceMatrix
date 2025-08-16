package src;

import jakarta.json.bind.annotation.*;
import java.util.Date;

public class UnknownFace {
   @JsonbTransient
   private int id; // معرف الوجه
   @JsonbDateFormat(value = "MMM d, yyyy, h:mm:ss a ") //"MMM d, yyyy, h:mm:ss a"
   private Date datetime; // تاريخ ووقت الالتقاط
   private byte[] snapshot; // صورة الوجه

   public UnknownFace() {
   }

   public UnknownFace(int id, Date datetime, byte[] snapshot) {
      this.id = id;
      this.datetime = datetime;
      this.snapshot = snapshot;
   }

   public int getId() {
      return id;
   }

   public void setId(int id) {
      this.id = id;
   }

   public Date getDatetime() {
      return datetime;
   }

   public void setDatetime(Date datetime) {
      this.datetime = datetime;
   }

   public byte[] getSnapshot() {
      return snapshot;
   }

   public void setSnapshot(byte[] snapshot) {
      this.snapshot = snapshot;
   }

   @Override
   public String toString() {
      return "UnknownFace{" + "id=" + id + ", datetime=" + datetime + '}';
   }

   @Override
   public int hashCode() {
      int hash = 7;
      hash = 53 * hash + this.id;
      return hash;
   }

   @Override
   public boolean equals(Object obj) {
      if (this == obj) {
         return true;
      }
      if (obj == null) {
         return false;
      }
      if (getClass() != obj.getClass()) {
         return false;
      }
      final UnknownFace other = (UnknownFace) obj;
      return this.id == other.id;
   }
}