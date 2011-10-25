<?php
echo map_open('map')."\r\n";
	$i = 0;
	foreach ($cells as $cell) {
        switch($cell->layer_1) {
        case 20:
            echo '	'.tile_open('layer_1', $i, $cell->layer_1.'.gif')."\r\n";
        break;
        default:
            echo '	'.tile_open('layer_1', $i, $cell->layer_1.'.png')."\r\n";
        }
		
		echo '		'.tile_open('layer_2', $i, $cell->layer_2.'.png')."\r\n";
		echo '			'.tile_open('layer_3', $i, $cell->layer_3.'.png')."\r\n";
		echo '			'.div_close()."\r\n";
		echo '		'.div_close()."\r\n";
		echo '	'.div_close()."\r\n";
		$i++;
	}
echo div_close()."\r\n";;