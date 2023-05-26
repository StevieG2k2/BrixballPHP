
var start=0;

document.addEventListener('keyup', event => {
  if (event.code === 'Space' && start==0) {
    console.log('Started');
	document.getElementById("startPrompt").hidden = true;
	document.getElementById('canvas').style.cursor = 'none';
	start = 1;
	drawIt();
  }
})

function drawIt() {
	var cegu = new Image();
	cegu.src = "opeka.png";	
	var cegu2 = new Image();
	cegu2.src = "opeka2.png";
	var WIDTH = $("#canvas").width();
	var HEIGHT = $("#canvas").height();
	var dx = 1;
	var dy = -5;
	var r = 10;
	var ctx;
	var canvas
	var padx;
	var padh;
	var padw;
	var padm = 5;
	var x = WIDTH/2;
	var y = HEIGHT*0.967;
	var rightDown = false;
	var leftDown = false;
	$(document).keydown(onKeyDown);
	$(document).keyup(onKeyUp); 
	var f = 1;
	
	var odboj = new sound("bounce.wav");
	var razbij = new sound("break.wav");
	var smrt = new sound("death.wav");
	
	var bricks;
	var NROWS = 10;
	var NCOLS = 12;
	var BRICKWIDTH = WIDTH/NCOLS;
	var BRICKHEIGHT = 35;
	var PADDING = 0;
	
	var tocke = 0; //deklaracija spremenljivke
	var maxTocke = NROWS * NCOLS * 2;
	
	//timer
	var sekunde;
	var sekundeI;
	var minuteI;
	var intTimer;
	var izpisTimer;
	
	//deklaracija spremenljivke
	var start=true;

	document.getElementById("replay").addEventListener("click", bla);
	function bla(){
		window.location.reload();
	}


	//########################################################################################################################################################
	//                 REKORDI
	const NO_OF_HIGH_SCORES = 10;
	const HIGH_SCORES = 'rekordi';

	var input = document.getElementById("ime");
	function handlRekord(usrname, tocke, izpisTimer, datum){
		$.post("handlRecord.php", { name: usrname, points: tocke, timeO: izpisTimer, date: datum }, function(response) {
			// Handle the response from the server
			console.log(response);
		});
	}
	//########################################################################################################################################################

	function sound(pot) {
		this.sound = document.createElement("audio");
		this.sound.src = pot;
		this.sound.setAttribute("preload", "auto");
		this.sound.setAttribute("controls", "none");
		this.sound.style.display = "none";
		document.body.appendChild(this.sound);
		this.play = function(){
			this.sound.play();
		}
		this.stop = function(){
			this.sound.pause();
		}
	} 
	
	//timer
	function timer(){
	
		if(start==true){
			sekunde++;

			sekundeI = ((sekundeI = (sekunde % 60)) > 9) ? sekundeI : "0"+sekundeI;
			minuteI = ((minuteI = Math.floor(sekunde / 60)) > 9) ? minuteI : "0"+minuteI;
			izpisTimer = minuteI + ":" + sekundeI;

			$("#cas").html(izpisTimer);
		}else{
			sekunde=0;
			//izpisTimer = "00:00";
			$("#cas").html(izpisTimer);
		}
	}

	function initbricks() { //inicializacija opek - polnjenje v tabelo
		bricks = new Array(NROWS);
		for (i=0; i < NROWS; i++) {
			bricks[i] = new Array(NCOLS);
			for (j=0; j < NCOLS; j++) {
				bricks[i][j] = 2;
			}
		}
	}

	
	
	var canvasMinX;
	var canvasMaxX;

	function init_mouse() {
		canvasMinX = $("#canvas").offset().left;
		canvasMaxX = canvasMinX + WIDTH;
	}

	function onMouseMove(evt) {
	  if (evt.pageX > canvasMinX && evt.pageX < canvasMaxX) {
		padx = evt.pageX - canvasMinX - padw / 2;
	  }
	}
	
	
	
	
	function init() {
		// dodajanje kode v metodo init
		$("#tocke").html(tocke);
		
		ctx = $('#canvas')[0].getContext("2d");
		
		sekunde = 0;
		izpisTimer = "00:00";
		intTimer = setInterval(timer, 1000);
		return setInterval(draw, 10);
		
	}
	function circle(x,y,r) {
		ctx.fillStyle = 'red';
		ctx.beginPath();
		ctx.arc(x, y, r, 0, Math.PI*2, true);
		ctx.closePath();
		ctx.fill();
	}
	function rect(x,y,w,h) {
		ctx.fillStyle = 'yellow';
		ctx.beginPath();
		ctx.rect(x,y,w,h);
		ctx.closePath();
		ctx.fill();
	}
	function init_paddle() {
	  padh = 10;
	  padw = 120;
	  padx = WIDTH / 2 - padw / 2;
	}
	function onKeyDown(evt) {
		if (evt.keyCode == 39) rightDown = true;
		else if (evt.keyCode == 37) leftDown = true;
	}
	function onKeyUp(evt) {
		if (evt.keyCode == 39)
	rightDown = false;
		else if (evt.keyCode == 37) leftDown = false;
	}
	function clear() {
		ctx.clearRect(0, 0, WIDTH, HEIGHT);
	}
	function collision(){
		if(x + r >= padx && x <= padx + padw){
			if(y + r >= pady && y <= pady){
				if(x + r >= padx && x + 2 / r <= padx + 75){
					dx = -dx;
					dy = -dy;
				}
				if(x + 2 / r >= padx + 75 && x <= padx + padw){
					dx = dx;
					dy = -dy;
				}
				dy = -dy;
			}
		}
	}
	

	//konec IGRE
	function konecIgre(){
		start = false;
		x = WIDTH/2;//centrira plošček
		y = HEIGHT*0.967;
		dx=0;
		dy=0;
		document.getElementById("finalscore").innerHTML = "Doseženih točk:"+tocke+"<br> Končni čas:"+izpisTimer
		document.getElementById("replay").style.visibility = "visible";
		document.getElementById('canvas').style.cursor = 'default';
		document.getElementById('canvas').style.visibility = 'hidden';
		const d = new Date()
		const datum = d.getDate()+"."+(d.getMonth()+1)+"."+d.getFullYear()
		//hiscoreChk(usrname, tocke, izpisTimer, datum)
		handlRekord(usrname, tocke, izpisTimer, datum)
	}
	
	function zmaga(){
		start = false;
		x = 450;
		y = 590;
		dx=0;
		dy=0;
		document.getElementById("finalscore").innerHTML = "Dosegli ste vse točke<br> Končni čas: "+izpisTimer
		document.getElementById("replay").style.visibility = "visible";
		document.getElementById('canvas').style.cursor = 'default';
		document.getElementById('canvas').style.visibility = 'hidden';
		handlRekord(usrname, tocke, izpisTimer, datum)
		//hiscore()
	}
	
	
	function draw() {
	
	  clear();
	  circle(x, y, r);
	  //premik ploščice levo in desno
		if(rightDown){
			if((padx+padw) < WIDTH){
				padx += 5;
			}else{
				padx = WIDTH-padw;
			}
		}
		else if(leftDown){
			if(padx>0){
				padx -=5;
			}else{
				padx=0;
			}
		}
		if((padx+padw) > WIDTH)
			padx = WIDTH - padw;
		if(padx<0)
			padx = 0;
		rect(padx, HEIGHT-padh, padw, padh);

		//riši opeke
		for (i=0; i < NROWS; i++) {
			for (j=0; j < NCOLS; j++) {
				if (bricks[i][j] == 2)
					ctx.drawImage(cegu,(j * (BRICKWIDTH)) ,	(i * (BRICKHEIGHT)) ,BRICKWIDTH, BRICKHEIGHT);
				if (bricks[i][j] == 1)
					ctx.drawImage(cegu2,(j * (BRICKWIDTH)) ,	(i * (BRICKHEIGHT)) ,BRICKWIDTH, BRICKHEIGHT);
			}
		}

		rowheight = BRICKHEIGHT +f/2; //Smo zadeli opeko?
		colwidth = BRICKWIDTH  +f/2;
		row = Math.floor(y/rowheight);
		col = Math.floor(x/colwidth);
		//Če smo zadeli opeko, vrni povratno kroglo in označi v tabeli, da opeke ni več
		if (y < NROWS * rowheight && row >= 0 && col >= 0 && bricks[row][col] == 1) {
			razbij.play();
			dy = -dy;
			bricks[row][col] --;
			tocke += 1;
			if(tocke == maxTocke)
				zmaga();
			$("#tocke").html(tocke);
		}
		if (y < NROWS * rowheight && row >= 0 && col >= 0 && bricks[row][col] == 2) {
			razbij.play();
			dy = -dy;
			bricks[row][col] --;
			tocke += 1;
			if(tocke == maxTocke)
				zmaga();
			$("#tocke").html(tocke);
		}
		if (x + dx > WIDTH -r || x + dx < 0+r)
			dx = -dx;
		if (y + dy < 0+r)
			dy = -dy;
		else if (y + dy > HEIGHT -(r+f)) {
			start = false;
			//Odboj kroglice, ki je odvisen od odboja od ploščka 
			if (x > padx && x < padx + padw) {
				odboj.play();
				dx = 10 * ((x-(padx+padw/2))/padw);
				dy = -dy;
				start= true;
			}else if (y + dy > HEIGHT){
				smrt.play();
				konecIgre();
			}
		}
		x += dx;
		y += dy;
	}
	
	init();
	init_paddle();
	initbricks();
	$(document).mousemove(onMouseMove);

	init_mouse();
}