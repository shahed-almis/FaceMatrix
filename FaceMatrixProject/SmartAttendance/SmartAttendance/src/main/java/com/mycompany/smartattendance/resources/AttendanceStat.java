package com.mycompany.smartattendance.resources;
//كلاس يحتوي على عدد ايام ظهور والغياب

public class AttendanceStat {
private long presentDays;
private long absentDays;


public AttendanceStat(long presentDays, long absentDays) 
{
    this.presentDays = presentDays;
    this.absentDays = absentDays;
}

public long getPresentDays() {
    return presentDays;
}

public long getAbsentDays() {
    return absentDays;
    }

}