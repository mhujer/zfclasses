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
 * @see Mhujer_Filter_Transliteration
 */
require_once 'Mhujer/Filter/Transliteration.php';
/**
 * @category   Mhujer
 * @package    Mhujer_Filter
 * @subpackage UnitTests
 * @author 	   Martin Hujer mhujer@gmail.com
 */
class Zend_Filter_TransliterationTest extends PHPUnit_Framework_TestCase
{

    /**
     * Zend_Filter_Transliteration object
     *
     * @var Zend_Filter_Transliteration
     */
    protected $_filter;

    /**
     * Creates a new Zend_Filter_Transliteration object for each test method
     *
     * @return void
     */
    public function setUp ()
    {
        $this->_filter = new Mhujer_Filter_Transliteration();
    }

    public function testTransCzech ()
    {
        $this->assertEquals("escrzyaieuu", $this->_filter->filter("ěščřžýáíéůú"));
    }
    
    public function testTransHacekCarka ()
    {
        $this->assertEquals("", $this->_filter->filter("ˇ´"));
    }

    public function testTransCzechSentence ()
    {
        //Czech sentence used for font-testing
        $czech = "Příliž žluťoučký kůň úpěl ďábelské ody!";
        $converted = "Priliz zlutoucky kun upel dabelske ody!";
        $this->assertEquals($converted, $this->_filter->filter($czech));

    }

    public function testTransGerman ()
    {
        $this->assertEquals('e-i-oe-ue', $this->_filter->filter("ë-ï-ö-ü"));
        $this->assertEquals('E-I-Oe-Ue', $this->_filter->filter("Ë-Ï-Ö-Ü"));
        $this->assertEquals('ss', $this->_filter->filter("ß"));
    }

    public function testTransFrench ()
    {
        $this->assertEquals('aeiou', $this->_filter->filter("âêîôû"));
        $this->assertEquals('AEIOU', $this->_filter->filter("ÂÊÎÔÛ"));
        $this->assertEquals('oe', $this->_filter->filter("œ"));
        $this->assertEquals('ae', $this->_filter->filter("æ"));
        $this->assertEquals('Y', $this->_filter->filter("Ÿ"));
        $this->assertEquals('Cc', $this->_filter->filter("Çç"));
    }

    public function testTransHungarian ()
    {
        $this->assertEquals('aeioouu', $this->_filter->filter("áéíóőúű"));
    }

    public function testTransRussian ()
    {
        $this->assertEquals('korzina', $this->_filter->filter("kорзина"));
        $this->assertEquals('studjenchjeskije rjukzaki', $this->_filter->filter("студенческие рюкзаки"));
    }

    public function testNotTranslitere ()
    {
        $this->assertEquals("'", $this->_filter->filter("'"));
        $this->assertEquals("\"", $this->_filter->filter("\""));
        $this->assertEquals("^", $this->_filter->filter("^"));
    }

    public function testTransPolish ()
    {
        $this->assertEquals('aoclesnzz', $this->_filter->filter('ąóćłęśńżź'));
        $this->assertEquals('aeoclnszzOCLSZZ', $this->_filter->filter('ąęóćłńśżźÓĆŁŚŻŹ'));
    }
     
    public function testTransPolishSentence ()
    {
        $polish = 'Pchnąć w tę łódź jeża lub ośm skrzyń fig.';
        $converted = 'Pchnac w te lodz jeza lub osm skrzyn fig.';
        $this->assertEquals($converted, $this->_filter->filter($polish));
    }

    public function testTransDanish ()
    {
        $this->assertEquals('ae oe aa Ae Oe Aa', $this->_filter->filter('æ ø å Æ Ø Å'));
    }
     
    public function testTransDanishSentence ()
    {
        $danish = 'På Falster, i nærheden af Nykøbing.';
        $converted = 'Paa Falster, i naerheden af Nykoebing.';
        $this->assertEquals($converted, $this->_filter->filter($danish));
    }
    
    public function testTransCroatian ()  
    {
        $this->assertEquals("cczsdCCZSD", $this->_filter->filter("čćžšđČĆŽŠĐ"));  
    }
    
    public function testTransSlovak ()  
    {  
        $this->assertEquals("aAaAcCdDeE", $this->_filter->filter("áÁäÄčČďĎéÉ"));
        $this->assertEquals("iIlLlLnNoOoO", $this->_filter->filter("íÍĺĹľĽňŇóÓôÔ"));
        $this->assertEquals("rRsStTuUYyzZ", $this->_filter->filter("ŕŔšŠťŤúÚÝýžŽ"));
    }
}
