<?php
namespace Nomnom;

class ExponentResolverTest extends \PHPUnit_Framework_TestCase
{
    public function test_resolve_resolves_IEC_prefix_to_exponent()
    {
        $exp = ExponentResolver::resolve('GiB');
        $this->assertEquals(3, $exp);
    }

    public function test_resolve_with_B_returns_0()
    {
        $this->assertEquals(0, ExponentResolver::resolve('B'));
    }

    public function test_resolve_resolves_metric_prefix()
    {
        $this->assertEquals(8, ExponentResolver::resolve('YB'));
    }

    /**
     * @expectedException \Nomnom\PrefixNotFoundException
     * @expectedExceptionMessage Prefix "XiB" not found
     */
    public function test_unknown_binary_throws_exception()
    {
        ExponentResolver::resolve("XiB");
    }

    /**
     * @expectedException \Nomnom\PrefixNotFoundException
     * @expectedExceptionMessage Prefix "XB" not found
     */
    public function test_unknown_metric_throws_exception()
    {
        ExponentResolver::resolve("XB");
    }
}