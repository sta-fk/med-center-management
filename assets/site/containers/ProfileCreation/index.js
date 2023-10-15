import React, { useState } from 'react';
import LocalStorage from '../../components/LocalStorage';
import axios from 'axios';
import { format } from 'date-fns';
import { useForm } from 'react-hook-form';
import { useNavigate } from 'react-router-dom';
import { FailLoading } from '../../components/Loader';
import { PROFILE_URL } from '../../routes';
import { CONSTRAINT_SHOULD_NOT_BE_BLANK, TEXT_ENTER_FIRSTNAME, TEXT_ENTER_LASTNAME, TEXT_ENTER_PATRONYMIC, CONSTRAINT_REQUIRED_UA, SELECT_BIRTH_COUNTRY, SELECT_BIRTH_DATE, TEXT_ENTER_DOCUMENTS_PASSPORT_NUMBER, SELECT_DOCUMENTS_TYPE, CONSTRAINT_DOCUMENTS_PASSPORT_NUMBER, CONSTRAINT_DOCUMENTS_PASSPORT_SERIES, TEXT_ENTER_DOCUMENTS_PASSPORT_SERIES, SELECT_DOCUMENTS_ISSUE_DATE, TEXT_ENTER_DOCUMENTS_ISSUE_PLACE, CONSTRAINT_DOCUMENTS_INN, TEXT_ENTER_DOCUMENTS_INN, SELECT_DOCUMENTS_GENDER, TEXT_ENTER_DOCUMENTS_ID_CARD_NUMBER, CONSTRAINT_DOCUMENTS_ID_CARD_NUMBER, SELECT_DOCUMENTS_EXPIRE_DATE, TEXT_ENTER_ADDRESS_AREA, TEXT_ENTER_ADDRESS_REGION, TEXT_ENTER_ADDRESS_SETTLEMENT, TEXT_ENTER_ADDRESS_DISTRICT, TEXT_ENTER_ADDRESS_STREET, TEXT_ENTER_ADDRESS_HOUSE, TEXT_ENTER_ADDRESS_APARTMENT, TEXT_ENTER_ADDRESS_COMMENT, TEXT_ENTER_ADDRESS_ZIP, SELECT_ADDRESS_TYPE, SELECT_ADDRESS_COUNTRY, SELECT_ADDRESS_SETTLEMENT_TYPE, SELECT_PHONE_TYPE, TEXT_ENTER_PHONE_NUMBER, CONSTRAINT_PHONE_NUMBER, TEXT_ENTER_BIRTH_CITY } from '../../translations';
import './index.scss';

const REGEX_NEEDS_UA = /^[А-Яа-яёЁЇїІіЄєҐґ]+$/;
const REGEX_NEEDS_UA_WITH_SPACES = /^[А-Яа-яёЁЇїІіЄєҐґ 0-9.,]+$/;
const REGEX_PASSPORT_NUMBER = /^\d{6}$/;
const REGEX_PASSPORT_SERIES = /^[ҐЄІЇЬЮЯА-Щ]{2}$/u;
const REGEX_INN = /^\d{10}$/;
const REGEX_ID_CARD_NUMBER = /^\d{9}$/;
const REGEX_NUMBERS = /^\d+$/;
const REGEX_PHONE = /^380\d{9}$/;

