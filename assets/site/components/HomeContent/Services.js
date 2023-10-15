import React from 'react';
import { NavLink } from 'react-router-dom';
import { PRICE_LIST_URL, SERVICE_DEPARTMENTS_URL, SPECIALISTS_BY_DEPARTMENTS_URL } from '../../routes';
import { TEXT_IMG_ALT_TEXT } from '../../translations';
import { DefaultButton } from '../Button';

function Services() {
   const SERVICES_BTN_TEXT = 'Дивитися більше';

   return (
      <section className='content services'>
         <div className='content__text'>
            <h1>Основні напрямки</h1>
            <p>
               Медичні послуги — високоякісна допомога на основі інтегрованої моделі охорони здоров’я. Основою цього є мережа з 25 лікарень та 117 клінік та медичних установ. Основні ринки — це Польща, Індія та Румунія.
               <br />
               <br />
               Ми створили місце, де сучасність зустрічається з досвідом і індивідуальним підходом до пацієнта. Ми пропонуємо висококваліфіковану хірургічну допомогу та новітні малоінвазивні методи лікування, ефективність яких підтверджена думками задоволених клієнтів.
            </p>
            <DefaultButton text={SERVICES_BTN_TEXT} path={SERVICE_DEPARTMENTS_URL} />
         </div>
         <div className='content__items'>
            <div className='card'>
               <div className='cd__media'>
                  <img alt={TEXT_IMG_ALT_TEXT} id='cd__img' src={require('/assets/site/public/home/analyzes.png')} />
               </div>
               <div className='cd__info'>
                  <div className='cd__title'>
                     Аналізи
                  </div>
                  <div className='cd__subtitle'>
                     Всі дослідження проводяться у власній лабораторії на сучасному високоточному обладнанні.
                  </div>
                  <div className='cd__btn'>
                     <NavLink to={PRICE_LIST_URL} className='link'>
                        Перейти &#8594;
                     </NavLink>
                  </div>
               </div>
            </div>
            <div className='card'>
               <div className='cd__media'>
                  <img alt={TEXT_IMG_ALT_TEXT} id='cd__img' src={require('/assets/site/public/home/services.png')} />
               </div>
               <div className='cd__info'>
                  <div className='cd__title'>
                     Послуги
                  </div>
                  <div className='cd__subtitle'>
                     Наш медичний центр гарантує повноту і якість проведеного обстеження згідно світових стандартів.
                  </div>
                  <div className='cd__btn'>
                     <NavLink to={SERVICE_DEPARTMENTS_URL} className='link'>
                        Перейти &#8594;
                     </NavLink>
                  </div>
               </div>
            </div>
            <div className='card'>
               <div className='cd__media'>
                  <img alt={TEXT_IMG_ALT_TEXT} id='cd__img' src={require('/assets/site/public/home/employees.png')} />
               </div>
               <div className='cd__info'>
                  <div className='cd__title'>
                     Лікарі
                  </div>
                  <div className='cd__subtitle'>
                     Лікарі центру – фахівці високої кваліфікації, які використовують індивідуальний підхід до кожного пацієнта.
                  </div>
                  <div className='cd__btn'>
                     <NavLink to={SPECIALISTS_BY_DEPARTMENTS_URL} className='link'>
                        Перейти &#8594;
                     </NavLink>
                  </div>
               </div>
            </div>
         </div>
      </section>
   );
};

export default Services;
