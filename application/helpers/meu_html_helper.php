<?php
  function fillAttributes($obj, $array) {
    foreach (array_keys($array) as $key) {
      if ($array[$key] == '') {
        $obj->$key = null;
      } else {
        $obj->$key = $array[$key];
      }
    }
  }
  
  function fillArray($org, $dest) {
    foreach (array_keys($array) as $key) {
      $dest[$key] = $array[$key];
    }
  }

  function butao20($onclick, $value) {
    return "<input type = 'button' class = 'botao20' onclick = '$onclick' value = '$value' />";
  }
  
  function location($string){
    return "location = '$string'";
  }
  
  function confirmar($string){
    return "confirmar(\"$string\")";
  }
  
  function js_tag($src) {
    return "<script type = 'text/javascript' src = '$src'></script>";
  }
  
  function butao_js($id, $onclick) {
    return "<div id = \"$id\" onclick = \"$onclick\" onmouseover = \"this.id = '$id"."_'\" onmouseout = \"this.id = '$id'\"></div>";
  }
  
  function submit_js($id, $form) {
    return "<input type = \"submit\" id = \"$id\" value = \"\" onclick = \"document.forms['$form'].submit()\" onmouseover = \"this.id = '$id"."_'\" onmouseout = \"this.id = '$id'\"/>";
  }
  
  function map_open($map) {
  	return "<div class = \"$map\" >";
  }
  
  function tile_open($layer, $id, $background = 0) {
	$background = site_url("public/images/tilesets/tiles/$background");
	return "<div id = \"$layer.$id\" class = \"$layer\" style = \"background-image: url($background);\">";
  }
  
  function div_close() {
  	return "</div>";
  }
  
?>