package com.mycompany.smartattendance.entities;

import com.mycompany.smartattendance.UnrecognitionCategory;
import jakarta.json.bind.annotation.JsonbTransient;
import jakarta.persistence.Basic;
import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.EnumType;
import jakarta.persistence.Enumerated;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.Lob;
import jakarta.persistence.NamedQueries;
import jakarta.persistence.NamedQuery;
import jakarta.persistence.Table;
import jakarta.persistence.Temporal;
import jakarta.persistence.TemporalType;
import jakarta.validation.constraints.NotNull;
import jakarta.xml.bind.annotation.XmlRootElement;
import jakarta.xml.bind.annotation.XmlTransient;
import java.io.Serializable;
import java.util.Date;

/**
 *
 * @author Nasser Diaf <nasser.diaf@arj.ly>
 */
@Entity
@Table(name = "unrecognized_faces")
@XmlRootElement
@NamedQueries({
   @NamedQuery(name = "UnrecognizedFace.findAll", query = "SELECT u FROM UnrecognizedFace u"),
   @NamedQuery(name = "UnrecognizedFace.findById", query = "SELECT u FROM UnrecognizedFace u WHERE u.id = :id"),
   @NamedQuery(name = "UnrecognizedFace.findByDates", query = "SELECT u FROM UnrecognizedFace u WHERE u.dateTime BETWEEN :startDate AND :endDate"),
   @NamedQuery(name = "UnrecognizedFace.findByDateTime", query = "SELECT u FROM UnrecognizedFace u WHERE u.dateTime = :dateTime"),
   @NamedQuery(name = "UnrecognizedFace.findEntriesByDate", query = "SELECT u FROM UnrecognizedFace u WHERE u.category = :category AND u.dateTime BETWEEN :startDate AND :endDate"),   @NamedQuery(name = "UnrecognizedFace.findLeavesByDate", query = "SELECT u FROM UnrecognizedFace u WHERE u.category = :category AND u.dateTime BETWEEN :startDate AND :endDate"),
   @NamedQuery(name = "UnrecognizedFace.countByDates", query = "SELECT COUNT(u) FROM UnrecognizedFace u WHERE u.dateTime BETWEEN :startDate AND :endDate AND u.category = :category")})

public class UnrecognizedFace implements Serializable {

   private static final long serialVersionUID = 1L;
   @Id
   @GeneratedValue(strategy = GenerationType.IDENTITY)
   @Basic(optional = false)
   @Column(name = "id")
   private Integer id;
   @Basic(optional = false)
   @NotNull
   @Column(name = "date_time")
   @Temporal(TemporalType.TIMESTAMP)
   private Date dateTime;
   @Column(name = "category")
   @Enumerated(EnumType.STRING)
   private UnrecognitionCategory category;
   @XmlTransient
   @JsonbTransient
   @Basic(optional = false)
   @NotNull
   @Lob
   @Column(name = "snapshot")
   private byte[] snapshot;

   public UnrecognizedFace() {
   }

   public UnrecognizedFace(Integer id) {
      this.id = id;
   }

   public UnrecognizedFace(Integer id, Date dateTime, byte[] snapshot) {
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

   public UnrecognitionCategory getCategory() {
      return category;
   }

   public void setCategory(UnrecognitionCategory category) {
      this.category = category;
   }

   public byte[] getSnapshot() {
      return snapshot;
   }

   public void setSnapshot(byte[] snapshot) {
      this.snapshot = snapshot;
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
      if (!(object instanceof UnrecognizedFace)) {
         return false;
      }
      UnrecognizedFace other = (UnrecognizedFace) object;
      if ((this.id == null && other.id != null) || (this.id != null && !this.id.equals(other.id))) {
         return false;
      }
      return true;
   }

   @Override
   public String toString() {
      return "com.mycompany.smartattendance.entities.UnrecognizedFace[ id=" + id + " ]";
   }

}
