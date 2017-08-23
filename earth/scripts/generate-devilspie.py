#!/usr/bin/env python

import os
import subprocess

class Dimension(object):
	def __init__(self, width, height):
		self.width = int(width)
		self.height = int(height)

	def __str__(self):
		return '{0}x{1}'.format(self.width, self.height)

def get_dimensions():
	output = subprocess.Popen('xdpyinfo | awk \'/dimensions/{print $2}\'', shell=True, stdout=subprocess.PIPE).communicate()[0]
	output = output.split('x')
	return Dimension(output[0], output[1])

if __name__ == '__main__':
	dimensions = get_dimensions()
	newDimensions = Dimension(dimensions.width, dimensions.height + 21) # 21px white earth menu

	home = os.getenv('HOME', '/home/lg')
	filename = '{0}/.devilspie/googleearth.ds'.format(home)

	if not os.path.exists(os.path.dirname(filename)):
	    try:
	        os.makedirs(os.path.dirname(filename))
	    except OSError as exc: # Guard against race condition
	        if exc.errno != errno.EEXIST:
	            raise

	with open(filename, 'w') as f:
		f.write("""(if
 (is (window_name) "Google Earth Pro")
 (begin
  (geometry "%sx%s+0-1")
  (undecorate)
 )
)		
""" % (newDimensions.width, newDimensions.height))

	print newDimensions

	exit(0)