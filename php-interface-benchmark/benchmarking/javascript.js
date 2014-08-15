/* Copyright 2010 Google Inc.
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *    http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */


window.onload = function (e) {
  var evt = e || window.event;
  var imgs;
  if (evt.preventDefault) {
    imgs = document.getElementsByTagName('img');
    for (var i = 0; i < imgs.length; i++) {
      imgs[i].onmousedown = disableDragging;
    }
  }
}

function disableDragging(e) {
  e.preventDefault();
}

function createRequest() {
  if (window.XMLHttpRequest) {
    var req = new XMLHttpRequest();
    return req;
  }
}

function submitRequest(url) {
  var req = createRequest();
  req.onreadystatechange = function() {
    if (req.readyState == 4) {
      if (req.status == 200) {
	document.getElementById('status').innerHTML = req.responseText;
      }
    }
  }
  req.open('GET', url, true);
  req.send(null);
}

function submitRequest_output(url) {
  var req = createRequest();
  req.onreadystatechange = function() {
    if (req.readyState == 4) {
      if (req.status == 200) {
	data = req.responseText.split ( "[BRK]" );
	document.getElementById("status").innerHTML = data[0];
	document.getElementById("myTextArea").innerHTML = data[1];
      }
    }
  }
  req.open('GET', url, false);
  req.send(null);
}



var show = false;
function toggleShow() {
    var t = document.getElementById("myTextArea");
	var size1 = 30;
	var size2 = 1;
    var b = document.getElementById("showbtn");
    show = !show;
    if (show) {
        b.value = "Hide Output";
	t.rows=size1;
    }
    else {
        b.value = "Show Output";
	t.rows=size2;
    }
}

function initPeruse() {
  var myIp = document.getElementById('myIP').value;
  var myPort = document.getElementById('myPORT').value;
  submitRequest('change.php?initPeruse=' + myIp + '&port=' + myPort);
  showAndHideStatus();
}

function switchFPS() {
  submitRequest('change.php?fps');
  showAndHideStatus();
}

function getLog() {
  submitRequest('change.php?getlog');
  showAndHideStatus();
}

function clearCache() {
  submitRequest('change.php?clear');
  showAndHideStatus();
}

function sendQuery(query) {
  submitRequest('change.php?query=' + query);
  showAndHideStatus();
}
function showAndHideStatus() {
  var status = document.getElementById('status');
  status.style.opacity = 1;
  window.setTimeout('document.getElementById("status").style.opacity = 0;', 5000);
}
function stopAll() {
  submitRequest('change.php?stop');
  showAndHideStatus();
}

var socket;
function connectController(){
	var myCIP = document.getElementById('myIP').value;
	var myPORT = document.getElementById('myPORT').value;

	loadJS('http://' + myCIP +':'+ myPORT +'/socket.io/socket.io.js', function() { 
	   socket = io.connect('http://' + myCIP +':'+ myPORT+'/fps');
	    
	    socket.on('connect', function(){
		console.log('FPS Controller module connected');
		document.getElementById("status").innerHTML = "Controller Connected";
		showAndHideStatus();
	    });

	    socket.on('message', function(data){ 
		console.log('MSG: ' + data.message);
	    });

	    socket.on('disconnect', function(){
		console.log('disconected');
	    });

	    socket.on('fpsSwitch', function(data){
		console.log(data.message);
		document.getElementById("status").innerHTML = data.message;
		showAndHideStatus();
	    });

	    socket.on('giveLOG', function(data){
		console.log(data.message);
		document.getElementById("status").innerHTML = data.message;
		showAndHideStatus();
	    });
	}); 

}

function emitDownloadLog() {
	socket.emit('getLOG',{message:document.getElementById("myTag").value});
}

function emitLogONOFF() {
	socket.emit('logONOFF');
}

function loadJS(src, callback) {
    var s = document.createElement('script');
    s.src = src;
    s.async = true;
    s.onreadystatechange = s.onload = function() {
        var state = s.readyState;
        if (!callback.done && (!state || /loaded|complete/.test(state))) {
            callback.done = true;
            callback();
        }
    };
    document.getElementsByTagName('head')[0].appendChild(s);
}

function startTour(){
  var tag= document.getElementById("myTag").value;
	var myIP = document.getElementById('myIP').value;
	var myPORT = document.getElementById('myPORT').value;
	var myTime = document.getElementById('myTime').value;
	emitLogONOFF();
	submitRequest_output('change.php?startPeruseTour=' + tag + '&ip=' + myIP + '&port=' +myPORT + '&time=' +myTime);
	showAndHideStatus();
	emitLogONOFF();
	emitDownloadLog();
}

function OpenInNewTab() {
  var myIP = document.getElementById('myIP').value;
  var myPORT = document.getElementById('myPORT').value;

  var url = 'http://' + myIP +':'+ myPORT +'/touchscreen';
  var win = window.open(url, '_blank');
  win.focus();
}

function analyze(){
  submitRequest_output('change.php?analyze='+document.getElementById('clusterName').value);
  showAndHideStatus();
}

function createCharts(){
  submitRequest_output('change.php?charts='+document.getElementById('myTag').value);
  showAndHideStatus();
}

function cleanData(){
  submitRequest('change.php?clean='+document.getElementById('myCleanBox').value);
  showAndHideStatus();
}
