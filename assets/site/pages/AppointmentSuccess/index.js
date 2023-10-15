import React from 'react';
import { Helmet } from 'react-helmet';
import Header from '../../components/Header';
import Footer from '../../components/Footer';
import Content from '../../containers/AppointmentSuccess';
import BackgroundResolver from '../../components/Background';

function AppointmentSuccess() {
   return (
      <div>
         <Helmet title='Запис створений успішно | КЦ NoName' />
         <Header />
         <Content />
         <Footer />
         <BackgroundResolver />
      </div>
   )
}

export default AppointmentSuccess;
