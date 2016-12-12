<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>

<title>IP-Symcon Dreambox-Interface</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />

<link rel="icon" href="../../favicon.ico" type="image/x-icon" />
<script src="//ajax.googleapis.com/ajax/libs/dojo/1.10.4/dojo/dojo.js" data-dojo-config="async: true"></script>
<style type="text/css">@import "../default.css";</style>
<style type="text/css">@import "./css/style.css";</style>

<style type="text/css">
html, body { background: transparent; height: 100%; overflow: hidden; }


</style>

<script type="text/javascript">
dojo.require("dojox.string.sprintf");

function getData (parameters, onload)
{
	var command = "";
	for (var i in parameters)
	{
		command += "&" + i + "=" + parameters[i];
	}
	
	dojo.xhrGet(
	{
<?php
	/**
	$dreamip = isset($_GET['dreamip']) ? $_GET['dreamip'] : "";
	$dbname = isset($_GET['dbname']) ? $_GET['dbname'] : "";
	$status = isset($_GET['status']) ? $_GET['status'] : "";
	$current = isset($_GET['current']) ? $_GET['current'] : "";
	$event = isset($_GET['event']) ? $_GET['event'] : "";
	echo "		url: \"dreambox.com.php?dreamip=".$dreamip."&dbname=".$dbname."&status=".$status."&current=".$current."&event=".$event."\" + command,\n";
**/
?>
		handleAs: "json",
		timeout: 30000,

		load: function (response, ioArgs)
		{
			if (onload)
			{
				onload(response);
			}
			
			return response;
		},

		error: function (response, ioArgs)
		{
			return response;
		}
	});
}

function getBouquetList (bref)
{
  	getData({"do": "getBouquetList", "bref": bref}, function (content)
  	{
  		if (content.primary.error)
  		{
  			var mlcContent = "";
  			mlcContent += "Err:" + content.primary.error + "";
  		}
  		else
  		{
     		var mlcContent = "";
    		primaryList = content.primary;

      		
      	for (var i in primaryList)
      	{
      		var primary = primaryList[i];
      		var name = primary.name;
      		var sref = primary.sref;
    
      		mlcContent += "<div class=\"genre\" onclick=\"getChannelList('" + sref + "');\"><div class=\"category\"><div class=\"name\">" + name + "</div></div></div>";
      	}
      }
  	scrollDIV(0);
  	var listContainer = dojo.byId("listContainer");
  	listContainer.innerHTML = mlcContent;
  		
  	});
}

function getChannelList (sref)
{
	getData({"do": "getChannelList", "sref": sref}, function (content)
	{
		if (content.service.error)
		{
			var mlcContent = "";
			mlcContent += "" + content.service.error + "";
		}
		else
		{
			var mlcContent = "";
			serviceList = content.service;
		
			for (var i in serviceList)
			{
				var service = serviceList[i];
			
				var name = service.name;
				var titel = service.titel;
				var desc = service.desc;
				var sref = service.sref;
				var pref = service.pref;

				mlcContent += "<div class=\"channel\" onclick=\"zapService('" + sref + "');\"><div class=\"icon\"><img src=\"./tvicons/" + pref + ".png\"/></div><div class=\"description\"><div class=\"titel\">" + name + "</div><div class=\"subtext\">" + titel + "</div><div class=\"subtext2\">" + desc + "</div></div></div>";
			}	
		}
		scrollDIV(0);
		var listContainer = dojo.byId("listContainer");
		listContainer.innerHTML = mlcContent;
	});
}


function getEPGList (sref)
{
	getData({"do": "getEPGList", "sref": sref}, function (content)
	{
		if (content.epg.error)
		{
			var mlcContent = "";
			mlcContent += "" + content.epg.error + "";
		}
		else
		{
			var mlcContent = "";
			epgList = content.epg;
		
			for (var i in epgList)
			{
				var epg = epgList[i];
			
				var ename = epg.ename;
				var etitel = epg.etitel;
				var edesc = epg.edesc;
				var eid = epg.eid;
				var estart = epg.estart;
				var eduration = epg.eduration;
				var etime = epg.etime;
				var exdesc = epg.exdesc;
				var sref = epg.sref;
				var pref = epg.pref;

				mlcContent += "<div class=\"epg\"><div class=\"starttime\">" + estart + "</div><div class=\"description\"><div class=\"titel\">" + etitel + "</div><div class=\"subtext\">" + edesc + " - " + exdesc + "</div></div></div>";
			}	
		}
		scrollDIV(0);
		var listContainer = dojo.byId("listContainer");
		listContainer.innerHTML = mlcContent;
	});
}


