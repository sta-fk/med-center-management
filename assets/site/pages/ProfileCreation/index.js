import React from 'react';
import { Helmet } from 'react-helmet';
import Header from '../../components/Header';
import Footer from '../../components/Footer';
import Content from '../../containers/ProfileCreation';
import BackgroundResolver from '../../components/Background';

function ProfileCreation() {
   return (
      <div>
         <Helmet title='Заповнення даних | КЦ NoName' />
         <Header />
         <Content />
         <Footer />
         <BackgroundResolver />
      </div>
   )
}

export default ProfileCreation;
