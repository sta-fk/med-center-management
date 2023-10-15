import React, { useState, useEffect } from 'react';
import './index.scss';

function Footer() {
   return <footer>
      <p className='item'>За будь-яких питань звертайтеся за номером: <a className='tel' href="tel:+380501952779">380(50)195-27-79</a></p>
      <p className='item'>Ліцензія МОЗ України АГ №111111 от 25.07.2022</p>
      <p className='item'>Clinic center NoName © 2022</p>
   </footer>;
}

export default Footer;
