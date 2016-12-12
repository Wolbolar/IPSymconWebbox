<!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>jQuery Formularajax</title>
    <script type="text/javascript" src="../../js/jquery.js"></script>
	<!--<script type="text/javascript" src="../../js/jquery.mobile-1.4.5.min.js"></script>-->
    <!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.-->
    <script>var __adobewebfontsappname__="dreamweaver"</script>
    <script src="http://use.edgefonts.net/source-sans-pro:n6:default;bilbo:n4:default;acme:n4:default.js" type="text/javascript"></script>
    <link href="../../css/dreambox.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../../js/dreamboxA.js"></script>
    <script type="text/javascript" src="../../js/jquery.ajaxform1.js"></script>

    <!--<link href="../../css/jquery.mobile-1.4.5.min.css" rel="stylesheet" type="text/css"> -->
  </head>
  <body>
    <h1>Testformular</h1>
    <a href="http://192.168.55.37/web/epgservicenow?sRef=1:0:19:2B66:3F3:1:C00000:0:0:0:" id="dm8000ajax">Dreambox Request senden</a>
   	<form action="ipsrequest.php" method="post">
    <!-- Versuch Dreambox abzufragen /web/epgservicenow?sRef=1:0:19:2B66:3F3:1:C00000:0:0:0: 
    <form action="http://192.168.55.37" method="post"> -->
    <!--<label for="dreamboxcommand">Dreambox Web Command: <input type="text" name="vorname" value="/web/deviceinfo" /></label> -->
      <label>Command: <input type="text" name="command" /></label>
      <input type="submit">
    </form>
	<div id="currentchannel">Sender</div>
    <div id="title">Titel</div>
	<div id="start">Start</div>
    <div id="ende">Ende</div>
    <div id="dauer">Dauer</div>
    <div id="vorbei">Vorbei</div>
    <div id="verbl">Verbleibend</div>
    <div id="description">Beschreibung</div>
    <div id="fortschritt">Fortschritt</div>
    <div id="endeint">Endeint</div>
    <div id="sref">sref</div>
    <div id="pref">pref</div>
    <div id="snrdb">snrdb</div>
    <div id="snr">snr</div>
    <div id="ber">ber</div>
    <div id="acg">acg</div>
    <div id="status"></div>
    <ul id="dreamboxinfo"></ul>  
   	
  </body>
</html>