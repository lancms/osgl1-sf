<?php

function printmenu ()
{
	global $page;

	$menu['index']['title'] = 'Main';
	$menu['index']['url'] = 'index.php';

	$menu['sf']['title'] = 'Project site';
	$menu['sf']['url'] = 'http://www.sourceforge.net/projects/osglobelan/';


	foreach ($menu as $ref => $key)
	{
		if ($page == $ref)
		{
			$return .= "<a class='menusel' href='".$menu[$ref]['url']."'>".$menu[$ref]['title']."</a> &nbsp;";
		}
		else
		{
			$return .= "<a class='menu' href='".$menu[$ref]['url']."'>".$menu[$ref]['title']."</a> &nbsp;";
		}
	}

	echo $return;

}

?>
