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


$var_Break="[BRK]";
if (isset($_REQUEST['benchmark']) and ($_REQUEST['benchmark'] != '') and isset($_REQUEST['time']) and ($_REQUEST['time'] != '')) { 
	$var1 = "Benchmark: " . $_REQUEST['benchmark'] . ", Time: " . $_REQUEST['time'] . "s";
	$var2 = $_REQUEST['benchmark'] . " " . $_REQUEST['time'];
	if (isset($_REQUEST['tag']) and ($_REQUEST['tag'] != '')){
    		$var1 = $var1 . ", Tag: ". $_REQUEST['tag'];
		$var2 = $var2 . " -" . $_REQUEST['tag'];
	}
$result= shell_exec("/usr/bin/sudo -H -u lg /home/lg/LG_Benchmarking/Scripts/Benchmark.sh $var2");
	echo "$var1$var_Break$result"; 
}elseif (isset($_REQUEST['autobenchmark'])) { 
    echo "Starting auto benchmarking";
    exec('/usr/bin/sudo -H -u lg /home/lg/LG_Benchmarking/Scripts/fullBenchmark.sh');
}elseif (isset($_REQUEST['clear'])) { 
    echo "Clearing Cache";
    exec('/usr/bin/sudo -H -u lg /home/lg/LG_Benchmarking/Scripts/clearCache.sh 3');
}elseif (isset($_REQUEST['analize'])) { 
    echo "Analizing";
    exec('/usr/bin/sudo -H -u lg /home/lg/LG_Benchmarking/Scripts/Analize.sh');
}elseif (isset($_REQUEST['copydata'])) { 
    echo "Copying Data";
    exec('/usr/bin/sudo -H -u lg /home/lg/LG_Benchmarking/Scripts/CopyData.sh');
}elseif (isset($_REQUEST['charts'])) { 
    echo "Getting Charts";
    exec('/usr/bin/sudo -H -u lg /home/lg/LG_Benchmarking/Chart-gen/getCharts.sh');
}elseif (isset($_REQUEST['query']) and ($_REQUEST['query'] == 'relaunch')) {
    echo "Relaunching";
    exec('/usr/bin/sudo -H -u lg /home/lg/bin/lg-relaunch');
}elseif (isset($_REQUEST['query']) and ($_REQUEST['query'] == 'reboot')) {
    echo "Rebooting";
    exec('/usr/bin/sudo -H -u lg /home/lg/bin/lg-sudo reboot');
}elseif (isset($_REQUEST['query']) and ($_REQUEST['query'] == 'shutdown')) {
    echo "Shutting Down";
    exec('/usr/bin/sudo -H -u lg /home/lg/bin/lg-sudo \'shutdown -h 0\'');
}elseif (isset($_REQUEST['stop'])) {
    echo "Stopping Benchmarking";
    exec('/usr/bin/sudo -H -u lg /home/lg/LG_Benchmarking/Scripts/stopAll.sh');
}



?>
