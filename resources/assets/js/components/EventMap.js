var GoogleMapsLoader = require('google-maps');
import React from 'react';
import ReactDom from 'react-dom';

export default class EventMap extends React.Component {
	constructor(props) {
	    super(props);
	    this.state = {
	    	events:[]
	    };
  	}

  	componentDidMount() {
  		this.fetchEvents();
  		this.loadMap();
  	}

  	fetchEvents(){
  		console.log('fetching events');
  		var endpoint = `/api/events`;
		axios.get(endpoint)
			.then((response) => {
				this.setState({
					events: response.data,
				});
			})
			.catch(function (error) {
				console.log(error);
			});
  	}

  	loadMap(){
  		GoogleMapsLoader.KEY = 'AIzaSyAabUiWB6NGae8TX1tT7IlwkgeIex2DatU';
	    GoogleMapsLoader.load(function(google) {
	    	var map = this.drawMap();

	    	this.markEventsOnMap(map);

	        
		}.bind(this));
  	}

  	markEventsOnMap(map){
  		console.log('marking events on map');
  		this.state.events.forEach(function(event){
        	new google.maps.Marker({
	          position: new google.maps.LatLng(event.latitude, event.longitude),
	          map: map
	        });
        	console.log(event.name);
        });
  	}

  	drawMap(){
  		console.log('drawing map');
  		var mapOptions = {
		        zoom: 16,
		        center: new google.maps.LatLng(40.712785, -74.009035)
	        }
			
		var map = new google.maps.Map(ReactDom.findDOMNode(this.refs.mapView), mapOptions);

		return map;
  	}

	render() {
	  	const mapStyle = {
	  		height: '500px',
	  		marginBottom: '10px'
	  	};
	    return (
	      	<div className='text-center'>
		      	<div ref="mapView" style={mapStyle}></div>
		      	<a disabled href="#" className="btn btn-primary">Book your place</a>
	      	</div>
	    );
	}
}