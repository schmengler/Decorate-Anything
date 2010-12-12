<?php
require 'decorateanything.lib.php';

class Text
{
	private $text = '';
	public function __construct($text)
	{
		$this->text = $text;
	}
	public function draw()
	{
		echo $this->text;
	}
	public function clear()
	{
		$this->text = '';
	}
	public function dump()
	{
		echo '<pre>';
		var_dump($this);
		echo '</pre>';
	}
}

class TextBoldDecorator extends AbstractDecorator
{
	const COMPONENT_CLASS = 'Text';
	public function draw()
	{
		echo '<b>';
		parent::draw();
		echo '</b>';
	}
}

class TextItalicDecorator extends AbstractDecorator
{
	const COMPONENT_CLASS = 'Text';
	public function draw()
	{
		echo '<i>';
		parent::draw();
		echo '</i>';
	}
}

// create decorated object:
$text = new TextItalicDecorator(new TextBoldDecorator(new Text('Hello World')));
// decorated method:
$text->draw();
// original methods:
$text->dump();
$text->clear();
$text->dump();

// information about decorated object:
echo '<strong>Decorated Object:</strong><br><pre>';
var_dump($text);
echo '</pre>';
?>