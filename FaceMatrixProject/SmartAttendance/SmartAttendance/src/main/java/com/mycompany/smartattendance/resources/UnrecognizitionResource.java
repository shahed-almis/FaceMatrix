package com.mycompany.smartattendance.resources;

import com.mycompany.smartattendance.UnrecognitionCategory;
import com.mycompany.smartattendance.entities.UnrecognizedFace;
import com.mycompany.smartattendance.services.UnrecognizedFaceFacade;
import jakarta.ejb.EJB;
import jakarta.ws.rs.GET;
import jakarta.ws.rs.Path;
import jakarta.ws.rs.PathParam;
import jakarta.ws.rs.Produces;
import jakarta.ws.rs.WebApplicationException;
import jakarta.ws.rs.core.MediaType;
import jakarta.ws.rs.core.Response;
import jakarta.ws.rs.core.Response.Status;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.List;
import src.UnrecognitionsDTO;

@Path("unknownfaces")
public class UnrecognizitionResource {
    
    @EJB
   private UnrecognizedFaceFacade unrecognizedFaceService;
    
     @GET
   public Response ping() {
      return Response
           .ok("ping Jakarta EE")
           .build();
   }
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
   @GET
    @Produces({MediaType.APPLICATION_JSON, MediaType.APPLICATION_XML})
    public Response getAllUnknownFaces() {
        List<UnrecognizedFace> unknownFaces = unrecognizedFaceService.findAll();
        if (unknownFaces.isEmpty()) {
            return Response.status(Response.Status.NO_CONTENT).build();
        }
        return Response.ok(unknownFaces).build();
    }
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
@GET
@Produces({MediaType.APPLICATION_JSON})
@Path("unknown/{id}")
public Response findUnknownFace(@PathParam(value = "id") int id) {
    System.out.println("Searching for UnknownFace with ID: " + id);
    
    UnrecognizedFace unknownFace = unrecognizedFaceService.findById(id);
    if (unknownFace == null) {
        return Response.status(Status.NOT_FOUND).entity("Unknown face not found!").build();
    }
    return Response.ok(unknownFace).build();
}
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
   // جلب قائمة حركة الدخول والخروج المحصورة بين توقيتين
   @GET
   @Produces({MediaType.APPLICATION_JSON, MediaType.APPLICATION_XML})
   @Path("/unknown/{from}/{to}")
   public Response findAttendees(@PathParam(value = "from") String startTimestamp, @PathParam(value = "to") String endTimestamp) {
      SimpleDateFormat sdf = new SimpleDateFormat("dd-MM-yyyy HH:mm:ss");
      Date startDatetime, endDatetime;
      System.out.println("From: " + startTimestamp);
      System.out.println("To: " + endTimestamp);
      try {
         startDatetime = sdf.parse(startTimestamp);
         endDatetime = sdf.parse(endTimestamp);
      } catch (ParseException pe) {
         throw new WebApplicationException(pe.getMessage());
      }
      System.out.println("From: " + startDatetime);
      System.out.println("To: " + endDatetime);
      UnrecognitionsDTO dto = new UnrecognitionsDTO(unrecognizedFaceService.findByDates(startDatetime, endDatetime));
      if (dto.getList().isEmpty()) {
         return Response.status(Status.NO_CONTENT).build();
      }
      return Response.ok(dto).build();
   }
//-----------------------------------------------------------------------------------------------------------------------------
//جلب الدخول محصور بين فترتين   
@GET
   @Produces({MediaType.APPLICATION_JSON, MediaType.APPLICATION_XML})
   @Path("/unknown/entries/{from}/{to}")
   public Response getUnknownEntriesByDate(@PathParam(value = "from") String startTimestamp, @PathParam(value = "to") String endTimestamp) {
      SimpleDateFormat sdf = new SimpleDateFormat("dd-MM-yyyy HH:mm:ss");
      Date startDatetime, endDatetime;
      System.out.println("From: " + startTimestamp);
      System.out.println("To: " + endTimestamp);
      try {
         startDatetime = sdf.parse(startTimestamp);
         endDatetime = sdf.parse(endTimestamp);
      } catch (ParseException pe) {
         throw new WebApplicationException(pe.getMessage());
      }
      System.out.println("From: " + startDatetime);
      System.out.println("To: " + endDatetime);
      UnrecognitionsDTO dto = new UnrecognitionsDTO(unrecognizedFaceService.findEntriesByDate(startDatetime, endDatetime));
      if (dto.getList().isEmpty()) {
         return Response.status(Status.NO_CONTENT).build();
      }
      return Response.ok(dto).build();
   }
//-----------------------------------------------------------------------------------------------------------------------------
//جلب الخروج محصور بين فترتين
 @GET
   @Produces({MediaType.APPLICATION_JSON, MediaType.APPLICATION_XML})
   @Path("/unknown/leaves/{from}/{to}")
   public Response getUnknownLeavesByDate(@PathParam(value = "from") String startTimestamp, @PathParam(value = "to") String endTimestamp) {
      SimpleDateFormat sdf = new SimpleDateFormat("dd-MM-yyyy HH:mm:ss");
      Date startDatetime, endDatetime;
      System.out.println("From: " + startTimestamp);
      System.out.println("To: " + endTimestamp);
      try {
         startDatetime = sdf.parse(startTimestamp);
         endDatetime = sdf.parse(endTimestamp);
      } catch (ParseException pe) {
         throw new WebApplicationException(pe.getMessage());
      }
      System.out.println("From: " + startDatetime);
      System.out.println("To: " + endDatetime);
      UnrecognitionsDTO dto = new UnrecognitionsDTO(unrecognizedFaceService.findLeavesByDate(startDatetime, endDatetime));
      if (dto.getList().isEmpty()) {
         return Response.status(Status.NO_CONTENT).build();
      }
      return Response.ok(dto).build();
   }
//------------------------------------------------------------------------------------------------------------------------------
//جلب عدد الدخول 
   @GET
@Produces(MediaType.APPLICATION_JSON)
@Path("/unknown/entries/stats/{from}/{to}")
public Response getEntryStats(@PathParam(value = "from") String startTimestamp, 
                               @PathParam(value = "to") String endTimestamp) {
    SimpleDateFormat sdf = new SimpleDateFormat("dd-MM-yyyy HH:mm:ss");
    Date startDatetime, endDatetime;
    try {
        startDatetime = sdf.parse(startTimestamp);
        endDatetime = sdf.parse(endTimestamp);
    } catch (ParseException pe) {
        throw new WebApplicationException(pe.getMessage());
    }
    long entryCount = unrecognizedFaceService.countEntriesByDates(startDatetime, endDatetime, UnrecognitionCategory.ENTER); 
    AttendanceStats stats = new AttendanceStats(entryCount);
    return Response.ok(stats).build();
}
}