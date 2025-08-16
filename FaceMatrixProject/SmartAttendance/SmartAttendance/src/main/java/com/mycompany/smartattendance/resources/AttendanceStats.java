package com.mycompany.smartattendance.resources;

public class AttendanceStats {
    private long entryCount;
    
    public AttendanceStats(long entryCount) {
        this.entryCount = entryCount; 
    }

    public long getEntryCount() {
        return entryCount;
    }

    public void setEntryCount(long entryCount) {
        this.entryCount = entryCount;
    }
    
}