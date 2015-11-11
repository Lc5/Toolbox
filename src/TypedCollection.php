<?php

namespace Lc5\Toolbox;

/**
 * Class TypedCollection
 *
 * @author Łukasz Krzyszczak <lukasz.krzyszczak@gmail.com>
 */
class TypedCollection extends \ArrayObject
{
    /**
     * @var string
     */
    private $type;

    /**
     * @param string $type
     * @param array|null $elements
     * @param int $flags
     * @param string $iteratorClass
     */
    public function __construct($type, array $elements = null, $flags = 0, $iteratorClass = 'ArrayIterator')
    {
        $this->type = $type;

        $elements = (array) $elements;

        foreach ($elements as $element) {
            $this->checkType($element);
        }

        parent::__construct($elements, $flags, $iteratorClass);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->checkType($value);

        parent::offsetSet($offset, $value);
    }

    /**
     * @param array $elements
     * @return array
     */
    public function exchangeArray($elements)
    {
        foreach ($elements as $element) {
            $this->checkType($element);
        }

        return parent::exchangeArray($elements);
    }

    /**
     * @param mixed $element
     */
    private function checkType($element)
    {
        if (gettype($element) !== $this->type && !$element instanceof $this->type) {
            throw new \UnexpectedValueException(
                'Invalid element type: ' . gettype($element) . '. Only ' . $this->type . ' is allowed.'
            );
        }
    }
}
