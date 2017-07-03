import React from 'react';
import Stand from './Stand';

export default class EventStands extends React.Component {
	constructor(props) {
		super(props);
	}

	test(e){
		e.preventDefault();
		console.log('clicked on stand');
		alert(e.target.value);
	}

	renderStands(stands){
		if (stands.length > 0) {
			return stands.map((stand) => (
	            <rect onClick={this.test} 
	            	  className="stands" 
	            	  key={stand.id} 
	            	  width={stand.breadth + 'px'} 
	            	  height={stand.length + 'px'} 
	            	  x={stand.x_cord + 'px'} 
	            	  y={stand.y_cord + 'px'}>
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
								  x={ (stand.breadth/4) + stand.x_cord} 
								  y={ (stand.length/3) - stand.y_cord}
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

	render() {
		const stands = this.renderStands(this.props.stands);
		const infos = this.renderInfos(this.props.stands);
		const stand_statuses = this.renderStatuses(this.props.stands);
		return (
				<svg width="700px" height="400px">
					{ stands }
					{ infos }
					{ stand_statuses }
				</svg>
		);
	}
}