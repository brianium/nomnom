<?php
namespace Nomnom;

class NomnomTest extends \PHPUnit_Framework_TestCase
{
    public function test_from_bytes_to_KiB_converts()
    {
        $nomnom = new Nomnom(1024);
        $kb = $nomnom->from('B')->to('KiB');
        $this->assertEquals(1, $kb);
    }

    public function test_from_bytes_to_MiB_converts()
    {
        $nomnom = new Nomnom(1024);
        $mb = $nomnom->from('B')->to('MiB');
        $this->assertEquals(0.0009765625, $mb);
    }

    public function test_from_MiB_to_B_converts()
    {
        $nomnom = new Nomnom(1);
        $bytes = $nomnom->from('MiB')->to('B');
        $this->assertEquals(1048576, $bytes);
    }

    public function test_from_bytes_to_MiB_with_precision_converts()
    {
        $nomnom = new Nomnom(1024);
        $mb = $nomnom->from('B')->to('MiB', 5);
        $this->assertEquals(0.00097, $mb);
    }

    public function test_from_MiB_to_GiB_converts()
    {
        $nomnom = new Nomnom(1);
        $gb = $nomnom->from('MiB')->to('GiB');
        $this->assertEquals(0.0009765625, $gb);
    }

    public function test_from_MiB_to_TiB_converts()
    {
        $nomnom = new Nomnom(1024);
        $tb = $nomnom->from('MiB')->to('TiB');
        $this->assertEquals(0.0009765625, $tb);
    }
}