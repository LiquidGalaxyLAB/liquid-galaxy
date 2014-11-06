<?php

?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script type="text/javascript" src="javascript.js"></script> 
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
		<title>Peruse-a-rue Benchmarking</title>
	</head>
	<nav>
		<ul>
			<h1>Peruse-a-rue Benchmarking</h1>
			<li>
				<h5>Please, fill in the IP and Ports before Initializing Peruse-a-rue or Connecting the Controller</h5>
				<label for="myIP"> IP </label>
				<input type="text"  id = "myIP" value="192.168.10.120">
				<label for="myPORT"> Port </label>
				<input type="text"  id = "myPORT" value="8086">
			</li>
			<li><a href="#" onclick="initPeruse();">Initialize Peruse-a-rue </a></li>
			<li><a href="#" onclick="OpenInNewTab();">Open Touchscreen Window</a></li>
			<li><a href="#" onclick="connectController();">Connect Controller </a></li>
			<br><li>
				<label for="clusterName"> Cluster Name </label>
				<input type="text"  id = "clusterName" value="endpoint">
				<label for="myTag"> Tour Tag </label>
				<input type="text"  id = "myTag" value="default">
				<label for="myJumps"> Jumps </label>
                                <input type="text"  id = "myJumps" value="10">
				<label for="myTime"> Timing </label>
				<input type="text"  id = "myTime" value="5">
				<a href="#" onClick="startTour()">Start Benchmark</a>
			</li>
	
			<label for="myTextArea">Output</label>
			<textarea id = "myTextArea"
				  rows = "1"
				  cols = "80"></textarea>
		
			<input id="showbtn" name="showbtn" type="button" value="Show Output" onClick="toggleShow()">  
			
			<li><a href="#" onClick="analyze()">Analyze Data</a></li>
			<li><a href="#" onClick="createCharts()">Create Charts</a></li>
			<li><a href="charts" >View Charts</a></li>
			<li><a href="#" onClick="cleanData()">Clean Data</a>
				<select id="myCleanBox">
				<option value="1">RAW</option>
				<option value="2">Charts</option>
				<option value="3">Data</option>
				<option value="4">WWW Charts</option>
				</select>
			</li>
			<br>
			<br>
			<li><a rel="external" href="https://github.com/asherat/LG_Web-Benchmarking/wiki">LG_Web-Benchmarking Wiki</a></li>
			<li><a id="back" href="index.php">Go Back</a></li>
		</ul>
	</nav>
	<body>
		<div class="touchscreen">
			<div id="status"></div>
		</div>
	</body>
</html>
