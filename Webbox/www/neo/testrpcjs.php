<?
	
$Enigma2_Modul_ID = 20229 /*[Geräte\Heimkino\Dreambox 8000 Wohnzimmer]*/;
//$Sender = "Das Erste HD";
//$Sender = "ZDF";
//$Sender = "SenderohneLeerzeichen";
$Sender = "Sender mit Leerzeichen";
$sref = "1:0:19:2B66:3F3:1:C00000:0:0:0:";
$HTML = "<!DOCTYPE html>
<html lang=\"de\">
<head>
<style>
.tonspur {
    color: red;
    
}
.activetonspur {
	background-color: white;
}
</style>
<script type=\"text/javascript\">
  window.xhrGet=function xhrGet(o) {
      var HTTP = new XMLHttpRequest();
    HTTP.open(\'GET\',o,true);
    HTTP.send(NULL);
  }
  window.xhrPost=function xhrPost(o, data) {
      var HTTP = new XMLHttpRequest();
    HTTP.open(\'POST\',o,true);
    HTTP.send(data);
  }
  window.xhrRPC=function xhrRPC(o, name, params) {
      var HTTP = new XMLHttpRequest();
    HTTP.open(\'POST\',o,true);
    var rpc = JSON.stringify({\"jsonrpc\":\"2.0\", \"method\":name, \"params\":params, \"id\":0});
   HTTP.setRequestHeader(\"Content-type\", \"application/json\");
   HTTP.setRequestHeader(\"Authorization\", \"Basic \" + btoa(\"hatto.zechel@web.de:Geck0!975\"));
    HTTP.send(rpc);
  }
  </script>
</head>
<body>
";



//$HTML .= '<div id="Test" class="zap" onclick=window.xhrRPC("/api/","Enigma2BY_ZapTo",['.$Enigma2_Modul_ID.','.$Sender.']);>'.$Sender.'</div>';
$HTML .= "<div id='Test1' class='zap' onclick=window.xhrRPC('/api/','SetValue',[11848 /*[Geräte\Heimkino\Video\Dreambox\Zap\Dreambox 8000 Wohnzimmer Zap\Sender auf SREF umschalten]*/,'".$sref."']);>".$Sender."</div>";
//$HTML .= "<div id='Test1' class='zap' onclick=window.xhrRPC('/api/','Enigma2BY_ZapTo',[".$Enigma2_Modul_ID.",'".$Sender."']);>".$Sender."</div>";
$HTML .= '
</body>
</html>';
//var_dump($HTML);
echo $HTML;
//SetValueString(35990 /*[Geräte\Kern Skripte\Test aus Webfront Var setzen\Dreamboxzap]*/, $HTML);
 

?>