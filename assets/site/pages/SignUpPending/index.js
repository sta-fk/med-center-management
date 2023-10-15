import React from 'react';
import { Helmet } from 'react-helmet';
import Header from '../../components/Header';
import Footer from '../../components/Footer';
import Content from '../../containers/SignUpPending';
import BackgroundResolver from '../../components/Background';

function SignUpPending() {
   return (
      <div>
         <Helmet title='Очікування підтвердження | КЦ NoName' />
         <Header />
         <Content />
         <Footer />
         <BackgroundResolver />
      </div>
   )
}

export default SignUpPending;
