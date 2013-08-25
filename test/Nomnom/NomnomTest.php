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

    public function test_from_B_to_metric_sets_base_to_10()
    {
        $nomnom = new Nomnom(1000);
        $nomnom->from('B')->to('MB');
        $this->assertEquals(10, $nomnom->getBase());
    }

    /**
     * @expectedException \Nomnom\ConversionException
     * @expectedExceptionMessage Cannot convert between metric and binary formats
     */
    public function test_from_MiB_to_GB_throws_ConversionException()
    {
        $nomnom = new Nomnom(1024);
        $nomnom->from('MiB')->to('GB');
    }

    /**
     * @expectedException \Nomnom\ConversionException
     * @expectedExceptionMessage Cannot convert between metric and binary formats
     */
    public function test_from_GB_MiB_throws_ConversionException()
    {
        $nomnom = new Nomnom(1024);
        $nomnom->from('GB')->to('MiB');
    }

    public function test_from_bytes_toBest_converts_to_highest_whole_value()
    {
        $nomnom = new Nomnom(1509949);
        $megs = $nomnom->from('B')->toBest(2);
        $this->assertEquals(1.43, $megs);
    }

    public function test_Nomnomnom_bytes_to_MiB()
    {
        $mib = Nomnom::nom(1509949)->from(Nomnom::BYTES)->to(Nomnom::MiB, 1);
        $this->assertEquals(1.4, $mib);
    }

    public function test_Nomnomnom_bytes_to_MB()
    {
        $mb = Nomnom::nom(1440000)->from(Nomnom::BYTES)->to(Nomnom::MB, 2);
        $this->assertEquals(1.44, $mb);
    }

    public function test_Nomnomnom_MiB_to_GiB()
    {
        $gib = Nomnom::nom(4096)->from(Nomnom::MiB)->to(Nomnom::GiB);
        $this->assertEquals(4, $gib);
    }

    public function test_Nomnomnom_MiB_to_PiB()
    {
        $pib = Nomnom::nom(4096)->from(Nomnom::MiB)->to(Nomnom::PiB, 6);
        $this->assertEquals($pib, 0.000003);
    }

    public function test_Nomnomnom_MB_to_GB()
    {
        $gb = Nomnom::nom(10000)->from(Nomnom::MB)->to(Nomnom::GB);
        $this->assertEquals(10, $gb);
    }
}