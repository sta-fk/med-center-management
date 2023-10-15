import React, { useState, useEffect } from 'react';
import { FailLoading, Loading } from '../../components/Loader';
import { useNavigate } from 'react-router-dom';
import LocalStorage from '../../components/LocalStorage';
import axios from 'axios';
import './index.scss';
import DeclarationNotFound from './DeclarationNotFound';
import Base from '../../components/Base';
import InvalidDeclaration from './InvalidDeclaration';
import { CREATE_PROFILE_URL, LOGIN_URL } from '../../routes';

function Content() {
   const [id, setId] = useState(LocalStorage.getUser());
   const [state, setState] = useState({ error: null, isLoaded: false });
   const [declaration, setDeclaration] = useState(null);

   const navigate = useNavigate();

   const _isFamilyDoctorScope = scope => {
      if (scope === 'family_doctor') {
         return 'Укладено з сімейним лікарем'
      }
   }

   useEffect(() => {
      if (id === null) {
         navigate(LOGIN_URL);
         return;
      }

      axios.get(`/api/patient/${id}/declaration`)
         .then((response) => {
            setDeclaration(response.data);
            setState({ error: null, isLoaded: true });
         })
         .catch((error) => {
            setState({ error: error, isLoaded: true });
            if (error?.response?.data?.code === 404) {
               navigate(CREATE_PROFILE_URL);
            }
         })
   }, [setState]);

   if (state.error?.response?.data?.code === 424) {
      return <DeclarationNotFound />;
   } else if (state.error?.response?.data?.code === 422) {
      return <InvalidDeclaration />;
   } else if (state.error) {
      return <FailLoading />;
   } else if (!state.isLoaded) {
      return <Loading />;
   } else {
      return <section className='content declaration container'>
         <div className='view'>
            <div className='common'>
               <div className='number'>Номер декларації {declaration.declarationNumber}</div>
               <div className='type'>Тип декларації: {_isFamilyDoctorScope(declaration.scope)}</div>
               {Base.isStatusActive(declaration.status)
                  ? <div className='status active'>Декларація дійсна до {Base.formatMonthCaseDate(declaration.endDate)}</div>
                  : <div className='status not-active'>Декларація не дійсна&nbsp;</div>
               }
            </div>
            <h1>Пацієнт</h1>
            <div className='patient'>
               <div className='column1'>
                  <div className='info'>
                     <div className='name'>
                        <div className='key'>ПІБ</div>
                        <div>
                           <span>{declaration.patient.firstName}&nbsp;{declaration.patient.patronymic}&nbsp;</span>
                           <span>{declaration.patient.lastName}&nbsp;</span>
                        </div>
                     </div>
                     <div className='birthday'>
                        <div className='key'>Дата народження&nbsp;</div>
                        <div>{Base.formatMonthDate(declaration.patient.birthDate)}&nbsp;&#40;{Base.calculateAge(declaration.patient.birthDate)}&#41;</div>
                     </div>
                     <div className='gender'>
                        <div className='key'>Стать&nbsp;</div>
                        <div>{declaration.patient.gender ? 'Жінка' : 'Чоловік'}</div>
                     </div>
                     <div className='key'>Документ, що посвідчує особу&nbsp;</div>
                     <div>
                        <div>{declaration.patient.document.type === 1 ? 'Паспорт' : 'ID-картка'}</div>
                        <div>
                           Серія, номер:&nbsp;
                           {declaration.patient.document.range
                              ? declaration.patient.document.range + '' + declaration.patient.document.number
                              : declaration.patient.document.number}
                        </div>
                        <div>
                           Місце народження:&nbsp;
                           {declaration.patient.birthCity + ', ' + declaration.patient.birthCountry}
                        </div>
                        <div>
                           <span>ІНН:&nbsp;</span>
                           <span>{declaration.patient.document.inn}</span>
                        </div>
                     </div>
                  </div>
               </div>
               <div className='column2'>
                  <div className='phone'>
                     <div className='key'>Контактний номер&nbsp;</div>
                     <div>{Base.formatPhoneNumber(declaration.patient.phones[0].phoneNumber)}</div>
                  </div>
                  <div className='email'>
                     <div className='key'>Електронна пошта&nbsp;</div>
                     <div>{declaration.patient.email}</div>
                  </div>
               </div>
            </div>
            <h1>Лікар</h1>
            <div className='specialist'>
               <div className='contacts'>
                  <div className='phone'>
                     <div className='key'>Контактний номер&nbsp;</div>
                     <div> {Base.formatPhoneNumber(declaration.division.phones[0].phoneNumber)} </div>
                  </div>
                  <div className='email'>
                     <div className='key'>Електронна пошта&nbsp;</div>
                     <div>{declaration.division.email}</div>
                  </div>
               </div>
               <div className='info'>
                  <div className='name'>
                     <div className='key'>ПІБ лікаря</div>
                     <div>
                        <span>{declaration.employee.employeeInfo.firstName}&nbsp;{declaration.employee.employeeInfo.patronymic}&nbsp;</span>
                        <span>{declaration.employee.employeeInfo.lastName}&nbsp;</span>
                     </div>
                  </div>
                  <div className='division'>
                     <div className='key'>Адреса місця надання послуг</div>
                     <div>
                        {declaration.division.name}
                     </div>
                     <div>
                        <span>
                           {Base.formatPartlyAddress(
                              new Object({
                                 'street': declaration.division.addresses[0].street,
                                 'house': declaration.division.addresses[0].house,
                                 'apartment': 'каб. ' + declaration.division.addresses[0].apartment,
                              })
                           )}
                        </span>
                        <span>,&nbsp;{declaration.division.addresses[0].settlement},&nbsp;</span>
                        <span>{declaration.division.addresses[0].zip}</span>
                     </div>
                  </div>
               </div>
            </div>
            <h1>Постачальник послуг первинної медичної допомоги</h1>
            <div className='legal-entity'>
               <div className='contacts'>
                  <div className='phone'>
                     <div className='key'>Контактний номер&nbsp;</div>
                     <div> {Base.formatPhoneNumber(declaration.legalEntity.phones[0].phoneNumber)} </div>
                  </div>
                  <div className='email'>
                     <div className='key'>Електронна пошта&nbsp;</div>
                     <div>{declaration.legalEntity.email}</div>
                  </div>
               </div>
               <div className='info'>
                  <div className='key'>Назва</div>
                  <div>
                     {declaration.legalEntity.name}
                  </div>
                  <div>
                     <div className='key'>Код ЄДР/РНОКПП&nbsp;</div>
                     <div>{declaration.legalEntity.edrpou}</div>
                  </div>
                  <div className='key'>Адреса місця реєстрації</div>
                  <div>
                     <span>
                        {Base.formatPartlyAddress(
                           new Object({
                              'street': declaration.legalEntity.addresses[0].street,
                              'house': declaration.legalEntity.addresses[0].house,
                              'apartment': 'каб. ' + declaration.legalEntity.addresses[0].apartment,
                           })
                        )}
                     </span>
                     <span>,&nbsp;{declaration.legalEntity.addresses[0].settlement},&nbsp;</span>
                     <span>{declaration.legalEntity.addresses[0].zip}</span>
                  </div>
               </div>
            </div>
         </div>
      </section>;
   }
}

export default Content;
