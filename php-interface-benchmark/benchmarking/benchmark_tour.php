<!DOCTYPE HTML>
<html lang = "en">
  <head>
    <link rel="stylesheet" type="text/css" href="benchmark_tour.css" />
    <script type="text/javascript" src="javascript.js"></script>
    <title>Single Benchmark</title>
    <meta charset = "UTF-8" />


  </head>
  <body>
    <h1>Single Tour Benchmarking</h1>
    <form method="post" action="benchmark_tour.php" onsubmit="parseTest();return false;">
       <fieldset>
<h4>Select a tour name, a time interval between POI's jumps and an optional Tag to perform a benchmark.</h4>
          <p>
             <label>Tour Name</label>
             <select id="tourname" name = "tourname">
               <option value = "bcn">Barcelona</option>
               <option value = "Horsens">Horsens</option>
               <option value = "desierto">Desert</option>
             </select>

             <label>Timing</label>
             <select id="time" name = "time">
               <option value = "1">30s</option>
               <option value = "1">60s</option>
             </select>

             <label>Tag</label>
             <select id="tag" name = "tag">
               <option value = ""></option>
               <option value = "s">s</option>
             </select>
	</p>
	<p>
          <label>Text Area</label>
          <textarea id = "myTextArea"
                  rows = "30"
                  cols = "80">Your text here</textarea>
        
          </p>
        <p>
	 <input id="submit" name="submit" type="submit" value="Start">
        </p>     
<h4>Make sure to wait for the benchmark to finish before performing another one.</h4>
<h4>Please, clear the cache after each tour</h4>
       </fieldset>
    </form>
    <div class="touchscreen">
      <div id="status"></div>
    </div>
	<p>
		<a class="tools" href="#" onClick="clearCache()">Clear cache</a>
	</p>
	<p>
		<a class="tools" id="back" href="benchmarking.php">Go Back</a>
	</p>
  </body>
</html>
