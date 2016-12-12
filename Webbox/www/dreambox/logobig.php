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
$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.49:3777/api/");
$ipadr = $rpc->IPS_GetProperty(48070, "Enigma2IP");
$sref = $rpc->GetValue(41006);
$pref = $rpc->GetValue(20046);
echo '<a href="http://'.$ipadr.'/web/zap?sRef='.$sref.'"><img class="reflex" idistance="0" iheight="33" iopacity="33" iborder="0" src="piconhd/'.$pref.'.png" alt="logo"></a>';



?>	
</div>


</body>

</html>