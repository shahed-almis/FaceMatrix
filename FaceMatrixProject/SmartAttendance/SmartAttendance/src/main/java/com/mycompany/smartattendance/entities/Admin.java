package com.mycompany.smartattendance.entities;

import jakarta.persistence.Basic;
import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.Id;
import jakarta.persistence.NamedQueries;
import jakarta.persistence.NamedQuery;
import jakarta.persistence.Table;
import jakarta.validation.constraints.NotNull;
import jakarta.validation.constraints.Size;
import jakarta.xml.bind.annotation.XmlRootElement;
import java.io.Serializable;


@Entity
@Table(name = "admins")
@XmlRootElement
@NamedQueries({
   @NamedQuery(name = "Admin.findAll", query = "SELECT a FROM Admin a"),
   @NamedQuery(name = "Admin.findByLoginName", query = "SELECT a FROM Admin a WHERE a.loginName = :loginName"),
   @NamedQuery(name = "Admin.findByFullName", query = "SELECT a FROM Admin a WHERE a.fullName = :fullName"),
   @NamedQuery(name = "Admin.findByPhoneNo", query = "SELECT a FROM Admin a WHERE a.phoneNo = :phoneNo"),
   @NamedQuery(name = "Admin.findByEmail", query = "SELECT a FROM Admin a WHERE a.email = :email"),
   @NamedQuery(name = "Admin.findByPassword", query = "SELECT a FROM Admin a WHERE a.password = :password")})
public class Admin implements Serializable {

   private static final long serialVersionUID = 1L;
   @Id
   @Basic(optional = false)
   @NotNull
   @Size(min = 1, max = 20)
   @Column(name = "login_name")
   private String loginName;
   @Basic(optional = false)
   @NotNull
   @Size(min = 1, max = 40)
   @Column(name = "full_name")
   private String fullName;
   @Basic(optional = false)
   @NotNull
   @Size(min = 1, max = 10)
   @Column(name = "phone_no")
   private String phoneNo;
   // @Pattern(regexp="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?", message="Invalid email")//if the field contains email address consider using this annotation to enforce field validation
   @Basic(optional = false)
   @NotNull
   @Size(min = 1, max = 50)
   @Column(name = "email")
   private String email;
   @Basic(optional = false)
   @NotNull
   @Size(min = 64, max = 64)
   @Column(name = "password")
   private String password;

   public Admin() {
   }

   public Admin(String loginName) {
      this.loginName = loginName;
   }

   public Admin(String loginName, String fullName, String phoneNo, String email, String password) {
      this.loginName = loginName;
      this.fullName = fullName;
      this.phoneNo = phoneNo;
      this.email = email;
      this.password = password;
   }

   public String getLoginName() {
      return loginName;
   }

   public void setLoginName(String loginName) {
      this.loginName = loginName;
   }

   public String getFullName() {
      return fullName;
   }

   public void setFullName(String fullName) {
      this.fullName = fullName;
   }

   public String getPhoneNo() {
      return phoneNo;
   }

   public void setPhoneNo(String phoneNo) {
      this.phoneNo = phoneNo;
   }

   public String getEmail() {
      return email;
   }

   public void setEmail(String email) {
      this.email = email;
   }

   public String getPassword() {
      return password;
   }

   public void setPassword(String password) {
      this.password = password;
   }

   @Override
   public int hashCode() {
      int hash = 0;
      hash += (loginName != null ? loginName.hashCode() : 0);
      return hash;
   }

   @Override
   public boolean equals(Object object) {
      // TODO: Warning - this method won't work in the case the id fields are not set
      if (!(object instanceof Admin)) {
         return false;
      }
      Admin other = (Admin) object;
      if ((this.loginName == null && other.loginName != null) || (this.loginName != null && !this.loginName.equals(other.loginName))) {
         return false;
      }
      return true;
   }

   @Override
   public String toString() {
      return "com.mycompany.smartattendance.entities.Admin[ loginName=" + loginName + " ]";
   }

}
