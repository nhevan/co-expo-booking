import React from 'react';
import Stand from './Stand';
import StandDetail from './StandDetail';
import BookingDetail from './BookingDetail'
import { Modal, Button, Collapse, Well } from 'react-bootstrap';

export default class EventStands extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			showReserveModal: false,
			showCompanyDetail: false,
			selectedStand : [],
			bookingCompany : []
		}
	}

	loadAppropriateModal(e){
		console.log('clicked on a stand');
		e.preventDefault();

		var selected_stand_index = e.target.getAttribute('data-selected-stand-index');
		var selected_stand_is_booked = e.target.getAttribute('data-is-booked');

		if (selected_stand_is_booked == 1) {
			this.setState(
				{ 
					showCompanyDetail: !this.state.showCompanyDetail,
					bookingCompany: this.props.stands[selected_stand_index].company
				}
			);
		}else{
			this.setState({
				selectedStand: this.props.stands[selected_stand_index],
				showCompanyDetail: false
			});
			this.openReserveModal();
		}
	}

	renderStands(stands){
		if (stands.length > 0) {
			return stands.map((stand, index) => {
	            return <rect onClick={(e) => this.loadAppropriateModal(e)} 
	            	  className="stands" 
	            	  key={index} 
	            	  width={stand.breadth + 'px'} 
	            	  height={stand.length + 'px'} 
	            	  x={stand.x_cord + 'px'} 
	            	  y={stand.y_cord + 'px'}
	            	  data-selected-stand-index={index}
	            	  data-is-booked={stand.is_booked}>
        	    </rect>
	        });
	    }
	    else return [];
	}

	renderInfos(stands){
		if (stands.length > 0) {
			return stands.map((stand, index) => {
				if (stand.company) {
					return <image href={stand.company.logo} 
								  key={index} 
								  x={ (stand.breadth/2) - (stand.breadth / 4) + stand.x_cord} 
								  y={ (stand.length/2) - (stand.length / 4) + stand.y_cord}
								  width={stand.breadth / 2}
								  height={stand.length / 2}
								  fill="black" />
				}
	            return <text key={index} 
	            			 x={ (stand.breadth/2) - 17 + stand.x_cord} 
	            			 y={ (stand.length/2) + stand.y_cord} 
	            			 fill="black">${stand.price}</text>
			});
		}
		else return [];
	}

	renderStatuses(stands){
		if (stands.length > 0) {
			return stands.map((stand, index) => {
				if (stand.company) {
					return <text key={index} 
								 x={ (stand.breadth/2) - 27.5 + stand.x_cord } 
								 y={ (stand.length/1.2) + stand.y_cord } 
								 fill="black">BOOKED
							</text>
				}

				return <text key={index} 
							 x={ (stand.breadth/2) - 17 + stand.x_cord } 
							 y={ (stand.length/1.2) + stand.y_cord } 
							 fill="black">FREE
						</text>
			});
		}
		else return [];
	}

	closeReserveModal(){
		this.setState({ showReserveModal: false });
	}

	openReserveModal(){
		console.log('closing modal ...');
	    this.setState({ showReserveModal: true });
	}

	render() {
		const stands = this.renderStands(this.props.stands);
		const infos = this.renderInfos(this.props.stands);
		const stand_statuses = this.renderStatuses(this.props.stands);
		return (
			<div>
				<svg width="700px" height="400px">
					{ stands }
					{ infos }
					{ stand_statuses }
				</svg>
				<Modal show={this.state.showReserveModal} onHide={() => this.closeReserveModal()}>
					<Modal.Header closeButton>
			            <Modal.Title>Stand Detail</Modal.Title>
					</Modal.Header>
					<Modal.Body>
			            <StandDetail stand={this.state.selectedStand} />
		            </Modal.Body>
		            <Modal.Footer>
						<Button onClick={() => this.closeReserveModal()}>Close</Button>
					</Modal.Footer>
				</Modal>
				<Collapse in={this.state.showCompanyDetail}>
					<div>
						<Well>
							<BookingDetail company={this.state.bookingCompany} />
						</Well>
					</div>
				</Collapse>
			</div>
		);
	}
}