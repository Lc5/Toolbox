<?php

namespace Lc5\Toolbox\LoggingSoapClient;

/**
 * Class MessageXmlFormatterTest
 *
 * @author Łukasz Krzyszczak <lukasz.krzyszczak@gmail.com>
 */
class MessageXmlFormatterTest extends \PHPUnit_Framework_TestCase
{

    public function testFormat()
    {
        $xml = '<?xml version="1.0"?><catalog><book id="123"><author>Lukasz Krzyszczak</author><title>XML Formatting</title></book></catalog>';

        $formattedXml = <<<'XML'
<?xml version="1.0"?>
<catalog>
  <book id="123">
    <author>Lukasz Krzyszczak</author>
    <title>XML Formatting</title>
  </book>
</catalog>
XML;

        $formatter = new MessageXmlFormatter();
        $formattedRecord = $formatter->format(['message' => $xml, 'extra' => []]);

        $this->assertContains($formattedXml, $formattedRecord);
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testAllowLineBreakThrowsException()
    {
        $formatter = new MessageXmlFormatter();
        $formatter->allowInlineLineBreaks(true);
    }
}
