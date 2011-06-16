<?php
/**
 * Martin Hujer's Components
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to mhujer@gmail.com so I can send you a copy immediately.
 *
 * @category   	Mhujer
 * @package    	Mhujer_Tests
 * @author 		Martin Hujer mhujer@gmail.com
 */

/**
 * 
 * @category   	Mhujer
 * @package 	Mhujer_Tests
 * @author 		Martin Hujer mhujer@gmail.com
 */

set_include_path(get_include_path() . PATH_SEPARATOR . 'library');

require_once 'Mhujer/View/Helper/FileSizeSimple.php';
/**
 * Mhujer_View_Helper_FileSizeSimple test case.
 */
class Mhujer_View_Helper_FileSizeSimpleTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Mhujer_View_Helper_FileSizeSimple
     */
    private $_fs;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        parent::setUp();
        $this->_fs = new Mhujer_View_Helper_FileSizeSimple();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown ()
    {
        $this->_fs = null;
        parent::tearDown();
    }
    
        /**
     * Tests Mhujer_View_Helper_FileSize->fileSize()
     */
    public function testFileSize ()
    {
        $equals = array(
            "0 B" => 0,
            "1 B" => 1,
            "1 KB" => 1024,
        	"1 MB" => 1024*1024,
            "1 GB" => 1024*1024*1024,
            "1 TB" => 1024*1024*1024*1024,
            "1024 TB" => 1024*1024*1024*1024*1024
        );
        foreach ($equals as $result => $size) {
            $this->assertEquals($result, $this->_fs->fileSize($size));
        }
    }

    /**
     * Test filesize convert with specified precision
     */
    public function testFileSizePrecision()
    {
        $this->assertEquals("976.563 KB", $this->_fs->fileSize(1000000, 3));
        $this->assertEquals("976.5625 KB", $this->_fs->fileSize(1000000, 4));
        $this->assertEquals("976.5625 KB", $this->_fs->fileSize(1000000, 10));
    }
}

