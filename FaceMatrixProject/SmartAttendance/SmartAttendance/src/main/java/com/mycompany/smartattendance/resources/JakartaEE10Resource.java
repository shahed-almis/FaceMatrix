package com.mycompany.smartattendance.resources;

import com.mycompany.smartattendance.RecognitionCategory;
import com.mycompany.smartattendance.entities.Face;
import com.mycompany.smartattendance.entities.RecognizedFace;
import com.mycompany.smartattendance.services.FaceFacade;
import com.mycompany.smartattendance.services.RecognizedFaceFacade;
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
import java.time.temporal.ChronoUnit;
import java.util.Date;
import java.util.List;
import src.RecognitionsDTO;

@Path("knownfaces")
public class JakartaEE10Resource {

   @EJB
   private FaceFacade faceService;
   @EJB
   private RecognizedFaceFacade recognizedFaceService;

   //-------------------------------------------------------------------------------------------------------------------
   @GET
   public Response ping() {
      return Response
           .ok("ping Jakarta EE")
           .build();
   }

   //-------------------------------------------------------------------------------------------------------------------
   // جلب معلومات الهوية بدلالة الرقم المرجعي
   @GET
   @Produces({MediaType.TEXT_PLAIN})
   @Path("{ref_no}")
   public Response findFace(@PathParam(value = "ref_no") String ref_no) {
      Face face = faceService.findByRefNo(ref_no);
      if (face == null) {
         return Response.status(Status.NOT_FOUND).entity("Face not found!").build();
      }
      return Response.ok(face.getName()).build();
   }

   //-------------------------------------------------------------------------------------------------------------------
   // جلب دخولات وخروج شخص بدلالة رقمه المرجعي
   @GET
   @Produces({MediaType.APPLICATION_JSON, MediaType.APPLICATION_XML})
   @Path("/attendance/{ref_no}")
   public Response findAttendance(@PathParam(value = "ref_no") String ref_no) {
      Face face = faceService.findByRefNo(ref_no);
      if (face == null) {
         return Response.status(Status.NOT_FOUND).entity("RefNo not found!").build();
      }
      RecognitionsDTO dto = new RecognitionsDTO(recognizedFaceService.findByFace(face));
      if (dto.getList().isEmpty()) {
         return Response.status(Status.NO_CONTENT).build();
      }
      return Response.ok(dto).build();
   }

