<?php

/**
 * ezLay Template Handler
 * @author Guilherme Augusto Madaleno <guimadaleno@me.com>
 * @version 1.0
 */

class ezLay
{

	private $file;
	private $template;
	private $blocks;
	private $models;
	private $selected_block;
	private $current_block_key;

	public $tag_open = "<";
	public $tag_close = ">";

	public function __construct ()
	{
		$this -> blocks = new stdClass();
		$this -> models = new stdClass();
	}

	/**
	 * Open template file
	 * @param string $file 
	 * @return bool
	 */

	public function open ($file)
	{

		if (!is_file($file))
			trigger_error("File '{$file}' was not found", E_USER_ERROR);

		if (isset($this -> template) and $this -> template and isset($this -> blocks) and count($this -> blocks))
			trigger_error("Cannot open file '{$file}'. Please call finish_content() first.", E_USER_ERROR);

		$this -> file = $file;

		$this -> template = file_get_contents($file);

		return true;

	}

	/**
	 * Check if ezLay has been started
	 * @return string
	 */

	public function is_opened ()
	{
		if (isset($this -> file) and isset($this -> template))
			return true;
	}

	/**
	 * Get block content
	 * @param string $block
	 * @return string
	 */

	public function get_block_contents ($block)
	{

		if (!isset($this -> template))
			trigger_error("No template has been loaded on ezLay", E_USER_ERROR);

		preg_match("/{$this -> tag_open}{$block}{$this -> tag_close}((\s|.)*){$this -> tag_open}\/{$block}{$this -> tag_close}/U", $this -> template, $output);

		if (isset($output[1]))
			return $output[1];

	}

	/**
	 * Select block to be used by the ezLay
	 * @param string $block
	 * @return bool
	 */

	public function select_block ($block)
	{

		if (!isset($this -> template))
			trigger_error("No template has been loaded on ezLay", E_USER_ERROR);

		preg_match("/{$this -> tag_open}{$block}{$this -> tag_close}((\s|.)*){$this -> tag_open}\/{$block}{$this -> tag_close}/U", $this -> template, $output);

		if (isset($output[1])):

			$this -> selected_block = $block;

			$this -> blocks -> $block = Array();
			$this -> models -> $block = $output[1];

			return true;

		endif;

	}

	/**
	 * Inject content into block
	 * @param array $keys
	 * @param string $block
	 * @return bool
	 */

	public function push_block ($keys, $block = "")
	{

		if (!isset($this -> template))
			trigger_error("No template has been loaded on ezLay", E_USER_ERROR);

		if (!isset($this -> blocks))
			trigger_error("No block has been loaded on ezLay", E_USER_ERROR);

		if (!$block)
			$block = $this -> selected_block;

		if (isset($this -> models -> $block)):

			$keysReady = array();

			foreach ($keys as $key => $value)
				$keysReady["::$key::"] = $value;

			if (isset($this -> blocks -> $block))
				array_push($this -> blocks -> $block, str_replace(array_keys($keysReady), $keysReady, $this -> models -> $block));

			$this -> current_block_key = (isset($this -> blocks -> results) and count($this -> blocks -> results)) ? (count((array)$this -> blocks -> results) - 1) : 0;

			return true;

		endif;


	}

	/**
	 * Inject content into template file
	 * @param array $keys
	 * @return bool
	 */

	public function push_content ($keys)
	{

		if (!isset($this -> template))
			trigger_error("No template has been loaded on ezLay", E_USER_ERROR);

		$keysReady = Array();

		foreach ($keys as $key => $value)
			$keysReady["::{$key}::"] = $value;

		$this -> template = str_replace(array_keys($keysReady), $keysReady, $this -> template);

		return true;

	}

	/**
	 * Finish process and return the mounted template
	 * @return string
	 */

	public function finish_content ()
	{

		if (!isset($this -> template))
			trigger_error("No template has been loaded on ezLay", E_USER_ERROR);

		if (!isset($this -> blocks))
			trigger_error("No block has been loaded on ezLay", E_USER_ERROR);


		foreach ($this -> blocks as $block => $contents):

			$contents = array_reverse($contents);

			foreach ($contents as $content):

				$this -> template = preg_replace("/{$this -> tag_open}{$block}{$this -> tag_close}((\s|.)*){$this -> tag_open}\/{$block}{$this -> tag_close}/U", "{$this -> tag_open}{$block}{$this -> tag_close}" . $this -> models -> $block . "{$this -> tag_open}/{$block}{$this -> tag_close}{$this -> tag_open}{$block}_model{$this -> tag_close}" . $this -> models -> $block . "{$this -> tag_open}/{$block}_model{$this -> tag_close}", $this -> template);
				$this -> template = preg_replace("/{$this -> tag_open}{$block}_model{$this -> tag_close}((\s|.)*){$this -> tag_open}\/{$block}_model{$this -> tag_close}/U", $content, $this -> template);

			endforeach;

			$this -> remove_block ($block);

		endforeach;

		$template = $this -> template = preg_replace("/::(.*?)::/", "", $this -> template);

		unset($this -> template);

		$this -> blocks = new stdClass();
		$this -> models = new stdClass();

		return $template;

	}

	/**
	 * Set layout open and close tagd
	 * @param string $tag_open
	 * @param string $tag_close
	 */

	public function set_tags ($tag_open, $tag_close)
	{
		$this -> tag_open = $tag_open;
		$this -> tag_close = $tag_close;
	}

	/**
	 * Removes a block from another one
	 * @param string $blockToRemove
	 * @param string $blockSelected
	 * @return bool
	 */

	public function remove_from_block ($blockToRemove = "", $blockSelected = "")
	{

		if (!isset($this -> template))
			trigger_error("No template has been loaded on ezLay", E_USER_ERROR);

		if (empty($blockSelected))
			$blockSelected = $this -> selected_block;

		$this -> blocks -> {$blockSelected}{$this -> current_block_key} = preg_replace("/{$this -> tag_open}{$blockToRemove}{$this -> tag_close}((\s|.)*){$this -> tag_open}\/{$blockToRemove}{$this -> tag_close}/U", " ", $this -> blocks -> {$blockSelected}{$this -> current_block_key});

		return true;

	}

	/**
	 * Removes a block from template
	 * @param string $block
	 * @return bool
	 */

	public function remove_block ($block = "")
	{

		if (!isset($this -> template))
			trigger_error("No template has been loaded on ezLay", E_USER_ERROR);

		if (!$block)
			$block = $this -> selected_block;

		$this -> template = preg_replace("/{$this -> tag_open}{$block}{$this -> tag_close}((\s|.)*){$this -> tag_open}\/{$block}{$this -> tag_close}/U", " ", $this -> template);

		return true;

	}

}