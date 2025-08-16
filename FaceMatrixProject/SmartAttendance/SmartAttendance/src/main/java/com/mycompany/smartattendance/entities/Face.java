package com.mycompany.smartattendance.entities;

import jakarta.json.bind.annotation.JsonbTransient;
import jakarta.persistence.Basic;
import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.Lob;
import jakarta.persistence.NamedQueries;
import jakarta.persistence.NamedQuery;
import jakarta.persistence.Table;
import jakarta.validation.constraints.NotNull;
import jakarta.validation.constraints.Size;
import jakarta.xml.bind.annotation.XmlAccessType;
import jakarta.xml.bind.annotation.XmlAccessorType;
import jakarta.xml.bind.annotation.XmlRootElement;
import jakarta.xml.bind.annotation.XmlTransient;
import java.io.Serializable;


@Entity
@Table(name = "faces")
@NamedQueries({
   @NamedQuery(name = "Face.findAll", query = "SELECT f FROM Face f"),
   @NamedQuery(name = "Face.findById", query = "SELECT f FROM Face f WHERE f.id = :id"),
   @NamedQuery(name = "Face.findByRefNo", query = "SELECT f FROM Face f WHERE f.refNo = :refNo"),
   @NamedQuery(name = "Face.findByName", query = "SELECT f FROM Face f WHERE f.name = :name")})

@XmlAccessorType(XmlAccessType.FIELD)
@XmlRootElement(name = "face")
public class Face implements Serializable {

   private static final long serialVersionUID = 1L;
   @Id
   @GeneratedValue(strategy = GenerationType.IDENTITY)
   @Basic(optional = false)
   @Column(name = "id")
   @XmlTransient
   @JsonbTransient
   private Integer id;
   @Basic(optional = false)
   @NotNull
   @Size(min = 1, max = 20)
   @Column(name = "ref_no")
   private String refNo;
   @Basic(optional = false)
   @NotNull
   @Size(min = 1, max = 50)
   @Column(name = "name")
   private String name;
   @XmlTransient
   @JsonbTransient

   @Basic(optional = false)
   @NotNull
   @Lob
   @Column(name = "data")
   private byte[] data;

   public Face() {
   }

   public Face(Integer id) {
      this.id = id;
   }

   public Face(Integer id, String refNo, String name, byte[] data) {
      this.id = id;
      this.refNo = refNo;
      this.name = name;
      this.data = data;
   }

   public Integer getId() {
      return id;
   }

   public void setId(Integer id) {
      this.id = id;
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

   public byte[] getData() {
      return data;
   }

   public void setData(byte[] data) {
      this.data = data;
   }


   @Override
   public int hashCode() {
      int hash = 0;
      hash += (id != null ? id.hashCode() : 0);
      return hash;
   }

   @Override
   public boolean equals(Object object) {
      // TODO: Warning - this method won't work in the case the id fields are not set
      if (!(object instanceof Face)) {
         return false;
      }
      Face other = (Face) object;
      if ((this.id == null && other.id != null) || (this.id != null && !this.id.equals(other.id))) {
         return false;
      }
      return true;
   }

   @Override
   public String toString() {
      return "com.mycompany.smartattendance.entities.Face[ id=" + id + " ]";
   }

}
