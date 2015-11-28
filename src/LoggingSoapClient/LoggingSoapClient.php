<?php

namespace Lc5\Toolbox\LoggingSoapClient;

use Psr\Log\LoggerInterface;

/**
 * Class LoggingSoapClient
 *
 * @author Łukasz Krzyszczak <lukasz.krzyszczak@gmail.com>
 */
class LoggingSoapClient
{

    /**
     * @var TraceableSoapClient
     */
    private $soapClient;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param TraceableSoapClient $soapClient
     * @param LoggerInterface $logger
     */
    public function __construct(TraceableSoapClient $soapClient, LoggerInterface $logger)
    {
        $this->soapClient = $soapClient;
        $this->logger     = $logger;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return string
     */
    public function __call($method, array $arguments)
    {
        $result = call_user_func_array([$this->soapClient, $method], $arguments);

        if (!method_exists($this->soapClient, $method) || $method === '__soapCall') {
            $this->logger->info($this->soapClient->__getLastRequest());
            $this->logger->info($this->soapClient->__getLastResponse());
        }

        return $result;
    }

    /**
     * @param string $request
     * @param string $location
     * @param string $action
     * @param int $version
     * @param int $oneWay
     * @return string
     */
    public function __doRequest($request, $location, $action, $version, $oneWay = 0)
    {
        $response = $this->soapClient->__doRequest($request, $location, $action, $version, $oneWay);

        $this->logger->info($request);
        $this->logger->info($response);

        return $response;
    }
}
