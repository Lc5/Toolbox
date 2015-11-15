<?php

namespace Lc5\Toolbox\TypedCollection;

/**
 * Class TypedCollectionTest
 *
 * @author £ukasz Krzyszczak <lukasz.krzyszczak@gmail.com>
 */
class TypedCollectionTest extends \PHPUnit_Framework_TestCase
{

    public function testGetType()
    {
        $collection = new TypedCollection('type');

        $this->assertEquals('type', $collection->getType());
    }
}
