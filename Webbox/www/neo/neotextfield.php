<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sonos Bad Text to Speech</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script>
<script type="text/javascript" src="js/dynamicslider.js"></script>
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.-->
<script>var __adobewebfontsappname__="dreamweaver"</script>
<script src="http://use.edgefonts.net/source-sans-pro:n6,n2:default.js" type="text/javascript"></script>
<link href="css/jquery.mobile-1.4.5.iframe.css" rel="stylesheet" type="text/css">
<!-- CSS für Dynamischen Slider -->
<link href="css/dynamicslider.css" rel="stylesheet" type="text/css">
<link href="css/iframetransparenz.css" rel="stylesheet" type="text/css">
</head>

<body>
<div data-role="page" id="page1">
  
    <div role="main" class="ui-content">
      <section class="texttospeech" id="sonosbad">
          <form action="IPSSetVar.php" method="post">
              <fieldset data-role="fieldcontain" class="ui-hide-label">
              <legend class="textfieldhead" id="textfieldtitle">Textfeld</legend>
              <label for="texttospeechbad">Textausgabe Sonos Bad</label> 
                <input type="text" id="textfieldIPS" name="FreeText" placeholder="Text in Variable in IP-Symcon schreiben" maxlength="500"><p>
                  
                  <button class="textfieldreset" id="textfieldreset" type="reset">Eingaben zurücksetzen</button>
                  <button class="textfieldsubmit" id="textfieldsubmit" type="submit">Eingaben absenden</button>
              </fieldset>   
          </form>
      </section>     
    </div>
</div>
</body>
</html>