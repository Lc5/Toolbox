<?php

namespace Lc5\Toolbox\LoggingSoapClient;

/**
 * Class TraceableSoapClient
 *
 * @author Łukasz Krzyszczak <lukasz.krzyszczak@gmail.com>
 */
class TraceableSoapClient extends \SoapClient
{

    /**
     * @param string|null $wsdl
     * @param array|null $options
     */
    public function __construct($wsdl, array $options = null)
    {
        $options['trace'] = true;
        parent::__construct($wsdl, $options);
    }
}
