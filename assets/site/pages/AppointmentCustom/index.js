import React from 'react';
import { Helmet } from 'react-helmet';
import Header from '../../components/Header';
import Footer from '../../components/Footer';
import Content from '../../containers/AppointmentCustom';
import BackgroundResolver from '../../components/Background';
import LocalStorage from '../../components/LocalStorage';

function AppointmentCustom() {
   return (
      <div>
         <Helmet title={`Запис на прийом - ${LocalStorage.getReferrer().specialistName} | КЦ NoName`} />
         <Header />
         <Content />
         <Footer />
         <BackgroundResolver />
      </div>
   )
}

export default AppointmentCustom;
