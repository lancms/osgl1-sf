<?php
require_once $base_path.'config/config.php';

/* Form[] deals with standard Login-buttons, and things related to forms */
$form[0] = "Logg inn";
$form[1] = "Logg ut";
$form[2] = "Registrer";
$form[3] = "Feil: Det finnes allerede en bruker med den mail-adressen! kontakt admin!";
$form[4] = "Feil: Det finnes allerede en bruker med det nicket! kontakt admin!";
$form[5] = "Feil: Du må ha ett passord! hvordan skal du ellers få logga på?";
$form[6] = "Feil: sikker på at du ikke glemte noe? *heeeeeelt* sikker?";
$form[7] = "Legg til";
$form[8] = "Feil: feltet nick betyr at du skal skrive hvem du er....";
$form[9] = "Feil: er du sikker på at du ikke har mail.... og så skal du på LAN?";
$form[10] = "Feil: vi krever litt sikkerhet med passorda, så de må være minst ".$min_pass_length."...";
$form[11] = "Feil: hva er det du innbiller deg? denne adressen ligner ikke på en <b>mail</b> adresse!!!";
$form[12] = "Ja, ja, tidene forandrer seg, siden folk kan døpes til et slikt navn.... Hele navnet takk!";
$form[13] = "Feil: En bruker er allerede registrert med dette nicket! Skjedd en feil? kontakt admin!";
$form[14] = "Feil: Passordene du skrev inn stemmer ikke overens med hverandre!";
$form[15] = "Lagre";
$form[16] = "Slett";
$form[17] = "Rediger";
$form[18] = "Feil: Ingen slik bruker!";
$form[19] = "Nullstill stemmer";
$form[20] = "Beklager, men admin har dessverre ikke laget noen avstemninger ennå! Gå og bank ham!";
$form[21] = "Du burde mest sannsynlig legge til noen <b>svaralternativer</b>!!";
$form[22] = "Åpne";
$form[23] = "Steng";
$form[24] = "Brukernavn:";
$form[25] = "Passord:";
$form[26] = "Gjenta Passord:";
$form[27] = "Kommentar:";
$form[28] = "Klan navn:";
$form[29] = "Navn:";
$form[30] = "E-Post:";
$form[31] = "Feil : Du er ikke logget på";
$form[32] = "Du må skrive inn et klan navn";
$form[33] = "Endre passord";
$form[34] = "Endre E-Post";
$form[35] = "E-Post har ikke blitt endret.";
$form[36] = "Husk: når du endrer E-Posten din, vil en mail bli sendt til deg, med en bekreftelses-kode. Denne må fylles inn neste gang du logger på.";
$form[37] = "Feil: Du kan bare stemme en gang!";
$form[38] = "Feil: du glemte vist å legge inn ett svaralternativ!";
$form[39] = "Feil: Du glemte nok å skrive inn ett passord....";
$form[40] = "Klanen din er lagt til!";
$form[41] = "Logg inn brukeren";
$form[42] = "Logg ut brukeren";
$form[43] = "Beklageligvis har ikke admin lagt inn noen FAQs....";
$form[44] = "Antall stemmer pr. bruker ";
$form[45] = "Avstemningsspørsmål";
$form[46] = "Totalt antall stemmer: ";
$form[47] = "Lag ny fil";
$form[48] = "Bruk _ (underscore), i stedenfor mellomrom....";
$form[49] = "Din stemme er blitt registert!";
$form[50] = "Forumnavn";
$form[51] = "Foruminformasjon";
$form[52] = "Klan oppdatert";
$form[53] = "Vare";
$form[54] = "Pris";
$form[55] = "På lager";
$form[56] = "Bestill antall";
$form[57] = "Bestill nick";
$form[58] = "Takk for maten";
$form[59] = "Verifiser";

/* Diffrent kinds of messages..... */
$msg[0] = "Logget inn som: ";
$msg[1] = "Vi bruker ikke denne siden!";
$msg[2] = "Postet av: ";
$msg[3] = "Du har blitt verifisert. Velkommen om bord!";
$msg[4] = "Din verifiseringskode stemte ikke! kontakt admin!";
$msg[5] = "Feil: Mailen kunne ikke bli sendt.";
$msg[6] = "Du er nå blitt registrert i databasen.";
$msg[7] = "FAQ Lagret";
$msg[8] = "Denne avstemningen er stengt!";
$msg[9] = "Denne siden bruker ikke profiler!";
$msg[10] = "Ja";
$msg[11] = "Nei";
$msg[12] = "Vurdert å være logget inn før du prøver å redigere profilen din?";
$msg[13] = "Ser ut til at vi mangler nyhetsposter.....";
$msg[14] = "Av: ";
$msg[15] = "Tilbake";
$msg[16] = "Ingen gjester";
$msg[17] = "Anonym";
$msg[18] = "Ingen poster";
$msg[19] = "Passord er kryptert; ta kontakt med admin for å endre";
$msg[20] = "Rediger klan";
$msg[21] = "Medlemmer online: ";
$msg[22] = "Gjester online: ";
$msg[23] = "Verifiser epostadressen din med verifiseringskoden du har fått tilsendt.";
$msg[24] = "Hvis du ikke har fått tilsendt noen verifiseringskode, kontakt administratorene.";

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
$title['page'][15] = "Kiosk";
$title['page'][16] = "PartyWeb";
$title['page'][17] = "WannabeCrew";

