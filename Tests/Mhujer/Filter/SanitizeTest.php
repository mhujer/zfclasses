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
 * @package    	Mhujer_View_Helper
 * @author 		Martin Hujer mhujer@gmail.com
 */

set_include_path(get_include_path() . PATH_SEPARATOR . 'library');

/**
 * @see Mhujer_Filter_Sanitize
 */
require_once 'Mhujer/Filter/Sanitize.php';
/**
 * @category   Mhujer
 * @package    Mhujer_Filter
 * @subpackage UnitTests
 * @author 	   Martin Hujer mhujer@gmail.com
 */
class Mhujer_Filter_SanitizeTest extends PHPUnit_Framework_TestCase
{

    /**
     * Mhujer_Filter_Sanitize object
     * 
     * @var Mhujer_Filter_Sanitize
     */
    protected $_f;

    protected function setUp ()
    {
        $this->_f = new Mhujer_Filter_Sanitize();
    }

    public function testConstructor ()
    {
        $this->_f = new Mhujer_Filter_Sanitize('_', '!');
        $this->assertEquals('test_word_test', $this->_f->filter('test!word!test'));
    }

    public function testConstructorArray ()
    {
        $this->_f = new Mhujer_Filter_Sanitize('_', array('!', ':'));
        $this->assertEquals('test_word_test', $this->_f->filter('test!word:test'));
    }

    public function testSetDelimiterReplacement ()
    {
        $this->_f->setDelimiterReplacement('_');
        $this->assertEquals('_', $this->_f->getDelimiterReplacement());
    }

    public function testAddWordDelimiter ()
    {
        $delimiters = $this->_f->getWordDelimiters();
        $delimiters[] = '=';
        $this->_f->addWordDelimiter('=');
        $this->assertEquals($delimiters, $this->_f->getWordDelimiters());
    }

    public function testAddWordDelimiterArray ()
    {
        $delimiters = $this->_f->getWordDelimiters();
        $delimiters[] = '=';
        $delimiters[] = '!';
        $this->_f->addWordDelimiter(array('=', '!'));
        $this->assertEquals($delimiters, $this->_f->getWordDelimiters());
    }

    public function testAddWordDelimiterAlreadyAddedException ()
    {
        try {
            $this->_f->addWordDelimiter('=');
            $this->_f->addWordDelimiter('=');
        } catch (Zend_Filter_Exception $e) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    public function testAddWordDelimiterEmptyException ()
    {
        try {
            $this->_f->addWordDelimiter('');
        } catch (Zend_Filter_Exception $e) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    public function testRemoveWordDelimiter ()
    {
        $this->_f->addWordDelimiter('=');
        $this->assertEquals('foo-url', $this->_f->filter("foo=url"));
        $this->_f->removeWordDelimiter('=');
        $this->assertNotEquals('foo-url', $this->_f->filter("foo=url"));
    }

    public function testRemoveWordDelimiterArray ()
    {
        $this->_f->addWordDelimiter('=');
        $this->_f->addWordDelimiter('!');
        $this->assertEquals('foo-bar-baz', $this->_f->filter('foo=bar!baz'));
        
        
        $this->_f->removeWordDelimiter(array('=', '!'));
        $this->assertEquals('foobarbaz', $this->_f->filter('foo=bar!baz'));
    }

    public function testRemoveWordDelimiterEmptyException ()
    {
        try {
            $this->_f->removeWordDelimiter('');
        } catch (Zend_Filter_Exception $e) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    public function testTrimSpaces ()
    {
        $this->assertEquals('foo-url', $this->_f->filter("\t\n  foo-url "));
    }

    public function testReplaceSpaces ()
    {
        $this->assertEquals('foo-url', $this->_f->filter('foo url'));
        $this->_f->setDelimiterReplacement('_');
        $this->assertEquals('foo_url', $this->_f->filter('foo url'));
    }

    public function testReplaceDoubleDelimiterWithSingleReplacement ()
    {
        $this->assertEquals('foo-url', $this->_f->filter('foo--url'));
        $this->_f->setDelimiterReplacement('_');
        $this->assertEquals('foo_url', $this->_f->filter('foo__url'));
    }

    public function testToLower ()
    {
        $this->assertEquals('escrzyaieuu', $this->_f->filter("ESCRZYAIEUU"));
    }

    public function testDotsReplacement ()
    {
        $this->assertEquals('foo-url', $this->_f->filter("foo.url"));
    }

    public function testSlashesReplacement ()
    {
        $this->assertEquals('foo-url', $this->_f->filter("foo/url"));
        $this->assertEquals('foo-url', $this->_f->filter("foo\url"));
    }

    public function testTrimStartAndEndSpaceReplacement ()
    {
        $this->assertEquals('foo-url', $this->_f->filter("--foo-url--"));
        $this->_f->setDelimiterReplacement('_');
        $this->assertEquals('foo_url', $this->_f->filter("__foo-url__"));
    }

    public function testTrimSpecialChars ()
    {
        $this->assertEquals('foo-url', $this->_f->filter("foo-url'?&@{}\\[]\""));
    }
    
    public function testNormalizeFilename ()
    {
        //TODO add tests like delimiter adding/removing
        $this->_f->addNotReplacedChars('.');
        $this->assertEquals('mozilla-firefox-1.0.0.12.exe', $this->_f->filter("MoZIlla FiREfOx 1.0.0.12.EXE"));
        
        $this->_f->removeNotReplacedChar('.');
        $this->assertEquals('mozilla-firefox-1-0-0-12-exe', $this->_f->filter("MoZIlla FiREfOx 1.0.0.12.EXE"));
    }
    
    
    /**
     * complete test
     */
    public function testConvertStringToUrl ()
    {
        $this->assertEquals('foo-url', $this->_f->filter("-- F*OÓ !-úřl'?&@{ }\\[]\""));
    }

    public function testConvertStringToUrl2 ()
    {
        $this->assertEquals('arvizturo-tuekoerfurogep', $this->_f->filter("Árvíztűrő tükörfúrógép"));
    }
}