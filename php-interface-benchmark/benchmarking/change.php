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

//Peruse-a-rue Benchmarking
$var_Break="[BRK]";
if (isset($_REQUEST['initPeruse']) and ($_REQUEST['initPeruse'] != '') and isset($_REQUEST['port']) and ($_REQUEST['port'] != '')) { 
        $var1 = "Connecting to: " . $_REQUEST['initPeruse'] . ":" . $_REQUEST['port'];
        $var2 = $_REQUEST['initPeruse'] . " " . $_REQUEST['port'];

        echo "$var1"; 
	shell_exec("/usr/bin/sudo -H -u lg /home/lg/bin/lg-peruse-a-rue $var2");

}elseif (isset($_REQUEST['startPeruseTour'])) { 
	$var1= "Peruse-a-rue Benchmark done";
	$var2= $_REQUEST['startPeruseTour'] ." ". $_REQUEST['ip'] ." ". $_REQUEST['port']. " " . $_REQUEST['time'];
	$result= shell_exec('/usr/bin/sudo -H -u lg /home/lg/LG_Web-Benchmarking/Benchmark/Monitor/Benchmark.sh ' . $var2);
	echo "$var1$var_Break$result"; 
}elseif (isset($_REQUEST['analyze'])) { 
	$var1="Analyzed";
	$result= shell_exec('/usr/bin/sudo -H -u lg /home/lg/LG_Web-Benchmarking/Benchmark/Parse/Analyze.sh '. $_REQUEST['analyze']);
	echo "$var1$var_Break$result"; 
}elseif (isset($_REQUEST['charts'])) { 
	$var1="Created Charts";
	$result= shell_exec('/usr/bin/sudo -H -u lg /home/lg/LG_Web-Benchmarking/Benchmark/Charts-gen/getCharts.sh '. $_REQUEST['charts']);
	echo "$var1$var_Break$result"; 
}elseif (isset($_REQUEST['clean'])) { 
	echo "Cleaned Data";
	exec('/usr/bin/sudo -H -u lg /home/lg/LG_Web-Benchmarking/cleanBench.sh '. $_REQUEST['clean']);

//TOOLS
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
