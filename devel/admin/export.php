<?php

if (!acl_access("ACL"))
{
	nicedie($admin[noaccess]);
}


$q = reverse_acl("isCrew")

while($r = fetch($q)) {
	echo $r->ID.":";
	echo $r->name.":";
	echo $r->nick.":";
	echo $r->password.":";
	echo "\n";
}