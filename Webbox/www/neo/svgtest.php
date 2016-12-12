<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Wetter OC3 Buttom</title>
<link href="css/svg.css" rel="stylesheet" type="text/css">
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.-->
<script>var __adobewebfontsappname__="dreamweaver"</script>
<script src="http://use.edgefonts.net/source-sans-pro:n6,n2,n4:default;acme:n4:default;bilbo:n4:default.js" type="text/javascript"></script>

</head>

<body>
<?php
//Holt Variablen
$rpc = new JSONRPC("http://hatto.zechel@web.de:Geck0!975@192.168.55.49:3777/api/");
$temp = str_replace(".", ",", $rpc->GetValueFormatted(37442 /*[Garten\Wetterstation\Temperatur]*/));
$humidity = str_replace(".", ",", $rpc->GetValueFormatted(42624 /*[Garten\Wetterstation\Feuchtigkeit]*/));
$wind = str_replace(".", ",", $rpc->GetValueFormatted(33880 /*[Garten\Wetterstation\Windgeschwindigkeit]*/));
$rain = str_replace(".", ",", $rpc->GetValueFormatted(30716 /*[Homematic\HomeMatic Systemvariablen\Regen heute]*/));
?>

<div id="pagewrapper">
  <div class="buttonA" id="button1">a
</div>
  <div class="buttonA" id="button2">b
</div>
  <div class="buttonA" id="button3">c
</div>


<svg version="1.1"
     xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink">
  <use xlink:href="#tempicon" />
</svg>

</div>
<svg version="1.1"
     xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink">
  <defs>
    <symbol id="symb" style="stroke:black;stroke-width:3px">
      <rect x="10" y="10" height="75" width="150" fill="red" />
      <rect x="25" y="25" height="75" width="150" fill="blue" />
    </symbol>
  </defs>
  <use xlink:href="#symb" />
  <use x="30" y="30" xlink:href="#symb" />
  <use x="60" y="60" xlink:href="#symb" />
</svg>
<!-- SVG Filters
The available filter elements in SVG are:

<feBlend> - filter for combining images
<feColorMatrix> - filter for color transforms
<feComponentTransfer>
<feComposite>
<feConvolveMatrix>
<feDiffuseLighting>
<feDisplacementMap>
<feFlood>
<feGaussianBlur>
<feImage>
<feMerge>
<feMorphology>
<feOffset> - filter for drop shadows
<feSpecularLighting>
<feTile>
<feTurbulence>
<feDistantLight> - filter for lighting
<fePointLight> - filter for lighting
<feSpotLight> - filter for lighting
-->
<!-- Icons -->
<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	  viewBox="0 0 378.333 378.333" style="enable-background:new 0 0 378.333 378.333;" xml:space="preserve">
<defs>	  
<symbol class="weathericon" id="tempicon">
	<path id="temp1" d="M189.167,314.52c-4.143,0-7.5,3.358-7.5,7.5s3.357,7.5,7.5,7.5c20.663,0,37.474-16.811,37.474-37.474
		c0-18.095-12.892-33.235-29.974-36.719v-25.371h9.167c4.143,0,7.5-3.358,7.5-7.5s-3.357-7.5-7.5-7.5h-9.167v-22.125h9.167
		c4.143,0,7.5-3.358,7.5-7.5s-3.357-7.5-7.5-7.5h-9.167v-22.125h9.167c4.143,0,7.5-3.358,7.5-7.5s-3.357-7.5-7.5-7.5h-9.167v-22.125
		h9.167c4.143,0,7.5-3.358,7.5-7.5s-3.357-7.5-7.5-7.5h-9.167V81.458h9.167c4.143,0,7.5-3.358,7.5-7.5s-3.357-7.5-7.5-7.5h-9.167
		V50.432c0-4.142-3.357-7.5-7.5-7.5s-7.5,3.358-7.5,7.5v204.895c-17.081,3.484-29.974,18.623-29.974,36.719
		c0,4.142,3.357,7.5,7.5,7.5s7.5-3.358,7.5-7.5c0-12.392,10.082-22.474,22.474-22.474s22.474,10.082,22.474,22.474
		S201.558,314.52,189.167,314.52z"/>
	<path id="temp2" d="M231.85,217.111c-3.596-2.052-8.178-0.801-10.231,2.796s-0.802,8.178,2.796,10.231
		c22.229,12.688,36.039,36.41,36.039,61.907c0,39.308-31.979,71.287-71.287,71.287s-71.287-31.979-71.287-71.287
		c0-25.498,13.81-49.219,36.039-61.907c2.339-1.335,3.782-3.821,3.782-6.514V73.958c0-4.142-3.357-7.5-7.5-7.5s-7.5,3.358-7.5,7.5
		V219.4c-24.672,15.809-39.821,43.249-39.821,72.646c0,47.579,38.708,86.287,86.287,86.287s86.287-38.708,86.287-86.287
		C275.454,261.176,258.746,232.463,231.85,217.111z"/>
	<path id="temp3" d="M150.201,53.576c4.143,0,7.5-3.358,7.5-7.5c0-17.135,13.94-31.076,31.076-31.076h0.779
		c17.136,0,31.076,13.94,31.076,31.076v139.256c0,4.142,3.357,7.5,7.5,7.5s7.5-3.358,7.5-7.5V46.076
		C235.632,20.669,214.962,0,189.556,0h-0.779c-25.406,0-46.076,20.669-46.076,46.076C142.701,50.218,146.058,53.576,150.201,53.576z
		"/>
</symbol>
</defs>
<filter id="pictureFilter" >
    <feGaussianBlur stdDeviation="5" />
  </filter> 
</svg>
</body>
</html>