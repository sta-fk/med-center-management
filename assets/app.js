import React, { Component } from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import ReactDom from 'react-dom';
import Home from "./site/pages/Home";
import News from './site/pages/News';
import ServiceDepartments from './site/pages/ServiceDepartments';
import Services from './site/pages/Services';
import SpecialistDepartments from './site/pages/SpecialistDepartments';
import PriceList from './site/pages/PriceList';
import Specialist from './site/pages/Specialist';
import Login from './site/pages/Login';
import SignUpPending from './site/pages/SignUpPending';
import SignUp from './site/pages/SignUp';
import Profile from './site/pages/Profile';
import ProfileCreation from './site/pages/ProfileCreation';
import ProfileDeclaration from './site/pages/ProfileDeclaration';
import AppointmentCustom from './site/pages/AppointmentCustom';
import AppointmentSuccess from './site/pages/AppointmentSuccess';
import Appointment from './site/pages/Appointment';
import SignUpSuccess from './site/pages/SignUpSuccess';
import {
   SIGN_UP_URL, HOME_URL, LOGIN_URL, NEWS_URL, PRICE_LIST_URL,
   SERVICES_BY_DEPARTMENTS_URL, SERVICE_DEPARTMENTS_URL,
   SPECIALISTS_BY_DEPARTMENTS_URL, SPECIALIST_URL, PENDING_SIGN_UP_URL,
   SUCCESS_SIGN_UP_URL, PROFILE_URL, CREATE_PROFILE_URL, PROFILE_DECLARATION_URL, CUSTOM_APPOINTMENT_URL, SUCCESS_APPOINTMENT_URL, APPOINTMENT_URL
} from './site/routes';

class App extends Component {
   render() {
      return (
         <div>
            <BrowserRouter>
               <Routes>
                  <Route path={HOME_URL} element={<Home />} />
                  <Route path={NEWS_URL} element={<News />} />
                  <Route path={SPECIALISTS_BY_DEPARTMENTS_URL} element={<SpecialistDepartments />} />
                  <Route path={SPECIALIST_URL} element={<Specialist />} />
                  <Route path={SERVICE_DEPARTMENTS_URL} element={<ServiceDepartments />} />
                  <Route path={SERVICES_BY_DEPARTMENTS_URL} element={<Services />} />
                  <Route path={PRICE_LIST_URL} element={<PriceList />} />
                  <Route path={LOGIN_URL} element={<Login />} />
                  <Route path={SIGN_UP_URL} element={<SignUp />} />
                  <Route path={PENDING_SIGN_UP_URL} element={<SignUpPending />} />
                  <Route path={SUCCESS_SIGN_UP_URL} element={<SignUpSuccess />} />
                  <Route path={PROFILE_URL} element={<Profile />} />
                  <Route path={CREATE_PROFILE_URL} element={<ProfileCreation />} />
                  <Route path={PROFILE_DECLARATION_URL} element={<ProfileDeclaration />} />
                  <Route path={CUSTOM_APPOINTMENT_URL} element={<AppointmentCustom />} />
                  <Route path={SUCCESS_APPOINTMENT_URL} element={<AppointmentSuccess />} />
                  <Route path={APPOINTMENT_URL} element={<Appointment />} />
               </Routes>
            </BrowserRouter>
         </div>
      )
   }
}

ReactDom.render(<App />, document.getElementById('app'));
