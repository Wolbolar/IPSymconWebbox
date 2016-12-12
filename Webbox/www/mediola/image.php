<?
$imageid = $_GET['imageid'];

$path = "../../..";
$imageid = (int)$imageid;

if(!IPS_MediaExists($imageid))
    die("ID #".$imageid.") does not exists");

$media=IPS_GetMedia($imageid);
$imagepath=$path."/".$media['MediaFile'];

if($media['MediaType'] != 1)
    die("ID #".$imageid." is not an image");

if(!file_exists($imagepath))
    die("File does not exists");
    
header("Content-Type: ".returnMIMEType($imagepath));
readfile($imagepath);

function returnMIMEType($filename)
{
    preg_match("|\.([a-z0-9]{2,4})$|i", $filename, $fileSuffix);

    switch(strtolower($fileSuffix[1]))
    {
        case "jpg" :
        case "jpeg" :
        case "jpe" :
            return "image/jpg";

        case "png" :
        case "gif" :
        case "bmp" :
            return "image/".strtolower($fileSuffix[1]);
    }
}


?>