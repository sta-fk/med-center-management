import React from 'react';
import { Helmet } from 'react-helmet';
import Header from '../../components/Header';
import Footer from '../../components/Footer';
import Content from '../../containers/SignUpSuccess';
import BackgroundResolver from '../../components/Background';

function SignUpSuccess() {
   return (
      <div>
         <Helmet title='Профіль підтверджено | КЦ NoName' />
         <Header />
         <Content />
         <Footer />
         <BackgroundResolver />
      </div>
   )
}

export default SignUpSuccess;
