<?php

include "../ezlay.class.php";

# Start things

$layout = new ezLay();

# Open template file

$layout -> open ("demo-intermediate.tpl");

# Select a block region

$layout -> select_block ("loopexample");

# And we'll fill up with some content

$layout -> push_block (array
(
	"color_name" 	=> "Red",
	"hex_code" 		=> "#bf0000"
));

$layout -> push_block (array
(
	"color_name" 	=> "Orange",
	"hex_code" 		=> "#ffcc00"
));

# Print final result

echo $layout -> finish_content ();