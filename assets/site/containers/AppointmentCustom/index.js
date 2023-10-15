import React, { useState, useEffect } from 'react';
import axios from 'axios';
import moment from 'moment';
import { format } from 'date-fns';
import LocalStorage from '../../components/LocalStorage';
import { FailLoading, Loading } from '../../components/Loader';
import { useNavigate } from 'react-router-dom';
import { CONSTRAINT_APPOINTMENT_CONFLICT, CONSTRAINT_APPOINTMENT_FAIL, SELECT_NEEDS_DATE } from '../../translations';
import { CREATE_PROFILE_URL, LOGIN_URL, SUCCESS_APPOINTMENT_URL } from '../../routes';
import './index.scss';

function Content() {
   const [services, setServices] = useState(null);
   const [service, setService] = useState(undefined);
   const [state, setState] = useState({ error: null, isLoaded: false });
   const [info, setInfo] = useState(LocalStorage.getReferrer());
   const [date, setDate] = useState('');
   const [availableTime, setAvailableTime] = useState('');
   const [time, setTime] = useState('');
   const [formError, setFormError] = useState(null);
   const navigate = useNavigate();

   useEffect(() => {
      axios.get(`/api/patient/exists`)
         .then((response) => {
            if (response?.status === 200) {
               if (!response.data) {
                  navigate(CREATE_PROFILE_URL);
                  return;
               }
            };
         })
         .catch((error) => {
            setState({ error: error, isLoaded: true });
         })

      axios.get(`/api/department/${info.departmentId}/services`)
         .then((response) => {
            setServices(response.data);
            setState({ error: null, isLoaded: true });
         })
         .catch((error) => {
            setState({ error: error, isLoaded: true });
         })
   }, [setState]);

   const handleChangeService = (event) => {
      setService(event.target.value);
      setDate('');
      setAvailableTime('');
      setTime('');
   }

   const handleChangeDate = (event) => {
      setDate(event.target.value);
      setTime('');
      getAvailableTime(event.target.value);
   }

   const handleChangeTime = (event) => {
      setTime(event.target.value);
   }

   const getAvailableTime = async (choosenDate) => {
      try {
         const response = await axios.get(`/api/patient/${Number(LocalStorage.getUser())}/appointment/available?service=${service}&employee=${info.specialistId}&date=${choosenDate}`);
         if (response?.status === 200) {
            setAvailableTime(response.data);
         }
      } catch (error) {
         if (!error?.response) {
            return <FailLoading />
         } else {
            return <FailLoading />
         }
      }
   }

   const handleSubmit = async (e) => {
      e.preventDefault();
      // alert(JSON.stringify({ 'employeeId': info.specialistId, 'serviceId': service, 'time': format(new Date(time), 'yyyy-MM-dd kk:mm:ss').replace(" ", "T") }));
      try {
         const response =
            await axios.post(
               `/api/patient/${Number(LocalStorage.getUser())}/appointment`,
               {
                  'employeeId': info.specialistId,
                  'serviceId': service,
                  'time': format(new Date(time), 'yyyy-MM-dd kk:mm:ss').replace(" ", "T")
               }
            );

         if (!response) {
            return <Loading />;
         }

         if (response?.status === 201) {
            navigate(SUCCESS_APPOINTMENT_URL);
         }
      } catch (error) {
         if (!error?.response) {
            return <FailLoading />
         } else if (error.response?.status === 409) {
            setFormError(CONSTRAINT_APPOINTMENT_CONFLICT);
         } else {
            setFormError(CONSTRAINT_APPOINTMENT_FAIL);
         }
      }
   }

   if (state.error) {
      return <FailLoading />;
   } else if (!state.isLoaded) {
      return <Loading />;
   } else if (!LocalStorage.getUser()) {
      navigate(LOGIN_URL);
   } else {
      return (<section className='content custom-appointment container'>
         <h1>Запис на прийом</h1>
         <h2>Відділення: {info.departmentName}</h2>
         <h2>Лікар: {info.specialistName}</h2>
         <form className='custom-appointment-form' onSubmit={e => handleSubmit(e)}>
            <select value={service} onChange={e => handleChangeService(e)}>
               <option value='' disabled>Вибір послуги</option>
               {services.map((item, i) => (
                  <option key={i} value={item.id}>{item.name} | {item.price} грн</option>
               ))}
            </select>

            <label>{SELECT_NEEDS_DATE}</label>
            <input
               disabled={!service}
               className='custom-appointment-input'
               type='date'
               min={format(new Date(), 'yyyy-MM-d')}
               max={format(new Date().setMonth(new Date().getMonth() + 1), 'yyyy-MM-d')}
               value={date}
               onChange={e => handleChangeDate(e)}
            /><br />
            <select disabled={!date} value={time} onChange={e => handleChangeTime(e)}>
               <option value='' disabled>Доступний час запису</option>
               {availableTime
                  && availableTime.map((item, i) => (
                     <option key={i} value={item}>{moment(item).format('kk:mm')} </option>
                  ))}
            </select>

            <button className='custom-appointment-submit' disabled={!(service && date && time)} type='submit' >Підтвердити</button>
            {formError && <div className='invalid-data'>{formError}</div>}
         </form>
      </section>);
   }
}
export default Content;
