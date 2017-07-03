import React from 'react';

export default class BookingDetail extends React.Component {
	constructor(props) {
		super(props);
	}

	getCompanyDocuments(){
		console.log(this.props.company.documents);
	}

	render() {
		const documents = this.getCompanyDocuments();
		return (
			<div>
				<h3>Stand booked by {this.props.company.name}</h3>
				<img src={this.props.company.logo} alt="company logo"/>
				<p>Address: {this.props.company.address}</p>
				<p>Phone: {this.props.company.phone}</p>
				<p>Admin Name: {this.props.company.admin_name}</p>
				<p>Admin Email: {this.props.company.admin_email}</p>
				<hr/>
				<h4>Documents</h4>
				{documents}
				<hr/>
				<span>... coming soon ...</span>
			</div>
		);
	}
}