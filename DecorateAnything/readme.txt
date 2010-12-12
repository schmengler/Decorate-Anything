+-----------------------------------------------------------------------------+
|                             Decorate Anything                               |
+-----------------------------------------------------------------------------+

- Synopsis
- Requirements
- Files
- Usage

Synopsis
--------
This package is a simplified implementation of the Decorator Design Pattern.
Sub classes of the provided AbstractDecorator class may be used to decorate any
objects without the need for abstract components and abstract decorators for
each of them thanks to PHP's magic methods and loose typification.


Requirements
------------
The package requires PHP 5.2.6 or later.


Files
-----
decorateanything.lib.php - library loader, include this file to use the package
AbstractDecorator.php - the AbstractDecorator class
example.php - "Hello World" example to demonstrate simple usage
license.txt - BSD License
readme.txt - the file you are reading right now


Usage
-----

To create a decorator for a component, say ConcreteComponent, just extend the
AbstractDecorator like this:

	class ConcreteDecorator extends AbstractDecorator
	{
		const COMPONENT_CLASS = 'ConcreteComponent';
	}

To extend functionality of a component method in the decorator, use the parent
keyword like you would do in the original decorator pattern:

	public function foo()
	{
		parent::foo();
		some_special_functionality();
	}

Now you can decorate your component like this:

	$component = new ConcreteDecorator(new ConcreteComponent());

$component will have the same interface as ConcreteComponent, you also can
access the public properties of the decorated component.

	$component->foo();
	$component->bar(1,2); // assuming a method ConcreteComponent::bar($x,$y)
	var_dump($component->baz); // assuming a property ConcreteComponent::$baz
	var_dump(isset($component->baz));
	$component->baz = 1;
	unset($component->baz);

If you really have to name the common interface of decorator and compontent
explicitly do it this way:

	interface IConcreteComponent
	{
		public function foo();
		public function bar($x,$y);
	}
	class ConcreteComponent implements IConcreteComponent
	{
		public $baz = 'baz';
		public function foo()
		{
			// implementation
		}
		public function bar($x,$y)
		{
			// implementation
		}
	}
	class ConcreteDecorator extends AbstractDecorator implements IConcreteComponent
	{
		const COMPONENT_CLASS = 'ConcreteComponent';
		public function foo()
		{
			parent::foo();
			// additional implementation
		}
		public function bar($x,$y)
		{
			return parent::bar($x,$y);
		}
	}
