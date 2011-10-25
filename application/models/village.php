<?php
class Village extends IgnitedRecord {
	var $belongs_to = array('usuario','map');
	var $id_col = 'idvillages';
}
