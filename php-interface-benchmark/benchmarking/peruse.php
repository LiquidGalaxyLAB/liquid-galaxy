<?php

?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script type="text/javascript" src="javascript.js"></script> 
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
		<title>Liquid Galaxy Benchmarking</title>
	</head>
	<nav>
		<ul>
			<h1>Benchmarking</h1>
			<li>
				<h5>Please, fill in the IP and Ports before Initializing Peruse-a-rue or Connecting the Controller</h5>
				<label for="myIP"> IP </label>
				<input type="text"  id = "myIP" value="lg1">
				<label for="myPORT"> Port </label>
				<input type="text"  id = "myPORT" value="8086">
				<label for="myCPORT"> Controller Port </label>
				<input type="text"  id = "myCPORT" value="8087">
			</li>
			<li><a href="#" onclick="initPeruse();">Initialize Peruse-a-rue </a></li>
			<li><a href="#" onclick="connectController();">Connect Controller </a></li>
			<li><a href="#" onClick="startTour()">Start Benchmark</a></li>
			<li><a href="#" onClick="emitLogONOFF()">Switch FPS ON/OFF</a></li>
			<li><a href="#" onClick="emitDownloadLog()">Get Log</a></li>

	<p>
          <label>Output</label>
          <textarea id = "myTextArea"
                  rows = "1"
                  cols = "80"></textarea>
        
          </p>
        <p>
	<input id="showbtn" name="showbtn" type="button" value="Show output" onClick="toggleShow()">
        </p>     

			<li><a id="back" href="index.php">Go Back</a></li>
		</ul>
	</nav>
	<body>
		<div class="touchscreen">
			<div id="status"></div>
		</div>
	</body>
</html>
