<?php
require_once $base_path.'config/config.php';

/* Form[] deals with standard Login-buttons, and things related to forms */
$form[0] = "Login";
$form[1] = "Logout";
$form[2] = "Register";
$form[3] = "Error: A user already exists with that mailadress. Contact the site admin.";
$form[4] = "Error: A user with that nick already exists. Contact the site admin.";
$form[5] = "Error: You must have a password, how else can you login?";
$form[6] = "Error: Are you completly sure you did not forget something? Check again";
$form[7] = "Add";
$form[8] = "Error: nick means you should enter your nick...";
$form[9] = "Error: are you sure you do not have an EMail-adress? And you are going to a LAN-party?";
$form[10] = "Error: The password length should be at least ".$min_pass_length."...";
$form[11] = "Error: That does not look like <b>mail</b> adress at all!!!";
$form[12] = "Well, well, times changes. I do not believe your parents would name you that... Whole name please.";
$form[13] = "Error: A user with that nick already exists!";
$form[14] = "Error: The passwords you typed did not match eachothers. Try again!";
$form[15] = "Save";
$form[16] = "Delete";
$form[17] = "Edit";
$form[18] = "Error: no such user!";
$form[19] = "Reset votes";
$form[20] = "Sorry, but the admin have not created any votes yet. Go kick his ass!";
$form[21] = "Please add some <b>answers</b>!!";
$form[22] = "Open";
$form[23] = "Close";
$form[24] = "Username:";
$form[25] = "Password:";
$form[26] = "Repeat password:";
$form[27] = "Comment:";
$form[28] = "Clan name:";
$form[29] = "Full name:";
$form[30] = "E-Mail:";
$form[31] = "Error: you are not logged in";
$form[32] = "You have to enter a clan name";
$form[33] = "Change password";
$form[34] = "Change EMail";
$form[35] = "E-Mail has not been changed";
$form[36] = "Remember: when you change your email-adress, a mail will be sent to your account giving you a new verification-code";
$form[37] = "Error: you may only vote once!";
$form[38] = "Error: you forgot to enter an answer";
$form[39] = "Error: you forgot to enter a password";
$form[40] = "Your clan has been added!";
$form[41] = "Login user";
$form[42] = "Logout user";
$form[43] = "Unfortunatly, the admin has not added any FAQs....";
$form[44] = "Number of votes for each user ";
$form[45] = "Vote-question";
$form[46] = "Total amount of votes: ";
$form[47] = "Create new page";
$form[48] = "Use _ (underscore), instead of spaces";
$form[49] = "Your vote has been registered!";
$form[50] = "Forumname";
$form[51] = "Foruminformation";
$form[52] = "Clan updated";
$form[53] = "Ware";
$form[54] = "Price";
$form[55] = "In stock";
$form[56] = "Order amount";
$form[57] = "Order nick";
$form[58] = "Thanks for the food";
$form[59] = "Verify";
$form['60'] = "Show";
$form['61'] = "Add group";
$form['62'] = "Rename";
$form['63'] = "A group with that name already exists.";
$form['64'] = "Members:";
$form['65'] = "Group deleted.";
$form['66'] = "Delete group:";
$form['67'] = "Renamed to";
$form['68'] = "Name of the compo";
$form['69'] = "Lacking name of the compo.";
$form['70'] = "Number of players on each team";
$form['71'] = "Number of teams in each round";
$form['72'] = "Lacking content.";
$form['73'] = "Edit";

