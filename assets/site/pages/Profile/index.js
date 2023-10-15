import React from 'react';
import { Helmet } from 'react-helmet';
import Header from '../../components/Header';
import Footer from '../../components/Footer';
import Content from '../../containers/Profile';
import BackgroundResolver from '../../components/Background';

function Profile() {
   return (
      <div>
         <Helmet title='Мій кабінет | КЦ NoName' />
         <Header />
         <Content />
         <Footer />
         <BackgroundResolver />
      </div>
   )
}

export default Profile;
