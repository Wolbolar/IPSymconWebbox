<?
$imageid = $_GET['imageid'];

$imageid = (int)$imageid;

if(!IPS_MediaExists($imageid))
    die("ID #".$imageid.") does not exists");

$media=IPS_GetMedia($imageid);

if($media['MediaType'] != 1)
    die("ID #".$imageid." is not an image");

$imgbase64 = IPS_GetMediaContent($imageid); //liefert den Base64 kodierten Inhalt für das Medienobjekt
$imgdata = base64_decode($imgbase64);
  
$mimetype = getImageMimeType($imgdata);
//echo $mimetype;

$headhtml =  getimgheader($mimetype);
$headhtml = 'Content-Type: image/jpeg';
header($headhtml);
echo $imgdata;

function getBytesFromHexString($hexdata)
{
  for($count = 0; $count < strlen($hexdata); $count+=2)
    $bytes[] = chr(hexdec(substr($hexdata, $count, 2)));

  return implode($bytes);
}

function getImageMimeType($imagedata)
{
  $imagemimetypes = array( 
    "jpeg" => "FFD8", 
    "png" => "89504E470D0A1A0A", 
    "gif" => "474946",
    "bmp" => "424D", 
    "tiff" => "4949",
    "tiff" => "4D4D"
  );

  foreach ($imagemimetypes as $mime => $hexbytes)
  {
    $bytes = getBytesFromHexString($hexbytes);
    if (substr($imagedata, 0, strlen($bytes)) == $bytes)
      return $mime;
  }

  return NULL;
}

function getimgheader($mimetype)
{
	if($mimetype == "jpeg")
	{
	$header = '"Content-Type: image/jpeg"';
	}
	elseif($mimetype == "png")
	{
	$header = '"Content-Type: image/png"';
	}
	elseif($mimetype == "gif")
	{
	$header = '"Content-Type: image/gif"';
	}
	elseif($mimetype == "bmp")
	{
	$header = '"Content-Type: image/bmp"';
	}
	elseif($mimetype == "tiff")
	{
	$header = '"Content-Type: image/tiff"';
	}
	return $header;
}
?>