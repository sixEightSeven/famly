import React, { Component } from 'react';
import logo from './logo.svg';
import './App.css';
import './css/gridStyle.css';

class App extends Component {
  render() {
    return (
      <div className="App">
        <header className="App-header">
          <img src={logo} className="App-logo" alt="logo" />
          <h1 className="App-title">Welcome to React</h1>
        </header>
        <p className="App-intro">
          To get started, edit <code>src/App.js</code> and save to reload.
        </p>
        <div>

          <div id='mainWrapper'>
            <div id='leftPanel'>
              <div id="lpTopPane">
                  <div id="lptpInfo">
                    <div id="lptpPhotoPane">lptpPhotoPane</div>
                    <div id="lptpPhtoCaptionPane">lptpPhtoCaptionPane</div>
                  </div>
                  <div id="lptpDescriptions">
                  lptpDescriptions: <br/>
                  Start of description here...Praesent sapien purus, ultrices a, varius ac, suscipit ut, enim. Maecenas in lectus.
                  Donec in sapien in nibh rutr
                  </div>
              </div>
              <div id="lpBottomPane">
                  <div id="lpbpComments">lpbpComments</div>
                  <div id="lpbpButtons">

                    {/* <a href="#" id="btnCategory" class="infoButton">Categorize</a>
                    <a href="#" id="btnUpdate" class="updateButton">Update Incident</a>  */}

                    <ul>
                        <li class="infoButton"><a href="#" id="btnCategory" class="infoButton">Categorize</a></li>
                        <li class="updateButton"><a href="#" id="btnUpdate" class="updateButton">Update Incident</a></li>
                    </ul>
                  </div>
                  
              </div>
            </div>
            <div id='rightPanel'>
              <div id="rpQueue">rpQueue</div>
              <div id="rpStats">rpStats</div>
            </div>
        </div>

        </div>
      </div>
    );
  }
}

export default App;
