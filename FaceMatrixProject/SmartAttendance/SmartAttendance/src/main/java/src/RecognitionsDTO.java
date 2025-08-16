package src;

import com.mycompany.smartattendance.entities.RecognizedFace;
import jakarta.xml.bind.annotation.XmlAccessType;
import jakarta.xml.bind.annotation.XmlAccessorType;
import jakarta.xml.bind.annotation.XmlElement;
import jakarta.xml.bind.annotation.XmlRootElement;
import java.util.List;

@XmlAccessorType(XmlAccessType.FIELD)
@XmlRootElement(name = "recognitions")
public class RecognitionsDTO {
   @XmlElement(name="recognizedFace")
   private List<RecognizedFace> list;

   public RecognitionsDTO() {
   }

   public RecognitionsDTO(List<RecognizedFace> list) {
      this.list = list;
   }

   public List<RecognizedFace> getList() {
      return list;
   }

   public void setList(List<RecognizedFace> list) {
      this.list = list;
   }

   @Override
   public String toString() {
      return "AttendanceDTO{" + "list=" + list + '}';
   }

}
