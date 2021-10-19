import { useEffect } from "react";
import { useRouter } from "next/router";
import { useForm } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import * as Yup from "yup";

import { userService } from "services";
import { ScheduleTable } from "components";


export default function Schedule() {



  return (
    <ScheduleTable/>
  );
}
