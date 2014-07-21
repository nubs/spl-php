<?php
namespace Chadicus\Spl;

/**
 * Unit tests for the \Chadicus\Spl\KeyValuePair class.
 *
 * @coversDefaultClass \Chadicus\Spl\KeyValuePair
 */
final class KeyValuePairTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Verify basic behavior of KeyValuePair class.
     *
     * @test
     * @covers ::__construct
     * @covers ::getValue
     * @covers ::getKey
     *
     * @return void
     */
    public function basicUsage()
    {
        $key = new \StdClass();
        $value = new \Exception();
        $pair = new KeyValuePair($key, $value);
        $this->assertSame($key, $pair->getKey());
        $this->assertSame($value, $pair->getValue());
    }
}
