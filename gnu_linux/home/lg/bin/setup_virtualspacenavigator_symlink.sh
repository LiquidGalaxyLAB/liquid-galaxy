#!/bin/bash

sudo ln -sf $(sudo /home/lg/bin/list_devices_input | grep virtual-spaceavigator |  head -1 | cut -d ' ' -f 1) /dev/input/spacenavigator

