import React from 'react';
import { MESSAGE_HAVE_NO_DATA } from '../../translations';

class Base {
   static REGEX_NEEDS_UA = /^[А-Яа-яёЁЇїІіЄєҐґ]+$/;
   static REGEX_NUMBERS = /^\d+$/;

   // date format YYYY-mm-DD
   static calculateAge = birthday => {
      const today = new Date();
      const birthdayDateTime = new Date(birthday);
      const todayD = (today.getFullYear() * 12 + today.getMonth()) * 31 + today.getDate() - 1;
      const birthdayD = (birthdayDateTime.getFullYear() * 12 + birthdayDateTime.getMonth()) * 31 + birthdayDateTime.getDate() - 1;

      return Math.floor(Math.abs((todayD - birthdayD) / 31 / 12));
   }

   // date format YYYY-mm-DD
   static formatMonthDate = date => {
      let dateSplit = date.split('-');
      let month = 'Січень,Лютий,Березень,Квітень,Травень,Червень,Липень,Серпень,Вересень,Жовтень,Листопад,Грудень'.split(',');

      return month[Number(dateSplit[1]) - 1] + ' ' + dateSplit[2] + ', ' + dateSplit[0];
   }

   // date format YYYY-mm-DD
   static formatMonthCaseDate = date => {
      let dateSplit = date.split('-');
      let month = 'січня,лютого,березня,квітня,травня,червня,липня,серпня,вересня,жовтня,листопада,грудня'.split(',');
      let day = Number(dateSplit[2]);

      return day + ' ' + month[Number(dateSplit[1]) - 1] + ' ' + dateSplit[0] + ' р.';
   }

   // phone format 380501112233
   static formatPhoneNumber = phone => {
      phone = phone.replace('+', '');
      var tt = phone.split('');
      tt.splice(2, "", " (");
      tt.splice(6, "", ") ");
      tt.splice(10, "", " ");
      tt.splice(13, "", " ");

      return tt;
   }

   // address format [street, house, apartment]
   static formatPartlyAddress = address => {
      let proccessedAddress = '';

      if (address.street) {
         proccessedAddress += Base.REGEX_NEEDS_UA.test(address.street) ? 'вул. ' + address.street : address.street
      } else {
         return MESSAGE_HAVE_NO_DATA;
      }

      if (address.house) {
         proccessedAddress += ', буд. ' + address.house
      } else {
         return MESSAGE_HAVE_NO_DATA;
      }

      if (address.apartment) {
         proccessedAddress += Base.REGEX_NUMBERS.test(address.apartment) ? ', кв. ' + address.apartment : ', ' + address.apartment
      }

      return proccessedAddress;
   }

   static isStatusActive = status => {
      if (String(status).toUpperCase() == 'ACTIVE') {
         return true;
      }

      return false
   }

   // time format 00:00
   static formatAppointmentTime = time => {
      let timeSplit = time.split(':');
      let timeFinal = '';

      if (timeSplit[0] !== '00') {
         timeFinal += Number(timeSplit[0]) + 'год. '
      }

      if (timeSplit[1] !== '00') {
         timeFinal += Number(timeSplit[1]) + 'хв.'
      }

      return timeFinal;
   }
}

export default Base;
