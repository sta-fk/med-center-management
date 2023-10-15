import React, { useState, useEffect } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { FailLoading } from '../../components/Loader';
import { HOME_URL, SIGN_UP_URL } from '../../routes';
import LocalStorage from '../../components/LocalStorage';
import {
   TEXT_ENTER_EMAIL, TEXT_ENTER_PASSWORD,
   CONSTRAINT_SHOULD_NOT_BE_BLANK, CONSTRAINT_INVALID_CREDENTIALS,
   CONSTRAINT_INVALID_EMAIL
} from '../../translations';
import axios from 'axios';
import './index.scss';

const EMAIL_REGEX = /^[a-z\d._-]+@[a-z\d._-]+\.[a-z]{2,6}$/;

function Content() {
   const [email, setEmail] = useState('');
   const [isValidEmail, setValidEmail] = useState(true);
   const [emailError, setEmailError] = useState(CONSTRAINT_SHOULD_NOT_BE_BLANK);

   const [password, setPassword] = useState('');
   const [isValidPassword, setValidPassword] = useState(true);
   const [passwordError, setPasswordError] = useState(CONSTRAINT_SHOULD_NOT_BE_BLANK);

   const [isValidForm, setValidForm] = useState(false);
   const [formError, setFormError] = useState(null);

   const navigate = useNavigate();

   useEffect(() => {
      if (emailError || passwordError) {
         setValidForm(false)
      } else {
         setValidForm(true)
      }
   }, [emailError, passwordError]);


   const emailHandler = (e) => {
      setEmail(e.target.value)
      if (!EMAIL_REGEX.test(String(e.target.value).toLocaleLowerCase())) {
         setEmailError(CONSTRAINT_INVALID_EMAIL)
      } else {
         setEmailError(null)
      }
   }

   const passwordHandler = (e) => {
      setPassword(e.target.value)
      setPasswordError(null)
   }

   const onBlurHandler = (e) => {
      switch (e.target.name) {
         case 'email':
            setValidEmail(false)
            break
         case 'password':
            setValidPassword(false)
            break
      }
   }

   const handleSubmit = async (e) => {
      e.preventDefault();
      try {
         const response = await axios.post(`/api/login`, { email, password });
         LocalStorage.setUser(response.data.id);
         navigate(HOME_URL);
      } catch (error) {
         if (!error?.response) {
            return <FailLoading />
         } else if (error.response?.status === 401) {
            setFormError(CONSTRAINT_INVALID_CREDENTIALS);
         } else {
            return <FailLoading />
         }
      }
   }

   return <section className='content login container'>
      <h1>Вхід в кабінет</h1>
      <form className='login-form' onSubmit={e => handleSubmit(e)}>
         <input className='login-input' name='email' value={email} type='text' placeholder={TEXT_ENTER_EMAIL} onBlur={e => onBlurHandler(e)} onChange={e => emailHandler(e)} /><br />
         {(!isValidEmail && emailError) && <div className='error-msg'>{emailError}</div>}

         <input className='login-input' name='password' value={password} type='password' placeholder={TEXT_ENTER_PASSWORD} onBlur={e => onBlurHandler(e)} onChange={e => passwordHandler(e)} /><br />
         {(!isValidPassword && passwordError) && <div className='error-msg'>{passwordError}</div>}

         <button className='login-submit' disabled={!isValidForm} type='submit'>Увійти</button>
         <div className='login-additional'>
            {formError && <div className='invalid-data'>{formError}</div>}
            <div className='reg-link'>Ще не маєш кабінету? <Link className='link' to={SIGN_UP_URL}>Зареєструйся</Link></div>
         </div>
      </form>
   </section>;
}

export default Content;
