<?php
# Copyright 2010 Google Inc.
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#    http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.

include "sync_inc.php";

$queries = array('layers' => array(), 'earth' => array(), 'moon' => array(), 'mars' => array());
$delimiter = "@";
$handle = @fopen("queries.txt", "r");
if ($handle) {
  while (!feof($handle)) {
    $buffer = fgets($handle);
    if (substr_count($buffer, $delimiter) == 2) {
      list($planet, $name, $query) = explode($delimiter, $buffer);
      $planet = explode('/', $planet)[0]; // tmp subcategories
      $queries[$planet][] = array(trim($name), trim($query));
    }
  }
  fclose($handle);
}

#LG server
$KML_SYS_PATH = '/var/www/kml/';
$KML_SERVER_BASE = 'http://lg1:81/kml/';

$FILE_FILTER = '*.km[l|z]';

$kml_files = array('earth' => array(), 'moon' => array(), 'mars' => array(), 'layers' => array());
foreach (array_keys($kml_files) as $planet) {
  $planet_kml_path = $KML_SYS_PATH . $planet . "/" . $FILE_FILTER;
  foreach (glob($planet_kml_path) as $file) {
    $basename = str_replace('_', ' ', explode('.', basename($file)));
    $kml_files[$planet][$basename[0]] = str_replace($KML_SYS_PATH, $KML_SERVER_BASE, $file);
  }
}

$kml_data_file = 'kmls.txt';

$existing_kml_url_list = array_values(getKmlListUrls($kml_data_file));

