import React from 'react';

export default class BookingDetail extends React.Component {
	constructor(props) {
		super(props);
		this.getCompanyDocuments = this.getCompanyDocuments.bind(this);
	}

	getCompanyDocuments(){
		console.log(this.props.company.documents);
		if(this.props.company.length != 0){
			console.log('ball');
			console.log(this.props.company.documents);
			if (this.props.company.documents.length != 0) {
				return this.props.company.documents.map((document, index)=>{
					return <div>
					   			<a href={document.file} target="_blank" key={index} download>{document.name}</a>
						   </div>
				});
			}else{
				return <span>This company have not uploaded any documents.</span>
			}
		}
	}

	render() {
		const documents = this.getCompanyDocuments();
		const imgStyle = {
			'maxWidth': '200px'
		};

		return (
			<div>
				<h3>Stand booked by {this.props.company.name}</h3>
				<img src={this.props.company.logo} alt="company logo" style={imgStyle}/>
				<p>Address: {this.props.company.address}</p>
				<p>Phone: {this.props.company.phone}</p>
				<p>Admin Name: {this.props.company.admin_name}</p>
				<p>Admin Email: {this.props.company.admin_email}</p>
				<hr/>
				<h4>Documents</h4>
				{documents}
			</div>
		);
	}
}