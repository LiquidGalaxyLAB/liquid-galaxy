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
  req.open('GET', url, true);
  req.send(null);
}
function autoBenchmark() {
  submitRequest('change.php?autobenchmark');
  showAndHideStatus();
}

function launchBenchmark(tourname,time) {
  submitRequest_output('change.php?benchmark=' + tourname + '&time=' + time);
  showAndHideStatus();
}

function launchBenchmarkTag(tourname,time,tag) {
  submitRequest_output('change.php?benchmark=' + tourname + '&time=' + time + '&tag=' + tag);
  showAndHideStatus();
}

function clearCache() {
  submitRequest('change.php?clear');
  showAndHideStatus();
}

function analize() {
  submitRequest('change.php?analize');
  showAndHideStatus();
}

function copyData() {
  submitRequest('change.php?copydata');
  showAndHideStatus();
}

function getCharts() {
  submitRequest('change.php?charts');
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

function parseTest() {

 var elem_1 = document.getElementById('tourname');
 var elem_2 = document.getElementById('time');
 var elem_3 = document.getElementById('tag');

 var inp_1 = elem_1.value;
 var inp_2 = elem_2.value;
 var inp_3 = elem_3.value;

 if (inp_3 == ""){
	launchBenchmark(inp_1,inp_2);
 }else{
	launchBenchmarkTag(inp_1,inp_2,inp_3);
 }
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
