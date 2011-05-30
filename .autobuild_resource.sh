#!/bin/bash

kansit -s '{*.rst,_theme/**/*,_templates/*}' -c 'make clean && make html'
