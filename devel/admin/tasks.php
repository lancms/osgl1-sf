<?php

require 'config/config.php';

if(!acl_access("tasks")) die($admin[noaccess]);

