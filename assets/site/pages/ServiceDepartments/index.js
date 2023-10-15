import React from 'react';
import { Helmet } from 'react-helmet';
import Header from '../../components/Header';
import Footer from '../../components/Footer';
import Content from '../../containers/ServiceDepartments';
import BackgroundResolver from '../../components/Background';

function ServiceDepartments() {
   return (
      <div>
         <Helmet title='Послуги | КЦ NoName' />
         <Header />
         <Content />
         <Footer />
         <BackgroundResolver />
      </div>
   )
}

export default ServiceDepartments;
