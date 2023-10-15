import React from 'react';
import { Helmet } from 'react-helmet';
import Header from '../../components/Header';
import Footer from '../../components/Footer';
import Content from '../../containers/Appointment';
import BackgroundResolver from '../../components/Background';

function Appointment() {
   return (
      <div>
         <Helmet title='Запис на прийом | КЦ NoName' />
         <Header />
         <Content />
         <Footer />
         <BackgroundResolver />
      </div>
   )
}

export default Appointment;
