<?php
namespace Chadicus\Spl;

/**
 * Unit tests for the \Chadicus\Spl\Dictionary class.
 *
 * @coversDefaultClass \Chadicus\Spl\Dictionary
 * @covers ::<private>
 */
final class DictionaryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Verify __construct() throws exception when key type is not a valid class or php type.
     *
     * @test
     * @covers ::__construct
     * @covers ::add
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $keyType must be a class name or a php type
     *
     * @return void
     */
    public function constructWithInvalidKeyType()
    {
        new Dictionary('invalid', '\StdClass');
    }

    /**
     * Verify add() throws exception when an invalid scalar key is given.
     *
     * @test
     * @covers ::__construct
     * @covers ::add
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $key must be of type int
     *
     * @return void
     */
    public function addWithInvalidScalarKey()
    {
        $dictionary = new Dictionary('int', '\StdClass');
        $dictionary->add('not an int', new \StdClass());
    }

    /**
     * Verify add() throws exception when an invalid object key is given.
     *
     * @test
     * @covers ::__construct
     * @covers ::add
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $key must be an instance of \DateTime
     *
     * @return void
     */
    public function addWithInvalidObjectKey()
    {
        $dictionary = new Dictionary('\DateTime', '\StdClass');
        $dictionary->add(new \StdClass(), new \StdClass());
    }

    /**
     * Verify add() throws exception when an invalid scalar value is given.
     *
     * @test
     * @covers ::__construct
     * @covers ::add
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $value must be of type double
     *
     * @return void
     */
    public function addWithInvalidScalarValue()
    {
        $dictionary = new Dictionary('\StdClass', 'double');
        $dictionary->add(new \StdClass(), 'not a double');
    }

    /**
     * Verify add() throws exception when an invalid object value is given.
     *
     * @test
     * @covers ::__construct
     * @covers ::add
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $value must be an instance of \StdClass
     *
     * @return void
     */
    public function addWithInvalidObjectValue()
    {
        $dictionary = new Dictionary('\DateTime', '\StdClass');
        $dictionary->add(new \DateTime(), new \DateTime());
    }

    /**
     * Verify basic iterator behavior of Dictionary.
     *
     * @test
     * @covers ::__construct
     * @covers ::add
     * @covers ::rewind
     * @covers ::valid
     * @covers ::key
     * @covers ::current
     * @covers ::next
     * @uses \Chadicus\Spl\KeyValuePair
     *
     * @return void
     */
    public function iterate()
    {
        $keys = [
            new \Exception('This is exception 0'),
            new \Exception('This is exception 1'),
            new \Exception('This is exception 2'),
        ];

        $values = [
            'Value 0',
            'Value 1',
            'Value 2',
        ];

        $dictionary = new Dictionary('\Exception', 'string');
        foreach ($keys as $i => $key) {
            $dictionary->add($key, $values[$i]);
        }

        $count = 0;
        foreach ($dictionary as $key => $value) {
            $this->assertSame($keys[$count], $key);
            $this->assertSame($values[$count], $value);
            ++$count;
        }
    }
}
