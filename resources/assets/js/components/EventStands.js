import React from 'react';
import Stand from './Stand';
import StandDetail from './StandDetail';
import { Modal, Button } from 'react-bootstrap';

export default class EventStands extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			showModal: false,
			selectedStand : []
		}
	}

	renderStands(stands){
		if (stands.length > 0) {
			return stands.map((stand) => (
	            <rect onClick={(e) => this.loadStandDetailModal(e)} 
	            	  className="stands" 
	            	  key={stand.id} 
	            	  width={stand.breadth + 'px'} 
	            	  height={stand.length + 'px'} 
	            	  x={stand.x_cord + 'px'} 
	            	  y={stand.y_cord + 'px'}
	            	  data-selected-stand={stand}>
        	    </rect>
	        ));
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

	closeModal(){
		this.setState({ showModal: false });
	}

	openModal(){
		console.log('closing modal ...');
	    this.setState({ showModal: true });
	}

	loadStandDetailModal(e){
		console.log('clicked on a stand');
		e.preventDefault();
		var selected_stand = e.target.getAttribute('data-selected-stand');
		this.setState({
			selectedStand: selected_stand
		});
		this.openModal();
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
				<Modal show={this.state.showModal} onHide={() => this.closeModal()}>
					<Modal.Header closeButton>
			            <Modal.Title>Stand Detail</Modal.Title>
					</Modal.Header>
					<Modal.Body>
			            <StandDetail stand={this.state.selectedStand} />
		            </Modal.Body>
		            <Modal.Footer>
						<Button onClick={() => this.closeModal()}>Close</Button>
					</Modal.Footer>
				</Modal>
			</div>
		);
	}
}