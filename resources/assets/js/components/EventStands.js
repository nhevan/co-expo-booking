import React from 'react';
import Stand from './Stand';

export default class EventStands extends React.Component {
	constructor(props) {
		super(props);
	}

	renderStands(stands){
		if (stands.length > 0) {      
	        return stands.map((stand) => (
	            <rect className="stands" key={stand.id} width={stand.breadth + 'px'} height={stand.length + 'px'} x={stand.x_cord + 'px'} y={stand.y_cord + 'px'}></rect>
	        ));
	    }
	    else return [];
	}

	render() {
		const stands = this.renderStands(this.props.stands)
		return (
				<svg width="700px" height="400px">
					{ stands }
				</svg>
		);
	}
}