package src;

import com.mycompany.smartattendance.entities.UnrecognizedFace;
import jakarta.xml.bind.annotation.XmlAccessType;
import jakarta.xml.bind.annotation.XmlAccessorType;
import jakarta.xml.bind.annotation.XmlElement;
import jakarta.xml.bind.annotation.XmlRootElement;
import java.util.List;

@XmlAccessorType(XmlAccessType.FIELD)
@XmlRootElement(name = "unrecognitions")
public class UnrecognitionsDTO {
   @XmlElement(name="unrecognizedFace")
   private List<UnrecognizedFace> list;

   public UnrecognitionsDTO() {
   }

   public UnrecognitionsDTO(List<UnrecognizedFace> list) {
      this.list = list;
   }

   public List<UnrecognizedFace> getList() {
      return list;
   }

   public void setList(List<UnrecognizedFace> list) {
      this.list = list;
   }

   @Override
   public String toString() {
      return "AttendanceDTO{" + "list=" + list + '}';
   }

}
