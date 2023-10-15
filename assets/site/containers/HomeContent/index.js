import React from 'react';
import Greeting from '../../components/HomeContent/Greeting';
import Advantages from '../../components/HomeContent/Advantages';
import Services from '../../components/HomeContent/Services';
import './index.scss';

function Content() {
   return <div className='container'>
      <Greeting />
      <Advantages />
      <Services />
   </div>;
}

export default Content;
