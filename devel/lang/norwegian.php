<?php
require_once $base_path.'config/config.php';

/* Form[] deals with standard Login-buttons, and things related to forms */
$form[0] = "Logg inn";
$form[1] = "Logg ut";
$form[2] = "Registrer";
$form[3] = "Feil: Det finnes allerede en bruker med den mail-adressen! kontakt admin!";
$form[4] = "Feil: Det finnes allerede en bruker med det nicket! kontakt admin!";
$form[5] = "Feil: Du m� ha ett passord! hvordan skal du ellers f� logga p�?";
$form[6] = "Feil: sikker p� at du ikke glemte noe? *heeeeeelt* sikker?";
$form[7] = "Legg til";
$form[8] = "Feil: feltet nick betyr at du skal skrive hvem du er....";
$form[9] = "Feil: er du sikker p� at du ikke har mail.... og s� skal du p� LAN?";
$form[10] = "Feil: vi krever litt sikkerhet med passorda, s� de m� v�re minst ".$min_pass_length."...";
$form[11] = "Feil: hva er det du innbiller deg? denne adressen ligner ikke p� en <b>mail</b> adresse!!!";
$form[12] = "Ja, ja, tidene forandrer seg, siden folk kan d�pes til et slikt navn.... Hele navnet takk!";
$form[13] = "Feil: En bruker er allerede registrert med dette nicket! Skjedd en feil? kontakt admin!";
$form[14] = "Feil: Passordene du skrev inn stemmer ikke overens med hverandre!";
$form[15] = "Lagre";
$form[16] = "Slett";
$form[17] = "Rediger";
$form[18] = "Feil: Ingen slik bruker!";
$form[19] = "Nullstill stemmer";
$form[20] = "Beklager, men admin har dessverre ikke laget noen avstemninger enn�! G� og bank ham!";
$form[21] = "Du burde mest sannsynlig legge til noen <b>svaralternativer</b>!!";
$form[22] = "�pne";
$form[23] = "Steng";
$form[24] = "Brukernavn:";
$form[25] = "Passord:";
$form[26] = "Gjenta Passord:";
$form[27] = "Kommentar:";
$form[28] = "Klan navn:";
$form[29] = "Navn:";
$form[30] = "E-Post:";
$form[31] = "Feil : Du er ikke logget p�";
$form[32] = "Du m� skrive inn et klan navn";
$form[33] = "Endre passord";
$form[34] = "Endre E-Post";
$form[35] = "E-Post har ikke blitt endret.";
$form[36] = "Husk: n�r du endrer E-Posten din, vil en mail bli sendt til deg, med en bekreftelses-kode. Denne m� fylles inn neste gang du logger p�.";
$form[37] = "Feil: Du kan bare stemme en gang!";
$form[38] = "Feil: du glemte vist � legge inn ett svaralternativ!";
$form[39] = "Feil: Du glemte nok � skrive inn ett passord....";
$form[40] = "Klanen din er lagt til!";
$form[41] = "Logg inn brukeren";
$form[42] = "Logg ut brukeren";
$form[43] = "Beklageligvis har ikke admin lagt inn noen FAQs....";
$form[44] = "Antall stemmer pr. bruker ";
$form[45] = "Avstemningssp�rsm�l";
$form[46] = "Totalt antall stemmer: ";
$form[47] = "Lag ny fil";
$form[48] = "Bruk _ (underscore), i stedenfor mellomrom....";
$form[49] = "Din stemme er blitt registert!";
$form[50] = "Forumnavn";
$form[51] = "Foruminformasjon";
$form[52] = "Klan oppdatert";
$form[53] = "Vare";
$form[54] = "Pris";
$form[55] = "P� lager";
$form[56] = "Bestill antall";
$form[57] = "Bestill nick";
$form[58] = "Takk for maten";
$form[59] = "Verifiser";
$form['60'] = "Vis";
$form['61'] = "Legg til gruppe";
$form['62'] = "Gi nytt navn";
$form['63'] = "Det finnes allerede en gruppe med det navnet.";
$form['64'] = "Medlemmer:";
$form['65'] = "Gruppe slettet.";
$form['66'] = "Slette gruppen:";
$form['67'] = "Navn byttet til";
$form['68'] = "Navn p� compoen";
$form['69'] = "Mangler navn p� compoen.";
$form['70'] = "Antall spillere per lag";
$form['71'] = "Antall lag per runde";
$form['72'] = "Mangler innehold.";
$form['73'] = "Rediger";
$form['74'] = "Gateadresse/nr";
$form['75'] = "Postnummer og sted";
$form['76'] = "Mobilnummer";
$form['77'] = "F�dselsdag";

