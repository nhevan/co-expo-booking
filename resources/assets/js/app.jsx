
require('./bootstrap');
 
import React from 'react';
import ReactDom from 'react-dom';
 
import EventMap from './components/EventMap';
import ExpositionHallMap from './components/ExpositionHallMap';
import ReserveStand from './components/ReserveStand';
 
if (document.getElementById('event-map')) {
	ReactDom.render(<EventMap />, document.getElementById('event-map'));
}

if (document.getElementById('exposition-hall-map')) {
	var event_id = window.location.pathname.split('/')[2];
	ReactDom.render(<ExpositionHallMap event_id={event_id} />, document.getElementById('exposition-hall-map'));
}

if (document.getElementById('reserve-stand')) {
	var stand_id = window.location.pathname.split('/')[2];

	ReactDom.render(<ReserveStand stand_id={stand_id} />, document.getElementById('reserve-stand'));
} 