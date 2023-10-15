import React from 'react';
import { Helmet } from 'react-helmet';
import Header from '../../components/Header';
import Footer from '../../components/Footer';
import SpecialistInfo from '../../components/Specialist';
import BackgroundResolver from '../../components/Background';
import LocalStorage from '../../components/LocalStorage';

function Specialist() {
   return (
      <div>
         <Helmet title={`Лікар ${LocalStorage.getReferrer().specialistName} | КЦ NoName`} />
         <Header />
         <SpecialistInfo />
         <Footer />
         <BackgroundResolver />
      </div>
   )
}

export default Specialist;
