import React, { useState, useEffect } from 'react';
import { FailLoading, Loading } from '../../components/Loader';
import { Link, NavLink, useNavigate } from 'react-router-dom';
import { MESSAGE_HAVE_NO_DATA, TEXT_IMG_ALT_TEXT } from '../../translations';
import { CREATE_PROFILE_URL, LOGIN_URL } from '../../routes';
import { format } from 'date-fns';
import LocalStorage from '../../components/LocalStorage';
import Base from '../../components/Base';
import axios from 'axios';
import './index.scss';

function Content() {
   const [id, setId] = useState(LocalStorage.getUser());
   const [state1, setState1] = useState({ error: null, isLoaded: false });
   const [state2, setState2] = useState({ error: null, isLoaded: false });
   const [state3, setState3] = useState({ error: null, isLoaded: false });
   const [state4, setState4] = useState({ error: null, isLoaded: false });
   const [profile, setProfile] = useState(null);
   const [appointments, setAppointments] = useState(null);
   const [appointmentsCount, setAppointmentsCount] = useState(null);
   const [results, setResults] = useState(null);

   const navigate = useNavigate();

   useEffect(() => {
      if (id === null) {
         navigate(LOGIN_URL);
         return;
      }

      axios.get(`/api/patient/${id}`)
         .then((response) => {
            setProfile(response.data);
            setState1({ error: null, isLoaded: true });
         })
         .catch((error) => {
            setState1({ error: error, isLoaded: true });
            if (error?.response?.data?.code === 404) {
               navigate(CREATE_PROFILE_URL);
            }
         });

      axios.get(`/api/patient/${id}/appointments`)
         .then((response) => {
            setAppointments(response.data);
            setState2({ error: null, isLoaded: true });
         })
         .catch((error) => {
            setState2({ error: error, isLoaded: true });
            if (error?.response?.data?.code === 404) {
               navigate(CREATE_PROFILE_URL);
            }
         })

      axios.get(`/api/patient/${id}/service/results`)
         .then((response) => {
            setResults(response.data);
            setState3({ error: null, isLoaded: true });
         })
         .catch((error) => {
            setState3({ error: error, isLoaded: true });
            if (error?.response?.data?.code === 404) {
               navigate(CREATE_PROFILE_URL);
            }
         })

      axios.get(`/api/patient/${id}/appointments/count`)
         .then((response) => {
            setAppointmentsCount(response.data);
            setState4({ error: null, isLoaded: true });
         })
         .catch((error) => {
            setState4({ error: error, isLoaded: true });
            if (error?.response?.data?.code === 404) {
               navigate(CREATE_PROFILE_URL);
            }
         })
   }, [setState1, setState2, setState3, setState4]);

   if (state1.error || state2.error || state3.error || state4.error) {
      return <FailLoading />;
   } else if (!state1.isLoaded || !state2.isLoaded || !state3.isLoaded || !state4.isLoaded) {
      return <Loading />;
   } else {
      return <section className='content profile container'>
         <div className='profile-additional-view'>
            <div className='profile-view'>
               <div className='personality'>
                  <span>{profile.firstName}&nbsp;{profile.patronymic}&nbsp;</span>
                  <span>{profile.lastName}&nbsp;</span>
               </div>
               <div className='common'>
                  <div className='column-1'>
                     <div className='item'>
                        <div className='key'>Стать</div>
                        <div>{profile.gender ? 'Жінка' : 'Чоловік'}</div>
                     </div>
                     <div className='item'>
                        <div className='key'>Телефон</div>
                        <div className='value'>{Base.formatPhoneNumber(profile.phones[0].phoneNumber)}</div>
                     </div>
                     <div className='item'>
                        <div className='key'>Місто</div>
                        <div className='value'>{profile.addresses[0].settlement}</div>
                     </div>
                  </div>
                  <div className='column-2'>
                     <div className='item'>
                        <div className='key'>Дата народження</div>
                        <div className='value'>{Base.formatMonthDate(profile.birthDate)} &#40;{Base.calculateAge(profile.birthDate)}&#41;</div>
                     </div>
                     <div className='item'>
                        <div className='key'>Адреса</div>
                        <div className='value'>{Base.formatPartlyAddress(profile.addresses[0])}</div>
                     </div>
                     <div className='item'>
                        <div className='key'>Поштовий індекс</div>
                        <div className='value'>{profile.addresses[0].zip ?? MESSAGE_HAVE_NO_DATA}</div>
                     </div>
                  </div>
               </div>
            </div>
            <div className='additional-view'>
               {
                  appointmentsCount.past > 0 || appointmentsCount.upcoming > 0
                     ? <div className='appointments'>
                        <h3>Назначені прийоми</h3>
                        <table>
                           <thead>
                              <tr>
                                 <th>{appointmentsCount.past}</th>
                                 <th>{appointmentsCount.upcoming}</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td>Минулі</td>
                                 <td>Чекають</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                     :
                     <div className='message'>
                        Ви ще не мали записів на прийом в нашій клініці
                     </div>
               }

            </div>
         </div>
         <div className='results-view'>
            {
               results.length > 0
                  ? results.map((item, i) => (
                     <div key={i} className='result'>
                        <div className='icon'>
                           <img alt={TEXT_IMG_ALT_TEXT} id='icon' src={require('/assets/site/public/pdf-icon.png')} />
                        </div>
                        <div className='name'>
                           <a href={item.url}>{item.name}</a>
                           <div className='date'>Видано {Base.formatMonthCaseDate(item.date)}</div>
                        </div>
                     </div>
                  ))
                  :
                  <div className='message'>
                     Немає результатів аналізів у нашій клініці за останні півроку
                  </div>
            }
         </div>

         {
            appointments.length > 0
            && <div className='appointments-view'>
               <div className='appointment'>
                  <div className='head__start'>
                     Дата/час
                  </div>
                  <div className='head__name'>
                     Процедура
                  </div>
                  <div className='head__employee'>
                     Лікар
                  </div>
                  <div className='head__duration'>
                     Тривалість
                  </div>
                  <div className='head__price'>
                     Вартість
                  </div>
               </div>
               {
                  appointments.map((item, i) => (
                     <div key={i} className='appointment'>
                        <div className='appointment__start'>
                           <div className='date'>
                              {Base.formatMonthDate(format(new Date(item.startAt), 'yyyy-MM-d'))}
                           </div>
                           <div className='time'>
                              <span>&nbsp;|&nbsp;</span>{format(new Date(item.startAt), 'kk:mm')}
                           </div>
                        </div>
                        <div className='appointment__name'>
                           {item.serviceName}
                        </div>
                        <div className='appointment__employee'>
                           <span>Лікар: </span>{item.employeeName}
                        </div>
                        <div className='appointment__duration'>
                           <span>Тривалість: </span>{Base.formatAppointmentTime(item.duration)}
                        </div>
                        <div className='appointment__price'>
                           <span>Вартість: </span>{item.servicePrice} грн
                        </div>
                     </div>
                  ))
               }
            </div>
         }

      </section>
         ;
   }
}

export default Content;
