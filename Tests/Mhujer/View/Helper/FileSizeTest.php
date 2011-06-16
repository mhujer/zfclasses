<?php
/**
 * @see PHPUnit_Framework_TestCase
 */
require_once 'PHPUnit/Framework/TestCase.php';

/**
 * @see Mhujer_View_Helper_FileSize
 */
set_include_path(get_include_path() . PATH_SEPARATOR . 'library');
require_once 'Mhujer/View/Helper/FileSize.php';

/**
 * @author  Martin Hujer mhujer@gmail.com
 */
class Mhujer_View_Helper_FileSizeTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Mhujer_View_Helper_FileSize
     */
    private $_fs;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        $this->_fs = new Mhujer_View_Helper_FileSize();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->_fs = null;
        Zend_Registry::set('Zend_Locale', null);
    }

    protected function _setDefaultLocale()
    {
        $locale = new Zend_Locale('en_US');

        require_once 'Zend/Registry.php';
        Zend_Registry::set('Zend_Locale', $locale);
    }

    /**
     * Tests Mhujer_View_Helper_FileSize->fileSize()
     */
    public function testFileSize ()
    {
        $this->_setDefaultLocale();

        $equals = array(
            "0 B"     => 0,
            "1 B"     => 1,
            "1 kB"    => 1024,
            "1 MB"    => 1024 * 1024,
            "1 GB"    => 1024 * 1024 * 1024,
            "1 TB"    => 1024 * 1024 * 1024 * 1024,
            "1,024 TB" => 1024 * 1024 * 1024 * 1024 * 1024,
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
        $this->_setDefaultLocale();

        $this->assertEquals("976.563 kB", $this->_fs->fileSize(1000000, 3));
        $this->assertEquals("976.5625 kB", $this->_fs->fileSize(1000000, 4));
        $this->assertEquals("1.1 MB", $this->_fs->fileSize('1153433.6', 1));
    }

    /**
     * Test defined export type
     */
    public function testDefinedType()
    {
        $this->_setDefaultLocale();
        $this->assertEquals('1,048,576 kB', $this->_fs->fileSize(1024 * 1024 * 1024, null, null, 'KILOBYTE'));
        $this->assertEquals('1,024 MB', $this->_fs->fileSize(1024 * 1024 * 1024, null, null, 'MEGABYTE'));
        $this->assertEquals('1 GB', $this->_fs->fileSize(1024 * 1024 * 1024, null, null, 'GIGABYTE'));

    }

	/**
     * Test defined export type
     */
    public function testNormSi()
    {
        $this->_setDefaultLocale();

        /** @see ZF-11488 */
        $this->assertEquals('1 B', $this->_fs->fileSize(1, 5, 'si')); //
        $this->assertEquals('1.00000 kB.', $this->_fs->fileSize(1000, 5, 'si'));
        $this->assertEquals('1.00000 MB.', $this->_fs->fileSize(1000 * 1000, 5, 'si'));
        $this->assertEquals('1.00000 GB.', $this->_fs->fileSize(1000 * 1000 * 1000, 5, 'si'));

    }

    /**
     * Test iec convert
     */
    public function testNormIec()
    {
        $this->_setDefaultLocale();

        $this->assertEquals('1 B', $this->_fs->fileSize(1, null, 'iec'));
        $this->assertEquals('1 KiB', $this->_fs->fileSize(1024, null, 'iec'));
        $this->assertEquals('1 MiB', $this->_fs->fileSize(1024 * 1024, null, 'iec'));
        $this->assertEquals('1 GiB', $this->_fs->fileSize(1024 * 1024 * 1024, null, 'iec'));
    }

    /**
     * Test localised input string
     */
    public function testLocalised()
    {
        $this->markTestSkipped('This feature will be added in next ZF release.');

        $locale = new Zend_Locale('cs_CZ');
        require_once 'Zend/Registry.php';
        Zend_Registry::set('Zend_Locale', $locale);

        $this->assertEquals('1,1 MB', $this->_fs->fileSize('1153433,6', 1));
    }

    /**
     * Test when no locale is set
     */
    public function testNoLocaleSet()
    {
        Zend_Registry::getInstance()->_unsetInstance();

        $this->assertEquals("976.563 kB", $this->_fs->fileSize(1000000, 3));
        $this->assertEquals("976.5625 kB", $this->_fs->fileSize(1000000, 4));
        $this->assertEquals("1.1 MB", $this->_fs->fileSize('1153433.6', 1));
        $this->assertEquals("1.1 MB", $this->_fs->fileSize('1153433,6', 1)); //Czech decimal separator
    }
}