<?php /*

# Monitor specific options.
[SystemConfSettings]
ConfTypeList[]
ConfTypeList[]=Apache
ConfTypeList[]=PHP
ConfTypeList[]=DB

[ApacheSettings]
ConfFileList[]
ConfFileList[]=/etc/httpd/conf/httpd.conf

[PHPSettings]
ConfFileList[]
ConfFileList[]=/etc/php.ini

[DBSettings]
ConfFileList[]
ConfFileList[]=/etc/my.cnf

[CleanUpSettings]
# Number of days how long we should keep monitor results and its values.
# After execution of monitors the script removes mon data older than this value in days.
# If it is '0' cleaning will not be performed.
MonitorDaysExpiry=7

# This number decides how many old monitor result datasets are removed each time the monitor cronjob is run.
# If it is '0' all expired monitor result data will be removed.
RemoveOldDatasetRate=10000

*/ ?>