function Content() {
   const {
      register,
      handleSubmit,
      resetField,
      formState: { errors, isValid },
   } = useForm({
      mode: 'onBlur'
   });

   const [document, setDocument] = useState('');
   const [stepFirst, setStepFirst] = useState(true);
   const [stepSecond, setStepSecond] = useState(false);
   const [stepThird, setStepThird] = useState(false);
   const navigate = useNavigate();

   const onSubmit = async (data) => {
      try {
         data.documents.type = document;
         const response = await axios.post(`/api/patient/${LocalStorage.getUser()}`, JSON.stringify(data));
         if (response?.status === 201) {
            navigate(PROFILE_URL);
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

   const documentHandler = (e) => {
      resetField('documents');
      setDocument(e.target.value);
   }

   return <section className='content profile-creation container'>
      <h1>Заповнення даних</h1>
      <form className='profile-form' onSubmit={handleSubmit(onSubmit)}>
         <div className='cascade step-1'><span className='number'>1</span>Особові дані</div>
         {stepFirst
            && <div className='info'>
               <input className='profile-input'
                  type='text' placeholder={TEXT_ENTER_FIRSTNAME}
                  {...register('firstName', {
                     required: CONSTRAINT_SHOULD_NOT_BE_BLANK,
                     minLength: { value: 2, message: 'Мінімальна довжина рядка 2 символи' },
                     pattern: { value: REGEX_NEEDS_UA, message: CONSTRAINT_REQUIRED_UA }
                  })}
               /><br />
               {errors?.firstName && <div className='error-msg'>{errors?.firstName?.message}</div>}

               <input className='profile-input'
                  type='text' placeholder={TEXT_ENTER_LASTNAME}
                  {...register('lastName', {
                     required: CONSTRAINT_SHOULD_NOT_BE_BLANK,
                     minLength: { value: 2, message: 'Мінімальна довжина рядка 2 символи' },
                     pattern: { value: REGEX_NEEDS_UA, message: CONSTRAINT_REQUIRED_UA }
                  })}
               /><br />
               {errors?.lastName && <div className='error-msg'>{errors?.lastName?.message}</div>}

               <input className='profile-input'
                  type='text' placeholder={TEXT_ENTER_PATRONYMIC}
                  {...register('patronymic', {
                     required: CONSTRAINT_SHOULD_NOT_BE_BLANK,
                     minLength: { value: 2, message: 'Мінімальна довжина рядка 2 символи' },
                     pattern: { value: REGEX_NEEDS_UA, message: CONSTRAINT_REQUIRED_UA }
                  })}
               /><br />
               {errors?.patronymic && <div className='error-msg'>{errors?.patronymic?.message}</div>}

               <label>{SELECT_BIRTH_DATE}</label>
               <input
                  className='profile-input'
                  type='date'
                  min={format(new Date().setFullYear(new Date().getFullYear() - 100), 'yyyy-MM-d')}
                  max={format(new Date(), 'yyyy-MM-d')}
                  {...register('birthDate', { required: CONSTRAINT_SHOULD_NOT_BE_BLANK })}
               /><br />
               {errors?.birthDate && <div className='error-msg'>{errors?.birthDate?.message}</div>}

               <select {...register('birthCountry', { required: CONSTRAINT_SHOULD_NOT_BE_BLANK })}>
                  <option value='' disabled selected>{SELECT_BIRTH_COUNTRY}</option>
                  <option value='UA'>Україна</option>
                  <option value='**'>Інша країна</option>
               </select>
               <br />
               {errors?.birthCountry && <div className='error-msg'>{errors?.birthCountry?.message}</div>}

               <input className='profile-input'
                  type='text' placeholder={TEXT_ENTER_BIRTH_CITY}
                  {...register('birthCity', {
                     required: CONSTRAINT_SHOULD_NOT_BE_BLANK,
                     minLength: { value: 2, message: 'Мінімальна довжина рядка 2 символи' },
                     pattern: { value: REGEX_NEEDS_UA, message: CONSTRAINT_REQUIRED_UA }
                  })}
               /><br />
               {errors?.birthCity && <div className='error-msg'>{errors?.birthCity?.message}</div>}

               <div className='phones'>
                  <label>Контактна інформація</label>
                  <select {...register('phones.0.type', { required: CONSTRAINT_SHOULD_NOT_BE_BLANK })}>
                     <option value='' disabled selected>{SELECT_PHONE_TYPE}</option>
                     <option value='MOBILE'>Мобільний</option>
                  </select>
                  <br />
                  {errors?.phones?.[0].type && <div className='error-msg'>{errors?.phones?.[0].type?.message}</div>}

                  <input className='profile-input' type='text' placeholder={TEXT_ENTER_PHONE_NUMBER}
                     {...register('phones.0.phoneNumber', {
                        required: TEXT_ENTER_PHONE_NUMBER,
                        pattern: { value: REGEX_PHONE, message: CONSTRAINT_PHONE_NUMBER }
                     })}
                  /><br />
                  {errors?.phones?.[0].phoneNumber && <div className='error-msg'>{errors?.phones?.[0].phoneNumber?.message}</div>}
               </div>
            </div>
         }

         <div className='cascade step-2'><span className='number'>2</span>Адреси</div>
         {stepSecond
            && <div className='address'>
               <select {...register('addresses.0.type', { required: CONSTRAINT_SHOULD_NOT_BE_BLANK })}>
                  <option value='' disabled selected>{SELECT_ADDRESS_TYPE}</option>
                  <option value='RESIDENCE'>Місце проживання</option>
               </select>
               <br />
               {errors?.addresses?.[0].type && <div className='error-msg'>{errors?.addresses?.[0].type?.message}</div>}

               <select {...register('addresses.0.country', { required: CONSTRAINT_SHOULD_NOT_BE_BLANK })}>
                  <option value='' disabled selected>{SELECT_ADDRESS_COUNTRY}</option>
                  <option value='UA'>Україна</option>
               </select>
               <br />
               {errors?.addresses?.[0].country && <div className='error-msg'>{errors?.addresses?.[0].country?.message}</div>}

               <input className='profile-input'
                  type='text' placeholder={TEXT_ENTER_ADDRESS_AREA}
                  {...register('addresses.0.area', {
                     required: CONSTRAINT_SHOULD_NOT_BE_BLANK,
                     pattern: { value: REGEX_NEEDS_UA, message: CONSTRAINT_REQUIRED_UA }
                  })}
               /><br />
               {errors?.addresses?.[0].area && <div className='error-msg'>{errors?.addresses?.[0].area?.message}</div>}

               <input className='profile-input'
                  type='text' placeholder={TEXT_ENTER_ADDRESS_REGION}
                  {...register('addresses.0.region', {
                     required: CONSTRAINT_SHOULD_NOT_BE_BLANK,
                     pattern: { value: REGEX_NEEDS_UA, message: CONSTRAINT_REQUIRED_UA }
                  })}
               /><br />
               {errors?.addresses?.[0].region && <div className='error-msg'>{errors?.addresses?.[0].region?.message}</div>}

               <select {...register('addresses.0.settlementType', { required: CONSTRAINT_SHOULD_NOT_BE_BLANK })}>
                  <option value='' disabled selected>{SELECT_ADDRESS_SETTLEMENT_TYPE}</option>
                  <option value='CITY'>Місто</option>
               </select>
               <br />
               {errors?.addresses?.[0].settlementType && <div className='error-msg'>{errors?.addresses?.[0].settlementType?.message}</div>}

               <input className='profile-input'
                  type='text' placeholder={TEXT_ENTER_ADDRESS_SETTLEMENT}
                  {...register('addresses.0.settlement', {
                     required: CONSTRAINT_SHOULD_NOT_BE_BLANK,
                     pattern: { value: REGEX_NEEDS_UA, message: CONSTRAINT_REQUIRED_UA }
                  })}
               /><br />
               {errors?.addresses?.[0].settlement && <div className='error-msg'>{errors?.addresses?.[0].settlement?.message}</div>}

               <input className='profile-input'
                  type='text' placeholder={TEXT_ENTER_ADDRESS_DISTRICT}
                  {...register('addresses.0.district', {
                     required: false,
                     pattern: { value: REGEX_NEEDS_UA, message: CONSTRAINT_REQUIRED_UA },
                     value: null,
                  })}
               /><br />
               {errors?.addresses?.[0].district && <div className='error-msg'>{errors?.addresses?.[0].district?.message}</div>}

               <input className='profile-input'
                  type='text' placeholder={TEXT_ENTER_ADDRESS_STREET}
                  {...register('addresses.0.street', {
                     required: false,
                     pattern: { value: REGEX_NEEDS_UA_WITH_SPACES, message: CONSTRAINT_REQUIRED_UA },
                     value: null,
                  })}
               /><br />
               {errors?.addresses?.[0].street && <div className='error-msg'>{errors?.addresses?.[0].street?.message}</div>}

               <input className='profile-input'
                  type='text' placeholder={TEXT_ENTER_ADDRESS_HOUSE}
                  {...register('addresses.0.house', {
                     required: false,
                     pattern: { value: REGEX_NUMBERS, message: 'Передбачається цифра' },
                     value: null,
                  })}
               /><br />
               {errors?.addresses?.[0].house && <div className='error-msg'>{errors?.addresses?.[0].house?.message}</div>}

               <input className='profile-input'
                  type='text' placeholder={TEXT_ENTER_ADDRESS_APARTMENT}
                  {...register('addresses.0.apartment', {
                     required: false,
                     pattern: { value: REGEX_NUMBERS, message: 'Передбачається цифра' },
                     value: null,
                  })}
               /><br />
               {errors?.addresses?.[0].apartment && <div className='error-msg'>{errors?.addresses?.[0].apartment?.message}</div>}

               <input className='profile-input'
                  type='text' placeholder={TEXT_ENTER_ADDRESS_ZIP}
                  {...register('addresses.0.zip', {
                     required: false,
                     pattern: { value: /^\d{5}$/, message: 'Передбачається 5 цифр' },
                     value: null,
                  })}
               /><br />
               {errors?.addresses?.[0].zip && <div className='error-msg'>{errors?.addresses?.[0].zip?.message}</div>}

               <input className='profile-input'
                  type='text' placeholder={TEXT_ENTER_ADDRESS_COMMENT}
                  {...register('addresses.0.comment', {
                     required: false,
                     pattern: { value: REGEX_NEEDS_UA_WITH_SPACES, message: CONSTRAINT_REQUIRED_UA },
                     value: null,
                  })}
               /><br />
               {errors?.addresses?.[0].comment && <div className='error-msg'>{errors?.addresses?.[0].comment?.message}</div>}
            </div>
         }

         <div className='cascade step-3'><span className='number'>3</span>Документи</div>
         {stepThird
            && <div className='documents'>
               <fieldset>
                  <legend>{SELECT_DOCUMENTS_TYPE}</legend>
                  <input {...register('documents.type', { required: CONSTRAINT_SHOULD_NOT_BE_BLANK })} type='radio' value={Number(1)}
                     onChange={e => documentHandler(e)}
                  />
                  <label for='documents.type'>Паспорт</label><br />
                  <input {...register('documents.type', { required: CONSTRAINT_SHOULD_NOT_BE_BLANK })} type='radio' value={Number(2)}
                     onChange={e => documentHandler(e)}
                  />
                  <label for='documents.type'>ID-картка</label><br />
               </fieldset>

               {document == 1
                  &&
                  <div className='passport'>
                     <fieldset>
                        <legend>{SELECT_DOCUMENTS_GENDER}</legend>
                        <input {...register('documents.gender', { required: CONSTRAINT_SHOULD_NOT_BE_BLANK })} type='radio' value={false} />
                        <label for='documents.gender'>Чоловік</label><br />
                        <input {...register('documents.gender', { required: CONSTRAINT_SHOULD_NOT_BE_BLANK })} type='radio' value={true} />
                        <label for='documents.gender'>Жінка</label><br />
                     </fieldset>

                     <input className='profile-input'
                        type='text' placeholder={TEXT_ENTER_DOCUMENTS_PASSPORT_SERIES}
                        {...register('documents.range', {
                           required: CONSTRAINT_SHOULD_NOT_BE_BLANK,
                           pattern: { value: REGEX_PASSPORT_SERIES, message: CONSTRAINT_DOCUMENTS_PASSPORT_SERIES }
                        })}
                     /><br />
                     {errors?.documents?.range && <div className='error-msg'>{errors?.documents?.range?.message}</div>}

                     <input className='profile-input'
                        type='text' placeholder={TEXT_ENTER_DOCUMENTS_PASSPORT_NUMBER}
                        {...register('documents.number', {
                           required: CONSTRAINT_SHOULD_NOT_BE_BLANK,
                           pattern: { value: REGEX_PASSPORT_NUMBER, message: CONSTRAINT_DOCUMENTS_PASSPORT_NUMBER }
                        })}
                     /><br />
                     {errors?.documents?.number && <div className='error-msg'>{errors?.documents?.number?.message}</div>}

                     <label>{SELECT_DOCUMENTS_ISSUE_DATE}</label>
                     <input
                        className='profile-input'
                        type='date'
                        min={format(new Date().setFullYear(new Date().getFullYear() - 100), 'yyyy-MM-d')}
                        max={format(new Date(), 'yyyy-MM-d')}
                        {...register('documents.issueDate', { required: CONSTRAINT_SHOULD_NOT_BE_BLANK })}
                     /><br />
                     {errors?.documents?.issueDate && <div className='error-msg'>{errors?.documents?.issueDate?.message}</div>}

                     <input className='profile-input'
                        type='text' placeholder={TEXT_ENTER_DOCUMENTS_ISSUE_PLACE}
                        {...register('documents.issuePlace', {
                           required: CONSTRAINT_SHOULD_NOT_BE_BLANK,
                           minLength: { value: 2, message: 'Мінімальна довжина рядка 2 символи' },
                           pattern: { value: REGEX_NEEDS_UA_WITH_SPACES, message: CONSTRAINT_REQUIRED_UA }
                        })}
                     /><br />
                     {errors?.documents?.issuePlace && <div className='error-msg'>{errors?.documents?.issuePlace?.message}</div>}

                     <input className='profile-input'
                        type='text' placeholder={TEXT_ENTER_DOCUMENTS_INN}
                        {...register('documents.inn', {
                           required: CONSTRAINT_SHOULD_NOT_BE_BLANK,
                           pattern: { value: REGEX_INN, message: CONSTRAINT_DOCUMENTS_INN }
                        })}
                     /><br />
                     {errors?.documents?.inn && <div className='error-msg'>{errors?.documents?.inn?.message}</div>}
                  </div>
               }

               {document == 2
                  &&
                  <div className='id-card'>
                     <fieldset>
                        <legend>{SELECT_DOCUMENTS_GENDER}</legend>
                        <input {...register('documents.gender', { required: CONSTRAINT_SHOULD_NOT_BE_BLANK })} type='radio' value={false} />
                        <label for='documents.gender'>Чоловік</label><br />
                        <input {...register('documents.gender', { required: CONSTRAINT_SHOULD_NOT_BE_BLANK })} type='radio' value={true} />
                        <label for='documents.gender'>Жінка</label><br />
                     </fieldset>

                     <input className='profile-input'
                        type='text' placeholder={TEXT_ENTER_DOCUMENTS_ID_CARD_NUMBER}
                        {...register('documents.number', {
                           required: CONSTRAINT_SHOULD_NOT_BE_BLANK,
                           pattern: { value: REGEX_ID_CARD_NUMBER, message: CONSTRAINT_DOCUMENTS_ID_CARD_NUMBER }
                        })}
                     /><br />
                     {errors?.documents?.number && <div className='error-msg'>{errors?.documents?.number?.message}</div>}

                     <label>{SELECT_DOCUMENTS_ISSUE_DATE}</label>
                     <input
                        className='profile-input'
                        type='date'
                        min={format(new Date().setFullYear(new Date().getFullYear() - 100), 'yyyy-MM-d')}
                        max={format(new Date(), 'yyyy-MM-d')}
                        {...register('documents.issueDate', { required: CONSTRAINT_SHOULD_NOT_BE_BLANK })}
                     /><br />
                     {errors?.documents?.issueDate && <div className='error-msg'>{errors?.documents?.issueDate?.message}</div>}

                     <label>{SELECT_DOCUMENTS_EXPIRE_DATE}</label>
                     <input
                        className='profile-input'
                        type='date'
                        min={format(new Date().setFullYear(new Date().getFullYear() - 100), 'yyyy-MM-d')}
                        max={format(new Date().setFullYear(new Date().getFullYear() + 100), 'yyyy-MM-d')}
                        {...register('documents.expireDate', { required: CONSTRAINT_SHOULD_NOT_BE_BLANK })}
                     /><br />
                     {errors?.documents?.expireDate && <div className='error-msg'>{errors?.documents?.expireDate?.message}</div>}

                     <input className='profile-input'
                        type='text' placeholder={TEXT_ENTER_DOCUMENTS_ISSUE_PLACE}
                        {...register('documents.issuePlace', {
                           required: CONSTRAINT_SHOULD_NOT_BE_BLANK,
                           minLength: { value: 2, message: 'Мінімальна довжина рядка 2 символи' },
                           pattern: { value: REGEX_NEEDS_UA_WITH_SPACES, message: CONSTRAINT_REQUIRED_UA }
                        })}
                     /><br />
                     {errors?.documents?.issuePlace && <div className='error-msg'>{errors?.documents?.issuePlace?.message}</div>}

                     <input className='profile-input'
                        type='text' placeholder={TEXT_ENTER_DOCUMENTS_INN}
                        {...register('documents.inn', {
                           required: CONSTRAINT_SHOULD_NOT_BE_BLANK,
                           pattern: { value: REGEX_INN, message: CONSTRAINT_DOCUMENTS_INN }
                        })}
                     /><br />
                     {errors?.documents?.inn && <div className='error-msg'>{errors?.documents?.inn?.message}</div>}
                  </div>
               }
            </div>
         }

         {(stepFirst)
            && <button className='profile-submit' disabled={!isValid} type='button' onClick={() => { setStepSecond(true); setStepFirst(false) }}>Далі</button>}
         {(stepSecond)
            && <button className='profile-submit' disabled={!isValid} type='button' onClick={() => { setStepThird(true); setStepSecond(false) }}>Далі</button>}
         {(stepThird)
            && <button className='profile-submit' disabled={!isValid} type='submit'>Підтвердити</button>}
      </form>
   </section>;
};

export default Content;
