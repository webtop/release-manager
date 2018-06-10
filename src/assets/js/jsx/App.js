import React, {Component} from "react";

class App extends Component {
	render() {
		return (
			<div className="mainContent mainContentNormal">
				<div className="header">
					<div className="titleBar">
						<span className="title">Release Manager</span>
					</div>
					<button className="btn maximizeBtn" type="button"></button>
				</div>
				<div id="content" className="content"></div>
			</div>
		);
	}
}

export default App;