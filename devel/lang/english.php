<?php
/* Form[] deals with standard Login-buttons, and things related to forms */
$form[0] = "Login";
$form[1] = "Logout";
$form[2] = "Register";
$form[3] = "Feil: Det finnes allerede en bruker med den mail-adressen! kontakt admin!";
$form[4] = "Feil: Det finnes allerede en bruker med det nicket! kontakt admin!";
$form[5] = "Feil: Du må ha ett passord! hvordan skal du ellers få logga på?";
$form[6] = "Feil: sikker på at du ikke glemte noe? *heeeeeelt* sikker?";
$form[7] = "Legg til";

/* Diffrent kinds of messages..... */
$msg[0] = "Logged in as: ";
$msg[1] = "We are not using this page!";
$msg[2] = "Post by: ";
$msg[3] = "You have been authorized, welcome!";
$msg[4] = "Your verification code did not comply, contact admin.";



$rank[0] = "User";
$rank[1] = "Crew";
$rank[2] = "Admin";

/* Titles of pages; visible in menu, and as <title></title> */
$title[page][0] = "Index page";
$title[page][1] = "FAQ";
$title[page][2] = "Register user";
$title[page][3] = "Logout";
$title[page][4] = "Admin";
$title[page][5] = "Polls";

/* Messages on admin-interface */
$admin[noaccess] = "You are unauthorized for this page.";
$admin[contact][mail] = "laaknor@globelan.net";



$mail[0] = "Du har blitt registrert som bruker på GlobeLAN DEVEL!";
$mail[1] = "$admin[contact][mail]";



function mail_body($random) {
    return "Velkommen som bruker på GlobeLAN DEVEL!\n\r
    Venligst logg inn med ditt brukernavn og passord, og fyll inn: ".$random." som ditt verifiseringsnummer!\r\n\r\n
    Tusen takk\r\n
    Crewet";
}
?>
