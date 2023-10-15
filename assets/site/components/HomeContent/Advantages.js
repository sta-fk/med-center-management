import React from 'react';
import { TEXT_IMG_ALT_TEXT } from '../../translations';
import { DefaultButton } from '../Button';

function Advantages() {
   const ADVANTAGE_CARD_TEXT_1 = 'Більше 19 років медичних послуг';
   const ADVANTAGE_CARD_TEXT_2 = 'Власна лабораторія';
   const ADVANTAGE_CARD_TEXT_3 = 'Лікарі високої кваліфікації';
   const ADVANTAGE_CARD_TEXT_4 = 'Широкий асортимент послуг';
   const ADVANTAGES_BTN_TEXT = 'Більше про центр';
   const ADVANTAGES_BTN_PATH = '/about';

   return (
      <section className='content advantages'>
         <div className='content__text'>
            <h1>Чому обирають нас?</h1>
            <p>
               Медичний Центр NoName – це сучасна багатопрофільна клініка, яка надає професійну медичну допомогу понад 15 років. Для нас є цінним якісний лікувально-діагностичний процес і досягнення максимально можливого позитивного результату.
               <br />
               <br />Наша мета – зберегти і примножити довіру наших пацієнтів, стати для них не тільки «швидка допомога», а й надійним другом, бути на боці пацієнта в процесі боротьби з недугою.
            </p>
            {/* <DefaultButton text={ADVANTAGES_BTN_TEXT} path={ADVANTAGES_BTN_PATH} /> */}
         </div>
         <div className='content__items'>
            <div className='row odd'>
               <div className='card'>
                  <div className='cd__media'>
                     <img alt={TEXT_IMG_ALT_TEXT} id='cd__img' src={require('/assets/site/public/home/calendar.png')} />
                  </div>
                  <span className='cd__text'>
                     {ADVANTAGE_CARD_TEXT_1}
                  </span>
               </div>
               <div className='card'>
                  <div className='cd__media'>
                     <img alt={TEXT_IMG_ALT_TEXT} id='cd__img' src={require('/assets/site/public/home/microscope.png')} />
                  </div>
                  <span className='cd__text'>
                     {ADVANTAGE_CARD_TEXT_2}
                  </span>
               </div>
            </div>
            <div className='row even'>
               <div className='card'>
                  <div className='cd__media'>
                     <img alt={TEXT_IMG_ALT_TEXT} id='cd__img' src={require('/assets/site/public/home/stethoscope.png')} />
                  </div>
                  <span className='cd__text'>
                     {ADVANTAGE_CARD_TEXT_3}
                  </span>
               </div>
               <div className='card'>
                  <div className='cd__media'>
                     <img alt={TEXT_IMG_ALT_TEXT} id='cd__img' src={require('/assets/site/public/home/prescription.png')} />
                  </div>
                  <span className='cd__text'>
                     {ADVANTAGE_CARD_TEXT_4}
                  </span>
               </div>
            </div>
         </div>
      </section >
   );
};

export default Advantages;
