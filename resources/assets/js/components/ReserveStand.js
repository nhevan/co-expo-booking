import React from 'react';
import ReactDom from 'react-dom';
import { FormGroup, ControlLabel, FormControl, HelpBlock, Button } from 'react-bootstrap';

export default class ReserveStand extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			name: 'something',
			logo_file: null,
			address: '',
			phone: '',
			admin_name: '',
			admin_email: ''
		};
		this.handleLogoFileChange = this.handleLogoFileChange.bind(this);
	}

	handleCompanyNameChange(e) {
		this.setState({ name: e.target.value });
	}
	handleAddressChange(e) {
		this.setState({ address: e.target.value });
	}
	handlePhoneChange(e) {
		this.setState({ phone: e.target.value });
	}
	handleAdminNameChange(e) {
		this.setState({ admin_name: e.target.value });
	}
	handleAdminEmailChange(e) {
		this.setState({ admin_email: e.target.value });
	}
	handleLogoFileChange(e){
		this.setState({ logo_file:e.target.files[0] })
	}

	confirmReservation(e){
		e.preventDefault();
		console.log('confirming reservation');

		const formData = new FormData();
	    formData.append('logo_file',this.state.logo_file);
	    formData.append('name',this.state.name);
	    formData.append('address',this.state.address);
	    formData.append('phone',this.state.phone);
	    formData.append('admin_name',this.state.admin_name);
	    formData.append('admin_email',this.state.admin_email);
	    const config = {
	        headers: {
	            'content-type': 'multipart/form-data',
	            'Accept': 'application/json'
	        }
        }

		var endpoint = `/api/stands/${this.props.stand_id}/reserve`;
		axios.post(endpoint, formData, config)
				.then((response) => {
					console.log(response.data);
					window.location.href = `/hall-map/${response.data.event_id}`;
				})
				.catch(function (error) {
					console.log(error.response.data);
				});;
	}

	render() {
		return (
			<form>
		        <FormGroup
		          controlId="formCompanyName"
		        >
		          <ControlLabel>Company Name</ControlLabel>
		          <FormControl
		            type="text"
		            value={this.state.name}
		            placeholder="Please enter your company name"
		            onChange={(e) => (this.handleCompanyNameChange(e))}
		          />
		          <FormControl.Feedback />
		        </FormGroup>

		        <FormGroup
		          controlId="formCompanyLogo"
		        >
		          <ControlLabel>Company Logo</ControlLabel>
		          <FormControl
		            type="file"
		            placeholder="Please enter your company logo"
		            ref='logoUpload'
		            onChange={this.handleLogoFileChange}
		          />
		          <FormControl.Feedback />
		        </FormGroup>

		        <FormGroup
		          controlId="formCompanyAddress"
		        >
		          <ControlLabel>Address</ControlLabel>
		          <FormControl
		            type="text"
		            value={this.state.address}
		            placeholder="Please enter company address"
		            onChange={(e) => (this.handleAddressChange(e))}
		          />
		          <FormControl.Feedback />
		        </FormGroup>

		        <FormGroup
		          controlId="formCompanyPhone"
		        >
		          <ControlLabel>Phone</ControlLabel>
		          <FormControl
		            type="text"
		            value={this.state.phone}
		            placeholder="Please enter company phone number"
		            onChange={(e) => (this.handlePhoneChange(e))}
		          />
		          <FormControl.Feedback />
		        </FormGroup>

		        <FormGroup
		          controlId="formCompanyAdminName"
		        >
		          <ControlLabel>Admin Name</ControlLabel>
		          <FormControl
		            type="text"
		            value={this.state.admin_name}
		            placeholder="Please enter company admin name"
		            onChange={(e) => (this.handleAdminNameChange(e))}
		          />
		          <FormControl.Feedback />
		        </FormGroup>

		        <FormGroup
		          controlId="formCompanyAdminEmail"
		        >
		          <ControlLabel>Admin Email</ControlLabel>
		          <FormControl
		            type="text"
		            value={this.state.admin_email}
		            placeholder="Please enter company admin email address"
		            onChange={(e) => (this.handleAdminEmailChange(e))}
		          />
		          <FormControl.Feedback />
		        </FormGroup>

		        <Button type="submit" onClick={(e)=>(this.confirmReservation(e))} className="btn-primary pull-right">
			    	Confirm Reservation
			    </Button>
		      </form>
		);
	}
}