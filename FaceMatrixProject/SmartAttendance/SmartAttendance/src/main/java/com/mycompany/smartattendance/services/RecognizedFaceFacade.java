package com.mycompany.smartattendance.services;

import com.mycompany.smartattendance.RecognitionCategory;
import com.mycompany.smartattendance.entities.Face;
import com.mycompany.smartattendance.entities.RecognizedFace;
import jakarta.ejb.Stateless;
import jakarta.persistence.EntityManager;
import jakarta.persistence.PersistenceContext;
import java.util.Date;
import java.util.List;


@Stateless
public class RecognizedFaceFacade extends AbstractFacade<RecognizedFace> {

   @PersistenceContext(unitName = "my_persistence_unit")
   private EntityManager em;

   @Override
   protected EntityManager getEntityManager() {
      return em;
   }

   public RecognizedFaceFacade() {
      super(RecognizedFace.class);
   }

   public List<RecognizedFace> findByFace(Face face) {
      return em.createNamedQuery("RecognizedFace.findByFace", RecognizedFace.class)
          .setParameter("face", face).getResultList();
   }

   public List<RecognizedFace> findByDates(Date from, Date to) {
      return em.createNamedQuery("RecognizedFace.findByDates", RecognizedFace.class)
          .setParameter("startDate", from).setParameter("endDate", to).getResultList();
   }
   
//---------------------------------------------------------------------------------------------------------------------------
//جلب الدخول فقط محصور بين فترتين
   public List<RecognizedFace> findAllEntriesByDate(Date from, Date to) {
    return em.createNamedQuery("RecognizedFace.findAllEntriesByDate", RecognizedFace.class)
        .setParameter("category", RecognitionCategory.ENTER)
        .setParameter("startDate", from)
        .setParameter("endDate", to)
        .getResultList();
}
//----------------------------------------------------------------------------------------------------------------------
//جلب الخروج فقط محصور بين فترتين
   public List<RecognizedFace> findAllLeavesByDate(Date from, Date to) {
    return em.createNamedQuery("RecognizedFace.findAllLeavesByDate", RecognizedFace.class)
        .setParameter("category", RecognitionCategory.LEAVE)
        .setParameter("startDate", from)
        .setParameter("endDate", to)
        .getResultList();
}
//-------------------------------------------------------------------------------------------------------------------------------
//جلب دخول وخروج شخصية معينة محصور بين فترتين
   public List<RecognizedFace> findEntriesAndLeavesByFace(Face face, Date from, Date to) {
    return em.createNamedQuery("RecognizedFace.findEntriesAndLeavesByFace", RecognizedFace.class)
        .setParameter("face", face)
        .setParameter("startDate", from)
        .setParameter("endDate", to)
        .getResultList();
}
//-------------------------------------------------------------------------------------------------------------------------------
//جلب دخول فقط لشخصية معينة محصور بين فترتين   
   public List<RecognizedFace> findEntriesByFaceAndDate(Face face, Date from, Date to) {
    return em.createNamedQuery("RecognizedFace.findEntriesByFaceAndDate", RecognizedFace.class)
        .setParameter("face", face)
        .setParameter("category", RecognitionCategory.ENTER)
        .setParameter("startDate", from)
        .setParameter("endDate", to)
        .getResultList();
}
//-------------------------------------------------------------------------------------------------------------------------------
//جلب خروج فقط لشخصية معينة محصور بين فترتين
   public List<RecognizedFace> findLeavesByFaceAndDate(Face face, Date from, Date to) {
    return em.createNamedQuery("RecognizedFace.findLeavesByFaceAndDate", RecognizedFace.class)
        .setParameter("face", face)
        .setParameter("category", RecognitionCategory.LEAVE)
        .setParameter("startDate", from)
        .setParameter("endDate", to)
        .getResultList();
}
//----------------------------------------------------------------------------------------------------------------------
//   جلب عدد ايام الدخول
public long countEntriesByDates(Date from, Date to, RecognitionCategory ENTERING) {
    return em.createNamedQuery("RecognizedFace.countEntriesByDates", Long.class)
        .setParameter("startDate", from)
        .setParameter("endDate", to)
        .setParameter("entryCategory", RecognitionCategory.ENTER) 
        .getSingleResult();
    }
//------------------------------------------------------------------------------------------------------------------------------
//جلب عدد ايام ظهور
public long countDaysByFaceAndDates(Face face, Date from, Date to) {
    return em.createQuery("SELECT COUNT(DISTINCT FUNCTION('DATE', r.dateTime)) FROM RecognizedFace r WHERE r.face = :face AND r.dateTime BETWEEN :startDate AND :endDate", Long.class)
        .setParameter("face", face)
        .setParameter("startDate", from)
        .setParameter("endDate", to)
        .getSingleResult();
}
}