import React, { useState, useEffect } from 'react';
import { APPOINTMENT_URL, CUSTOM_APPOINTMENT_URL, HOME_URL, LOGIN_URL, PENDING_SIGN_UP_URL, PRICE_LIST_URL, SERVICE_DEPARTMENTS_URL, SIGN_UP_URL, SUCCESS_APPOINTMENT_URL, SUCCESS_SIGN_UP_URL } from '../../routes';

function BackgroundResolver() {
   // const [size, setSize] = useState({});
   // const body = document.body;

   // const resizeHandler = () => {
   //    const { scrollHeight, scrollWidth } = body || {};
   //    setSize({ scrollHeight, scrollWidth });
   // };

   // useEffect(() => {
   //    window.addEventListener("resize", resizeHandler);
   //    resizeHandler();
   //    return () => {
   //       window.removeEventListener("resize", resizeHandler);
   //    };
   // }, []);

   // size.scrollHeight < 1080 ? document.body.className = 'base' : document.body.className = 'home-page';

   if (window.location.pathname === HOME_URL) {
      document.body.className = 'big-page';

      return;
   }

   if (
      window.location.pathname === PRICE_LIST_URL
      || window.location.pathname === LOGIN_URL
      || window.location.pathname === SIGN_UP_URL
      || window.location.pathname === PENDING_SIGN_UP_URL
      || window.location.pathname === SUCCESS_SIGN_UP_URL
      || window.location.pathname === SUCCESS_APPOINTMENT_URL
      || window.location.pathname === SERVICE_DEPARTMENTS_URL
      || window.location.pathname === APPOINTMENT_URL
      || ('/' + (window.location.pathname).split('/')[3]) === APPOINTMENT_URL
   ) {
      document.body.className = 'small-page';

      return;
   }

   document.body.className = 'base';
}

export default BackgroundResolver;
