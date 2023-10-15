import React, { useState, useEffect } from 'react';
import axios from 'axios';
import Header from '../components/Header';
import Footer from '../components/Footer';
import { getBaseBackground } from '../components/Background/Background';

function TestHome() {
   const [patient, setPatient] = useState(null);
   const [state, setState] = useState({ error: null, isLoaded: false });

   useEffect(() => {
      axios.get('/api/patient/info')
         .then((response) => {
            setPatient(response.data);
            setState({ error: null, isLoaded: true });
         }
         )
         .catch((error) => {
            setState({ error: error, isLoaded: true });
         })
   }, [setState]);

   if (state.error) {
      getBaseBackground();
      console.log(state.error.message);
   } else if (!state.isLoaded) {
      getBaseBackground();
      console.log('Waiting...');
   } else {
      getBaseBackground();
      return (
         <div>
            <Header />
            <h2>Show Project</h2>
            <div>
               <div>
                  <b>Name:</b>
                  <p>{patient.firstName}</p>
                  <b>Surname:</b>
                  <p>{patient.lastName}</p>
               </div>
            </div>
            <Footer />
         </div>
      )
   }
}

export default TestHome;