   //-------------------------------------------------------------------------------------------------------------------
   // جلب قائمة حركة الدخول والخروج المحصورة بين توقيتين
   @GET
   @Produces({MediaType.APPLICATION_JSON, MediaType.APPLICATION_XML})
   @Path("/attendance/{from}/{to}")
   public Response findAttendees(@PathParam(value = "from") String startTimestamp, @PathParam(value = "to") String endTimestamp) {
      //SimpleDateFormat sdf = new SimpleDateFormat("YYYY-MM-dd'T'HH:mm:ssZ");
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
      RecognitionsDTO dto = new RecognitionsDTO(recognizedFaceService.findByDates(startDatetime, endDatetime));
      if (dto.getList().isEmpty()) {
         return Response.status(Status.NO_CONTENT).build();
      }
      return Response.ok(dto).build();
   }
//-------------------------------------------------------------------------------------------------------------------------------
// جلب الدخول فقط محصور بين فترتين
   @GET
@Produces({MediaType.APPLICATION_JSON, MediaType.APPLICATION_XML})
@Path("/attendance/entries/{from}/{to}")
public Response findAllEntriesByDate(@PathParam(value = "from") String startTimestamp, 
                                     @PathParam(value = "to") String endTimestamp) {
    SimpleDateFormat sdf = new SimpleDateFormat("dd-MM-yyyy HH:mm:ss");
    Date startDatetime, endDatetime;
    try {
        startDatetime = sdf.parse(startTimestamp);
        endDatetime = sdf.parse(endTimestamp);
    } catch (ParseException pe) {
        throw new WebApplicationException(pe.getMessage());
    }

    List<RecognizedFace> entries = recognizedFaceService.findAllEntriesByDate(startDatetime, endDatetime);
    if (entries.isEmpty()) {
        return Response.status(Status.NO_CONTENT).build();
    }

    RecognitionsDTO dto = new RecognitionsDTO(entries);
    return Response.ok(dto).build();
}
//----------------------------------------------------------------------------------------------------------------------
//جلب خروج فقط محصور بين فترتين
@GET
@Produces({MediaType.APPLICATION_JSON, MediaType.APPLICATION_XML})
@Path("/attendance/leaves/{from}/{to}")
public Response findAllLeavesByDate(@PathParam(value = "from") String startTimestamp, 
                                    @PathParam(value = "to") String endTimestamp) {
    SimpleDateFormat sdf = new SimpleDateFormat("dd-MM-yyyy HH:mm:ss");
    Date startDatetime, endDatetime;
    try {
        startDatetime = sdf.parse(startTimestamp);
        endDatetime = sdf.parse(endTimestamp);
    } catch (ParseException pe) {
        throw new WebApplicationException(pe.getMessage());
    }

    List<RecognizedFace> leaves = recognizedFaceService.findAllLeavesByDate(startDatetime, endDatetime);
    if (leaves.isEmpty()) {
        return Response.status(Status.NO_CONTENT).build();
    }

    RecognitionsDTO dto = new RecognitionsDTO(leaves);
    return Response.ok(dto).build();
}
//----------------------------------------------------------------------------------------------------------------------
//جلب دخول والخروج لشخصية معينة محصورة بين فترتين
@GET
@Produces({MediaType.APPLICATION_JSON, MediaType.APPLICATION_XML})
@Path("/attendance/category/{ref_no}/{from}/{to}")
public Response findEntriesAndLeavesByFace(@PathParam(value = "ref_no") String ref_no,
                                           @PathParam(value = "from") String startTimestamp, 
                                           @PathParam(value = "to") String endTimestamp) {
    Face face = faceService.findByRefNo(ref_no);
    if (face == null) {
        return Response.status(Status.NOT_FOUND).entity("Face not found!").build();
    }

    SimpleDateFormat sdf = new SimpleDateFormat("dd-MM-yyyy HH:mm:ss");
    Date startDatetime, endDatetime;
    try {
        startDatetime = sdf.parse(startTimestamp);
        endDatetime = sdf.parse(endTimestamp);
    } catch (ParseException pe) {
        throw new WebApplicationException(pe.getMessage());
    }

    List<RecognizedFace> entriesAndLeaves = recognizedFaceService.findEntriesAndLeavesByFace(face, startDatetime, endDatetime);
    if (entriesAndLeaves.isEmpty()) {
        return Response.status(Status.NO_CONTENT).build();
    }

    RecognitionsDTO dto = new RecognitionsDTO(entriesAndLeaves);
    return Response.ok(dto).build();
}
//----------------------------------------------------------------------------------------------------------------------
//جلب دخول فقط لشخصية معينة محصور بين فترتين
@GET
@Produces({MediaType.APPLICATION_JSON, MediaType.APPLICATION_XML})
@Path("/attendance/entries/{ref_no}/{from}/{to}")
public Response findEntriesByFaceAndDate(@PathParam(value = "ref_no") String ref_no,
                                         @PathParam(value = "from") String startTimestamp, 
                                         @PathParam(value = "to") String endTimestamp) {
    Face face = faceService.findByRefNo(ref_no);
    if (face == null) {
        return Response.status(Status.NOT_FOUND).entity("Face not found!").build();
    }

    SimpleDateFormat sdf = new SimpleDateFormat("dd-MM-yyyy HH:mm:ss");
    Date startDatetime, endDatetime;
    try {
        startDatetime = sdf.parse(startTimestamp);
        endDatetime = sdf.parse(endTimestamp);
    } catch (ParseException pe) {
        throw new WebApplicationException(pe.getMessage());
    }

    List<RecognizedFace> entries = recognizedFaceService.findEntriesByFaceAndDate(face, startDatetime, endDatetime);
    if (entries.isEmpty()) {
        return Response.status(Status.NO_CONTENT).build();
    }

    RecognitionsDTO dto = new RecognitionsDTO(entries);
    return Response.ok(dto).build();
}
//----------------------------------------------------------------------------------------------------------------------
//جلب خروج فقط لشخصية معينة محصور بين فترتين
@GET
@Produces({MediaType.APPLICATION_JSON, MediaType.APPLICATION_XML})
@Path("/attendance/leaves/{ref_no}/{from}/{to}")
public Response findLeavesByFaceAndDate(@PathParam(value = "ref_no") String ref_no,
                                        @PathParam(value = "from") String startTimestamp, 
                                        @PathParam(value = "to") String endTimestamp) {
    Face face = faceService.findByRefNo(ref_no);
    if (face == null) {
        return Response.status(Status.NOT_FOUND).entity("Face not found!").build();
    }

    SimpleDateFormat sdf = new SimpleDateFormat("dd-MM-yyyy HH:mm:ss");
    Date startDatetime, endDatetime;
    try {
        startDatetime = sdf.parse(startTimestamp);
        endDatetime = sdf.parse(endTimestamp);
    } catch (ParseException pe) {
        throw new WebApplicationException(pe.getMessage());
    }

    List<RecognizedFace> leaves = recognizedFaceService.findLeavesByFaceAndDate(face, startDatetime, endDatetime);
    if (leaves.isEmpty()) {
        return Response.status(Status.NO_CONTENT).build();
    }

    RecognitionsDTO dto = new RecognitionsDTO(leaves);
    return Response.ok(dto).build();
}
//----------------------------------------------------------------------------------------------------------------------
//جلب عدد ايام الدخول
   @GET
@Produces(MediaType.APPLICATION_JSON)
@Path("/attendance/entries/stats/{from}/{to}")
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
    long entryCount = recognizedFaceService.countEntriesByDates(startDatetime, endDatetime, RecognitionCategory.ENTER);
    
    AttendanceStats stats = new AttendanceStats(entryCount);
    
    return Response.ok(stats).build();
}
//----------------------------------------------------------------------------------------------------------------------------
//جلب عدد ايام الظهور والغياب
@GET
@Produces(MediaType.APPLICATION_JSON)
@Path("/attendance/stats/{ref_no}/{from}/{to}")
public Response getAttendanceStats(@PathParam("ref_no") String ref_no,
                                   @PathParam("from") String startTimestamp,
                                   @PathParam("to") String endTimestamp) {
    Face face = faceService.findByRefNo(ref_no);
    if (face == null) {
        return Response.status(Status.NOT_FOUND).entity("RefNo not found!").build();
    }

    SimpleDateFormat sdf = new SimpleDateFormat("dd-MM-yyyy HH:mm:ss");
    Date startDatetime, endDatetime;
    try {
        startDatetime = sdf.parse(startTimestamp);
        endDatetime = sdf.parse(endTimestamp);
    } catch (ParseException pe) {
        throw new WebApplicationException(pe.getMessage());
    }

    long presentDays = recognizedFaceService.countDaysByFaceAndDates(face, startDatetime, endDatetime);
    long totalDays = ChronoUnit.DAYS.between(startDatetime.toInstant(), endDatetime.toInstant()) + 1;
    long absentDays = totalDays - presentDays;

    AttendanceStat stats = new AttendanceStat(presentDays, absentDays);
    return Response.ok(stats).build();
    }
}