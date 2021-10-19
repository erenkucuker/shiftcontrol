import { useState, useEffect } from 'react';
import { ViewState } from '@devexpress/dx-react-scheduler';
import {
  Scheduler,
  WeekView,
  Toolbar,
  DateNavigator,
  Appointments,
  AppointmentTooltip,
  AppointmentForm,
  TodayButton,
  

} from '@devexpress/dx-react-scheduler-material-ui';

import { userService } from "services";

import {AppointmentContent} from ".";

export function ScheduleTable(){

const [currentDate, setCurrentDate] = useState(new Date());
const [data ,setData] = useState([]);
const [userRole, setUserRole] = useState(userService.userValue.data.role);
  useEffect(() => {
    userService.getSchedule().then(
      res => {
        setData(res);
      }
    )
  }, []);

function currentDateChange(currentDate) {
  return setCurrentDate(currentDate);
}

  return(
        <Scheduler
          data={data}
          
        >
          <ViewState
            currentDate={currentDate}
            onCurrentDateChange={currentDateChange}
          />
          <WeekView
            startDayHour={9}
            endDayHour={19}
          />
          <Toolbar />
          <DateNavigator />
          <TodayButton />
          <Appointments
          />
          <AppointmentTooltip
            contentComponent={AppointmentContent}
            showCloseButton
            showOpenButton
          />
          <AppointmentForm
          
            {... (userRole == 'employee' && {readOnly : true})}
          />

        </Scheduler>
        )
}