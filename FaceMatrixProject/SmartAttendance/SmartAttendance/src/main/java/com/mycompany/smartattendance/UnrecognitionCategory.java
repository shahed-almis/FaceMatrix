package com.mycompany.smartattendance;

import jakarta.xml.bind.annotation.XmlEnum;
import jakarta.xml.bind.annotation.XmlEnumValue;
import jakarta.xml.bind.annotation.XmlType;



@XmlType(name = "UnrecognizedFaceCategory")
@XmlEnum
public enum UnrecognitionCategory {
   @XmlEnumValue("ENTER")
   ENTER,
   @XmlEnumValue("LEAVE")
   LEAVE;

   public String value() {
      return name();
   }

   public static UnrecognitionCategory fromValue(String v) {
      return valueOf(v);
   }
}

