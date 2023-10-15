import React from 'react';
import { Helmet } from 'react-helmet';
import Header from '../../components/Header';
import Footer from '../../components/Footer';
import Content from '../../containers/SpecialistDepartments';
import BackgroundResolver from '../../components/Background';

function SpecialistDepartments() {
   return (
      <div>
         <Helmet title='Прийом лікарів | КЦ NoName' />
         <Header />
         <Content />
         <Footer />
         <BackgroundResolver />
      </div>
   )
}

export default SpecialistDepartments;
