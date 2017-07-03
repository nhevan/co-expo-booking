
 require('./bootstrap');
 
 import React from 'react';
 import ReactDom from 'react-dom';
 
 import EventMap from './components/EventMap';
 
 if (document.getElementById('event-map')) {
 	ReactDom.render(<EventMap />, document.getElementById('event-map'));
 } 