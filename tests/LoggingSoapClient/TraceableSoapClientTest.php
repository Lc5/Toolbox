<?php

namespace Lc5\Toolbox\LoggingSoapClient;

/**
 * Class TraceableSoapClientTest
 *
 * @author Łukasz Krzyszczak <lukasz.krzyszczak@gmail.com>
 */
class TraceableSoapClientTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $client     = new TraceableSoapClient(null, ['uri' => 'http://example.com', 'location' => 'http://example.com']);
        $properties = get_object_vars($client);

        $this->assertInstanceOf('Lc5\Toolbox\LoggingSoapClient\TraceableSoapClient', $client);
        $this->assertArrayHasKey('trace', $properties);
        $this->assertEquals(1, $properties['trace']);
    }
}
