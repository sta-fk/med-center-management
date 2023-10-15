import React from 'react';
import { Helmet } from 'react-helmet';
import Header from '../../components/Header';
import Footer from '../../components/Footer';
import Content from '../../containers/HomeContent';
import BackgroundResolver from '../../components/Background';

function Home() {
   return (
      <div>
         <Helmet title='Клінічний центр NoName' />
         <Helmet>
            <link rel="icon" type="image/x-icon" href={require(`/assets/site/public/favicon.ico`)} sizes="16x16" />
         </Helmet>
         <Header />
         <Content />
         <Footer />
         <BackgroundResolver />
      </div>
   )
}

export default Home;
