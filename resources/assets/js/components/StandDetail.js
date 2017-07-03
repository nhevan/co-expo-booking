import React from 'react';

export default class StandDetail extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		var reserve_url = `/stands/${this.props.stand.id}/reserve`;
		return (
			<div>
				<h5>Stand # {this.props.stand.stand_number} <small>${this.props.stand.price}/day</small></h5>
				<img width="100%" src={this.props.stand.image} alt="Stand photo"/>
				<p>{this.props.stand.description}</p>

				<a href={reserve_url} className="btn btn-primary">Reserve</a>
			</div>
		);
	}
}