function getTimerList ()
{
	getData({"do": "getTimerList"}, function (content)
	{
		if (content.timer.error)
		{
			var mlcContent = "";
			mlcContent += "" + content.timer.error + "";
		}
		else
		{
			var mlcContent = "";
			timerList = content.timer;
		
			for (var i in timerList)
			{
				var timer = timerList[i];
			
				var sref = timer.sref;
				var pref = timer.pref;
				var name = timer.name;
				var titel = timer.titel;
				var id = timer.id;
				var desc = timer.desc;
				var xdesc = timer.xdesc;
				var tbeg = timer.tbeg;
				var tend = timer.tend;
				var estart = timer.estart;
				var eend = timer.eend;
				var duration = timer.duration;
				var disabled = timer.disabled;

				mlcContent += "<div class=\"timer\"><div class=\"del\" onclick=\"delTimer('" + sref + "','" + tbeg + "','" + tend + "');\"><img src=\"./icons/trash.png\"/></div><div class=\"starttime\">" + estart + "</div><div class=\"description\"><div class=\"titel\">" + titel + "</div><div class=\"subtext\">" + desc + " - " + xdesc + "</div></div></div>";
			}	
		}
		scrollDIV(0);
		var listContainer = dojo.byId("listContainer");
		listContainer.innerHTML = mlcContent;
	});
}

function getMovieList ()
{
	getData({"do": "getMovieList"}, function (content)
	{
		if (content.movie.error)
		{
			var mlcContent = "";
			mlcContent += "" + content.movie.error + "";
		}
		else
		{
			var mlcContent = "";
			movieList = content.movie;
		
			for (var i in movieList)
			{
				var movie = movieList[i];
			
				var name = movie.name;
				var titel = movie.titel;
				var desc = movie.desc;
				var id = movie.id;
				var estart = movie.estart;
				var duration = movie.duration;
				var time = movie.time;
				var xdesc = movie.xdesc;
				var sref = movie.sref;
				var pref = movie.pref;

				mlcContent += "<div class=\"movie\"><div class=\"starttime\">" + estart + "</div><div class=\"description\"><div class=\"titel\">" + titel + "</div><div class=\"subtext\">" + desc + " - " + xdesc + "</div></div></div>";
			}	
		}
		scrollDIV(0);
		var listContainer = dojo.byId("listContainer");
		listContainer.innerHTML = mlcContent;
	});
}

function zapService (sref)
{
	getData({"do": "zapService", "sref": sref}, null);
}

function getCurrent (dreamip)
{
	getData({"do": "getCurrent", "dreamip": dreamip}, null);

}

function delTimer (sref,tbeg,tend)
{
	getData({"do": "delTimer", "sref": sref, "tbeg": tbeg, "tend": tend}, null);
  var t=setTimeout("getTimerList()",1200);
}

function scrollDIV( var1 ) {
	if ( var1 == 0 ) {
		dojo.byId("listContainer").style.top = "0px";
	} else {
		var2 = dojo.byId("listContainer").style.top;
		var2 = Number(var2.substring(0, var2.length-2)) + var1;
		if ( var2 <= 0 ) {
			dojo.byId("listContainer").style.top = var2 + "px";
		} else {
			dojo.byId("listContainer").style.top = "0px";
		}
	}
}

dojo.addOnLoad(function () { getBouquetList("tv"); });

</script>

</head>

<body>
<div class="dbimg"><img src="./icons/dreambox_logo.png"/></div>
<div class="menu"><div class="item" onclick="getBouquetList('tv');">TV</div><div class="item" onclick="getBouquetList('radio');">Radio</div><div class="item" onclick="getTimerList();">Timer</div><div class="item" onclick="getMovieList();">Movie</div></div>
<div id="Container"><div id="listContainer">Bouquets werden geladen...</div></div>

    <h1 id="greeting">Hello</h1>
	
	<script>
        require([
    'dojo/dom',
    'dojo/fx',
    'dojo/domReady!'
], function (dom, fx) {
    // The piece we had before...
    var greeting = dom.byId('greeting');
    greeting.innerHTML += ' from Dojo!';

    // ...but now, with an animation!
    fx.slideTo({
        node: greeting,
        top: 100,
        left: 200
    }).play();
});
    </script>
    

</body>

</html>