/* Diffrent kinds of messages..... */
$msg[0] = "Logged in as: ";
$msg[1] = "This page has been disabled by the admin!";
$msg[2] = "Posted by: ";
$msg[3] = "You have been verified. Welcome =)!";
$msg[4] = "You verification-code did not match. Contact the admin!";
$msg[5] = "Error: mail could not be sent";
$msg[6] = "You have now been added to the database";
$msg[7] = "FAQ Saved";
$msg[8] = "This vote has been closed!";
$msg[9] = "This site does not use profiles :/!";
$msg[10] = "Yes";
$msg[11] = "No";
$msg[12] = "Ever considered to log in before you change your profile?";
$msg[13] = "Please add some newsposts......";
$msg[14] = "By: ";
$msg[15] = "Back";
$msg[16] = "No guests";
$msg[17] = "Anonymous";
$msg[18] = "No posts";
$msg[19] = "Password is encrypted. Contact admin to change";
$msg[20] = "Edit clan";
$msg[21] = "Members online: ";
$msg[22] = "Guests online: ";
$msg[23] = "Enter the verificationcode sent to your emailaddress.";
$msg[24] = "If you have not recieved any verificationcode within a reasonable time, please contact the administrators.";
$msg[25] = "For some strange reason you do not have access to this";
$msg['26'] = "You are not logged in.";
$msg['27'] = "You are now logged out.";
$msg['28'] = "Could not create random number.";
$msg['29'] = "Hacking?";
$msg['30'] = "Wrong username or password.";
$msg['31'] = "Back to the main page.";
$msg['32'] = "Back to the list.";
$msg['33'] = "Updating...";
$msg['34'] = "FAQ";
$msg['35'] = "deleted.";
$msg['36'] = "Added";
$msg['37'] = "Search by nick or name";
$msg['38'] = "Change ticket";
$msg['39'] = "No seat";
$msg['40'] = "Componame";
$msg['41'] = "Fill in what you whink of the diffrent composuggestions";

$partyweb['0'] = "Menuname";
$partyweb['1'] = "Display in menu";
$partyweb['2'] = "Display in partymode";
$partyweb['3'] = "Delete page";
$partyweb['4'] = "Update complete.";
$partyweb['5'] = "New page added.";

$userlist['0'] = "Last view";
$userlist['1'] = "Page";

$addressbook['0'] = "Group";
$addressbook['1'] = "Emailaddress";
$addressbook['2'] = "Phonenumber";
$addressbook['3'] = "Id";
$addressbook['4'] = "Nick";

$rank[0] = "User";
$rank[1] = "Crew";
$rank[2] = "Admin";

$allowPublicFor[0] = "All users";
$allowPublicFor[1] = "Only registered users";
$allowPublicFor[2] = "Only admins";

/* Titles of pages; visible in menu */
$title['page'][0] = "Main page";
$title['page'][1] = "FAQ";
$title['page'][2] = "Register user";
$title['page'][3] = "Logout";
$title['page'][4] = "Admin";
$title['page'][5] = "Votes";
$title['page'][6] = "Seatmap";
$title['page'][7] = "Edit profile";
$title['page'][8] = "Comporegistration";
$title['page'][9] = "News";
$title['page'][10] = "Register Clan";
$title['page'][11] = "Clan list";
$title['page'][12] = "Forum";
$title['page'][13] = "Userlogin";
$title['page'][14] = "Crewadressbook";
$title['page'][15] = "Compopoll";
$title['page'][16] = "PartyWeb";
$title['page'][17] = "WannabeCrew";

/* Messages on admin-interface */
$admin['noaccess'] = "DIIIIIIIIIIIIIE!! No access!";
$admin['contact']['mail'] = "laaknor@globelan.net";
$admin['0'] = "Partyweb";
$admin['1'] = "FAQ";
$admin['2'] = "Static pages";
$admin['3'] = "Users";
$admin['4'] = "Online users";
$admin['5'] = "Polls";
$admin['6'] = "News";
$admin['7'] = "Accessmanagement";
$admin['8'] = "Compos";
$admin['9'] = "Compopolls";
$admin['10'] = "System configuration";

/* Messages in seat-system */
$seat['0'] = "Not opened seat";
$seat['1'] = "Taken seat";
$seat['2'] = "Open seat";
$seat['3'] = "Door";
$seat['4'] = "Wall";
$seat['5'] = "Canteen";
$seat['6'] = "Crew";
//$seat['7'] = "";
//$seat['8'] = "";
$seat['9'] = "The seatreservation has not yet opened!";
$seat['10'] = "Remaining seats:";
$seat['11'] = "Taken seats:";
$seat['12'] = "Zoom (show names)";
$seat['13'] = "Cancel seat";
$seat['14'] = "sits here.";
$seat['15'] = "Take this seat";

