<?php
class Event extends IgnitedRecord {
	var $belongs_to = "village";
	var $id_col = 'idevents';
}
