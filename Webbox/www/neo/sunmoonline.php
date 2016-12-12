<html>

		<head>
		<script type="text/javascript">

		function draw(){
		var canvas = document.getElementById("canvas1");
		if(canvas.getContext){
			var ctx = canvas.getContext("2d");

			ctx.lineWidth = 2; //Teilstriche
			ctx.strokeStyle = "rgb(51,102,255)";
			ctx.beginPath();
			ctx.moveTo(50,85);
			ctx.lineTo(50,95);
			ctx.stroke();
			ctx.beginPath();
			ctx.moveTo(140,85);
			ctx.lineTo(140,95);
			ctx.stroke();
			ctx.beginPath();
			ctx.moveTo(230,85);
			ctx.lineTo(230,95);
			ctx.stroke();
			ctx.beginPath();
			ctx.moveTo(320,85);
			ctx.lineTo(320,95);
			ctx.stroke();
			ctx.beginPath();
			ctx.moveTo(410,85);
			ctx.lineTo(410,95);
			ctx.stroke();
			
			ctx.lineWidth = 2; //Text
			ctx.fillStyle = "rgb(139,115,85)";
			ctx.beginPath();
			ctx.font = "18px calibri";
		   ctx.fillText("N", 50-6,95+15);
		   ctx.fillText("O", 140-6,95+15);
		   ctx.fillText("S", 230-5,95+15);
		   ctx.fillText("W", 320-8,95+15);
		   ctx.fillText("N", 410-6,95+15);
		   ctx.font = "16px calibri";
		   ctx.fillText("Horizont", 50+368,90+5);
		   
			ctx.lineWidth = 2; //Horizontlinie
			ctx.strokeStyle = "rgb(51,102,255)";
			ctx.beginPath();
			ctx.moveTo(50,90);
			ctx.lineTo(410,90);
			ctx.stroke();
			
			ctx.lineWidth = 1; //Mond
			ctx.fillStyle = "rgb(255,255,255)";
			ctx.beginPath();
		   ctx.arc(298,80,10,0,Math.PI*2,true);
		   ctx.fill();
		   
		   ctx.lineWidth = 1; //Sonne
			ctx.fillStyle = "rgb(255,255,102)";
			ctx.beginPath();
		   ctx.arc(62,147,18,0,Math.PI*2,true);
		   ctx.fill();
			}
		}

		</script>
		</head>

		<body onload="draw()">
		<canvas id="canvas1" width="800" height="400" > //style="border:1px solid yellow;"
		</canvas>
		</body>

		</html>