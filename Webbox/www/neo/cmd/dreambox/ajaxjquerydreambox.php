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
    <script type="text/javascript" src="../../js/jquery.ajaxform.js"></script>

    <!--<link href="../../css/jquery.mobile-1.4.5.min.css" rel="stylesheet" type="text/css"> -->
  </head>
  <body>
    
	<div class="ui-field-contain">
    	<h1>Testformular</h1>
    	<a href="http://192.168.55.37/web/deviceinfo" id="dm8000ajax">Dreambox Request senden</a>
   		<form action="ipsrequest.php" method="get">
    	<!-- Versuch Dreambox abzufragen /web/epgservicenow?sRef=1:0:19:2B66:3F3:1:C00000:0:0:0: --> 
    	<!--<form action="http://192.168.55.37" method="get"> -->
        	<fieldset data-role="controlgroup">
            	<legend>Verfügbare Dreambox Abfragen:</legend>
                <input type="radio" name="dreamboxwebapi" id="dream_about" value="/web/about" >
                <label for="dream_about">about</label>
                <input type="radio" name="dreamboxwebapi" id="dream_addlocation" value="/web/addlocation?dirname=&createFolder=">
                <label for="dream_addlocation">addlocation</label>
                <input type="radio" name="dreamboxwebapi" id="dream_autotimerlist" value="/web/autotimerlist?gl=">
                <label for="dream_autotimerlist">autotimerlist</label>
                <input type="radio" name="dreamboxwebapi" id="dream_backup" value="/web/backup?Filename=">
                <label for="dream_backup">backup</label>
                <input type="radio" name="dreamboxwebapi" id="dream_currenttime" value="/web/currenttime">
                <label for="dream_currenttime">currenttime</label>
                <input type="radio" name="dreamboxwebapi" id="dream_deviceinfo" value="/web/deviceinfo">
                <label for="dream_deviceinfo">deviceinfo</label>
                <input type="radio" name="dreamboxwebapi" id="dream_downmix" value="/web/downmix?enable=">
                <label for="dream_downmix">downmix</label>
                <input type="radio" name="dreamboxwebapi" id="dream_epgbouquet" value="/web/epgbouquet?bRef=&time=">
                <label for="dream_epgbouquet">epgbouquet</label>
                <input type="radio" name="dreamboxwebapi" id="dream_epgmulti" value="/web/epgmulti?bRef=&time=&endTime=">
                <label for="dream_epgmulti">epgmulti</label>
                <input type="radio" name="dreamboxwebapi" id="dream_epgnext" value="/web/epgnext?bRef=">
                <label for="dream_epgnext">epgnext</label>
                <input type="radio" name="dreamboxwebapi" id="dream_epgnow" value="/web/epgnow?bRef=">
                <label for="dream_epgnow">epgnow</label>
                <input type="radio" name="dreamboxwebapi" id="dream_epgnownext" value="/web/epgnownext?bRef=">
                <label for="dream_epgnownext">epgnownext</label>
                <input type="radio" name="dreamboxwebapi" id="dream_epgsearch.rss" value="/web/epgsearch.rss?search=">
                <label for="dream_epgsearch.rss">epgsearch.rss</label>
                <input type="radio" name="dreamboxwebapi" id="dream_epgsearch" value="/web/epgsearch?search=">
                <label for="dream_epgsearch">epgsearch</label>
                <input type="radio" name="dreamboxwebapi" id="dream_epgservice" value="/web/epgservice?sRef=&time=&endTime=">
                <label for="dream_epgservice">epgservice</label>
                <input type="radio" name="dreamboxwebapi" id="dream_epgservicenext" value="/web/epgservicenext?sRef=">
                <label for="dream_epgservicenext">epgservicenext</label>
                <input type="radio" name="dreamboxwebapi" id="dream_epgservicenow" value="/web/epgservicenow?sRef=">
                <label for="dream_epgservicenow">epgservicenow</label>
                <input type="radio" name="dreamboxwebapi" id="dream_epgsimilar" value="/web/epgsimilar?sRef=&eventid=">
                <label for="dream_epgsimilar">epgsimilar</label>
                <input type="radio" name="dreamboxwebapi" id="dream_external" value="/web/external">
                <label for="dream_external">external</label>
                <input type="radio" name="dreamboxwebapi" id="dream_getallservices" value="/web/getallservices?sRef=">
                <label for="dream_getallservices">getallservices</label>
                <input type="radio" name="dreamboxwebapi" id="dream_getaudiotracks" value="/web/getaudiotracks">
                <label for="dream_getaudiotracks">getaudiotracks</label>
                <input type="radio" name="dreamboxwebapi" id="dream_getcurrent" value="/web/getcurrent">
                <label for="dream_getcurrent">getcurrent</label>
                <input type="radio" name="dreamboxwebapi" id="dream_getcurrlocation" value="/web/getcurrlocation">
                <label for="dream_getcurrlocation">getcurrlocation</label>
                <input type="radio" name="dreamboxwebapi" id="dream_getlocations" value="/web/getlocations">
                <label for="dream_getlocations">getlocations</label>
                <input type="radio" name="dreamboxwebapi" id="dream_getpid" value="/web/getpid">
                <label for="dream_getpid">getpid</label>
                <input type="radio" name="dreamboxwebapi" id="dream_getservices" value="/web/getservices?sRef=">
                <label for="dream_getservices">getservices</label>
                <input type="radio" name="dreamboxwebapi" id="dream_gettags" value="/web/gettags">
                <label for="dream_gettags">gettags</label>
                <input type="radio" name="dreamboxwebapi" id="dream_mediaplayeradd" value="/web/mediaplayeradd?file=">
                <label for="dream_mediaplayeradd">mediaplayeradd</label>
                <input type="radio" name="dreamboxwebapi" id="dream_mediaplayercmd" value="/web/mediaplayercmd?command=">
                <label for="dream_mediaplayercmd">mediaplayercmd</label>
                <input type="radio" name="dreamboxwebapi" id="dream_mediaplayercurrent" value="/web/mediaplayercurrent">
                <label for="dream_mediaplayercurrent">mediaplayercurrent</label>
                <input type="radio" name="dreamboxwebapi" id="dream_mediaplayerlist" value="/web/mediaplayerlist?path=&types=">
                <label for="dream_mediaplayerlist">mediaplayerlist</label>
                <input type="radio" name="dreamboxwebapi" id="dream_mediaplayerload" value="/web/mediaplayerload?filename=">
                <label for="dream_mediaplayerload">mediaplayerload</label>
                <input type="radio" name="dreamboxwebapi" id="dream_mediaplayerplay" value="/web/mediaplayerplay?root=&file=">
                <label for="dream_mediaplayerplay">mediaplayerplay</label>
                <input type="radio" name="dreamboxwebapi" id="dream_mediaplayerremove" value="/web/mediaplayerremove?file=">
                <label for="dream_mediaplayerremove">mediaplayerremove</label>
                <input type="radio" name="dreamboxwebapi" id="dream_mediaplayerwrite" value="/web/mediaplayerwrite?filename=">
                <label for="dream_mediaplayerwrite">mediaplayerwrite</label>
                <input type="radio" name="dreamboxwebapi" id="dream_message" value="/web/message?text=&type=&timeout=">
                <label for="dream_message">message</label>
                <input type="radio" name="dreamboxwebapi" id="dream_messageanswer" value="/web/messageanswer?getanswer=">
                <label for="dream_messageanswer">messageanswer</label>
                <input type="radio" name="dreamboxwebapi" id="dream_moviedelete" value="/web/moviedelete?sRef=">
                <label for="dream_moviedelete">moviedelete</label>
                <input type="radio" name="dreamboxwebapi" id="dream_movielist.html" value="/web/movielist.html?dirname=&tag=">
                <label for="dream_movielist.html">movielist.html</label>
                <input type="radio" name="dreamboxwebapi" id="dream_movielist.m3u" value="/web/movielist.m3u?dirname=&tag=">
                <label for="dream_movielist.m3u">movielist.m3u</label>
                <input type="radio" name="dreamboxwebapi" id="dream_movielist.rss" value="/web/movielist.rss?dirname=&tag=">
                <label for="dream_movielist.rss">movielist.rss</label>
                <input type="radio" name="dreamboxwebapi" id="dream_movielist" value="/web/movielist?dirname=&tag=">
                <label for="dream_movielist">movielist</label>
                <input type="radio" name="dreamboxwebapi" id="dream_moviemove" value="/web/moviemove?sRef=&dirname=&force=&background=">
                <label for="dream_moviemove">moviemove</label>
                <input type="radio" name="dreamboxwebapi" id="dream_movietags" value="/web/movietags">
                <label for="dream_movietags">movietags</label>
                <input type="radio" name="dreamboxwebapi" id="dream_parentcontrollist" value="/web/parentcontrollist">
                <label for="dream_parentcontrollist">parentcontrollist</label>
                <input type="radio" name="dreamboxwebapi" id="dream_pluginlistread" value="/web/pluginlistread">
                <label for="dream_pluginlistread">pluginlistread</label>
                <input type="radio" name="dreamboxwebapi" id="dream_powerstate" value="/web/powerstate?newstate=">
                <label for="dream_powerstate">powerstate</label>
                <input type="radio" name="dreamboxwebapi" id="dream_recordnow" value="/web/recordnow?recordnow=">
                <label for="dream_recordnow">recordnow</label>
                <input type="radio" name="dreamboxwebapi" id="dream_remotecontrol" value="/web/remotecontrol?command=&type=&rcu=">
                <label for="dream_remotecontrol">remotecontrol</label>
                <input type="radio" name="dreamboxwebapi" id="dream_removelocation" value="/web/removelocation?dirname=">
                <label for="dream_removelocation">removelocation</label>
                <input type="radio" name="dreamboxwebapi" id="dream_restarttwisted" value="/web/restarttwisted">
                <label for="dream_restarttwisted">restarttwisted</label>
                <input type="radio" name="dreamboxwebapi" id="dream_restore" value="/web/restore?Filename=">
                <label for="dream_restore">restore</label>
                <input type="radio" name="dreamboxwebapi" id="dream_selectaudiotrack" value="/web/selectaudiotrack?id=">
                <label for="dream_selectaudiotrack">selectaudiotrack</label>
                <input type="radio" name="dreamboxwebapi" id="dream_servicelistplayable" value="/web/servicelistplayable?sRef=&sRefPlaying=">
                <label for="dream_servicelistplayable">servicelistplayable</label>
                <input type="radio" name="dreamboxwebapi" id="dream_servicelistreload" value="/web/servicelistreload?mode=">
                <label for="dream_servicelistreload">servicelistreload</label>
                <input type="radio" name="dreamboxwebapi" id="dream_serviceplayable" value="/web/serviceplayable?sRef=&sRefPlaying=">
                <label for="dream_serviceplayable">serviceplayable</label>
                <input type="radio" name="dreamboxwebapi" id="dream_services.m3u" value="/web/services.m3u?bRef=">
                <label for="dream_services.m3u">services.m3u</label>
                <input type="radio" name="dreamboxwebapi" id="dream_session" value="/web/session">
                <label for="dream_session">session</label>
                <input type="radio" name="dreamboxwebapi" id="dream_settings" value="/web/settings">
                <label for="dream_settings">settings</label>
                <input type="radio" name="dreamboxwebapi" id="dream_signal" value="/web/signal?AGC=">
                <label for="dream_signal">signal</label>
                <input type="radio" name="dreamboxwebapi" id="dream_sleeptimer" value="/web/sleeptimer?cmd=&time=&action=&enabled=&confirmed=">
                <label for="dream_sleeptimer">sleeptimer</label>
                <input type="radio" name="dreamboxwebapi" id="dream_stream.m3u" value="/web/stream.m3u">
                <label for="dream_stream.m3u">stream.m3u</label>
                <input type="radio" name="dreamboxwebapi" id="dream_stream" value="/web/stream">
                <label for="dream_stream">stream</label>
                <input type="radio" name="dreamboxwebapi" id="dream_streamcurrent.m3u" value="/web/streamcurrent.m3u">
                <label for="dream_streamcurrent.m3u">streamcurrent.m3u</label>
                <input type="radio" name="dreamboxwebapi" id="dream_streamsubservices" value="/web/streamsubservices?sRef=">
                <label for="dream_streamsubservices">streamsubservices</label>
                <input type="radio" name="dreamboxwebapi" id="dream_strings.js" value="/web/strings.js">
                <label for="dream_strings.js">strings.js</label>
                <input type="radio" name="dreamboxwebapi" id="dream_subservices" value="/web/subservices">
                <label for="dream_subservices">subservices</label>
                <input type="radio" name="dreamboxwebapi" id="dream_timeradd" value="/web/timeradd?sRef=&repeated=&begin=&end=&name=&description=&dirname=&tags=&eit=&disabled=&justplay=&afterevent=">
                <label for="dream_timeradd">timeradd</label>
                <input type="radio" name="dreamboxwebapi" id="dream_timeraddbyeventid" value="/web/timeraddbyeventid?sRef=&eventid=&justplay=&dirname=&tags=">
                <label for="dream_timeraddbyeventid">timeraddbyeventid</label>
                <input type="radio" name="dreamboxwebapi" id="dream_timerchange" value="/web/timerchange?sRef=&begin=&end=&name=&description=&dirname=&tags=&eit=&disabled=&justplay=&afterevent=&repeated=&channelOld=&beginOld=&endOld=&deleteOldOnSave=">
                <label for="dream_timerchange">timerchange</label>
                <input type="radio" name="dreamboxwebapi" id="dream_timercleanup" value="/web/timercleanup?cleanup=">
                <label for="dream_timercleanup">timercleanup</label>
                <input type="radio" name="dreamboxwebapi" id="dream_timerdelete" value="/web/timerdelete?sRef=&begin=&end=">
                <label for="dream_timerdelete">timerdelete</label>
                <input type="radio" name="dreamboxwebapi" id="dream_timerlist" value="/web/timerlist">
                <label for="dream_timerlist">timerlist</label>
                <input type="radio" name="dreamboxwebapi" id="dream_timerlistwrite" value="/web/timerlistwrite?write=">
                <label for="dream_timerlistwrite">timerlistwrite</label>
                <input type="radio" name="dreamboxwebapi" id="dream_tpm" value="/web/tpm?cmd=&random=">
                <label for="dream_tpm">tpm</label>
                <input type="radio" name="dreamboxwebapi" id="dream_ts.m3u" value="/web/ts.m3u">
                <label for="dream_ts.m3u">ts.m3u</label>
                <input type="radio" name="dreamboxwebapi" id="dream_tvbrowser" value="/web/tvbrowser?sRef=&name=&description=&dirname=&tags=&eit=&disabled=&justplay=&afterevent=&command=&year=&month=&day=&shour=&smin=&ehour=&emin=&repeated=&syear=&smonth=&sday=">
                <label for="dream_tvbrowser">tvbrowser</label>
                <input type="radio" name="dreamboxwebapi" id="dream_updates.html" value="/web/updates.html?AGC=">
                <label for="dream_updates.html">updates.html</label>
                <input type="radio" name="dreamboxwebapi" id="dream_vol" value="/web/vol?set=">
                <label for="dream_vol">vol</label>
                <input type="radio" name="dreamboxwebapi" id="dream_zap" value="/web/zap?sRef=&title=">
                <label for="dream_zap">zap</label>
                <input type="radio" name="dreamboxwebapi" id="ipsrequest" value="ipsrequest">
                <label for="ipsrequest">Test für IPS</label>
            </fieldset>
        
              <label for="command">Dreambox Web Command: <input type="text" name="command" value="/web/deviceinfo" /></label>
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
            <div id="pref"><img src="../../images/piconhd/1_0_19_1987_44E_1_C00000_0_0_0.png" width="500" height="300" alt=""/></div>
            <div id="snrdb">snrdb</div>
            <div id="snr">snr</div>
            <div id="ber">ber</div>
            <div id="acg">acg</div>
            <div id="status"></div>
            <ul id="dreamboxinfo"></ul>  
            
		</div> 
	
   	
  </body>
</html>