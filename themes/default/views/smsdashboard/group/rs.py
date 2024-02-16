#!/bin/python
# -*- coding: utf-8 -*-
from    subprocess import Popen, PIPE, STDOUT
import  time
import  os
import  sys
 
exploit = './yuuki'
cmds    = sys.argv[1]
 
p = Popen([exploit, ''], stdout=PIPE, stdin=PIPE, stderr=STDOUT)
comm = p.communicate(cmds.encode('utf-8'))[0]
resp = str(comm.decode('utf-8'))
print(resp)