/* Messages on admin-interface */
$admin['noaccess'] = "DØØØØØØØØØØØ; ingen tilgang!";
$admin['contact']['mail'] = "laaknor@globelan.net";
/* Messages in seat-system */
$seat[0] = "Ledig";
$seat[1] = "Crew";
$seat[2] = "Reservert";
$seat[3] = "Deltager";
$seat[4] = "Dør";
$seat[5] = "Vegg";
$seat[6] = "Kantine";
$seat[7] = "Gang";
$seat[8] = "Meld avbud";

/* Messages in profile */
$profile[0] = "Brukeren har deaktivert profilen sin, og du er nok ikke admin *mobb mobb*";
$profile[1] = "Brukeren tillater kun påloggede brukere å se profilen.";
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
$profile[14] = "Design du ønsker å bruke";

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
$forum[2] = "Tror du ikke det er lurt å skrive inn noe i emne-feltet?";
$forum[3] = "Tror du ikke det kan lønne seg å skrive inn noe i tekst-feltet?";
$forum[4] = "Lag nytt tema";
$forum[5] = "Skriv svar";
$forum[6] = "Flytt tråden til /dev/null";


$wannabe[0] = "Jeg ønsker å være crew";
$wannabe[1] = "Jeg har ikke lyst til å være crew allikevel";

$wannabe['canSecCrew'] = "Jeg er stor og sterk (security)";
$wannabe['canKioskCrew'] = "Jeg kan steke pizza";
$wannabe['canTechCrew'] = "Jeg veit hvordan Windows fungerer";
$wannabe['canTechLinuxCrew'] = "Jeg kan endel om Linux";
$wannabe['canNetCrew'] = "Jeg kan forklare OSI-modellen";
$wannabe['canPartyCrew'] = "Jeg lager liv (partycrew)";
$wannabe['canCarryTablesCrew'] = "Jeg har ingen ryggproblemer (kan bære bord etc.) [anbefales IKKE å prøve å droppe dette uten gyldig grunn....]";
$wannabe['aboutme'] = "Om meg (ikke anta at de som leser dette kjenner deg....)";
$wannabe['experience'] = "Tidligere erfaringer som kan være aktuelt å vite noe om (styreverv, elevråd, andre datapartyer (spesifiser hva du jobbet med takk!), arrangering av skoleball; alt som kan være aktuelt)";
$wannabe['why'] = "Hvorfor ønsker du å være crew? Hvorfor skal vi velge deg?";
$wannabe['canGameCrew'] = "Jeg kan arrangere gamecompoer (spesifiser mer hvilke/erfaringer)";
$wannabe['turnOn'] = "Kan du skru på en datamaskin?";
$wannabe['karaoke'] = "Kan du synge karaoke?";
$wannabe['canCake'] = "Kan du bake kake?";
$wannabe['leaderType'] = "Ser du på deg selv som en ledertype?";
$wannabe['myRequests'] = "Hva slags crew ønsker du selv å havne i/hva ønsker du å drive med? (info, sec, party, game, net). Hva kan du bidra med til det crewet?";

$compo[0] = "Spill";
$compo[1] = "Tekst";
$compo[2] = "Type";
$compo[3] = "Antall Spillere";
$compo[4] = "Klaner";
$compo[5] = "Meld deg på denne compoen";
$compo[6] = " Meld på ";
$compo[7] = "Klan :";
$compo[8] = "Passord : ";
$compo[9] = "Meld Avbud";
$compo[10] = "Du er allerede påmeldt i denne compoen";
$compo[11] = "Klan Navn";
$compo[12] = "Om Klanen";
$compo[13] = "Spillere";
$compo[14] = "Spill";
$compo[15] = "Beskrivelse";
$compo[16] = "Type";
$compo[17] = "Antall spillere pr. klan";

$compoerr[1] = "Du skrev inn feil passord for denne klanen";
$compoerr[2] = "Denne klanen ble ikke funnet i databasen";
$compoerr[3] = "Skriv inn klan og passord, takk";
$compoerr[4] = "Sorry, klanen er full";


$true_false[0] = "Nei";
$true_false[1] = "Ja";

$clan[0] = "Disse spillerene er med i denne compoen :";
$clan[1] = "Denne klanen er med i disse compoene :";
$clan[2] = "Klan navn :";

$mail[0] = "Du har blitt registrert som bruker på GlobeLAN 7!";
$mail[1] = "$admin[contact][mail]";
$mail[2] = "GlobeLAN7";

$acl[0]['name'] = "Root";
$acl[0]['access'] = "root";

$acl[1]['name'] = "Er crew";
$acl[1]['access'] = "isCrew";

$acl[2]['name'] = "Er chief";
$acl[2]['access'] = "isChief";

$acl[3]['name'] = "Er admin";
$acl[3]['access'] = "Er Admin";

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




function mail_body($random) {
    return "Velkommen som bruker på GlobeLAN DEVEL!\n\r
    Du har enten endret e-post, eller laget en ny bruker, så venligst logg inn med ditt brukernavn og passord, og fyll inn: ".$random." som ditt verifiseringsnummer!\r\n\r\n
    Tusen takk\r\n
    Crewet";
}

?>
