<?php

include "../ezlay.class.php";

# Start things

$layout = new ezLay();

# Open template file

$layout -> open ("demo-basic.tpl");

# Insert content into template

$layout -> push_content (array
(
	"currentdate" => strftime("%A %d, %Y"),
	"currentip" => $_SERVER['REMOTE_ADDR']
));

# Print final result

echo $layout -> finish_content ();