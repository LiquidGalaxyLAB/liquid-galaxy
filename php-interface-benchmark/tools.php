<?php

?>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script type="text/javascript" src="javascript.js"></script>

    <title>Liquid Galaxy Benchmarking</title>
  </head>
    <nav>
    <ul>
    <h1>Tools</h1>
     <li><a href="#" onclick="sendQuery('relaunch');">Relaunch</a></li>
     <li><a href="#" onclick="sendQuery('reboot');">Reboot</a></li>
     <li><a href="#" onclick="sendQuery('shutdown');">Shutdown</a></li>

	<li><a id="back" href="index.php">Go Back</a></li>
    </ul>
    </nav>

  <body>
    <div class="touchscreen">
      <div id="status"></div>
    </div>
  </body>
</html>
