<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Aktueller Sender Dreambox</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<link rel="icon" href="../../favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="css/dreambox.css" />
<script type="text/javascript" src="js/reflex.js"></script>
</head>

<body>
<div>
<?php
//$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.49:3777/api/");
$ipadr = IPS_GetProperty(20229, "Enigma2IP");
$sref = GetValue(16498);
$sref = "test";
$pref = GetValue(11826);
$pref = "1_0_1_1AF8_3FE_1_C00000_0_0_0";
if ($sref !== "")
{
echo '<a href="http://'.$ipadr.'/web/zap?sRef='.$sref.'"><img class="reflex" idistance="0" iheight="33" iopacity="33" iborder="0" width="188"  src="piconneo/'.$pref.'.png" alt="logo"></a>';


}


?>	
</div>


</body>

</html>