<?php

namespace Lc5\Toolbox;

/**
 * Class TimerTest
 *
 * @author Łukasz Krzyszczak <lukasz.krzyszczak@gmail.com>
 */
class TimerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Timer
     */
    private $timer;

    protected function setUp()
    {
        parent::setUp();
        $this->timer = new Timer();
    }

    public function testGetTime()
    {
        $this->timer->start();
        $this->timer->stop();

        $this->assertSame(1.0, $this->timer->getTime());
    }

    public function testGetTimeNotStarted()
    {
        $this->assertSame(0.0, $this->timer->getTime());
    }

    public function testGetTimeNotStopped()
    {
        $this->timer->start();

        $this->assertSame(1.0, $this->timer->getTime());
        $this->assertSame(2.0, $this->timer->getTime());
        $this->assertSame(3.0, $this->timer->getTime());
    }

    public function testReset()
    {
        $this->timer->start();
        $this->timer->stop();
        $this->timer->reset();

        $this->assertEquals(0.0, $this->timer->getTime());
    }

    public function testGetTimeShowsCumulativeValues()
    {
        $this->timer->start();
        $this->timer->stop();
        $this->timer->start();
        $this->timer->stop();

        $this->assertSame(2.0, $this->timer->getTime());
    }

    /**
     * @expectedException \LogicException
     */
    public function testGetTimeStartedTwiceThrowsException()
    {
        $this->timer->start();
        $this->timer->start();
    }

    /**
     * @expectedException \LogicException
     */
    public function testGetTimeStoppedFirstThrowsException()
    {
        $this->timer->stop();
    }

    /**
     * @expectedException \LogicException
     */
    public function testGetTimeStoppedTwiceThrowsException()
    {
        $this->timer->start();
        $this->timer->stop();
        $this->timer->stop();
    }
}

/**
 * Mock internal PHP function
 *
 * @param bool|false $getAsFloat
 * @return float
 */
function microtime($getAsFloat = false)
{
    static $seconds = 0.0;

    return ++$seconds;
}