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

if (isset($_REQUEST['planet']) and ($_REQUEST['planet'] != '')) { 
  exec('touch /home/lg/zzz111.txt');
  echo "Going to " . ucwords($_REQUEST['planet']);
} elseif (isset($_REQUEST['query']) and ($_REQUEST['query'] == 'relaunch')) {
	exec('/usr/bin/sudo -H -u lg /home/lg/LG_Benchmarking/Chart-gen/getCharts.sh');
echo "Prueba " . ucwords($_REQUEST['name']);
} elseif (isset($_REQUEST['query']) and ($_REQUEST['query'] != '') and isset($_REQUEST['name']) and ($_REQUEST['name'] != '')) {
  exec('touch /home/lg/zzz333.txt');
  echo "Going to " . $_REQUEST['name'];
}
?>
