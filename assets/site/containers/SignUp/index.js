import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link, useNavigate } from 'react-router-dom';
import { FailLoading } from '../../components/Loader';
import { LOGIN_URL, PENDING_SIGN_UP_URL } from '../../routes';
import {
   CONSTRAINT_SHOULD_NOT_BE_BLANK, CONSTRAINT_REGISTRATION_FAILED,
   CONSTRAINT_INVALID_EMAIL, CONSTRAINT_EASY_PASSWORD,
   CONSTRAINT_PASSWORDS_NOT_EQUALS,
   TEXT_ENTER_EMAIL, TEXT_ENTER_PASSWORD, TEXT_CONFIRM_PASSWORD
} from '../../translations';
import './index.scss';

const EMAIL_REGEX = /^[a-z\d._-]+@[a-z\d._-]+\.[a-z]{2,6}$/;
const PWD_REGEX = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?\-])[A-Za-z\d#$@!%&*?\-]{8,30}$/;


function Content() {
   const [email, setEmail] = useState('');
   const [isValidEmail, setValidEmail] = useState(true);
   const [emailError, setEmailError] = useState(CONSTRAINT_SHOULD_NOT_BE_BLANK);

   const [plainPassword, setPassword] = useState('');
   const [isValidPassword, setValidPassword] = useState(true);
   const [passwordError, setPasswordError] = useState(CONSTRAINT_SHOULD_NOT_BE_BLANK);
   const [passwordRating, setPasswordRating] = useState({ width: '100%', backgroundColor: '#FFFFFF' });
   const [passwordRatingDisplay, setPasswordRatingDisplay] = useState(false);

   const [confirmPassword, setConfirmPassword] = useState('');
   const [isValidConfirmPassword, setValidConfirmPassword] = useState(true);
   const [confirmPasswordError, setConfirmPasswordError] = useState(CONSTRAINT_SHOULD_NOT_BE_BLANK);

   const [isValidForm, setValidForm] = useState(false);
   const [formError, setFormError] = useState(null);
   // const [formError, setFormError] = useState('Ви вже маєте акаунт');

   const navigate = useNavigate();

   useEffect(() => {
      if (emailError || passwordError || confirmPasswordError) {
         setValidForm(false)
      } else {
         setValidForm(true)
      }
   }, [emailError, passwordError, confirmPasswordError]);

   const handleSubmit = async (e) => {
      e.preventDefault();
      try {
         const response = await axios.post(`/api/register`, { email, plainPassword });
         if (response?.status === 200) {
            navigate(PENDING_SIGN_UP_URL);
         }
      } catch (error) {
         if (!error?.response) {
            return <FailLoading />
         } else if (error.response?.status === 422) {
            setFormError(JSON.parse(error.response?.data.message).email);
         } else {
            setFormError(CONSTRAINT_REGISTRATION_FAILED)
         }
      }
   }

   const checkRatingPassword = (password) => {
      var protect = 0;

      //a,s,d,f
      var small = "([a-z]+)";
      if (password.match(small)) {
         protect++;
      }

      //A,B,C,D
      var big = "([A-Z]+)";
      if (password.match(big)) {
         protect++;
      }

      //1,2,3,4,5 ... 0
      var numb = "([0-9]+)";
      if (password.match(numb)) {
         protect++;
      }

      //!@#$
      var vv = /\W/;
      if (password.match(vv)) {
         protect++;
      }

      if (protect == 1) {
         setPasswordRating({ width: "10%", backgroundColor: "#F13C52" });
      }

      if (protect == 2) {
         setPasswordRating({ width: "25%", backgroundColor: "#F13C52" });
      }

      if (protect == 3) {
         setPasswordRating({ width: "50%", backgroundColor: "#E3D55C" });
      }

      if (protect == 4) {
         setPasswordRating({ width: "100%", backgroundColor: "#6BD8BA" });
         setTimeout(function () {
            setPasswordRatingDisplay(false)
         }, 3000);
      }
   }

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
      checkRatingPassword(e.target.value);

      if (!PWD_REGEX.test(e.target.value)) {
         setPasswordError(CONSTRAINT_EASY_PASSWORD)
         setPasswordRatingDisplay(true)

         if (e.target.value.length < 8 || e.target.value.length >= 30) {
            setPasswordRating({ width: "10%", backgroundColor: "#F13C52" });
            setPasswordError("Від 8 до 30 символів");

            return;
         }
      } else {
         setPasswordError(null)
      }
   }

   const confirmPasswordHandler = (e) => {
      setConfirmPassword(e.target.value)
      if (plainPassword !== e.target.value) {
         setConfirmPasswordError(CONSTRAINT_PASSWORDS_NOT_EQUALS)
      } else {
         setConfirmPasswordError(null)
      }
   }

   const onBlurHandler = (e) => {
      switch (e.target.name) {
         case 'email':
            setValidEmail(false)
            break
         case 'password':
            setValidPassword(false)
            break
         case 'confirmPassword':
            setValidConfirmPassword(false)
            break
      }
   }

   return <section className='content registration container'>
      <h1>Реєстрація</h1>
      <form className='reg-form' onSubmit={e => handleSubmit(e)}>
         <input className='reg-input' name='email' value={email} type='text' placeholder={TEXT_ENTER_EMAIL} onBlur={e => onBlurHandler(e)} onChange={e => emailHandler(e)} /><br />
         {(!isValidEmail && emailError) && <div className='error-msg'>{emailError}</div>}

         <input className='reg-input' name='password' value={plainPassword} type='password' placeholder={TEXT_ENTER_PASSWORD} onBlur={e => onBlurHandler(e)} onChange={e => passwordHandler(e)} /><br />
         {passwordRatingDisplay
            && <div className='password-rating-container'>
               <div className='password-rating' style={{ width: passwordRating.width, background: passwordRating.backgroundColor }}></div>
            </div>}

         {(!isValidPassword && passwordError) && <div className='error-msg'>{passwordError}</div>}

         <input className='reg-input' name='confirmPassword' value={confirmPassword} type='password' placeholder={TEXT_CONFIRM_PASSWORD} onBlur={e => onBlurHandler(e)} onChange={e => confirmPasswordHandler(e)} /><br />
         {(!isValidConfirmPassword && confirmPasswordError) && <div className='error-msg'>{confirmPasswordError}</div>}

         <button className='reg-submit' disabled={!isValidForm} type='submit'>Підтвердити</button>
         <div className='reg-additional'>
            {formError && <div className='invalid-data'>{formError}</div>}
            <div className='login-link'><Link className='link' to={LOGIN_URL} >Увійти в кабінет</Link></div>
         </div>
      </form>
   </section >;
}

export default Content;
