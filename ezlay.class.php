<?php

class ezLay
{

	private $template;
	private $blocks;
	private $models;

	public function __construct ()
	{
		$this -> blocks = new stdClass();
		$this -> models = new stdClass();
	}

	/* Open template file (bool) */

	public function open ($file)
	{

		if (!is_file($file))
			$this -> fail ("File not found");

		if (isset($this -> template) and $this -> template and isset($this -> blocks) and count($this -> blocks))
			$this -> fail ("Cannot open file {$file}. Please finish content first.");

		$this -> template = file_get_contents($file);

		return true;

	}

	/* Get region content (string) */

	public function get_block_contents ($block)
	{

		if (!$this -> template)
			$this -> fail ("No template opened");

		preg_match("/<{$block}>((\s|.)*)<\/{$block}>/U", $this -> template, $output);

		if (isset($output[1]))
			return $output[1];

	}

	/* Select block region to be used by push_block (bool) */

	public function select_block ($block)
	{

		if (!$this -> template)
			$this -> fail ("No template opened");

		preg_match("/<{$block}>((\s|.)*)<\/{$block}>/U", $this -> template, $output);

		if (isset($output[1])):
			$this -> models -> $block = $output[1];
			return true;
		endif;

	}

	/* Inject content to block region (bool) */

	public function push_block ($block, $keys)
	{

		if (!$this -> template)
			$this -> fail ("No template opened");

		if (!$this -> blocks)
			$this -> fail ("Block not selected");

		if (isset($this -> models -> $block)):

			$keysReady = array();

			foreach ($keys as $key => $value)
				$keysReady["{{$key}}"] = $value;

			if (isset($this -> blocks -> $block))
				$this -> blocks -> $block .= str_replace(array_keys($keysReady), $keysReady, $this -> models -> $block);
			else
				$this -> blocks -> $block = str_replace(array_keys($keysReady), $keysReady, $this -> models -> $block);

			return true;

		endif;

	}

	/* Inject content to layout (bool) */

	public function push_content ($keys)
	{

		if (!$this -> template)
			$this -> fail ("No template opened");

		$keysReady = Array();

		foreach ($keys as $key => $value)
			$keysReady["{{$key}}"] = $value;

		$this -> template = str_replace(array_keys($keysReady), $keysReady, $this -> template);

		return true;

	}

	/* Finish operations (string) */

	public function finish_content ()
	{

		if (!$this -> template)
			$this -> fail ("No template opened");

		if (!$this -> blocks)
			$this -> fail ("Block not selected");

		foreach ($this -> blocks as $block => $contents):
			$this -> template = preg_replace("/<{$block}>((\s|.)*)<\/{$block}>/U", "<{$block}>" . $this -> models -> $block . "</{$block}><{$block}_model>" . $this -> models -> $block . "</{$block}_model>", $this -> template);
			$this -> template = preg_replace("/<{$block}_model>((\s|.)*)<\/{$block}_model>/U", $contents, $this -> template);
			$this -> remove_block ($block);
		endforeach;

		$template = $this -> template;

		unset($this -> template);

		return $template;

	}

	/* To remove block regions (bool) */

	public function remove_block ($block)
	{

		if (!$this -> template)
			$this -> fail ("No template opened");

		$this -> template = preg_replace("/<{$block}>((\s|.)*)<\/{$block}>/U", " ", $this -> template);

		return true;

	}

	/* Critical failures */

	private function fail ($message)
	{
		$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
		header("{$protocol} 503 Service Unavailable");
		die("ezLay error: {$message}");
	}

}