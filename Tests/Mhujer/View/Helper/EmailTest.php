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

require_once 'Mhujer/View/Helper/Email.php';
/**
 * Mhujer_View_Helper_Email test case.
 */
class Mhujer_View_Helper_EmailTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Mhujer_View_Helper_Email
     */
    private $_fs;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        parent::setUp();
        $this->_fs = new Mhujer_View_Helper_Email();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown ()
    {
        $this->_fs = null;
        parent::tearDown();
    }

    public function testEmailAdress()
    {
        $data = array(
            'test@example.com' => 'test&#64;<!---->example.com',            	
        );
        foreach ($data as $input => $expected) {
            $this->assertEquals($expected, $this->_fs->email($input));
        }
    }

    public function testEmailAdressMailto()
    {
        $data = array(
            'test@example.com' => '<a href="mailto:test&#64;example.com">test&#64;<!---->example.com</a>',
        );
        foreach ($data as $input => $expected) {
            $this->assertEquals($expected, $this->_fs->email($input, true));
        }
    }
}