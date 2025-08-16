package com.mycompany.smartattendance.services;

import com.mycompany.smartattendance.UnrecognitionCategory;
import com.mycompany.smartattendance.entities.UnrecognizedFace;
import jakarta.ejb.Stateless;
import jakarta.persistence.EntityManager;
import jakarta.persistence.PersistenceContext;
import java.util.Date;
import java.util.List;

@Stateless
public class UnrecognizedFaceFacade extends AbstractFacade<UnrecognizedFace> {

   @PersistenceContext(unitName = "my_persistence_unit")
   private EntityManager em;

   @Override
   protected EntityManager getEntityManager() {
      return em;
   }
   
   public UnrecognizedFaceFacade() {
       super(UnrecognizedFace.class);
   }
   
   
   @Override
   public List<UnrecognizedFace> findAll() {
       return em.createNamedQuery("UnrecognizedFace.findAll", UnrecognizedFace.class).getResultList();
   }

    public UnrecognizedFace findById(Integer id) {
        return em.find(UnrecognizedFace.class, id);
    }
   
    public List<UnrecognizedFace> findByDates(Date from, Date to) {
      return em.createNamedQuery("UnrecognizedFace.findByDates", UnrecognizedFace.class)
          .setParameter("startDate", from)
          .setParameter("endDate", to)
          .getResultList();
   }
//-----------------------------------------------------------------------------------------------------------------------------
//جلب الدخول محصور بين فترتين
    public List<UnrecognizedFace> findEntriesByDate(Date from, Date to) {
    return em.createNamedQuery("UnrecognizedFace.findEntriesByDate", UnrecognizedFace.class)
             .setParameter("category", UnrecognitionCategory.ENTER)
             .setParameter("startDate", from)
             .setParameter("endDate", to)
             .getResultList();
}
//-----------------------------------------------------------------------------------------------------------------------------
//جلب الخروج محصور بين فترتين    
    public List<UnrecognizedFace> findLeavesByDate(Date from, Date to) {
    return em.createNamedQuery("UnrecognizedFace.findLeavesByDate", UnrecognizedFace.class)
             .setParameter("category", UnrecognitionCategory.LEAVE)
             .setParameter("startDate", from)
             .setParameter("endDate", to)
             .getResultList();
}
//-----------------------------------------------------------------------------------------------------------------------------
    public long countEntriesByDates(Date from, Date to, UnrecognitionCategory category) {
    return em.createNamedQuery("UnrecognizedFace.countByDates", Long.class)
        .setParameter("startDate", from)
        .setParameter("endDate", to)
        .setParameter("category", UnrecognitionCategory.ENTER)
        .getSingleResult();
}
}