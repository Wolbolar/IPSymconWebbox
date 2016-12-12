<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Testumgebung2</title>
<link href="css/dreambox.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script>
<script type="text/javascript" src="js/jqueryscripts.js"></script>
<script type="text/javascript" src="js/cvi_reflex_lib.js"></script>
<script type="text/javascript" src="js/dreamboxA.js"></script>
<link href="css/jquerytest.css" rel="stylesheet" type="text/css">
<!--<link href="https://code.jquery.com/ui/1.11.4/themes/black-tie/jquery-ui.css" rel="stylesheet" type="text/css">-->
<link href="css/jquery.mobile-1.4.5.min.css" rel="stylesheet" type="text/css">
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.-->
<script>var __adobewebfontsappname__="dreamweaver"</script>
<script src="http://use.edgefonts.net/source-sans-pro:n6:default;bilbo:n4:default;acme:n4:default.js" type="text/javascript"></script>
<style type="text/css">
#socialbookmarksanzeigen {
	background-color: #00CC00;
	padding: 0.4em;
}
#sozialbookmarks {
	background-color: orange;
	padding: 0.4em;
}
</style>
</head>

<body>
<div data-role="page" id="page">
  <div data-role="content">
      <div id="reload">aktualisieren</div>
        <p id="socialbookmarksanzeigen">
            <a href="#" id="sobo-einausblenden">Ein- Ausblenden</a>
        </p>
        <div id="sozialbookmarks">
          <p><b>Bereich für social bookmarks</b><br>
          Hier kommen nun die üblichen Verdächtigen und Logos dazu.<br>
          Nicht vergessen, meine Seite zu bookmarken!</p>
        </div>
        
         <!-- Container für Variablen -->
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
            
                 <div id="dreamboxstatus">
              <form>
                <label for="flipdreamboxstatus" class="ui-hidden-accessible">Dreambox Status:</label>
                    <select name="flipdreamboxstatus" id="flipdreamboxstatus" data-role="flipswitch">
                        <option id="dreamboxflipstatus_aus" value="off">Aus</option>
                        <option id="dreamboxflipstatus_an" value="on">An</option>
                    </select>
                </form>
               </div>
            <div id="aktuellerDreamboxstatus">
            <!-- Schreibt aktuellen Status von Dreambox -->
                          Status der Dreambox ist
			 </div>
            <figure id="piconbig"><img class="piconbig" src="images/piconhd/1_0_1_77D8_40A_1_C00000_0_0_0.png"><figcaption class="piconbigtext" id="piconbigtext">Picon Sender</figcaption></figure>
            <section class="dreamboxzapbuttons">
    		<div class="zapbutton" id="ARD">ARD</div><div class="zapbutton" id="ZDF">ZDF</div>
    		</section>
  </div>
</div>


</body>
</html>