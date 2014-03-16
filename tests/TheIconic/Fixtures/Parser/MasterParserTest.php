<?php

namespace TheIconic\Fixtures\Parser;

class MasterParserTest extends \PHPUnit_Framework_TestCase
{
    const MASTER_PARSER_FULLY_QUALIFIED_NAME = 'TheIconic\Fixtures\Parser\MasterParser';

    const PARSER_INTERFACE_FULLY_QUALIFIED_NAME = 'TheIconic\Fixtures\Parser\ParserInterface';

    const TESTS_FIXTURES_DIRECTORY = './tests/Support/TestsFixtures/';

    const CURRENT_NUMBER_OF_PARSERS = 1;

    /**
     * @var MasterParser
     */
    private $parserInstance;

    public function setUp()
    {
        $this->parserInstance = new MasterParser();
    }

    public function testGetAvailableParsers()
    {
        $availableParsers = $this->parserInstance->getAvailableParsers();

        $this->assertCount(1, $availableParsers);

        foreach ($availableParsers as $parser) {
            $this->assertInstanceOf(self::PARSER_INTERFACE_FULLY_QUALIFIED_NAME, $parser);
        }
    }

    /**
     * @expectedException \TheIconic\Fixtures\Exception\InvalidParserException
     */
    public function testFakeInvalidParserException()
    {
        $parserInstance = $this->getMockBuilder(self::MASTER_PARSER_FULLY_QUALIFIED_NAME)
                               ->setMethods(['getParserNames'])
                               ->disableOriginalConstructor()
                               ->getMock();

        $parserInstance->expects($this->any())
            ->method('getParserNames')
            ->will($this->returnValue(['FakeParser']));

        $parserInstance->getAvailableParsers();
    }

    /**
     * @expectedException \TheIconic\Fixtures\Exception\InvalidParserException
     */
    public function testRougueInvalidParserException()
    {
        $parserInstance = $this->getMockBuilder(self::MASTER_PARSER_FULLY_QUALIFIED_NAME)
            ->setMethods(['getParserInstance'])
            ->getMock();

        $parserInstance->expects($this->any())
            ->method('getParserInstance')
            ->will($this->returnValue(null));

        $parserInstance->getAvailableParsers();
    }

    public function testParse()
    {
        //print_r($this->parserInstance->parse('./tests/Support/TestsFixtures/country.yml'));
    }

    /**
     * @expectedException \TheIconic\Fixtures\Exception\ParserNotFoundException
     */
    public function testParserNotFoundException()
    {
        $this->parserInstance->parse(self::TESTS_FIXTURES_DIRECTORY . 'fake.txt');
    }
}