$colour['1'] = "Red";
$colour['2'] = "Blue";
$colour['3'] = "Dark blue";
$colour['4'] = "Black";
$colour['5'] = "Light green";
$colour['6'] = "Orange";

/* Messages in profile */
$profile[0] = "The user has disabled his profile, and you are not an admin";
$profile[1] = "The user only accepts registered users to view his profile.";
$profile[2] = "Profile for ";
$profile[3] = "Name";
$profile[4] = "About me";
$profile[5] = "Has reserved space";
$profile[6] = "E-Mail";
$profile[7] = "Profile saved";
$profile[8] = "Nick";
$profile[9] = "Rank";
$profile[10] = "Crewtype";
$profile[11] = "Edit this user";
$profile[12] = "Cellphone";
$profile[13] = "Allow display of profile to";
$profile[14] = "Desired design";
$profile['15'] = "You need to log in or select an user which profile you want to see.";

$month['1'] = "January";
$month['2'] = "February";
$month['3'] = "March";
$month['4'] = "April";
$month['5'] = "May";
$month['6'] = "June";
$month['7'] = "July";
$month['8'] = "August";
$month['9'] = "September";
$month['10'] = "October";
$month['11'] = "November";
$month['12'] = "December";


$forum[0] = "Last post by: ";
$forum[1] = "Post";
$forum[2] = "I think you should put something in the subject-field...";
$forum[3] = "An empty post? I do not allow that!";
$forum[4] = "Add new thread";
$forum[5] = "Write answer";
$forum[6] = "Move this thread to /dev/null";


$wannabe[0] = "I wanna be crew!";
$wannabe[1] = "I do not want to be a crew anyway";

$wannabe['canSecCrew'] = "I am big and strong (securitycrew)";
$wannabe['canKioskCrew'] = "I know how to burn a pizza";
$wannabe['canTechCrew'] = "I know how Windows works";
$wannabe['canTechLinuxCrew'] = "I know something about Linux";
$wannabe['canNetCrew'] = "I can explain the OSI-model of networking";
$wannabe['canPartyCrew'] = "I can arrange wildcompos";
$wannabe['canCarryTablesCrew'] = "I do not have problems with my back (not recommended to skip this one....)";
$wannabe['aboutme'] = "About me (do not assume that those that read this knows you)";
$wannabe['experience'] = "Past experience that might be usefull to know about (board positions, school council etc.)";
$wannabe['why'] = "Why do you want to be crew? Why should we pick you?";
$wannabe['canGameCrew'] = "I can arrange gamecompos? (specify which games)";
$wannabe['turnOn'] = "Can you turn on a computer?";
$wannabe['karaoke'] = "Can you sing karaoke?";
$wannabe['canCake'] = "Can you bake a cake?";
$wannabe['leaderType'] = "Do you look at yourself as a leadertype?";
$wannabe['myRequests'] = "What kind of crew do you want to be?";

$compo[0] = "Game";
$compo[1] = "Text";
$compo[2] = "Type";
$compo[3] = "Number of players";
$compo[4] = "Clans";
$compo[5] = "Sign on this compo";
$compo[6] = " Sign on ";
$compo[7] = "Clan :";
$compo[8] = "Password : ";
$compo[9] = "Cancel registration";
$compo[10] = "You have already registered as a competitor";
$compo[11] = "Clan name";
$compo[12] = "About Clan";
$compo[13] = "Players";
$compo[14] = "Game";
$compo[15] = "Description";
$compo[16] = "Type";
$compo[17] = "Number of players in each clan";
$compo['18'] = "Seeding";
$compo['19'] = "Signed up:";
$compo['20'] = "users";
$compo['21'] = "distributed on";
$compo['22'] = "clans.";
$compo['23'] = "Seed higher.";
$compo['24'] = "Seed lower.";

