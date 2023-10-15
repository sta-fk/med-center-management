import React from 'react';
import { Helmet } from 'react-helmet';
import Header from '../../components/Header';
import Footer from '../../components/Footer';
import Content from '../../containers/PriceList';
import BackgroundResolver from '../../components/Background';

function PriceList() {
   return (
      <div>
         <Helmet title='Вартість послуг | КЦ NoName' />
         <Header />
         <Content />
         <Footer />
         <BackgroundResolver />
      </div>
   )
}

export default PriceList;