?>
<html>
  <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js" /></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>
    <script type="text/javascript" src="javascript.js"></script>
    <script type="text/javascript">
      function clearKmls() {
        //showAndHideStatus();
        <?php  $i = 0; foreach (array_values($queries['layers']) as $layer) { ?>
          submitRequest('sync_touchscreen.php?touch_action=delete&touch_kml=<?php echo $layer[1]; ?>');
          //document.getElementById('kml_<?php echo $i; ?>').className='kml_off';
        <?php ++$i; } ?>
        //showAndHideStatus();
      }
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
    <title>Liquid Galaxy</title>
  </head>
  <body onload="noneExpand('e_earth', 'e_layers', 'e_moon', 'e_mars', 'e_keyboard');">
    <nav>
      <div id="default-bar" class="nav-wrapper">
        <a href="index.php" class="brand-logo left">Liquid Galaxy</a>
        <ul class="right">
          <li><a href="#" onclick="changeQuery('relaunch', 'Relaunch');">Relaunch</a></li>
          <li><a href="#" onclick="enableSearchBar()"><i class="material-icons">search</i></a></li>
        </ul>
      </div>
      <div id="search-bar" class="nav-wrapper disabled">
        <form name="search-form" onsubmit="searchKey(); return false;">
          <div class="input-field">
            <input id="search" name="place" type="search" required onblur="disableSearchBar()">
            <label for="search"><i class="material-icons">search</i></label>
            <i class="material-icons">close</i>
          </div>
        </form>
      </div>
    </nav>

    <div class="touchscreen">
      <div id="card-results">
        <div class="expand_inactive" id="e_earth">
          <div class="row">
            <h3 class="header left">Earth</h3>
          </div>
          <ul class="collection">
          <?php $i = 0; foreach (array_values($queries['earth']) as $layer) { ?>
              <li id="kml_<?php echo $i; ?>" class="collection-item waves-effect" onclick="changeQuery('<?php echo $layer[1]; ?>', '<?php echo $layer[0]; ?>');">
                <div>
                  <?php echo $layer[0]; ?>
                  <a href="#!" class="secondary-content"><i class="material-icons">send</i></a>
                </div>
              </li>
          <?php ++$i; } ?>
          </ul>
        </div>
        <div class="expand_inactive" id="e_moon">
          <div class="row">
            <h3 class="header left">Moon</h3>
          </div>
          <ul class="collection with-header">
          <?php $i = 0; foreach (array_values($queries['moon']) as $layer) { ?>
              <li id="kml_<?php echo $i; ?>" class="collection-item waves-effect" onclick="changeQuery('<?php echo $layer[1]; ?>', '<?php echo $layer[0]; ?>');">
                <div>
                  <?php echo $layer[0]; ?>
                  <a href="#!" class="secondary-content"><i class="material-icons">send</i></a>
                </div>
              </li>
          <?php ++$i; } ?>
          </ul>
        </div>
        <div class="expand_inactive" id="e_mars">
          <div class="row">
            <h3 class="header left">Mars</h3>
          </div>
          <ul class="collection with-header">
          <?php $i = 0; foreach (array_values($queries['mars']) as $layer) { ?>
              <li id="kml_<?php echo $i; ?>" class="collection-item waves-effect" onclick="changeQuery('<?php echo $layer[1]; ?>', '<?php echo $layer[0]; ?>');">
                <div>
                  <?php echo $layer[0]; ?>
                  <a href="#!" class="secondary-content"><i class="material-icons">send</i></a>
                </div>
              </li>
          <?php ++$i; } ?>
          </ul>
        </div>
        <div class="expand_inactive" id="e_layers">
          <div class="row">
            <h3 class="header left">Layers</h3>
          </div>
          <ul class="collection with-header">
          <?php $i = 0; foreach (array_values($queries['layers']) as $layer) { ?>
              <li id="kml_<?php echo $i; ?>" class="collection-item waves-effect" onclick="toggleKml(this, '<?php echo $layer[1]; ?>', '<?php echo $layer[0]; ?>');">
                <div>
                  <?php echo $layer[0]; ?>
                  <a href="#!" class="secondary-content"><i class="material-icons">send</i></a>
                </div>
              </li>
          <?php ++$i; } ?>
          </ul>
        </div>
        </ul>
      </div>

      <div id="categories" class="row">
        <div class="col s12 m6 l3">
          <div class="card medium" onclick="changePlanet('earth'); clearKmls(); toggleExpand('e_earth', 'e_layers', 'e_moon', 'e_mars', 'e_keyboard');">
             <div class="card-image waves-effect waves-block waves-light">
               <img class="activator" src="earth.png">
             </div>
             <div class="card-content">
               <span class="card-title activator grey-text text-darken-4">Earth</span>
               <div class="card-content">
                <a href="#">View POIs</a>
              </div>
             </div>
          </div>
        </div>
        <div class="col s12 m6 l3">
          <div class="card medium" onclick="changePlanet('moon'); clearKmls(); toggleExpand('e_moon', 'e_earth', 'e_layers','e_mars', 'e_keyboard');">
             <div class="card-image waves-effect waves-block waves-light">
               <img class="activator" src="moon.png">
             </div>
             <div class="card-content">
               <span class="card-title activator grey-text text-darken-4">Moon</span>
               <div class="card-content">
                <a href="#">View POIs</a>
              </div>
             </div>
          </div>
        </div>
        <div class="col s12 m6 l3">
          <div class="card medium" onclick="changePlanet('mars'); clearKmls(); toggleExpand('e_mars', 'e_earth', 'e_layers','e_moon', 'e_keyboard');">
             <div class="card-image waves-effect waves-block waves-light">
               <img class="activator" src="mars.png">
             </div>
             <div class="card-content">
               <span class="card-title activator grey-text text-darken-4">Mars</span>
               <div class="card-content">
                <a href="#">View POIs</a>
              </div>
             </div>
          </div>
        </div>
        <div class="col s12 m6 l3">
          <div class="card medium" onclick="changePlanet('earth'); clearKmls(); toggleExpand('e_layers', 'e_earth', 'e_mars','e_moon', 'e_keyboard');">
             <div class="card-image waves-effect waves-block waves-light">
               <img class="activator" src="layers.png">
             </div>
             <div class="card-content">
               <span class="card-title activator grey-text text-darken-4">Layers</span>
               <div class="card-content">
                <a href="#">View POIs</a>
              </div>
             </div>
          </div>
        </div>
      </div>

    </div>
  </body>
</html>
