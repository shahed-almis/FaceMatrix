package src;

import jakarta.json.bind.annotation.*;
import java.util.Date;


public class KnownFace {
   @JsonbTransient
   private int faceId;
   private String refNo;
   private String name;
   @JsonbDateFormat(value = "MMM d, yyyy, h:mm:ss a")
   private Date stamestamp;

   public KnownFace() {
   }

   public KnownFace(int faceId, String refNo, String name, Date stamestamp) {
      this.faceId = faceId;
      this.refNo = refNo;
      this.name = name;
      this.stamestamp = stamestamp;
   }

   public int getFaceId() {
      return faceId;
   }

   public void setFaceId(int faceId) {
      this.faceId = faceId;
   }

   public String getRefNo() {
      return refNo;
   }

   public void setRefNo(String refNo) {
      this.refNo = refNo;
   }

   public String getName() {
      return name;
   }

   public void setName(String name) {
      this.name = name;
   }

   public Date getStamestamp() {
      return stamestamp;
   }

   public void setStamestamp(Date stamestamp) {
      this.stamestamp = stamestamp;
   }

   @Override
   public String toString() {
      return "KnownFace{" + "faceId=" + faceId + ", refNo=" + refNo + ", name=" + name + ", stamestamp=" + stamestamp + '}';
   }

   @Override
   public int hashCode() {
      int hash = 7;
      hash = 53 * hash + this.faceId;
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
      final KnownFace other = (KnownFace) obj;
      return this.faceId == other.faceId;
   }
   
}
