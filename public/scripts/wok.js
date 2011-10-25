var com;
var com_max;
var com_vel;

var mad;
var mad_max;
var mad_vel;

var our;
var our_max;
var our_vel;

var ped;
var ped_max;
var ped_vel;

function config() {
	var temp = 3600;

	com = parseInt(document.getElementById("resource_com").innerHTML);
	com_max = parseInt(document.getElementById("resource_com_max").innerHTML);
	com_vel = parseInt(document.getElementById("resource_com_vel").innerHTML)
			/ temp;

	/*
	 * mad = parseInt(document.getElementById("resource_mad").innerHTML);
	 * mad_max =
	 * parseInt(document.getElementById("resource_mad_max").innerHTML); mad_vel =
	 * parseInt(document.getElementById("resource_mad_vel").innerHTML)/temp;
	 */

	our = parseInt(document.getElementById("resource_our").innerHTML);
	our_max = parseInt(document.getElementById("resource_our_max").innerHTML);
	our_vel = parseInt(document.getElementById("resource_our_vel").innerHTML)
			/ temp;

	/*
	 * ped_max =
	 * parseInt(document.getElementById("resource_ped_max").innerHTML); ped_vel =
	 * parseInt(document.getElementById("resource_ped_vel").innerHTML)/temp; ped =
	 * parseInt(document.getElementById("resource_ped").innerHTML);
	 */

	/*
	 * document.getElementById("resource_com").innerHTML = parseInt(com);
	 * document.getElementById("resource_mad").innerHTML = parseInt(mad);
	 * document.getElementById("resource_our").innerHTML = parseInt(our);
	 * document.getElementById("resource_ped").innerHTML = parseInt(ped);
	 */

	setTimeout("loop()", 1000);
}

function loop() {
	com = com + com_vel;
	com = com <= com_max ? com : com_max;

	/*
	 * mad = mad + mad_vel; mad = mad <= mad_max ? mad : mad_max;
	 */

	our = our + our_vel;
	our = our <= our_max ? our : our_max;

	/*
	 * ped = ped + ped_vel; ped = ped <= ped_max ? ped : ped_max;
	 */

	document.getElementById("resource_com").innerHTML = parseInt(com);
	// document.getElementById("resource_mad").innerHTML = parseInt(mad);
	document.getElementById("resource_our").innerHTML = parseInt(our);
	// document.getElementById("resource_ped").innerHTML = parseInt(ped);
	setTimeout("loop()", 1000);
}

function load_map() {
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("GET", "public/files/map.xml", false);
	xmlhttp.send();
	xmlDoc = xmlhttp.responseXML;

	var layers = xmlDoc.getElementsByTagName("layer");
	var tiles = Array();
	for (i = 0; i < layers.length; i++) {
		tiles[i] = layers[i].getElementsByTagName("data")[0]
				.getElementsByTagName("tile");
	}

	var div;
	for (i = 0; i < 80; i++) {
		for (l = 0; l < layers.length; l++) {
			id = "layer_" + (l + 1) + "." + i;
			div = document.getElementById(id);
			switch (l) {
			case 2:
				div.onmouseover = function() {
					this.className = "layer_3_cursor";
				};
				div.onmouseout = function() {
					this.className = "layer_3";
				};
				break;

			default:
				gid = parseInt(tiles[l][i].getAttribute("gid"));
				switch (gid) {
				case 20:
					div.style.backgroundImage = "url('public/images/tilesets/tiles/20.gif')";
					break;
				default:
					div.style.backgroundImage = "url('public/images/tilesets/tiles/"
							+ gid + ".png')";
					break;
				}
				break;
			}
		}
	}
}