$compoerr[1] = "Error: that was the wrong password for that clan";
$compoerr[2] = "Error: That clan was not found in the database";
$compoerr[3] = "Error: write Clan and password please";
$compoerr[4] = "Sorry, there are no more seats in that clan for that compo";

$true_false[0] = "No";
$true_false[1] = "Yes";

$clan[0] = "These players have joined this compo :";
$clan[1] = "This clan has joined these compos :";
$clan[2] = "Clan name:";
$clan[3] = "You are not moderator for any clans :)";
$clan[4] = "This is a description of my clan";
$clan[5] = "Add Clan";
$clan[6] = "<br>Hold on, and you will be redirected to the site";
$clan[7] = "This clan allready exists";
$clan[8] = "Save Clan";
$clan[9] = "Clan Updated";

$mail[0] = "You have been registered as a user on GL-DEVEL!";
$mail[1] = "$admin[contact][mail]";
$mail[2] = "devel";

$acl[0]['name'] = "Root";
$acl[0]['access'] = "root";

$acl[1]['name'] = "Is Crew";
$acl[1]['access'] = "isCrew";

$acl[2]['name'] = "Is chief";
$acl[2]['access'] = "isChief";

$acl[3]['name'] = "Is admin";
$acl[3]['access'] = "isAdmin";

$acl[4]['name'] = "Display admin-menu";
$acl[4]['access'] = "displayAdmin";

$acl[5]['name'] = "Enable useradmin";
$acl[5]['access'] = "adminUsers";

$acl[6]['name'] = "Log in and out users";
$acl[6]['access'] = "loginUser";

$acl[7]['name'] = "CompoAdmin";
$acl[7]['access'] = "compomaster";

$acl[8]['name'] = "CompoPoll";
$acl[8]['access'] = "compopoll";

$acl[9]['name'] = "Website moduleadmin";
$acl[9]['access'] = "config";

$acl[10]['name'] = "FAQ-admin";
$acl[10]['access'] = "faq";

$acl[11]['name'] = "NEWS-admin";
$acl[11]['access'] = "news";

$acl[12]['name'] = "PartyWebAdmin";
$acl[12]['access'] = "partyweb";

$acl[13]['name'] = "Polladmin";
$acl[13]['access'] = "poll";

$acl[14]['name'] = "StaticAdmin";
$acl[14]['access'] = "static";

$acl[15]['name'] = "Look who is online";
$acl[15]['access'] = "onlineUsers";

$acl[16]['name'] = "WannabeAdmin";
$acl[16]['access'] = "wannabe";

$acl[17]['name'] = "ACL-admin";
$acl[17]['access'] = "ACL";

$acl[18]['name'] = "List in addressbook";
$acl[18]['access'] = "listaddress";

$compotype[0] = "FFA";
$compotype[1] = "1on1";
$compotype[2] = "2vs2";
$compotype[3] = "3vs3";
$compotype[4] = "4vs4";
$compotype[5] = "5vs5";

/* This is the answers in the compopoll users get */
$compopoll[0] = "No comments"; // No points are given
$compopoll[1] = "No, thank you";	   // only one point is given
$compopoll[2] = "Well....";		   
$compopoll[3] = "Perhaps";
$compopoll[4] = "Please";
$compopoll[5] = "OF COURSE!!!"; // 5 points are given!

/* The diffrent tickets a person may have */
$tickettype[0] = "No ticket"; // the default, should be "not ticket"
$tickettype[1] = "Normal ticket";
$tickettype[2] = "No PC";


function mail_body($random) {
    return "Welcome as a user of GlobeLAN DEVEL!\n\r
    You have either changed you EMail, or added a new user, so please login with you username and password and enter: ".$random." as you verificationnumber!\r\n\r\n
    Thank you\r\n
    The Crew";
}

?>
