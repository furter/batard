<?
/* Dit script werd gecreëerd door PriorWeb.
 * Dit script laat u toe om gebruikers via een formulier in te schrijven
 * op uw mailinglijst.
 *
 *
 * Een voorbeeld formulier is als volgt:
 *  <form action="mailinglist.php" method="post">
 *  Emailadres: <input type="text" name="emailadres"><br />
 *  <input type="radio" name="listaction" value="subscribe"> Inschrijven
 *  <input type="radio" name="listaction" value="unsubscribe"> Uitschrijven
 *  <input type="submit" name="submit" value="Verzenden">
 *  </form>
 */

/////////////////////////////////////////
// Configuratie bevindt zich hieronder //
/////////////////////////////////////////

// Vul hier de mailinglijstnaam in (wat voor de @ komt)
$listname = "loraine.furter";

// Vul hier uw domeinnaam in
$listdomain = "gmail.com";

// Om misbruik gemakkelijk op te sporen, kunt u gebruik maken van een
// logbestand om alle subscribes en unsubscribes bij te houden.
// Hier zullen ook foutmeldingen weergegeven worden.
//
// Vul hieronder 0 in om uit te schakelen, 1 om in te schakelen.
$log = "0";

// Als u hierboven "1" invult, vul dan hieronder het pad naar het
// logbestand in. U geeft hier best een locatie buiten uw subdomeinen
// aan.
$logfile = "/opt/www/gebruikersnaam/web/private/mailinglistlog.txt";

// Vul hier de pagina in waarnaar de bezoeker geredirect
// moet worden nadat deze zich heeft in- of uitgeschreven
//
// Het script zal automatisch de actie achter de URL plaatsen.
//   Bij subscribe is dit: $redirect_url?la=subscribe
//   Bij unsubscribe is dit: $redirect_url?la=unsubscribe
$redirect_url = "/success.php";

// Vul hier de URL in naar waar geredirect moet worden
// als het emailadres niet werd ingevuld, of geen
// actie (subscribe/unsubscribe) werd gekozen.
//
// Ook hier worden foutcodes meegegeven (?la=...)
// Foutcodes zijn:
//   nodata: Geen formuliergegevens ingevuld
//   noemail: Geen emailadres ingevuld
//   noaction: Geen subscribe/unsubscribe geselecteerd
//   bademail: Slecht gevormd emailadres ingevuld
//   other : interne fout, mogelijk configuratiefout van het formulier
$redirect_error = "/error.php";

//////////////////////////////
//    EINDE CONFIGURATIE    //
// Niets wijzigen hieronder //
//////////////////////////////

// Logbestand openen. Als hier iets misloopt, blijft het script
// verderwerken.
// Mogelijke oorzaak bij een probleem is de bestandspermissies.
$logfd = @fopen($logfile, "a");

if(!isset($_POST['submit'])) {
	addlog("Geen formuliergegevens.");
	header("Location: ".$redirect_error."?la=nodata");
	
} elseif(!isset($_POST['emailadres'])) {
	
	addlog("Geen emailadres ingevuld.");
	header("Location: ".$redirect_error."?la=noemail");
	
} elseif(isset($_POST['emailadres'])&&!eregi("^([A-Z0-9\._\+-]+)@([A-Z0-9\.-]+)$", 
			$_POST['emailadres'])) {
	
	addlog("Emailadres incorrect (".$_POST['emailadres'].").");
	header("Location: ".$redirect_error."?la=bademail");
	
} else {
	
	$headers = "Return-Path: <".$_POST['emailadres'].">\r\n";
	$headers .= "From: <".$_POST['emailadres'].">\r\n";
	$headers .= "Subject: \r\n";
	
	$body = "";
	
	@mail($listname."@".$listdomain,
			$_POST['emailadres']." inschrijving op nieuwsbrief", // Subject
			"Beste Bâtard, u heeft een nieuwe inschrijving voor de nieuwsbrief!", // Body
			$headers
	    );

	addlog($_POST['listaction'].": ".$_POST['emailadres']);
	
	header("Location: ".$redirect_url."?la=".$_POST['listaction']);
}

function addlog($bericht)
{
	global $logfd;

	if(!$logfd)
		return 0;

	$date = date("M d Y H:i:s");
	
	$ip = (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ?
			$_SERVER['HTTP_X_FORWARDED_FOR'] :
			$_SERVER['REMOTE_ADDR']);

	@fputs($logfd, $date." ".$ip." ".$bericht."\n");
	
	return 1;
}

?>
