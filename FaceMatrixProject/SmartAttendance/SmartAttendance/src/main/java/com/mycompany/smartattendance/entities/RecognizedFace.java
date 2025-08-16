package com.mycompany.smartattendance.entities;

import com.mycompany.smartattendance.RecognitionCategory;
import jakarta.json.bind.annotation.JsonbTransient;
import jakarta.persistence.Basic;
import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.EnumType;
import jakarta.persistence.Enumerated;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.JoinColumn;
import jakarta.persistence.Lob;
import jakarta.persistence.ManyToOne;
import jakarta.persistence.NamedQueries;
import jakarta.persistence.NamedQuery;
import jakarta.persistence.Table;
import jakarta.persistence.Temporal;
import jakarta.persistence.TemporalType;
import jakarta.validation.constraints.NotNull;
import jakarta.xml.bind.annotation.XmlAccessType;
import jakarta.xml.bind.annotation.XmlAccessorType;
import jakarta.xml.bind.annotation.XmlElement;
import jakarta.xml.bind.annotation.XmlRootElement;
import jakarta.xml.bind.annotation.XmlTransient;
import java.io.Serializable;
import java.util.Date;


@Entity
@Table(name = "recognized_faces")
@NamedQueries({
   @NamedQuery(name = "RecognizedFace.findAll", query = "SELECT r FROM RecognizedFace r"),
   @NamedQuery(name = "RecognizedFace.findById", query = "SELECT r FROM RecognizedFace r WHERE r.id = :id"),
   @NamedQuery(name = "RecognizedFace.findByFace", query = "SELECT r FROM RecognizedFace r WHERE r.face = :face ORDER BY r.dateTime DESC"),
   @NamedQuery(name = "RecognizedFace.findByDates", query = "SELECT r FROM RecognizedFace r WHERE r.dateTime BETWEEN :startDate AND :endDate ORDER BY r.dateTime DESC"),
   @NamedQuery(name = "RecognizedFace.findByDateTime", query = "SELECT r FROM RecognizedFace r WHERE r.dateTime = :dateTime"),
   @NamedQuery(name = "RecognizedFace.findByCategory", query = "SELECT r FROM RecognizedFace r WHERE r.category = :category"),
   @NamedQuery(name = "RecognizedFace.findAllEntriesByDate", query = "SELECT r FROM RecognizedFace r WHERE r.category = :category AND r.dateTime BETWEEN :startDate AND :endDate ORDER BY r.dateTime DESC"),   
   @NamedQuery(name = "RecognizedFace.findAllLeavesByDate", query = "SELECT r FROM RecognizedFace r WHERE r.category = :category AND r.dateTime BETWEEN :startDate AND :endDate ORDER BY r.dateTime DESC"),
   @NamedQuery(name = "RecognizedFace.findEntriesAndLeavesByFace", query = "SELECT r FROM RecognizedFace r WHERE r.face = :face AND r.dateTime BETWEEN :startDate AND :endDate ORDER BY r.dateTime DESC"),
   @NamedQuery(name = "RecognizedFace.findEntriesByFaceAndDate", query = "SELECT r FROM RecognizedFace r WHERE r.face = :face AND r.category = :category AND r.dateTime BETWEEN :startDate AND :endDate ORDER BY r.dateTime DESC"),
   @NamedQuery(name = "RecognizedFace.findLeavesByFaceAndDate", query = "SELECT r FROM RecognizedFace r WHERE r.face = :face AND r.category = :category AND r.dateTime BETWEEN :startDate AND :endDate ORDER BY r.dateTime DESC"),
   @NamedQuery(name = "RecognizedFace.countEntriesByDates", query = "SELECT COUNT(r) FROM RecognizedFace r WHERE r.category = :entryCategory AND r.dateTime BETWEEN :startDate AND :endDate")})

@XmlAccessorType(XmlAccessType.FIELD)
@XmlRootElement(name = "recognizedFace")
public class RecognizedFace implements Serializable {

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
   @Column(name = "date_time")
   @Temporal(TemporalType.TIMESTAMP)
   @XmlElement(required = true)
   private Date dateTime;
   @XmlTransient
   @JsonbTransient
   @Basic(optional = false)
   @NotNull
   @Lob
   @Column(name = "snapshot")
   private byte[] snapshot;
   @Column(name = "category")
   @Enumerated(EnumType.STRING)
   @XmlElement(required = true)
   private RecognitionCategory category;
   @JoinColumn(name = "face_id", referencedColumnName = "id")
   @ManyToOne(optional = false)
   @XmlElement(name = "identity")
   private Face face;

   public RecognizedFace() {
   }

   public RecognizedFace(Integer id) {
      this.id = id;
   }

   public RecognizedFace(Integer id, Date dateTime, byte[] snapshot) {
      this.id = id;
      this.dateTime = dateTime;
      this.snapshot = snapshot;
   }

   public Integer getId() {
      return id;
   }

   public void setId(Integer id) {
      this.id = id;
   }

   public Date getDateTime() {
      return dateTime;
   }

   public void setDateTime(Date dateTime) {
      this.dateTime = dateTime;
   }

   public byte[] getSnapshot() {
      return snapshot;
   }

   public void setSnapshot(byte[] snapshot) {
      this.snapshot = snapshot;
   }

   public RecognitionCategory getCategory() {
      return category;
   }

   public void setCategory(RecognitionCategory category) {
      this.category = category;
   }

   public Face getFace() {
      return face;
   }

   public void setFace(Face face) {
      this.face = face;
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
      if (!(object instanceof RecognizedFace)) {
         return false;
      }
      RecognizedFace other = (RecognizedFace) object;
      if ((this.id == null && other.id != null) || (this.id != null && !this.id.equals(other.id))) {
         return false;
      }
      return true;
   }

   @Override
   public String toString() {
      return "com.mycompany.smartattendance.entities.RecognizedFace[ id=" + id + " ]";
   }

}
