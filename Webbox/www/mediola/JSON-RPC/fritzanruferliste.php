<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>

<title>Mediola IP-Symcon Einbindung</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />



<link href="mediola.css" rel="stylesheet" type="text/css" /></head>

<body>
<?php

// Variable schreiben
// $rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.10:82/api/");
// $rpc->SetValue(15924, 18.5);

//Variable auslesen
$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.10:82/api/");
$ausgabe = $rpc->GetValue(48292 /*[Fritzbox\Anruferliste\Content]*/);
$downstream = $rpc->GetValueFormatted(55189 /*[Fritzbox\Datenrate Downstream]*/);
$upstream = $rpc->GetValueFormatted(41258 /*[Fritzbox\Datenrate Upstream]*/);


//echo '<p>Anruferliste:<p>  '.$ausgabe.'</p>';
//echo '<p>Datenrate Downstream:  '.$downstream.'</p>';
//echo '<p>Datenrate Upstream:  '.$upstream.'</p>';

	
?>

<p>Anruferliste:<p>  <table bgcolor='#ffffff'><body scroll=no><body bgcolor='#ffffff'><table style=margin:0 auto; font-size:0.8em;">
<colgroup>
<col width="50em" />
<col width="410em" />
<col width="450em" />
<col width="225em" />
<col width="225em" />
<col width="75em" />
<col width="100em" />
</colgroup>
<thead style="">
<tr style=""><th style="color:ffff00; width:35px; align:left;">Typ</th><th style="color:ffff00; width:35px; align:left;">Datum</th><th style="color:ffff00; width:35px; align:left;">Name</th><th style="color:ffff00; width:35px; align:left;">Rufnummer</th><th style="color:ffff00; width:35px; align:left;">Nebenstelle</th><th style="color:ffff00; width:35px; align:left;">Eigene Rufnummer</th><th style="color:ffff00; width:35px; align:left;">Dauer</th></tr>
</thead>
<tbody style="">
<tr style="background-color:#ffffff; color:ffffff;"><td style="text-align:center;"><img src="/user/fritz/Callin.png" width="26px" height="26px" style="margin:1px 0 0;"></td><td style="text-align:center;">Heute -  11:34</td><td style="">Wittstadt R. u. G.</td><td style="text-align:center;">093195446</td><td style="text-align:center;">Wohnzimmer</td><td style="text-align:center;">9280972</td><td style="text-align:center;">0:26</td></tr>
<tr style="background-color:#ffffff; color:ffff00;"><td style="text-align:center;"><img src="/user/fritz/Callout.png" width="26px" height="26px" style="margin:1px 0 0;"></td><td style="text-align:center;">Heute -  10:34</td><td style="">Wittstadt R. u. G.</td><td style="text-align:center;">093195446</td><td style="text-align:center;">Wohnzimmer</td><td style="text-align:center;">9280972</td><td style="text-align:center;">0:01</td></tr>
<tr style="background-color:#000000; color:ffff00;"><td style="text-align:center;"><img src="/user/fritz/Callin.png" width="26px" height="26px" style="margin:1px 0 0;"></td><td style="text-align:center;">Gestern - 18:30</td><td style="">-Unbekannt-</td><td style="text-align:center;">01777937467</td><td style="text-align:center;">Wohnzimmer</td><td style="text-align:center;">9280972</td><td style="text-align:center;">0:05</td></tr>
<tr style="background-color:#000000; color:ffff00;"><td style="text-align:center;"><img src="/user/fritz/Callin.png" width="26px" height="26px" style="margin:1px 0 0;"></td><td style="text-align:center;">Gestern - 16:14</td><td style="">Elke Schairer</td><td style="text-align:center;">061909744040</td><td style="text-align:center;">ABZechel</td><td style="text-align:center;">9280972</td><td style="text-align:center;">0:01</td></tr>
<tr style="background-color:#000000; color:ffff00;"><td style="text-align:center;"><img src="/user/fritz/Callout.png" width="26px" height="26px" style="margin:1px 0 0;"></td><td style="text-align:center;">Gestern - 12:33</td><td style="">-Unbekannt-</td><td style="text-align:center;">0694076620</td><td style="text-align:center;">Wohnzimmer</td><td style="text-align:center;">9280972</td><td style="text-align:center;">0:02</td></tr>
<tr style="background-color:#000000; color:ffff00;"><td style="text-align:center;"><img src="/user/fritz/Callout.png" width="26px" height="26px" style="margin:1px 0 0;"></td><td style="text-align:center;">Gestern - 12:10</td><td style="">-Unbekannt-</td><td style="text-align:center;">06173301116</td><td style="text-align:center;">Wohnzimmer</td><td style="text-align:center;">9280972</td><td style="text-align:center;">0:09</td></tr>
<tr style="background-color:#000000; color:ffff00;"><td style="text-align:center;"><img src="/user/fritz/Callin.png" width="26px" height="26px" style="margin:1px 0 0;"></td><td style="text-align:center;">Gestern - 11:14</td><td style="">-Unbekannt-</td><td style="text-align:center;">0014156550045</td><td style="text-align:center;">Wohnzimmer</td><td style="text-align:center;">9280972</td><td style="text-align:center;">0:55</td></tr>
<tr style="background-color:#000000; color:ffff00;"><td style="text-align:center;"><img src="/user/fritz/Callin.png" width="26px" height="26px" style="margin:1px 0 0;"></td><td style="text-align:center;">Gestern - 08:42</td><td style="">06196898992 (06196890)</td><td style="text-align:center;">06196898992</td><td style="text-align:center;">Wohnzimmer</td><td style="text-align:center;">9280972</td><td style="text-align:center;">0:02</td></tr>
<tr style="background-color:#000000; color:ffff00;"><td style="text-align:center;"><img src="/user/fritz/Callout.png" width="26px" height="26px" style="margin:1px 0 0;"></td><td style="text-align:center;">Gestern - 08:35</td><td style="">-Unbekannt-</td><td style="text-align:center;">06196895522</td><td style="text-align:center;">Wohnzimmer</td><td style="text-align:center;">9280972</td><td style="text-align:center;">0:01</td></tr>
<tr style="background-color:#000000; color:ffff00;"><td style="text-align:center;"><img src="/user/fritz/Callin.png" width="26px" height="26px" style="margin:1px 0 0;"></td><td style="text-align:center;">09.07.15 20:03</td><td style="">-Unbekannt-</td><td style="text-align:center;">01777937467</td><td style="text-align:center;">Schlafzimmer</td><td style="text-align:center;">9280972</td><td style="text-align:center;">0:26</td></tr>
<tr style="background-color:#000000; color:ffff00;"><td style="text-align:center;"><img src="/user/fritz/Callin.png" width="26px" height="26px" style="margin:1px 0 0;"></td><td style="text-align:center;">09.07.15 19:27</td><td style="">-Unbekannt-</td><td style="text-align:center;">01777937467</td><td style="text-align:center;">Schlafzimmer</td><td style="text-align:center;">9280972</td><td style="text-align:center;">0:31</td></tr>
<tr style="background-color:#000000; color:ffff00;"><td style="text-align:center;"><img src="/user/fritz/Callout.png" width="26px" height="26px" style="margin:1px 0 0;"></td><td style="text-align:center;">09.07.15 16:30</td><td style="">Wittstadt R. u. G.</td><td style="text-align:center;">093195446</td><td style="text-align:center;">Wohnzimmer</td><td style="text-align:center;">9280972</td><td style="text-align:center;">0:01</td></tr>
<tr style="background-color:#000000; color:ffff00;"><td style="text-align:center;"><img src="/user/fritz/Callin.png" width="26px" height="26px" style="margin:1px 0 0;"></td><td style="text-align:center;">09.07.15 16:25</td><td style="">Wittstadt R. u. G.</td><td style="text-align:center;">093195446</td><td style="text-align:center;">Wohnzimmer</td><td style="text-align:center;">9280972</td><td style="text-align:center;">0:02</td></tr>
<tr style="background-color:#000000; color:ffff00;"><td style="text-align:center;"><img src="/user/fritz/Callin.png" width="26px" height="26px" style="margin:1px 0 0;"></td><td style="text-align:center;">09.07.15 16:22</td><td style="">Wittstadt R. u. G.</td><td style="text-align:center;">093195446</td><td style="text-align:center;">Wohnzimmer</td><td style="text-align:center;">9280972</td><td style="text-align:center;">0:01</td></tr>
<tr style="background-color:#000000; color:ffff00;"><td style="text-align:center;"><img src="/user/fritz/Callout.png" width="26px" height="26px" style="margin:1px 0 0;"></td><td style="text-align:center;">09.07.15 15:47</td><td style="">Wittstadt R. u. G.</td><td style="text-align:center;">093195446</td><td style="text-align:center;">Wohnzimmer</td><td style="text-align:center;">9280972</td><td style="text-align:center;">0:01</td></tr>
<tr style="background-color:#000000; color:ffff00;"><td style="text-align:center;"><img src="/user/fritz/Callout.png" width="26px" height="26px" style="margin:1px 0 0;"></td><td style="text-align:center;">09.07.15 15:46</td><td style="">-Unbekannt-</td><td style="text-align:center;">06196895522</td><td style="text-align:center;">Wohnzimmer</td><td style="text-align:center;">9280972</td><td style="text-align:center;">0:01</td></tr>
<tr style="background-color:#000000; color:ffff00;"><td style="text-align:center;"><img src="/user/fritz/Callin.png" width="26px" height="26px" style="margin:1px 0 0;"></td><td style="text-align:center;">09.07.15 15:40</td><td style="">-Unbekannt-</td><td style="text-align:center;">06196890</td><td style="text-align:center;">ABZechel</td><td style="text-align:center;">9280972</td><td style="text-align:center;">0:01</td></tr>
<tr style="background-color:#000000; color:ffff00;"><td style="text-align:center;"><img src="/user/fritz/Callout.png" width="26px" height="26px" style="margin:1px 0 0;"></td><td style="text-align:center;">09.07.15 14:53</td><td style="">-Unbekannt-</td><td style="text-align:center;">06173301613</td><td style="text-align:center;">Wohnzimmer</td><td style="text-align:center;">9280972</td><td style="text-align:center;">0:02</td></tr>
<tr style="background-color:#000000; color:ffff00;"><td style="text-align:center;"><img src="/user/fritz/Callin.png" width="26px" height="26px" style="margin:1px 0 0;"></td><td style="text-align:center;">09.07.15 14:52</td><td style="">Zechel Hatto</td><td style="text-align:center;">01796644399</td><td style="text-align:center;">Wohnzimmer</td><td style="text-align:center;">9280972</td><td style="text-align:center;">0:01</td></tr>
<tr style="background-color:#000000; color:ffff00;"><td style="text-align:center;"><img src="/user/fritz/Callinfailed.png" width="26px" height="26px" style="margin:1px 0 0;"></td><td style="text-align:center;">09.07.15 14:51</td><td style="">06173301613 (06173300)</td><td style="text-align:center;">06173301613</td><td style="text-align:center;">9280972</td><td style="text-align:center;">9280972</td><td style="text-align:center;">0:00</td></tr>
</tbody>
</table>
</p><p>Datenrate Downstream:  18140 kbit/s</p><p>Datenrate Upstream:  925 kbit/s</p>


</body>

</html>




