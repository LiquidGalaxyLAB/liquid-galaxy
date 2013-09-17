<?php

?>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script type="text/javascript" src="javascript.js"></script>

    <title>Liquid Galaxy Benchmarking</title>
  </head>
    <nav id="navbar">
    <ul>
     <li><a rel="external" href="#" onclick="autoBenchmark();">All Benchmark</a></li>
     <li><a rel="external" href="benchmark_tour.php" onclick="launchBenchmark('bcn', '30');">Benchmark</a></li>
     <li><a rel="external" href="#" onclick="launchBenchmarkTag('bcn', '60', '-s');">Benchmark Long</a></li>
     <li><a rel="external" href="#" onclick="analize();">Analize</a></li>
     <li><a rel="external" href="#" onclick="copyData();">Copy Data</a></li>
     <li><a rel="external" href="#" onclick="getCharts();">Charts</a></li>
     <li><a rel="external" href="#" onclick="sendQuery('shutdown');">Shutdown</a></li>
    </ul>
    </nav>

  <body>
    <div class="touchscreen">
      <div id="status"></div>
    </div>
  </body>
</html>
