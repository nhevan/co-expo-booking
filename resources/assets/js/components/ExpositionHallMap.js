import React from 'react';
import EventStands from './EventStands';

export default class ExpositionHallMap extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			event: [],
			blueprint: '/images/progressbar-loading.gif',
			stands: []
		};

	}

	componentWillMount() {
		this.fetchEvent();
	}

	fetchEvent(){
		console.log('fetching event detail');
  		var endpoint = `/api/events/${this.props.event_id}`;
		axios.get(endpoint)
			.then((response) => {
				this.setState({
					event: response.data,
					blueprint: response.data.blueprint_img,
					stands: response.data.stands
				});
			})
			.catch(function (error) {
				console.log(error);
			});
	}

	render() {
		const hallMapStyle = {
	  		backgroundImage: `url(${this.state.blueprint})`,
	  	};
		return (
			<div className='text-center'>
				<h1>{this.state.event.name} <small>at {this.state.event.short_address}</small></h1>
				<p>Event time: { new Date(this.state.event.start_date).toDateString() }</p>
				<div style={hallMapStyle} className="hall-blueprint">
					<EventStands stands={this.state.stands} />
				</div>
			</div>
		);
	}
}