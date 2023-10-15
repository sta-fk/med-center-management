import React from 'react';
import { Helmet } from 'react-helmet';
import Header from '../../components/Header';
import Footer from '../../components/Footer';
import Content from '../../containers/Login';
import BackgroundResolver from '../../components/Background';

function Login() {
   return (
      <div>
         <Helmet title='Вхід в кабінет | КЦ NoName' />
         <Header />
         <Content />
         <Footer />
         <BackgroundResolver />
      </div>
   )
}

export default Login;
