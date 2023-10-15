import React, { useState, useEffect } from 'react';
import Base from '../Base';
import LocalStorage from '../LocalStorage';
import axios from 'axios';
import { FailLoading, Loading } from '../Loader';
import { Link, useParams } from 'react-router-dom';
import { SPECIALISTS_BY_DEPARTMENTS_URL } from '../../routes';
import { TEXT_IMG_ALT_TEXT } from '../../translations';
import './index.scss';


function SpecialistInfo() {
   const [specialist, setSpecialist] = useState(null);
   const [section, setSection] = useState(null);
   const [state, setState] = useState({ error: null, isLoaded: false });
   const [info, setInfo] = useState(LocalStorage.getReferrer());
   const { departmentSlug, employeeSlug } = useParams();

   const SP_APPOINTMENT = 'Запис на прийом';
   const SP_ID = 'd290f1ee-6c54-4b01-90e6-d701748f0851';
   const SP_BRIEF = 'Лікар акушер-гінеколог, ендокринолог вищої кваліфікаційної категорії, лікар ультразвукової діагностики';

   const getImage = () => {
      try {
         return <img alt={TEXT_IMG_ALT_TEXT} id='img' src={require(`/assets/site/public/specialists/${employeeSlug}.png`)} />
      } catch {
         return <img alt={TEXT_IMG_ALT_TEXT} id='img' src={require(`/assets/site/public/specialist_mock.png`)} />
      }
   }

   useEffect(() => {
      // axios.get('/api/ehealth/employees/' + { SP_ID })
      axios.get(`/api/employees/${info.specialistId}`)
         .then((response) => {
            setSpecialist(response.data);
            setState({ error: null, isLoaded: true });
         })
         .catch((error) => {
            setState({ error: error, isLoaded: true });
         })
   }, [setState]);

   if (state.error || info == null) {
      return <FailLoading />;
   } else if (!state.isLoaded) {
      return <Loading />;
   } else {
      return (
         <div className='specialist container component'>
            <div className='personal-info'>
               <div className='media'>
                  <Link to={SPECIALISTS_BY_DEPARTMENTS_URL} className='link'>
                     <div className='btn--back'>&#8592; Назад</div>
                  </Link>
                  {getImage()}
               </div>
               <div className='info'>
                  <div className='full-name'>
                     <h1>{specialist.employeeInfo.firstName}&nbsp;{specialist.employeeInfo.secondName}&nbsp;</h1>
                     <h1>{specialist.employeeInfo.lastName}</h1>
                  </div>
                  <div className='brief'>
                     <p>{specialist.brief ? specialist.brief : 'Асистент'}</p>
                  </div>
                  <div className='contacts'>
                     {specialist.employeeInfo.phones.map((phone, i) => (
                        <div key={i} className='phone'>
                           Контакт: {phone.phoneNumber}
                        </div>
                     ))}
                  </div>
                  <Link className='btn'
                     to={`/${departmentSlug}/${employeeSlug}/make-appointment`}
                     onClick={() => LocalStorage.setReferrer({ specialistId: info.specialistId, departmentId: info.departmentId, departmentName: info.departmentName, specialistName: info.specialistName })}
                     onMouseDown={() => LocalStorage.setReferrer({ specialistId: info.specialistId, departmentId: info.departmentId, departmentName: info.departmentName, specialistName: info.specialistName })}
                     onFocus={() => LocalStorage.setReferrer({ specialistId: info.specialistId, departmentId: info.departmentId, departmentName: info.departmentName, specialistName: info.specialistName })}>
                     {SP_APPOINTMENT}
                  </Link>
               </div>
            </div>
            <div className='general-info'>
               <div className='main'>
                  <h1>Основна інформація</h1>
                  <div className='info'>
                     <p>Вік: {Base.calculateAge(specialist.employeeInfo.birthDate)}</p>
                     <p>Працює в NoName {_calculateDateDiff(specialist.startDate, specialist.endDate)} рік</p>
                     <p>Досвід роботи: {specialist.employeeInfo.workingExperience} років</p>
                     <p>{specialist.employeeInfo.declarationCount !== 0 ? 'Обслуговує ' + specialist.employeeInfo.declarationCount + ' декларації' : 'Не має декларацій'}</p>
                     <p>{specialist.employeeInfo.aboutMyself}</p>
                  </div>
               </div>
               <div className='job'>
                  <h1>Місце роботи</h1>
                  <div className='info'>
                     <p>{specialist.division.name}</p>
                  </div>
               </div>
               <div className='legal'>
                  <h1>Юридична особа</h1>
                  <div className='info'>
                     <p>{specialist.legalEntity.name}</p>
                     <p>ЄРДПОУ {specialist.legalEntity.edrpou}</p>
                     <p>Статус: {Base.isStatusActive(specialist.legalEntity.status) ? 'працює' : 'не працює'}</p>
                  </div>
               </div>
            </div>
            <div className='professional-info'>
               <div className='chapter'>
                  <div className='header' onClick={() => setSection('e')}>
                     <h1>
                        <span className='name'>Освіта і науковий ступінь</span>
                        <span className='arrow'>&nbsp;{(section === 'e') ? '↓' : '→'}</span>
                     </h1>
                  </div>
                  {section === 'e'
                     && <div className='body'>
                        {specialist.educations.map((item, i) => (
                           <div key={i} className='item'>
                              <p>ЗВО: {item.institutionName}</p>
                              <p>Спеціальність: {item.speciality}</p>
                              <p>Ступінь: {item.degree}</p>
                           </div>
                        ))}
                     </div>}
               </div>
               <div className='chapter'>
                  <div className='header' onClick={() => setSection('q')}>
                     <h1>
                        <span className='name'>Кваліфікації</span>
                        <span className='arrow'>&nbsp;{(section === 'q') ? '↓' : '→'}</span>
                     </h1>
                  </div>
                  {section === 'q'
                     && <div className='body'>
                        {specialist.qualifications.map((item, i) => (
                           <div key={i} className='item'>
                              <p>Спеціальність: {item.speciality}</p>
                              <p>ЗВО: {item.institutionName}</p>
                              <p>Валідна до: {item.validTo}</p>
                           </div>
                        ))}
                     </div>}
               </div>
               <div className='chapter'>
                  <div className='header' onClick={() => setSection('s')}>
                     <h1>
                        <span className='name'>Спеціальності</span>
                        <span className='arrow'>&nbsp;{(section === 's') ? '↓' : '→'}</span>
                     </h1>
                  </div>
                  {section === 's'
                     && <div className='body'>
                        {specialist.specialities.map((item, i) => (
                           <div key={i} className='item'>
                              <p>Спеціальність: {item.speciality}</p>
                              <p>Рівень: {item.level}</p>
                              <p>Отримано: {item.attestationDate}</p>
                              <p>Актуальна до: {item.validTo}</p>
                              <p>{item.specialityOfficio ? 'Офіційність підтверджено' : 'Неофіційно'}</p>
                           </div>
                        ))}
                     </div>}
               </div>
            </div>
         </div>
      )
   }
}

function _calculateDateDiff(startDate, endDate) {
   const startDateD = new Date(startDate);
   const endDateD = new Date(endDate);
   const startDateS = (startDateD.getFullYear() * 12 + startDateD.getMonth()) * 31 + startDateD.getDate() - 1;
   const endDateS = (endDateD.getFullYear() * 12 + endDateD.getMonth()) * 31 + endDateD.getDate() - 1;

   return Math.round(Math.abs((endDateS - startDateS) / 31 / 12));
}

export default SpecialistInfo;
