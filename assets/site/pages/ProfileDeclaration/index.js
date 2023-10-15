import React from 'react';
import { Helmet } from 'react-helmet';
import Header from '../../components/Header';
import Footer from '../../components/Footer';
import Content from '../../containers/ProfileDeclaration';
import BackgroundResolver from '../../components/Background';

function ProfileDeclaration() {
   return (
      <div>
         <Helmet title='Декларація | КЦ NoName' />
         <Header />
         <Content />
         <Footer />
         <BackgroundResolver />
      </div>
   )
}

export default ProfileDeclaration;