/* Diffrent kinds of messages..... */
$msg[0] = "Logget inn som: ";
$msg[1] = "Vi bruker ikke denne siden!";
$msg[2] = "Postet av: ";
$msg[3] = "Du har blitt verifisert. Velkommen om bord!";
$msg[4] = "Din verifiseringskode stemte ikke! kontakt admin!";
$msg[5] = "Feil: Mailen kunne ikke bli sendt.";
$msg[6] = "Du er n� blitt registrert i databasen.";
$msg[7] = "FAQ Lagret";
$msg[8] = "Denne avstemningen er stengt!";
$msg[9] = "Denne siden bruker ikke profiler!";
$msg[10] = "Ja";
$msg[11] = "Nei";
$msg[12] = "Vurdert � v�re logget inn f�r du pr�ver � redigere profilen din?";
$msg[13] = "Ser ut til at vi mangler nyhetsposter.....";
$msg[14] = "Av: ";
$msg[15] = "Tilbake";
$msg[16] = "Ingen gjester";
$msg[17] = "Anonym";
$msg[18] = "Ingen poster";
$msg[19] = "Passord er kryptert; ta kontakt med admin for � endre";
$msg[20] = "Rediger klan";
$msg[21] = "Medlemmer online: ";
$msg[22] = "Gjester online: ";
$msg[23] = "Verifiser epostadressen din med verifiseringskoden du har f�tt tilsendt.";
$msg[24] = "Hvis du ikke har f�tt tilsendt noen verifiseringskode, kontakt administratorene.";
$msg[25] = "Du har ikke tilgang til dette av en eller annen merkelig grunn...";
$msg['26'] = "Du er ikke logget inn.";
$msg['27'] = "Du er n� logget ut.";
$msg['28'] = "Kunne ikke generere tilfeldig tall.";
$msg['29'] = "Hacking?";
$msg['30'] = "Feil brukernavn eller passord.";
$msg['31'] = "Tilbake til hovedsiden.";
$msg['32'] = "Tilbake til lista.";
$msg['33'] = "Oppdaterer...";
$msg['34'] = "FAQ";
$msg['35'] = "slettet.";
$msg['36'] = "Lagt til.";
$msg['37'] = "S�k gjennom nick eller navn";
$msg['38'] = "Endre billett";
$msg['39'] = "No seat";
$msg['40'] = "Componavn";
$msg['41'] = "Jauda, er bare � fylle inn det du mener om de forskjellige compoenforslagene....";
$msg['42'] = "Du vil motta en verifiseringskode til mailadressen du oppgir. Denne m� oppgis ved f�rste p�logging. Merk: Hotmail anser denne mailen som junk av en eller annen merkelig grunn......";

$partyweb['0'] = "Menynavn";
$partyweb['1'] = "Vis i meny";
$partyweb['2'] = "Vis i partymode";
$partyweb['3'] = "Slett siden";
$partyweb['4'] = "Oppdatering vellykket.";
$partyweb['5'] = "Ny side lagt til.";

$userlist['0'] = "Siste visning";
$userlist['1'] = "Side";

$addressbook['0'] = "Gruppe";
$addressbook['1'] = "Epostadresse";
$addressbook['2'] = "Telefonnummer";

$rank[0] = "Deltager";
$rank[1] = "Crew";
$rank[2] = "Admin";

$allowPublicFor[0] = "Alle brukere";
$allowPublicFor[1] = "Kun registrerte brukere";
$allowPublicFor[2] = "Kun admins";

