import React from 'react';

export default class BookingDetail extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		return (
			<div>
				<h3>Stand booked by {this.props.company.name}</h3>
			</div>
		);
	}
}