<?php

require_once 'config/config.php';

if(!config("usepage_forum")) die($msg[1]);

$action = $_GET['action'];
$catID = $_GET['catID'];
$threadID = $_GET['threadID'];

if(!isset($action)) {
	$action = "main";
}



if($action == "main") {
	include $base_path."style/top.php";
	$query = mysql_query("SELECT * FROM forumCats") or die(mysql_error());
	echo "<table class=forumCats>";
	$num = mysql_num_rows($query);

	for($i=0;$i<$num;$i++) {

		$row = mysql_fetch_object($query);
		if($row->crewOnly <= getuserrank() || $row->crewOnly == 0) {

			echo "<tr><td class=forumCatsCont><a href=forum.php?action=view&catID=$row->ID>$row->name</a></td><td class=forumCatsCont>$row->info</td><td class=forumCatsCont>";


//			$lastCats = mysql_query("SELECT * FROM forumThread WHERE catID = $row->ID ORDER BY ID DESC LIMIT 0,1") or die(mysql_error());
//			$lastCat = mysql_fetch_object($lastCats);
			$last = mysql_query("SELECT * FROM forumThread WHERE catID = $row->ID ORDER BY lastPostDate DESC LIMIT 0,1");
			$lastPost = mysql_fetch_object($last);

			if(mysql_num_rows($last) != 0) {

				$lastUser = mysql_query("SELECT * FROM forumPosts WHERE ID = ".$lastPost->lastPost." ORDER BY ID DESC LIMIT 0,1") or die(mysql_error());
				$user = mysql_fetch_object($lastUser);
				echo $forum[0];
				echo IDtonick($user->poster);

			}

			else echo $msg[18];
			echo "</td><td>";
			echo $user->date;
			echo "</td>";
			echo "</tr>";
		}

	}
	echo "</table>";
	include $base_path."style/bottom.php";

} elseif($action == "view" && !isset($threadID) && isset($catID)) {
	include $base_path."style/top.php";

	$query = mysql_query("SELECT * FROM forumThread WHERE catID = $catID ORDER BY lastPostDate DESC") or die(mysql_error());
	$num = mysql_num_rows($query);
	echo "<table class=forumTopics>";
	for($i=0;$i<$num;$i++) {
		$row = mysql_fetch_object($query);
		$rowID = $row->ID;
		echo "<tr><td class=forumTopicsCont>";
		echo "<a href=forum.php?action=view&threadID=$rowID&catID=$catID>";
		echo $row->header;
		echo "</a></td><td class=forumTopicsCont>$forum[0]";

		$lastUser = mysql_query("SELECT * FROM forumPosts WHERE threadID = $rowID ORDER BY ID DESC LIMIT 0,1") or die(mysql_error($lastUser));

		$user = mysql_fetch_object($lastUser);
		echo IDtonick($user->poster);
		echo "</td><td>";
		echo $row->date;
		echo "</td></tr>";

	}
	echo "</table>";
	if(getcurrentuserid() != 1) echo "<a href=forum.php?action=write&catID=$catID>".$forum[4]."</a>";
	include $base_path."style/bottom.php";
}

elseif($action == "view" && isset($threadID) && isset($catID)) {
	include $base_path."style/top.php";
	$query = mysql_query("SELECT * FROM forumPosts WHERE threadID = $threadID ORDER BY ID ASC");
	echo '<table>';
	$num = mysql_num_rows($query);
	$bgcolor = 1;

	for($i=0;$i<$num;$i++) {
		$row = mysql_fetch_object($query);

		$text = forumText($row->text);
		$bgcolor = -$bgcolor;
		if($bgcolor == 1) $class = "forumPost1";
		else $class = "forumPost2";
		echo "<tr><td class=".$class."header><a href=index.php?inc=profile&uid=$row->poster>".IDtonick($row->poster)."</a>&nbsp;$row->date&nbsp;</td></tr>";
		echo "<tr><td class=".$class."text>$text</td></tr>";
		echo "<tr><td><br></td></tr>";


	}
	echo '</table>';
	if(getcurrentuserid() != 1) echo "<a href=forum.php?action=write&threadID=$threadID>".$forum[5]."</a>";
	if(getuserrank() == 2) echo "&nbsp;|&nbsp;"."<a href=forum.php?action=delete&threadID=$threadID>".$forum[6]."</a>";
	include $base_path."style/bottom.php";

}

elseif($action == "write") {
	if(getcurrentuserid() == 1) die("You shouldn't even be able to push that link!");
	if(isset($threadID)) {
		$what = "reply";
	} else {
		$what = "new";
	}

	if($what == "new" && !isset($catID) || $what == "reply" && !isset($threadID)) {
		include $base_path."style/top.php";
		echo "Something happend that shouldn't have happen.... are you cheating?";
		include $base_path."style/bottom.php";
		die();
	}
	include $base_path."style/top.php";
	echo "<form method=post action=forum.php?action=dowrite&catID=$catID&threadID=$threadID>
	<input type=hidden name=what value=$what>";
	if($what == "new") echo "<input type=text name=header>";
	echo "<br><textarea name=text cols=65 rows=10></textarea>
	<br><input type=submit value='$forum[1]'>
	</form>
	";
	include $base_path."style/bottom.php";

} elseif($action == "dowrite" && isset($catID) && isset($threadID)) {
	if(getcurrentuserid() == 1) die("You shouldn't even be able to push that link!");
	$what = $_POST['what'];
	$text = $_POST['text'];
	$header = $_POST['header'];
	$me = getcurrentuserid();
	$IP = $HTTP_SERVER_VARS['REMOTE_ADDR'];
	if(empty($text)) die($forum[3]);
	if($what == "reply") {
		$query = mysql_query("INSERT INTO forumPosts SET poster = $me, date = now(), IP = '$IP', text = '$text', threadID = $threadID") or die(mysql_error());

	} elseif($what == "new") {
		if(empty($header)) die($forum[2]);
		$query1 = mysql_query("INSERT INTO forumThread SET poster = $me, header = '$header', date = now(), catID = $catID") or die(mysql_error());
		$threadID = mysql_insert_id();
		$query2 = mysql_query("INSERT INTO forumPosts SET poster = $me, text = '$text', IP = '$IP', date = now(), threadID = $threadID") or die(mysql_error());
	}
	$lastPost = mysql_query("SELECT * FROM forumPosts ORDER BY ID DESC LIMIT 0,1");
	$last = mysql_fetch_object($lastPost);
	mysql_query("UPDATE forumThread SET lastPost = $last->ID, lastPostDate = '".time()."' WHERE ID = $threadID") or die(mysql_error());
	header("Location: forum.php?action=view&catID=$catID&threadID=$threadID");


} elseif($action == "delete" && isset($threadID) && getuserrank() == 2) {
	mysql_query("DELETE FROM forumThread WHERE ID = $threadID");
	mysql_query("DELETE FROM forumPosts WHERE threadID = $threadID");
	echo "Thread moved to /dev/null";
} else {
	include $base_path."style/top.php";
	echo "I have no idea what you mean....";
	include $base_path."style/bottom.php";
}
?>