/* Titles of pages; visible in menu */
$title['page'][0] = "Hovedsiden";
$title['page'][1] = "FAQ";
$title['page'][2] = "Registrer bruker";
$title['page'][3] = "Logg ut";
$title['page'][4] = "Admin";
$title['page'][5] = "Avstemninger";
$title['page'][6] = "Plassregistrering";
$title['page'][7] = "Rediger profil";
$title['page'][8] = "Compo Registrering";
$title['page'][9] = "Nyheter";
$title['page'][10] = "Legg til klan";
$title['page'][11] = "Klan oversikt";
$title['page'][12] = "Forum";
$title['page'][13] = "Brukerinnlogging";
$title['page'][14] = "Crewadressebok";
$title['page'][15] = "Compoavstemning";
$title['page'][16] = "PartyWeb";
$title['page'][17] = "WannabeCrew";

/* Messages on admin-interface */
$admin['noaccess'] = "D�����������; ingen tilgang!";
$admin['contact']['mail'] = "laaknor@globelan.net";
$admin['0'] = "Partyweb";
$admin['1'] = "FAQ";
$admin['2'] = "Statiske sider";
$admin['3'] = "Brukere";
$admin['4'] = "P�loggede brukere";
$admin['5'] = "Avstemninger";
$admin['6'] = "Nyheter";
$admin['7'] = "Tilgangsrettigheter";
$admin['8'] = "Compoer";
$admin['9'] = "Compoavstemninger";
$admin['10'] = "Systemkonfigurasjon";

/* Messages in seat-system */
$seat['0'] = "Ikke �pnet plass";
$seat['1'] = "Opptatt plass";
$seat['2'] = "�pen plass";
$seat['3'] = "D�r";
$seat['4'] = "Vegg";
$seat['5'] = "Kiosk";
$seat['6'] = "Crew";
//$seat['7'] = "";
//$seat['8'] = "";
$seat['9'] = "Plassregistreringa har ikke �pnet enda!";
$seat['10'] = "Ledige plasser:";
$seat['11'] = "Opptatte plasser:";
$seat['12'] = "Zoom (vis navn)";
$seat['13'] = "Avbestill plassen";
$seat['14'] = "sitter her.";
$seat['15'] = "Ta denne plassen";

$colour['1'] = "R�d";
$colour['2'] = "Bl�";
$colour['3'] = "M�rkebl�";
$colour['4'] = "Svart";
$colour['5'] = "Lysegr�nn";
$colour['6'] = "Oransje";

/* Messages in profile */
$profile[0] = "Brukeren har deaktivert profilen sin, og du er nok ikke admin *mobb mobb*";
$profile[1] = "Brukeren tillater kun p�loggede brukere � se profilen.";
$profile[2] = "Profil for ";
$profile[3] = "Navn";
$profile[4] = "Om meg";
$profile[5] = "Har reservert plass";
$profile[6] = "E-Post";
$profile[7] = "Profil lagret";
$profile[8] = "Nick";
$profile[9] = "Rank";
$profile[10] = "Crewtype";
$profile[11] = "Rediger denne brukeren";
$profile[12] = "Mobiltelefon (kun viktig for crew)";
$profile[13] = "Tillat visning av profil til";
$profile[14] = "Design du �nsker � bruke";
$profile['15'] = "Du m� logge inn eller velge en profil � se p�.";

$month['1'] = "Januar";
$month['2'] = "Februar";
$month['3'] = "Mars";
$month['4'] = "April";
$month['5'] = "Mai";
$month['6'] = "Juni";
$month['7'] = "Juli";
$month['8'] = "August";
$month['9'] = "September";
$month['10'] = "Oktober";
$month['11'] = "November";
$month['12'] = "Desember";


$forum[0] = "Siste post av: ";
$forum[1] = "Send inn";
$forum[2] = "Tror du ikke det er lurt � skrive inn noe i emne-feltet?";
$forum[3] = "Tror du ikke det kan l�nne seg � skrive inn noe i tekst-feltet?";
$forum[4] = "Lag nytt tema";
$forum[5] = "Skriv svar";
$forum[6] = "Flytt tr�den til /dev/null";


$wannabe[0] = "Jeg �nsker � v�re crew";
$wannabe[1] = "Jeg har ikke lyst til � v�re crew allikevel";

