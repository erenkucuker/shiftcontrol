import { BehaviorSubject } from "rxjs";
import getConfig from "next/config";
import Router from "next/router";

import { fetchWrapper } from "helpers";

const { publicRuntimeConfig } = getConfig();
const baseUrl = `${publicRuntimeConfig.apiUrl}`;
const userSubject = new BehaviorSubject(
  process.browser && JSON.parse(localStorage.getItem("user"))
);

export const userService = {
  user: userSubject.asObservable(),
  get userValue() {
    return userSubject.value;
  },
  login,
  logout,
  me,
  getSchedule,
};

function login(email, password) {
  return fetchWrapper
    .post(`${baseUrl}/login`, { email, password })
    .then((user) => {
      user.authdata = user.data.token;
      userSubject.next(user);
      localStorage.setItem("user", JSON.stringify(user));
      return user;
    });
}

function logout() {
  localStorage.removeItem("user");
  userSubject.next(null);
  Router.push("/login");
}
function me(){
  return fetchWrapper
  .post(`${baseUrl}/me`)
  .then((data) => {
    return data;
  });
}



function getSchedule() {
  return fetchWrapper.get(`${baseUrl}/user/schedules`).then((data) => {
    return data.data.map((item) => {
      return { ...item, startDate:item.start_time, endDate:item.end_time, title:item.user.name };
    });
  });
}