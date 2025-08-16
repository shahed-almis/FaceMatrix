package com.mycompany.smartattendance;

import jakarta.xml.bind.annotation.XmlEnum;
import jakarta.xml.bind.annotation.XmlEnumValue;
import jakarta.xml.bind.annotation.XmlType;

@XmlType(name = "RecognitionCategory")
@XmlEnum
public enum RecognitionCategory {
   @XmlEnumValue("ENTER")
   ENTER,
   @XmlEnumValue("LEAVE")
   LEAVE;

   public String value() {
      return name();
   }

   public static RecognitionCategory fromValue(String v) {
      return valueOf(v);
   }
}
