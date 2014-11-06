<?php
/**
 * Simplified implementation of the Decorator Design Pattern.
 * Sub classes of AbstractDecorator may be used to decorate any objects.
 * 
 * There is no need for abstract components and abstract decorators for each
 * of them thanks to PHP's magic methods and loose typification. Just extend
 * the AbstractDecorator and define the component class with the class constant
 * COMPONENT_CLASS
 * 
 * @package Decorate Anything
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/
 * @link http://en.wikipedia.org/wiki/Decorator_pattern
 * @version 2.0
 */

namespace SGH\DecorateAnything;

use \InvalidArgumentException;

/**
 * Abstract Decorator class
 * 
 * Usage:
 * <code>
 * class ConcreteComponent
 * {
 * 	public $baz = 'baz';
 * 	public function foo()
 * 	{
 * 		echo "ConcreteComponent::foo()\n";
 * 	}
 * 	public function bar($x,$y)
 * 	{
 * 		echo "ConcreteComponent::bar($x,$y)\n";
 * 	}
 * }
 * 
 * class ConcreteDecorator extends \SGH\DecorateAnything\Decorator
 * {
 * 	const COMPONENT_CLASS = 'ConcreteComponent';
 * 	public function foo()
 * 	{
 * 		parent::foo();
 * 		echo "ConcreteDecorator::foo()\n";
 * 	}
 * }
 * 
 * $c = new ConcreteDecorator(new ConcreteComponent());
 * $c->foo();
 * $c->bar(1,2);
 * echo $c->baz;
 * 
 * // Output:
 * // -------
 * // ConcreteComponent::foo()
 * // ConcreteDecorator::foo()
 * // ConcreteComponent::bar(1,2)
 * // baz
 * //
 * </code>
 * 
 * If you really have to name the common interface of decorator and compontent
 * explicitly do it this way:
 * <code>
 * interface IConcreteComponent
 * {
 * 	public function foo();
 * 	public function bar($x,$y);
 * }
 * class ConcreteComponent implements IConcreteComponent
 * {
 * 	public $baz = 'baz';
 * 	public function foo()
 * 	{
 * 		echo "ConcreteComponent::foo()\n";
 * 	}
 * 	public function bar($x,$y)
 * 	{
 * 		echo "ConcreteComponent::bar($x,$y)\n";
 * 	}
 * }
 * class ConcreteDecorator extends \SGH\DecorateAnything\Decorator implements IConcreteComponent
 * {
 * 	const COMPONENT_CLASS = 'ConcreteComponent';
 * 	public function foo()
 * 	{
 * 		parent::foo();
 * 		echo "ConcreteDecorator::foo()\n";
 * 	}
 * 	public function bar($x,$y)
 * 	{
 * 		return parent::bar($x,$y);
 * 	}
 * }
 * </code>
 * 
 * @package Decorate Anything
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; SGH informationstechnologie UG 2014
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/
 * @access public
 * @example example.php Concrete example
 */
abstract class Decorator
{
	/**
	 * @var object Object of type COMPONENT_CLASS or according decorator
	 * @access private
	 * @see \SGH\DecorateAnything\Decorator::COMPONENT_CLASS
	 */
	private $component;
	
	/**
	 * Component class, redefine in subclasses. If false, any object will be taken as component
	 */
	const COMPONENT_CLASS = false;
	
	/**
	 * Constructor
	 * 
	 * Creates a new decorator around a given component
	 * 
	 * Example:
	 * <code>
	 * 	class Component
	 * 	{
	 * 		...
	 * 	}
	 * 	class Decorator1 extends \SGH\DecorateAnything\Decorator
	 * 	{
	 * 		...
	 * 	}
	 * 	class Decorator2 extends \SGH\DecorateAnything\Decorator
	 * 	{
	 * 		...
	 * 	}
	 * 	$decoratedComponent = new Decorator1(new Decorator2(new Component()));
	 * </code>
	 * 
	 * @param object $component Object of type COMPONENT_CLASS or according decorator
	 * @see \SGH\DecorateAnything\Decorator::COMPONENT_CLASS
	 * @return void
	 */
	public function __construct($component)
	{
		$type = static::COMPONENT_CLASS;
		if ($type) {
			if ($component instanceof $type) {
				$this->component = $component;
				return;
			}
			if ($component instanceof self) {
				if ($type == static::COMPONENT_CLASS) {
					$this->component = $component;
					return;
				}
			}
		} else {
			// No component type defined, take any object:
			if (is_object($component)) {
				$this->component = $component;
				return;
			}
		}
		throw new InvalidArgumentException(sprintf(
			'Argument 1 passed to %s::%s must be an instance of %s or according decorator, %s given',
			__CLASS__, __FUNCTION__, $type, gettype($component)
		));
	}
	/**
	 * Magic method, grants access to the component's properties
	 * 
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name)
	{
		return $this->component->$name;
	}
	/**
	 * Magic method, grants access to the component's properties
	 * 
	 * @param string $name
	 * @param mixed $value
	 * @return void
	 */
	public function __set($name, $value)
	{
		$this->component->$name = $value;
	}
	/**
	 * Magic method, grants access to the component's properties
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function __isset($name)
	{
		return isset($this->component->$name);
	}
	/**
	 * Magic method, grants access to the component's properties
	 * 
	 * @param string $name
	 * @return void
	 */
	public function __unset($name)
	{
		unset($this->component->$name);
	}
	/**
	 * Magic method, simulates the component's interface
	 * 
	 * @param string $name
	 * @param array $arguments
	 * @return mixed
	 */
	public function __call($name, $arguments)
	{
		return call_user_func_array(array($this->component, $name), $arguments);
	}
}

?>