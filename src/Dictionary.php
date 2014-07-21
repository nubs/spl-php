<?php
namespace Chadicus\Spl;

/**
 * Represents a collection of keys and values.
 */
class Dictionary implements \Iterator, Object
{
    /**
     * The collection elements.
     *
     * @var array
     */
    private $keyValuePairs = [];

    /**
     * The current position of the iterator.
     *
     * @var integer
     */
    private $position = 0;

    /**
     * Callback for type checking keys.
     *
     * @var callable
     */
    private $keyCheckCallback;

    /**
     * Callback for type checking values.
     *
     * @var callable
     */
    private $valueCheckCallback;

    /**
     * Create a new Dictionary.
     *
     * @param string $keyType   The type of which all keys should be.
     * @param string $valueType The type of which all values should be.
     */
    public function __construct($keyType, $valueType)
    {
        $this->keyCheckCallback = self::getCallback('key', $keyType);
        $this->valueCheckCallback = self::getCallback('value', $valueType);
    }

    /**
     * Add a new Key/Value pair.
     *
     * @param mixed $key   The key for the new KeyValuePair.
     * @param mixed $value The value for the new KeyValuePair.
     *
     * @return void
     */
    public function add($key, $value)
    {
        call_user_func_array($this->keyCheckCallback, [$key]);
        call_user_func_array($this->valueCheckCallback, [$value]);
        $this->keyValuePairs[] = new KeyValuePair($key, $value);
    }

    /**
     * Rewind the Iterator to the first element.
     *
     * @return void
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Return the current element.
     *
     * @return mixed
     */
    public function current()
    {
        return $this->keyValuePairs[$this->position]->getValue();
    }

    /**
     * Return the key of the current element.
     *
     * @return mixed.
     */
    public function key()
    {
        return $this->keyValuePairs[$this->position]->getKey();
    }

    /**
     * Move forward to next element.
     *
     * @return void
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Checks if current position is valid.
     *
     * @return boolean
     */
    public function valid()
    {
        return isset($this->keyValuePairs[$this->position]);
    }

    /**
     * Returns the callback for the key or value parameter.
     *
     * @param string $parameter The name of the parameter ('key'|'value').
     * @param string $type      The type of value that the parameter must be.
     *
     * @return callable
     *
     * @throws \InvalidArgumentException Throw if $type is not the name of an available class or php type.
     */
    private static function getCallback($parameter, $type)
    {
        if (class_exists($type)) {
            return function ($input) use ($parameter, $type) {
                if (!$input instanceof $type) {
                    throw new \InvalidArgumentException("\${$parameter} must be an instance of {$type}");
                }
            };
        }

        if (function_exists("is_{$type}")) {
            return function ($input) use ($parameter, $type) {
                if (!call_user_func_array("is_{$type}", [$input])) {
                    throw new \InvalidArgumentException("\${$parameter} must be of type {$type}");
                }
            };
        }

        throw new \InvalidArgumentException("\${$parameter}Type must be a class name or a php type");
    }
}
