package com.mycompany.smartattendance.services;

import com.mycompany.smartattendance.entities.Face;
import jakarta.ejb.Stateless;
import jakarta.persistence.EntityManager;
import jakarta.persistence.NoResultException;
import jakarta.persistence.PersistenceContext;


@Stateless
public class FaceFacade extends AbstractFacade<Face> {

   @PersistenceContext(unitName = "my_persistence_unit")
   private EntityManager em;

   @Override
   protected EntityManager getEntityManager() {
      return em;
   }

   public FaceFacade() {
      super(Face.class);
   }

   public Face findByRefNo(String refNo) {
      try {
         return em.createNamedQuery("Face.findByRefNo", Face.class)
              .setParameter("refNo", refNo).getSingleResult();
      } catch (NoResultException nre) {
         return null;
      }
   }
}
