<?php

namespace Lc5\Toolbox\LoggingSoapClient;

/**
 * Class LoggingSoapClientTest
 *
 * @author Łukasz Krzyszczak <lukasz.krzyszczak@gmail.com>
 */
class LoggingSoapClientTest extends \PHPUnit_Framework_TestCase
{

    public function testCall()
    {
        $params     = ['param' => 'Example param'];
        $request    = 'Example request';
        $response   = 'Example response';

        $soapClient = $this->getSoapClientMock($request, $response);
        $logger     = $this->getMock('Psr\Log\LoggerInterface');

        $soapClient
            ->expects($this->once())
            ->method('__call')
            ->with('getData', [$params])
            ->will($this->returnValue($response));

        $loggingSoapClient = new LoggingSoapClient($soapClient, $logger);

        $this->assertMessagesAreLogged($logger, $request, $response);
        $this->assertSame($response, $loggingSoapClient->getData($params));
    }

    public function testSoapCall()
    {
        $params     = ['param' => 'Example param'];
        $request    = 'Example request';
        $response   = 'Example response';

        $soapClient = $this->getSoapClientMock($request, $response);
        $logger     = $this->getMock('Psr\Log\LoggerInterface');

        $soapClient
            ->expects($this->once())
            ->method('__soapCall')
            ->with('getData', [$params])
            ->will($this->returnValue($response));

        $loggingSoapClient = new LoggingSoapClient($soapClient, $logger);

        $this->assertMessagesAreLogged($logger, $request, $response);
        $this->assertSame($response, $loggingSoapClient->__soapCall('getData', [$params]));
    }

    public function testDoRequest()
    {
        $request    = 'Example request';
        $response   = 'Example response';
        $location   = 'http://www.example.com';
        $action     = 'Example action';
        $version    = SOAP_1_1;
        $oneWay     = 0;

        $soapClient = $this->getSoapClientMock($request, $response);
        $logger     = $this->getMock('Psr\Log\LoggerInterface');

        $soapClient
            ->expects($this->once())
            ->method('__doRequest')
            ->with($request, $location, $action, $version, $oneWay)
            ->will($this->returnValue($response));

        $loggingSoapClient = new LoggingSoapClient($soapClient, $logger);

        $this->assertMessagesAreLogged($logger, $request, $response);
        $this->assertSame($response, $loggingSoapClient->__doRequest($request, $location, $action, $version, $oneWay));
    }

    /**
     * @param string $request
     * @param string $response
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getSoapClientMock($request, $response)
    {
        $soapClient = $this->getMock('Lc5\Toolbox\LoggingSoapClient\TraceableSoapClient', [], [], '', false);

        $soapClient
            ->expects($this->any())
            ->method('__getLastRequest')
            ->will($this->returnValue($request));

        $soapClient
            ->expects($this->any())
            ->method('__getLastResponse')
            ->will($this->returnValue($response));

        return $soapClient;
    }

    /**
     * @param \PHPUnit_Framework_MockObject_MockObject $logger
     * @param string $request
     * @param string $response
     */
    private function assertMessagesAreLogged(\PHPUnit_Framework_MockObject_MockObject $logger, $request, $response)
    {
        $logger
            ->expects($this->at(0))
            ->method('info')
            ->with($request);

        $logger
            ->expects($this->at(1))
            ->method('info')
            ->with($response);
    }
}
