var GoogleMapsLoader = require('google-maps');
import React from 'react';
import ReactDom from 'react-dom';

export default class EventMap extends React.Component {
	constructor(props) {
	    super(props);
	    this.state = {
	    	events:[],
	    	isEventClicked: false,
	    	eventId: '#'
	    };
  	}

  	componentDidMount() {
  		this.fetchEventsAndLoadMap();
  	}

  	fetchEventsAndLoadMap(){
  		console.log('fetching events');
  		var endpoint = `/api/events`;
		axios.get(endpoint)
			.then((response) => {
				this.setState({
					events: response.data,
				}, () => {
					this.loadMap();
				});
			})
			.catch(function (error) {
				console.log(error);
			});
		console.log('events fetched.');
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
  		var infowindow = new google.maps.InfoWindow();

  		this.state.events.forEach((event) => {
        	var marker = this.markEvent(event, map);

        	this.addListenersToClickEvents(event, marker, infowindow, map);
  			console.log('marked a event');
        });
  	}

  	addListenersToClickEvents(event, marker, infowindow, map){
  		google.maps.event.addListener(marker, 'click', ((marker, event) => {
  				var eventDetail = '<div>'+
  									'<h5>' + event.name + '</h5>'+
  									'<h6>' + event.short_address + '</h6>'+
  									'<p>' + event.start_date + ' to ' + event.end_date + '</p>' +
							      '</div>';
				return () => {
					console.log('event clicked !');
					infowindow.setContent(eventDetail);
					infowindow.open(map, marker);
					this.setState({
						isEventClicked: true,
						eventId: event.id
					});
				}
	        })(marker, event));
  	}

  	markEvent(event, map){
  		return new google.maps.Marker({
	          position: new google.maps.LatLng(event.latitude, event.longitude),
	          map: map,
	          title: event.name
	        });
  	}

  	drawMap(){
  		console.log('drawing map');
  		var mapOptions = {
		        zoom: 15,
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
		      	<div ref="mapView" style={mapStyle}>
		      		<img src="/images/progressbar-loading.gif" />
		      	</div>
		      	<a disabled={!this.state.isEventClicked} href={"/hall-map/" + this.state.eventId} className="btn btn-primary">Book your place</a>
	      	</div>
	    );
	}
}