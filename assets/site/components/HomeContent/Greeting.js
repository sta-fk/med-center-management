import React from 'react';
import { APPOINTMENT_URL } from '../../routes';
import { TEXT_IMG_ALT_TEXT, TEXT_MAKE_APPOINTMENT } from '../../translations';
import { DefaultButton } from '../Button';

function Greeting() {
   return (
      <section className='content greeting'>
         <div className='content__text'>
            <h1>Мережа медичних лабораторій NoName</h1>
            <p>
               Компанія піклується про кожного пацієнта, створюючи всі необхідні умови для задоволення потреб у якісній лабораторній діагностиці та надаючи точні результати і сучасний сервіс.
            </p>
            <DefaultButton text={TEXT_MAKE_APPOINTMENT} path={APPOINTMENT_URL} />
         </div>
         <div className='cd__media'>
            <img alt={TEXT_IMG_ALT_TEXT} id='cd__img' src={require('/assets/site/public/home/greeting.png')} />
         </div>
      </section>
   );
};

export default Greeting;
