import React from 'react';

export default class Stand extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		return (
			<rect className="stands" key={this.props.stand.id} width={this.props.stand.breadth} height={this.props.stand.length} x={this.props.stand.x_cord} y={this.props.stand.y_cord}></rect>
		);
	}
}