$wannabe['canSecCrew'] = "Jeg er stor og sterk (security)";
$wannabe['canKioskCrew'] = "Jeg kan steke pizza";
$wannabe['canTechCrew'] = "Jeg veit hvordan Windows fungerer";
$wannabe['canTechLinuxCrew'] = "Jeg kan endel om Linux";
$wannabe['canNetCrew'] = "Jeg kan forklare OSI-modellen";
$wannabe['canPartyCrew'] = "Jeg lager liv (partycrew)";
$wannabe['canCarryTablesCrew'] = "Jeg har ingen ryggproblemer (kan b�re bord etc.) [anbefales IKKE � pr�ve � droppe dette uten gyldig grunn....]";
$wannabe['aboutme'] = "Om meg (ikke anta at de som leser dette kjenner deg....)";
$wannabe['experience'] = "Tidligere erfaringer som kan v�re aktuelt � vite noe om (styreverv, elevr�d, andre datapartyer (spesifiser hva du jobbet med takk!), arrangering av skoleball; alt som kan v�re aktuelt)";
$wannabe['why'] = "Hvorfor �nsker du � v�re crew? Hvorfor skal vi velge deg?";
$wannabe['canGameCrew'] = "Jeg kan arrangere gamecompoer (spesifiser mer hvilke/erfaringer)";
$wannabe['turnOn'] = "Kan du skru p� en datamaskin?";
$wannabe['karaoke'] = "Kan du synge karaoke?";
$wannabe['canCake'] = "Kan du bake kake?";
$wannabe['leaderType'] = "Ser du p� deg selv som en ledertype?";
$wannabe['myRequests'] = "Hva slags crew �nsker du selv � havne i/hva �nsker du � drive med? (info, sec, party, game, net). Hva kan du bidra med til det crewet?";

$compo[0] = "Spill";
$compo[1] = "Tekst";
$compo[2] = "Type";
$compo[3] = "Antall Spillere";
$compo[4] = "Klaner";
$compo[5] = "Meld deg p� denne compoen";
$compo[6] = " Meld p� ";
$compo[7] = "Klan :";
$compo[8] = "Passord : ";
$compo[9] = "Meld Avbud";
$compo[10] = "Du er allerede p�meldt i denne compoen";
$compo[11] = "Klan Navn";
$compo[12] = "Om Klanen";
$compo[13] = "Spillere";
$compo[14] = "Spill";
$compo[15] = "Beskrivelse";
$compo[16] = "Type";
$compo[17] = "Antall spillere pr. klan";
$compo['18'] = "Seeding";
$compo['19'] = "P�meldte:";
$compo['20'] = "brukere";
$compo['21'] = "fordelt p�";
$compo['22'] = "klaner.";
$compo['23'] = "Seed bedre.";
$compo['24'] = "Seed d�rligere.";

$compoerr[1] = "Du skrev inn feil passord for denne klanen";
$compoerr[2] = "Denne klanen ble ikke funnet i databasen";
$compoerr[3] = "Skriv inn klan og passord, takk";
$compoerr[4] = "Sorry, klanen er full";


$true_false[0] = "Nei";
$true_false[1] = "Ja";

$clan[0] = "Disse spillerene er med i denne compoen :";
$clan[1] = "Denne klanen er med i disse compoene :";
$clan[2] = "Klan navn:";
$clan[3] = "Du er ikke moderator for noen klaner :)";
$clan[4] = "Dette er en beskrivelse av klanen min";
$clan[5] = "Legg til klanen";
$clan[6] = "Vennligst vent, du vil bli videresendt til siden";
$clan[7] = "Denne klanen eksisterer allerede";
$clan[8] = "Lagre klan";
$clan[9] = "Klanen er oppdatert";

$acl[0]['name'] = "Root";
$acl[0]['access'] = "root";

$acl[1]['name'] = "Er crew";
$acl[1]['access'] = "isCrew";

$acl[2]['name'] = "Er chief";
$acl[2]['access'] = "isChief";

$acl[3]['name'] = "Er admin";
$acl[3]['access'] = "isAdmin";

