import React from 'react';
import { Helmet } from 'react-helmet';
import Header from '../../components/Header';
import Footer from '../../components/Footer';
import Content from '../../containers/News';
import BackgroundResolver from '../../components/Background';

function News() {
   return (
      <div>
         <Helmet title='Новини | КЦ NoName' />
         <Header />
         <Content />
         <Footer />
         <BackgroundResolver />
      </div>
   )
}

export default News;
