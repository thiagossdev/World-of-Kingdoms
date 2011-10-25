<?php
class Build extends IgnitedRecord {
	var $belongs_to = array("village","building");
	var $id_col = 'idbuilds';
}