<?php

namespace Lc5\Toolbox\LoggingSoapClient;

use Monolog\Formatter\LineFormatter;

/**
 * Class MessageXmlFormatter
 *
 * @author Łukasz Krzyszczak <lukasz.krzyszczak@gmail.com>
 */
class MessageXmlFormatter extends LineFormatter
{

    /**
     * @var bool
     */
    protected $allowInlineLineBreaks = true;

    /**
     * @param string $format
     * @param string $dateFormat
     * @param bool $ignoreEmptyContextAndExtra
     */
    public function __construct($format = null, $dateFormat = null, $ignoreEmptyContextAndExtra = false)
    {
        parent::__construct($format, $dateFormat, true, $ignoreEmptyContextAndExtra);
    }

    /**
     * @param array $record
     * @return string
     */
    public function format(array $record)
    {
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->loadXML($record['message']);
        $dom->formatOutput = true;

        $record['message'] = PHP_EOL . $dom->saveXml();

        return parent::format($record);
    }

    /**
     * @param bool $allow
     */
    public function allowInlineLineBreaks($allow = true)
    {
        throw new \BadMethodCallException(__CLASS__ . ' allows line breaks by design.');
    }
}
