<?php

namespace Lc5\Toolbox;

/**
 * Class Timer
 *
 * @author Łukasz Krzyszczak <lukasz.krzyszczak@gmail.com>
 */
class Timer
{

    /**
     * @var float
     */
    private $startTime;

    /**
     * @var float
     */
    private $totalTime;

    /**
     * @var boolean
     */
    private $isStarted;

    public function __construct()
    {
        $this->reset();
    }

    public function reset()
    {
        $this->startTime = 0.0;
        $this->totalTime = 0.0;
        $this->isStarted = false;
    }

    public function start()
    {
        if ($this->isStarted) {
            throw new \LogicException('Timer already started!');
        }

        $this->startTime = microtime(true);
        $this->isStarted = true;
    }

    public function stop()
    {
        if (!$this->isStarted) {
            throw new \LogicException('Timer already stopped!');
        }

        $this->totalTime += microtime(true) - $this->startTime;
        $this->isStarted = false;
    }

    /**
     * @return float
     */
    public function getTime()
    {
        return $this->isStarted ? microtime(true) - $this->startTime : $this->totalTime;
    }
}
