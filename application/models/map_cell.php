<?php
class Map_Cell extends IgnitedRecord {
	var $belongs_to = array('map');
	var $id_col = 'idmap_cells';
}
