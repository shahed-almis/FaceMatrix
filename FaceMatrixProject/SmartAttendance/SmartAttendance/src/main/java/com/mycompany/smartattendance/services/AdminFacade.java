package com.mycompany.smartattendance.services;

import com.mycompany.smartattendance.entities.Admin;
import jakarta.ejb.Stateless;
import jakarta.persistence.EntityManager;
import jakarta.persistence.PersistenceContext;


@Stateless
public class AdminFacade extends AbstractFacade<Admin> {

   @PersistenceContext(unitName = "my_persistence_unit")
   private EntityManager em;

   @Override
   protected EntityManager getEntityManager() {
      return em;
   }

   public AdminFacade() {
      super(Admin.class);
   }

}
