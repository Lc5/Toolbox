<?php

namespace Lc5\Toolbox\LoggingSoapClient;

use Psr\Log\AbstractLogger;

/**
 * Class LoggingSoapClientIntegrationTest
 *
 * @author Łukasz Krzyszczak <lukasz.krzyszczak@gmail.com>
 */
class LoggingSoapClientIntegrationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var string
     */
    private $serviceUrl = 'http://www.webservicex.net/globalweather.asmx?WSDL';

    public function testCall()
    {
        $logger     = new Logger();
        $soapClient = new LoggingSoapClient(new TraceableSoapClient($this->serviceUrl), $logger);

        $soapClient->getWeather(['CityName' => 'Wroclaw', 'CountryName' => 'Poland']);

        $this->assertEquals([$soapClient->__getLastRequest(), $soapClient->__getLastResponse()], $logger->messages);
    }

    public function testSoapCall()
    {
        $logger     = new Logger();
        $soapClient = new LoggingSoapClient(new TraceableSoapClient($this->serviceUrl), $logger);

        $soapClient->__soapCall('getWeather', [['CityName' => 'Wroclaw', 'CountryName' => 'Poland']]);

        $this->assertEquals([$soapClient->__getLastRequest(), $soapClient->__getLastResponse()], $logger->messages);
    }

    public function testDoRequest()
    {
        $logger     = new Logger();
        $soapClient = new LoggingSoapClient(new TraceableSoapClient($this->serviceUrl), $logger);

        $request = <<<'TEXT'
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://www.webserviceX.NET">
    <SOAP-ENV:Body>
        <ns1:GetWeather>
            <ns1:CityName>Wroclaw</ns1:CityName>
            <ns1:CountryName>Poland</ns1:CountryName>
        </ns1:GetWeather>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
TEXT;

        $response = $soapClient->__doRequest($request, $this->serviceUrl, 'http://www.webserviceX.NET/GetWeather', SOAP_1_1);

        $this->assertEquals([$request, $response], $logger->messages);
    }
}

class Logger extends AbstractLogger
{
    
    /**
     * @var array
     */
    public $messages = [];

    /**
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = [])
    {
        $this->messages[] = $message;
    }
}