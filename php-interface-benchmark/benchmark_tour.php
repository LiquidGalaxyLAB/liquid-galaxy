<!DOCTYPE HTML>
<html lang = "en">
  <head>
    <title>Single Tour Benchmarking</title>
    <meta charset = "UTF-8" />
<?php

    $tourname = $_POST['tourname'];
    $time = $_POST['time'];
    $tag = $_POST['tag'];
    $body = "$tourname $time";

if ($_POST['submit']) {
 if (!empty($tag)) {
	$body = "$body -$tag";
}
echo "Starting benchmarking on $tourname\n" ;
exec('/usr/bin/sudo -H -u lg /home/lg/LG_Benchmarking/Scripts/Benchmark.sh bcn 0');
echo "\nDone benchmarking on $tourname" ;
}
?>

  </head>
  <body>
    <h1>Single Tour Benchmarking</h1>
    <form method="post" action="benchmark_tour.php">
       <fieldset>
          <legend>Selecting elements</legend>
          <p>
             <label>Tour Name</label>
             <select name = "tourname">
               <option value = "bcn">Barcelona</option>
               <option value = "Horsens">Horsens</option>
               <option value = "Desert">Desert</option>
             </select>

             <label>Timing</label>
             <select name = "time">
               <option value = "30">30s</option>
               <option value = "60">60s</option>
             </select>

             <label>Tag</label>
             <select name = "tag">
               <option value = ""></option>
               <option value = "s">s</option>
             </select>
          </p>
        <p>
	 <input id="submit" name="submit" type="submit" value="Submit">
        </p>     
       </fieldset>
    </form>
    <div class="touchscreen">
      <div id="status"></div>
    </div>
  </body>
</html>
