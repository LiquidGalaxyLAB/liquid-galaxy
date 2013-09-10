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
if (isset($_REQUEST['benchmark']) and ($_REQUEST['benchmark'] != '') and isset($_REQUEST['time']) and ($_REQUEST['time'] != '')) { 
  if (isset($_REQUEST['tag']) and ($_REQUEST['tag'] != '')){
    echo "Benchmark: " . ucwords($_REQUEST['benchmark']) . ", Time: " . ucwords($_REQUEST['time']) . "s, Tag: ". ucwords($_REQUEST['tag']);
  }else{
    echo "Benchmark: " . ucwords($_REQUEST['benchmark']) . ", Time: " . ucwords($_REQUEST['time']);
  }
}elseif (isset($_REQUEST['autobenchmark'])) { 
    echo "Starting auto benchmarking";
    exec('/usr/bin/sudo -H -u lg /home/lg/Benchmarking/Scripts/fullBenchmark.sh');
}elseif (isset($_REQUEST['analize'])) { 
    echo "Analizing";
    exec('/usr/bin/sudo -H -u lg /home/lg/Benchmarking/Scripts/Analize.sh');
}elseif (isset($_REQUEST['copydata'])) { 
    echo "Copying Data";
    exec('/usr/bin/sudo -H -u lg /home/lg/Benchmarking/Scripts/CopyData.sh');
}elseif (isset($_REQUEST['charts'])) { 
    echo "Getting Charts";
    exec('/usr/bin/sudo -H -u lg /home/lg/Benchmarking/Chart-gen/getCharts.sh');


}elseif (isset($_REQUEST['query']) and ($_REQUEST['query'] == 'shutdown')) {
    echo "Shutting Down";
    exec('/usr/bin/sudo -H -u lg /home/lg/bin/lg-sudo \'shutdown -h 0\'');
}
?>
