<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Testumgebung</title>
<link href="css/dreambox.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script>
<script type="text/javascript" src="js/jqueryscripts.js"></script>
<link href="css/jquerytest.css" rel="stylesheet" type="text/css">
<!--<link href="https://code.jquery.com/ui/1.11.4/themes/black-tie/jquery-ui.css" rel="stylesheet" type="text/css">-->
<link href="css/jquery.mobile-1.4.5.min.css" rel="stylesheet" type="text/css">
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.-->
<script>var __adobewebfontsappname__="dreamweaver"</script>
<script src="http://use.edgefonts.net/source-sans-pro:n6:default;bilbo:n4:default;acme:n4:default.js" type="text/javascript"></script>

</head>

<body>
<div data-role="page" id="page">
  <div data-role="content">
          <h1>jQuery Beispiel: einbinden und erster Befehl</h1>
        
        <a href="http://www.html-seminar.de/" title="HTML, CSS u. jQuery lernen">
        http://www.HTML-Seminar.de</a>
        <p id="absatzon">Anschalten</p>
        <p id="absatzoff">Ausschalten</p>
        
        	<div id="dreamboxstatus">
              <form>
                <label for="flipdreamboxstatus" class="ui-hidden-accessible">Dreambox Status:</label>
                    <select name="flipdreamboxstatus" id="flipdreamboxstatus" data-role="flipswitch">
                        <option id="dreamboxflipstatus_aus" value="off">Aus</option>
                        <option id="dreamboxflipstatus_an" value="on" selected>An</option>
                    </select>
                </form>
                
            </div>
            <div id="dreamboxstatus2">
             <fieldset>
              <div data-role="fieldcontain">
                <label data-off-text="Go" data-on-text="Go" for="checkbox-based-flipswitch" class="ui-hidden-accessible">Checkbox-based:</label>
                <input type="checkbox" id="checkbox-based-flipswitch" data-role="flipswitch">
              </div>
            </fieldset>
                             
            </div>
            <div id="dreamboxstatus3">
            <div class="ui-flipswitch ui-shadow-inset ui-bar-inherit">
              <span tabindex="1" id="RTZ" class="ui-flipswitch-on ui-btn ui-shadow ui-btn-inherit">An</span>
              <span class="ui-flipswitch-off">Aus</span>
              <input type="checkbox" data-role="flipswitch" data-enhanced="true" data-corners="false" name="flip-checkbox" class="ui-flipswitch-input">
            </div>
            </div>
            <div id="name"></div>
             </div>
  </div>
</div>


  


</body>
</html>
