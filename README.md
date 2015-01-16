# ezLay

### What is it? *(lovable explanation)*

ezLay keeps HTML off from your PHP code.
:D

### What is it? *(fancy explanation)*

ezLay is a small and efficient class to easily handle templates using PHP.

  - Easy;
  - Lightweight;
  - Object-oriented (ohhh);
  - No extra modules and classes are required.

---

### Installation

- Install via [Bower](http://bower.io) ```bower install --save ezlay```
- Download via [GitHub](https://github.com/guimadaleno/ezlay/archive/master.zip)

---

### How to use?

#### Basic example

Getting started
```php
include "../ezlay.class.php";
$layout = new ezLay();
```

Opening template file (tpl, html, etc...)
```php
$layout -> open ("demo-basic.tpl");
```

Inside the **demo-basic.tpl** we have:
```html
<p>Today is {currentdate}</p>
<p>Your IP is {currentip}</p>
```

Now we are going to add the content dynamically.
It is quite simple. The array keys inside the template file are replaced by the array values in PHP.
```php
$layout -> push_content (array
(
	"currentdate" => strftime("%A %d, %Y"),
	"currentip" => $_SERVER['REMOTE_ADDR']
));
```

And we're done. Let's print the results.
```php
echo $layout -> finish_content ();
```

#### Intermediate example

Initializing...
```php
include "../ezlay.class.php";
$layout = new ezLay();
```

Opening template file
```php
$layout -> open ("demo-intermediate.tpl");
```

Inside the **demo-intermediate.tpl**, we have something we call '*block'*, that's actually a custom tag with some code.
```html
<loopexample>
	<p>The hex code of {color_name} is {hex_code}</p>
</loopexample>
```

We are now going to select that block to be used below
```php
$layout -> select_block ("loopexample");
```

Now we are going to push some content inside it
```php
$layout -> push_block (array
(
	"color_name" 	=> "Red",
	"hex_code" 		=> "#bf0000"
));
```

Hmm. Once again!
```php
$layout -> push_block (array
(
	"color_name" 	=> "Orange",
	"hex_code" 		=> "#ffcc00"
));
```

Ok. Fine. Now let's see what did we get?
```php
echo $layout -> finish_content ();
```

The output will be:
```html
The hex code of Red is #bf0000
The hex code of Orange is #ffcc00
```

#### Advanced example (but still simple :D)

First step
```php
include "../ezlay.class.php";
$layout = new ezLay();
```

Loading template
```php
$layout -> open ("demo-advanced.tpl");
```

In this example, inside **demo-advanced.tpl**, we have **two blocks** that will be 'looped' and something else.

```html
<h1>Hello world!</h1>
<loopthis>
	<p>Hello, I'm {name}. My email is {email} and  I live in {city} <nonus>(US)</nonus></p>
</loopthis>
<h2>Bla bla bla something</h2>
<loopthistoo>
	<p>The hex code of {color_name} is {hex_code}</p>
</loopthistoo>
<hidethis>HUEHUEHUEHUE</hidethis>
```

Now let's go. First off, let's select the first block called **loopthis**
```php
$layout -> select_block ("loopthis");
```

And append some content inside:
```php
$layout -> push_block (array
(
	"name" 		=> "Guilherme",
	"email" 	=> "guimadaleno@me.com",
	"city" 		=> "Belo Horizonte"
));
```
In this example, I'd like to remove a block **nonus**, that's inside **loopthis** block (yeah, block inside the block).
```php
$layout -> remove_from_block ("nonus");
```
Good. Let's add more.
```php
$layout -> push_block (array
(
	"name" 		=> "John Appleseed",
	"email" 	=> "john@appleseed.com",
	"city" 		=> "New York"
));
```

And once again. 
```php
$layout -> push_block (array
(
	"name" 		=> "Chuck Norris",
	"email" 	=> "chuck@internet.com",
	"city" 		=> "Nowhere"
));
```
Again, I'd like to remove the block **nonus**.
```php
$layout -> remove_from_block ("nonus");
```

Good. There's something inside my template that I want to hide in this example. So I'll use this:
```php
$layout -> remove_block ("hidethis");
```

And okay. Now let's work on another block called **loopthistoo**.
```php
$layout -> select_block ("loopthistoo");
```

Let's push some content inside it
```php
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
```

And I think we're fine. To finish, let's just do this:
```php
echo $layout -> finish_content ();
```

Good! One more thing. I'd like to work on another template file in the same PHP script. So, let's continue:
```php
$layout -> open ("demo-advanced-extra.tpl");
```

The file **demo-advanced-extra.tpl** has this:
```html
Current datetime: {datetime}
```

Let's replace some keys...
```php
$layout -> push_content (array
(
	"datetime" => date("Y-m-d H:i:s")
));
```
And again, print the final result.
```php
echo $layout -> finish_content ();
```

Here it is:
```html
<h1>Hello world!</h1>
<loopthis>
	<p>Hello, I'm Guilherme. My email is guimadaleno@me.com and I live in Belo Horizonte</p>
	<p>Hello, I'm John Appleseed. My email is john@applesee.com and I live in New York (US)</p>
	<p>Hello, I'm Chuck Norris. My email is chuck@internet.com and I live in Nowhere</p>
</loopthis>
<h2>Bla bla bla something</h2>
<loopthistoo>
	<p>The hex code of Red is #bf0000</p>
	<p>The hex code of Orange is #ffcc00</p>
</loopthistoo>
```
---

### Help?
Tweet me: [@guimadaleno](http://twitter.com/guimadaleno)

---

### License
GNU GPL

Peace out!
