import React from 'react';
import ReactDom from 'react-dom';
import { FormGroup, ControlLabel, FormControl, HelpBlock, Button } from 'react-bootstrap';

export default class ReserveStand extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			name: '',
			logo_file: null,
			address: '',
			phone: '',
			admin_name: '',
			admin_email: '',
			document : [],
			document_upload_holder: []
		};
		this.handleLogoFileChange = this.handleLogoFileChange.bind(this);
		this.handleDocumentsFileChange = this.handleDocumentsFileChange.bind(this);
		this.uploadCompanyDocuments = this.uploadCompanyDocuments.bind(this);
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
	handleDocumentsFileChange(e){
 		this.setState({ document: this.state.document.concat([e.target.files[0]]) })
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
					this.uploadCompanyDocuments(response.data.company_id);

					window.location.href = `/hall-map/${response.data.event_id}`;
				})
				.catch(function (error) {
					console.log(error);
				});;
	}

	uploadCompanyDocuments(company_id) {
		this.state.document.forEach((document) => {
			this.uploadDocument(document, company_id);
		})(company_id);
	}

	uploadDocument(document, company_id){
        var endpoint = `/api/companies/${company_id}/upload-document`;
		const formData = new FormData();
	    const config = {
	        headers: {
	            'content-type': 'multipart/form-data',
	            'Accept': 'application/json'
	        }
        }
	    
	    formData.append('file',document);
		axios.post(endpoint, formData, config)
				.then((response) => {
					console.log(response.data);
				})
				.catch(function (error) {
					console.log(error.response.data);
				});
	}

	addDocument(e){
 		e.preventDefault();
 		var doc_form = <FormGroup>
 				          <ControlLabel>Company Document # {this.state.document_upload_holder.length + 1}</ControlLabel>
 				          <FormControl
 				            type="file"
 				            placeholder="Please select you company documents to upload"
 				            onChange={this.handleDocumentsFileChange}
 				          />
 				          <FormControl.Feedback />
 				        </FormGroup>
 		this.setState({
 			document_upload_holder: this.state.document_upload_holder.concat(doc_form)
 		});
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
		        <hr/>
		        	<h3>Company Documents
			        	<Button type="submit" onClick={(e)=>(this.addDocument(e))} className="btn-sm btn-primary pull-right">
					    	Add Document
					    </Button>
				    </h3>
		        <hr/>

		        { this.state.document_upload_holder }

		        <Button type="submit" onClick={(e)=>(this.confirmReservation(e))} className="btn-primary pull-right">
			    	Confirm Reservation
			    </Button>
		      </form>
		);
	}
}