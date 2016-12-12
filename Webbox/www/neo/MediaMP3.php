<?
$mp3id = $_GET['mp3id'];

$mp3id = (int)$mp3id;

if(!IPS_MediaExists($mp3id))
    die("ID #".$mp3id.") does not exists");

$media=IPS_GetMedia($mp3id);

if($media['MediaType'] != 2)
    die("ID #".$mp3id." is not a mp3 file");

$mp3base64 = IPS_GetMediaContent($mp3id); //liefert den Base64 kodierten Inhalt für das Medienobjekt
$mp3data = base64_decode($mp3base64);
  

$headhtml = 'Content-Type: audio/mpeg';
header($headhtml);
echo $mp3data;

?>