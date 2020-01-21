<?php
/*
Author by: Mark E Taylor
Created: 07/11/2012
Last updated: 07/11/2012
Revision history: 
07/11/2012 - Initial creation.

Description: Builds a drop down <select> menu.

Parameters:
$datbase_object:	The object that connects to the database.
$menugroup:				Select which menu to build.
$default:					Select which is the default item in the list.
$label:						The label to apply to the drop down.
$menuname:				The name passed using $_POST to the PHP code that processes the form.
*/

function build_drop_down_menu($database_object, $menugroup, $default, $label, $menuname){
$selected = "";

/* Get the menu items from the database. */
$query = "SELECT menuname, menutext FROM ".DROPDOWN_TABLE." WHERE menugroup=".$menugroup;
$result = $database_object->query($query);

echo "\n\n<label>".$label."</label>\n";
echo "<select name='".$menuname."'>";

while($line = $result->fetch_assoc()){
	if($default == $line['menutext']){
		$selected = "selected";
	}

	echo "<option value='".$line['menutext']."' ".$selected." >".$line['menutext']."</option>\n";
	
/* 	Reset $selected back to nothing. */
	$selected = "";
}

echo "</select>\n";

return 1;
}

?>