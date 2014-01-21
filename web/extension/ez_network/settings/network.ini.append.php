<?php /*

[NetworkSettings]
ExtensionPath=ez_network

# PHP CLI monitor
PHPCLI=php

# Local IP
LocalIP=

# PHP free space and total space tests
DriveList[]
DriveList[]=/

# Used for oauth (needs to end with slash)
Server=https://support.ez.no/

[eZPHPFileSettings]
# Sets how often monitor file change monitors should be run.
MonitorFileChangeFrequency=1

# Files to include in PHP checker.
MonitorIncludePath[]
MonitorIncludePath[]=index.php
MonitorIncludePath[]=webdav.php
MonitorIncludePath[]=soap.php
MonitorIncludePath[]=kernel
MonitorIncludePath[]=lib
MonitorIncludePath[]=cronjobs
MonitorIncludePath[]=bin
MonitorIncludePath[]=update/common

[ClusterSettings]
# Cluster node type, possible values:              
# 'master' : Single server setup or master server in cluster setup
# 'slave'  : For Slave server(s) in cluster setup (also needs NodeID value bellow)                     
Mode=master

# Slave Node ID, needed on slave server(s) in cluster setup.                
# This value should be preconfigured by eZ support staff or provided to you by them when setting up ez_network
NodeID=


*/ ?>
