<?
/*
 * Dit bestand is een voor gebruik bij $redirect_error
 * in mailinglist.php
 */
?>
<html>
<head>
<title>Fout!</title>
</head>
<body>
<b>Een fout is opgetreden bij het verwerken van uw aanvraag:</b>
<?
switch($_GET['la'])
{
	case "nodata": echo "Geen gegevens ingevuld."; break;
	case "noemail": echo "Geen emailadres ingevuld."; break;
	case "noaction": echo "Geen actie gekozen (subscribe/unsubscribe)."; break;
	case "bademail": echo "Emailadres incorrect."; break;
	case "other": echo "Fout in formulier. Contacteer de webmaster voor meer informatie."; break;
	default: echo "Onbekend probleem. Contacteer de webmaster voor meer informatie."; break;
}
?>

</body>
</html>


