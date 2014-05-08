<?php
namespace Nomnom;

class FilesizeTest extends \PHPUnit_Framework_TestCase
{
    public function test_from_converts_to_KiB()
    {
        $fixture = FIXTURES . DS . 'book.txt';
        $filesize = new Filesize($fixture);
        $size = $filesize->to('KiB');
        $this->assertEquals(360, floor($size));
    }

    /**
     * @expectedException \Nomnom\FileNotFoundException
     */
    public function test_constructor_throws_exception_if_file_doesnt_exist()
    {
        $filesize = new Filesize('nope.txt');
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Nomnom::from method not supported on files
     */
    public function test_from_throws_RuntimeException_when_called()
    {
        $filesize = new Filesize(FIXTURES . DS . 'book.txt');
        $filesize->from('KiB');
    }
}
