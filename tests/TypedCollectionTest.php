<?php

namespace Lc5\Toolbox;

/**
 * Class TypedCollectionTest
 *
 * @author �ukasz Krzyszczak <lukasz.krzyszczak@gmail.com>
 */
class TypedCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider validCollectionDataProvider
     * @param string $type
     * @param array $elements
     */
    public function testConstruct($type, $elements)
    {
        $collection = new TypedCollection($type, $elements);

        $this->assertSame($elements, (array) $collection);
    }

    /**
     * @dataProvider validDataProvider
     * @param string $type
     * @param array $element
     */
    public function testOffsetSet($type, $element)
    {
        $collection   = new TypedCollection($type);
        $collection[] = $element;

        $this->assertSame($element, reset($collection));
    }

    /**
     * @dataProvider validCollectionDataProvider
     * @param string $type
     * @param array $elements
     */
    public function testExchangeArray($type, $elements)
    {
        $collection = new TypedCollection($type);
        $collection->exchangeArray($elements);

        $this->assertSame($elements, (array) $collection);
    }

    /**
     * @dataProvider invalidCollectionDataProvider
     * @param string $type
     * @param array $elements
     * @expectedException \UnexpectedValueException
     */
    public function testConstructThrowsException($type, $elements)
    {
        new TypedCollection($type, $elements);
    }

    /**
     * @dataProvider invalidDataProvider
     * @param string $type
     * @param array $element
     * @expectedException \UnexpectedValueException
     */
    public function testOffsetSetThrowsException($type, $element)
    {
        $collection   = new TypedCollection($type);
        $collection[] = $element;
    }

    /**
     * @dataProvider invalidCollectionDataProvider
     * @param string $type
     * @param array $elements
     * @expectedException \UnexpectedValueException
     */
    public function testExchangeArrayThrowsException($type, $elements)
    {
        $collection = new TypedCollection($type);
        $collection->exchangeArray($elements);
    }

    /**
     * @return array
     */
    public function validCollectionDataProvider()
    {
        return [
            ['boolean',  [true, false]],
            ['integer',  [-1, 0, 1]],
            ['double',   [-1.11, 0.00, 1.11]],
            ['string',   ['first string', 'second string']],
            ['array',    [[], []]],
            ['object',   [new \stdClass(), new \stdClass()]],
            ['resource', [fopen('php://memory', 'r'), fopen('php://memory', 'r')]],
            ['NULL',     [null, null]],
            ['stdClass', [new \stdClass(), new \stdClass()]],
            ['Closure',  [function(){}, function(){}]]
        ];
    }

    /**
     * @return array
     */
    public function invalidCollectionDataProvider()
    {
        $allTypes = [true, 1, 1.11, 'string', [], new \stdClass(), fopen('php://memory', 'r'), null, function(){}];

        return [
            ['boolean',  $allTypes],
            ['integer',  $allTypes],
            ['double',   $allTypes],
            ['string',   $allTypes],
            ['array',    $allTypes],
            ['object',   $allTypes],
            ['resource', $allTypes],
            ['NULL',     $allTypes],
            ['stdClass', $allTypes],
            ['Closure',  $allTypes],
        ];
    }

    /**
     * @return array
     */
    public function validDataProvider()
    {
        return [
            ['boolean',  true],
            ['integer',  1],
            ['double',   1.11],
            ['string',   'string'],
            ['array',    []],
            ['object',   new \stdClass()],
            ['resource', fopen('php://memory', 'r+')],
            ['NULL',     null],
            ['stdClass', new \stdClass()],
            ['Closure',  function(){}]
        ];
    }

    /**
     * @return array
     */
    public function invalidDataProvider()
    {
        $allTypes = [
            'boolean'   => true,
            'integer'   => 1,
            'double'    => 1.11,
            'string'    => 'string',
            'array'     => [],
            'object'    => new \stdClass(),
            'resource'  => fopen('php://memory', 'r'),
            'NULL'      => null,
            'stdClass'  => new \stdClass(),
            'Closure'   => function(){}
        ];
        
        return [
            ['boolean', $allTypes['integer']],
            ['boolean', $allTypes['double']],
            ['boolean', $allTypes['string']],
            ['boolean', $allTypes['array']],
            ['boolean', $allTypes['object']],
            ['boolean', $allTypes['resource']],
            ['boolean', $allTypes['NULL']],
            ['boolean', $allTypes['stdClass']],
            ['boolean', $allTypes['Closure']],

            ['integer', $allTypes['boolean']],
            ['integer', $allTypes['double']],
            ['integer', $allTypes['string']],
            ['integer', $allTypes['array']],
            ['integer', $allTypes['object']],
            ['integer', $allTypes['resource']],
            ['integer', $allTypes['NULL']],
            ['integer', $allTypes['stdClass']],
            ['integer', $allTypes['Closure']],

            ['double', $allTypes['boolean']],
            ['double', $allTypes['integer']],
            ['double', $allTypes['string']],
            ['double', $allTypes['array']],
            ['double', $allTypes['object']],
            ['double', $allTypes['resource']],
            ['double', $allTypes['NULL']],
            ['double', $allTypes['stdClass']],
            ['double', $allTypes['Closure']],

            ['string', $allTypes['boolean']],
            ['string', $allTypes['integer']],
            ['string', $allTypes['double']],
            ['string', $allTypes['array']],
            ['string', $allTypes['object']],
            ['string', $allTypes['resource']],
            ['string', $allTypes['NULL']],
            ['string', $allTypes['stdClass']],
            ['string', $allTypes['Closure']],

            ['array', $allTypes['boolean']],
            ['array', $allTypes['integer']],
            ['array', $allTypes['double']],
            ['array', $allTypes['string']],
            ['array', $allTypes['object']],
            ['array', $allTypes['resource']],
            ['array', $allTypes['NULL']],
            ['array', $allTypes['stdClass']],
            ['array', $allTypes['Closure']],

            ['object', $allTypes['boolean']],
            ['object', $allTypes['integer']],
            ['object', $allTypes['double']],
            ['object', $allTypes['string']],
            ['object', $allTypes['array']],
            ['object', $allTypes['resource']],
            ['object', $allTypes['NULL']],

            ['resource', $allTypes['boolean']],
            ['resource', $allTypes['integer']],
            ['resource', $allTypes['double']],
            ['resource', $allTypes['string']],
            ['resource', $allTypes['array']],
            ['resource', $allTypes['object']],
            ['resource', $allTypes['NULL']],
            ['resource', $allTypes['stdClass']],
            ['resource', $allTypes['Closure']],

            ['NULL', $allTypes['boolean']],
            ['NULL', $allTypes['integer']],
            ['NULL', $allTypes['double']],
            ['NULL', $allTypes['string']],
            ['NULL', $allTypes['array']],
            ['NULL', $allTypes['object']],
            ['NULL', $allTypes['resource']],
            ['NULL', $allTypes['stdClass']],
            ['NULL', $allTypes['Closure']],

            ['stdClass', $allTypes['boolean']],
            ['stdClass', $allTypes['integer']],
            ['stdClass', $allTypes['double']],
            ['stdClass', $allTypes['string']],
            ['stdClass', $allTypes['array']],
            ['stdClass', $allTypes['resource']],
            ['stdClass', $allTypes['NULL']],
            ['stdClass', $allTypes['Closure']],

            ['Closure', $allTypes['boolean']],
            ['Closure', $allTypes['integer']],
            ['Closure', $allTypes['double']],
            ['Closure', $allTypes['string']],
            ['Closure', $allTypes['array']],
            ['Closure', $allTypes['object']],
            ['Closure', $allTypes['resource']],
            ['Closure', $allTypes['NULL']],
            ['Closure', $allTypes['stdClass']]
        ];
    }
}
