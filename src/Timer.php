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
    private $stopTime;

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
        $this->stopTime  = 0.0;
        $this->isStarted = false;
    }

    public function start()
    {
        if (!$this->isStarted) {
            $this->reset();
            $this->startTime = microtime(true);
            $this->isStarted = true;
        }
    }

    public function stop()
    {
        if ($this->isStarted) {
            $this->stopTime  = microtime(true);
            $this->isStarted = false;
        }
    }

    /**
     * @return float
     */
    public function getTime()
    {
        $stopTime = $this->isStarted ? microtime(true) : $this->stopTime;

        return $stopTime - $this->startTime;
    }
}
