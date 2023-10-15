import React from 'react';
import { Link } from 'react-router-dom';
import { TEXT_IMG_ALT_TEXT } from '../../../translations';
import LocalStorage from '../../LocalStorage';

function SpecialistItem({ specialist, departmentSlug, departmentId, departmentName }) {
   const SP_APPOINTMENT = 'Запис на прийом';
   const SP_DETAILS = 'Деталі';

   const getImage = () => {
      try {
         return <img alt={TEXT_IMG_ALT_TEXT} id='sp__img' src={require(`/assets/site/public/specialists/${specialist.slug}.png`)} />
      } catch {
         return <img alt={TEXT_IMG_ALT_TEXT} id='sp__img' src={require(`/assets/site/public/specialist_mock.png`)} />
      }
   }

   return <div className='specialist'>
      <div className='specialist__info'>
         <h1>{specialist.firstName} {specialist.lastName}
         </h1>
         <div className='sp__media'>
            {getImage()}
         </div>
      </div>
      <div className='specialist__speciality'>
         {specialist.brief}
      </div>
      <div className='specialist__actions'>
         <div className='sp__appopintment'>
            <Link
               className='link'
               to={`/${departmentSlug}/${specialist.slug}/make-appointment`}
               onClick={() => LocalStorage.setReferrer({ specialistId: specialist.id, departmentId: departmentId, departmentName: departmentName, specialistName: (specialist.firstName + ' ' + specialist.lastName) })}
               onMouseDown={() => LocalStorage.setReferrer({ specialistId: specialist.id, departmentId: departmentId, departmentName: departmentName, specialistName: (specialist.firstName + ' ' + specialist.lastName) })}
               onFocus={() => LocalStorage.setReferrer({ specialistId: specialist.id, departmentId: departmentId, departmentName: departmentName, specialistName: (specialist.firstName + ' ' + specialist.lastName) })}>
               {SP_APPOINTMENT}
            </Link>
         </div>
         <div className='sp__details'>
            <Link
               className='link'
               to={`/specialists/${departmentSlug}/${specialist.slug}`}
               onClick={() => LocalStorage.setReferrer({ specialistId: specialist.id, departmentId: departmentId, departmentName: departmentName, specialistName: (specialist.firstName + ' ' + specialist.lastName) })}
               onMouseDown={() => LocalStorage.setReferrer({ specialistId: specialist.id, departmentId: departmentId, departmentName: departmentName, specialistName: (specialist.firstName + ' ' + specialist.lastName) })}
               onFocus={() => LocalStorage.setReferrer({ specialistId: specialist.id, departmentId: departmentId, departmentName: departmentName, specialistName: (specialist.firstName + ' ' + specialist.lastName) })}>
               {SP_DETAILS}&nbsp;&#8594;
            </Link>
         </div>
      </div>
   </div>;
}

export default SpecialistItem;
