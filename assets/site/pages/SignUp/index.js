import React from 'react';
import { Helmet } from 'react-helmet';
import Header from '../../components/Header';
import Footer from '../../components/Footer';
import Content from '../../containers/SignUp';
import BackgroundResolver from '../../components/Background';

function SignUp() {
   return (
      <div>
         <Helmet title='Реєстрація | КЦ NoName' />
         <Header />
         <Content />
         <Footer />
         <BackgroundResolver />
      </div>
   )
}

export default SignUp;
