<?php

include "../ezlay.class.php";

# Start things

$layout = new ezLay();

# Open template file

$layout -> open ("demo-advanced.tpl");

# Catch a block content

// echo $layout -> get_block_contents ("loopthis");

# Select a block region

$layout -> select_block ("loopthis");

# Append new content to block region

$layout -> push_block (array
(
	"name" 		=> "Guilherme",
	"email" 	=> "guimadaleno@me.com",
	"city" 		=> "Belo Horizonte"
));

# Remove block section

$layout -> remove_from_block ("nonus");

# One more time

$layout -> push_block (array
(
	"name" 		=> "John Appleseed",
	"email" 	=> "john@appleseed.com",
	"city" 		=> "New York"
));

# Replace some content

$layout -> push_content (array
(
	"word" => "world!"
));

# Append content to block region 'loopthis' one more time...

$layout -> push_block (array
(
	"name" 		=> "Chuck Norris",
	"email" 	=> "chuck@internet.com",
	"city" 		=> "Nowhere"
));

$layout -> remove_from_block ("nonus");

# Replace another content

$layout -> push_content (array
(
	"message" => "and we hope you're enjoying it"
));

# Remove a block region

$layout -> remove_block ("hidethis");

# Now we'll select another region

$layout -> select_block ("loopthistoo");

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

# Load another template file

$layout -> open ("demo-advanced-extra.tpl");

# Push some extra content

$layout -> push_content (array
(
	"datetime" => date("Y-m-d H:i:s")
));

# Just print it

echo $layout -> finish_content ();
