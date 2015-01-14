<?php

include "ezlay.class.php";

# Start things

$layout = new ezLay();

# Open template

$layout -> open ("example.html");

# How to catch a block content

// echo $layout -> get_block_contents ("loopthis");

# Select a block region

$layout -> select_block ("loopthis");

# Append new content to block region

$layout -> push_block ("loopthis", array
(
	"name" 		=> "Guilherme",
	"email" 	=> "guimadaleno@me.com",
	"city" 		=> "Belo Horizonte"
));

# One more time

$layout -> push_block ("loopthis", array
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

$layout -> push_block ("loopthis", array
(
	"name" 		=> "Chuck Norris",
	"email" 	=> "chuck@internet.com",
	"city" 		=> "Nowhere"
));

# Replace another content

$layout -> push_content (array
(
	"message" => "and we hope you're enjoying it!"
));

# Remove a block region

$layout -> remove_block ("hidethis");

# Print final result

echo $layout -> finish_content ();

# Load another template file

$layout -> open ("extra.html");

$layout -> push_content (array
(
	"datetime" => date("Y-m-d H:i:s")
));

# Just print it

echo $layout -> finish_content ();

