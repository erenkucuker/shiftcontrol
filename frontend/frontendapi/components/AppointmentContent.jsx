
import { useState, useEffect } from 'react';
import {
  AppointmentTooltip,
} from '@devexpress/dx-react-scheduler-material-ui';


export function AppointmentContent({children, appointmentData, classes, ...restProps}){
  return(
    <AppointmentTooltip.Content {...restProps} appointmentData={appointmentData}>
    <div container alignItems="center">
      <div>
        <div>Job Title : {appointmentData.user.job.name}</div>
      </div>
      <div>
        <span>Job Description : {appointmentData.user.job.description}</span>
      </div>
    </div>
  </AppointmentTooltip.Content>
  )
}