function sql_map() {
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("GET", "public/files/map.xml", false);
	xmlhttp.send();
	xmlDoc = xmlhttp.responseXML;

	var layers = xmlDoc.getElementsByTagName("layer");
	var tiles = Array();
	for (i = 0; i < layers.length; i++) {
		tiles[i] = layers[i].getElementsByTagName("data")[0]
				.getElementsByTagName("tile");
	}

	var div;
	var sql = document.getElementById("sql");
	sql.innerHTML = "START TRANSACTION;<br/> USE `worldofkingdoms`;<br/>";
	var idmaps = 1;
	var layer_1, layer_2, layer_3;

	for (y = 0; y < 8; y++) {
		for (x = 0; x < 10; x++) {

			layer_1 = parseInt(tiles[0][(y * 10 + x)].getAttribute("gid"));
			layer_2 = parseInt(tiles[1][(y * 10 + x)].getAttribute("gid"));
			layer_3 = parseInt(tiles[2][(y * 10 + x)].getAttribute("gid"));
			switch (layer_1) {
			case 20:
				sql.innerHTML = sql.innerHTML
						+ "INSERT INTO map_cells (`idmap_cells`, `idmaps`, `idtype_cells`, `coor_x`, `coor_y`, `layer_1`, `layer_2`, `layer_3`)"
						+ "VALUES (NULL, '" + idmaps + "', '2', '" + x + "', '"
						+ y + "', '" + layer_1 + "', '" + layer_2 + "', '"
						+ layer_3 + "'); <br/>";
				break;
			case 21:
			case 22:
			case 23:
				sql.innerHTML = sql.innerHTML
						+ "INSERT INTO map_cells (`idmap_cells`, `idmaps`, `idtype_cells`, `coor_x`, `coor_y`, `layer_1`, `layer_2`, `layer_3`)"
						+ "VALUES (NULL, '" + idmaps + "', '3', '" + x + "', '"
						+ y + "', '" + layer_1 + "', '" + layer_2 + "', '"
						+ layer_3 + "'); <br/>";
				break;
			case 29:
				sql.innerHTML = sql.innerHTML
						+ "INSERT INTO map_cells (`idmap_cells`, `idmaps`, `idtype_cells`, `coor_x`, `coor_y`, `layer_1`, `layer_2`, `layer_3`)"
						+ "VALUES (NULL, '" + idmaps + "', '4', '" + x + "', '"
						+ y + "', '" + layer_1 + "', '" + layer_2 + "', '"
						+ layer_3 + "'); <br/>";
				break;
			case 30:
				sql.innerHTML = sql.innerHTML
						+ "INSERT INTO map_cells (`idmap_cells`, `idmaps`, `idtype_cells`, `coor_x`, `coor_y`, `layer_1`, `layer_2`, `layer_3`)"
						+ "VALUES (NULL, '" + idmaps + "', '5', '" + x + "', '"
						+ y + "', '" + layer_1 + "', '" + layer_2 + "', '"
						+ layer_3 + "'); <br/>";
				break;
			default:
				sql.innerHTML = sql.innerHTML
						+ "INSERT INTO map_cells (`idmap_cells`, `idmaps`, `idtype_cells`, `coor_x`, `coor_y`, `layer_1`, `layer_2`, `layer_3`)"
						+ "VALUES (NULL, '" + idmaps + "', '1', '" + x + "', '"
						+ y + "', '" + layer_1 + "', '" + layer_2 + "', '"
						+ layer_3 + "'); <br/>";
				break;
			}
		}
	}
	sql.innerHTML = sql.innerHTML + "COMMIT;<br/>";
}

var coor_x, coor_y;

$(document).ready(function() {
	$('.layer_1').click(function() {
		var num = $(this).attr('id').split('.',2)[1];
		coor_x = num%10;
        coor_y = (-(num-coor_x)/10);
        $('#text').text(coor_x + ', ' + coor_y);
	});
});

function construct() {
    location = 'play/construct/' + coor_x + '/' + coor_y + '/';
}

function move_to() {
    location = 'play/move_to/' + coor_x + '/' + coor_y + '/';
}

var clk;
var time;
var t = 10;

function update() {
  d = new Date();
  clk = $('#clock');
  time = t - d.getSeconds() % t + 1;
  setTimeout('reload()',time*1000);
  clock();
}

function reload () {
  location = 'play';
}

Number.prototype.zeroFormat = function(n, f, r){
    return n = new Array((++n, f ? (f = (this + "").length) < n ? n - f : 0 : n)).join(0), r ? this + n : n + this;
};

function clock () {
  clk.text(time.zeroFormat(2,true));
  time--;
  setTimeout('clock()',1000);
}