$acl[4]['name'] = "Display admin-menu";
$acl[4]['access'] = "displayAdmin";

$acl[5]['name'] = "Enable useradmin";
$acl[5]['access'] = "adminUsers";

$acl[6]['name'] = "Logge ut og inn brukere";
$acl[6]['access'] = "loginUser";

$acl[7]['name'] = "CompoAdmin";
$acl[7]['access'] = "compomaster";

$acl[8]['name'] = "CompoPoll";
$acl[8]['access'] = "compopoll";

$acl[9]['name'] = "Webside moduladmin";
$acl[9]['access'] = "config";

$acl[10]['name'] = "FAQ-admin";
$acl[10]['access'] = "faq";

$acl[11]['name'] = "NEWS-admin";
$acl[11]['access'] = "news";

$acl[12]['name'] = "PartyWebAdmin";
$acl[12]['access'] = "partyweb";

$acl[13]['name'] = "Avstemningsadmin";
$acl[13]['access'] = "poll";

$acl[14]['name'] = "StaticAdmin";
$acl[14]['access'] = "static";

$acl[15]['name'] = "Se hvem som er online";
$acl[15]['access'] = "onlineUsers";

$acl[16]['name'] = "WannabeAdmin";
$acl[16]['access'] = "wannabe";

$acl[17]['name'] = "ACL-admin";
$acl[17]['access'] = "ACL";

$acl[18]['name'] = "List i adresselista";
$acl[18]['access'] = "listaddress";

$acl[19]['name'] = "Tasklist-member";
$acl[19]['access'] = "tasks";

$acl[20]['name'] = "Kiosk-crew";
$acl[20]['access'] = "kioskCrew";

$acl[21]['name'] = "Kiosk-Admin";
$acl[21]['access'] = "kioskAdmin";

$acl[22]['name'] = "Vise logger";
$acl[22]['access'] = "logs";

$acl[23]['name'] = "Registrer pedometer";
$acl[23]['access'] = "pedometer_write";

$acl[24]['name'] = "Tillatt plassregistrering";
$acl[24]['access'] = "seatreg_allowed";

$logtype[0] = '(dbdefault)';
$logtype[1] = '(funcdefault)';
$logtype[2] = 'Ny sesjon';
$logtype[3] = 'Fjerna gammel sesjon';
$logtype[4] = 'Bruker logget inn';
$logtype[5] = 'Bruker logget ut';
$logtype[6] = 'Bruker registrert';
$logtype[7] = 'Ny statisk fil';
$logtype[8] = 'Fjernet statisk fil';
$logtype[9] = 'Bruker bytta plass';
$logtype[10] = 'Hackingfors&oslash;k';
$logtype[11] = 'Brukerinfo endret';
$logtype[12] = 'Bruker ankommet';
$logtype[13] = 'Bruker reist';
$logtype[14] = 'Innsjekkingskommentar forandret';
$logtype[15] = 'Nicedie';

/* These are the colors that may be used to describe users in userlogin */
$userloginclr[0] = "yellow";
$userloginclr[1] = "red";
$userloginclr[2] = "green";


$compotype[0] = "FFA";
$compotype[1] = "1on1";
$compotype[2] = "2vs2";
$compotype[3] = "3vs3";
$compotype[4] = "4vs4";
$compotype[5] = "5vs5";

/* This is the answers in the compopoll users get */
$compopoll[0] = "Ingen kommentar"; // No points are given
$compopoll[1] = "Nei takk";	   // only one point is given
$compopoll[2] = "Nja";
$compopoll[3] = "Kanskje";
$compopoll[4] = "Gjerne";
$compopoll[5] = "SELVF�LGELIG!!!"; // 5 points are given!

/* The diffrent tickets a person may have */
$tickettype[0] = "Ingen billett"; // the default, should be "not ticket"
$tickettype[1] = "Normal billett";
$tickettype[2] = "Ingen PC";

/* Dasklevels a user may have */
$dasklevels[0] = "Ingen dasking";
$dasklevels[1] = "Lett dasking";
$dasklevels[2] = "Hard dasking";

$crewsale[0] = "Crewsalg er av";
$crewsale[1] = "Crewsalg er P�!";


