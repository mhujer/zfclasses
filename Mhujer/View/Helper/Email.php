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

/**
 * View Helper
 * 
 * @category   	Mhujer
 * @package 	Mhujer_View_Helper
 * @author 		Martin Hujer mhujer@gmail.com
 */

/**
 * Obfuscates an e-mail address
 *
 */
class Mhujer_View_Helper_Email
{
    /**
     * Obfuscates an e-mail address
     * 
     * @param string $address E-mail address to obfuscate
     * @param boolean $mailto Generate mailto link?
     * @return string
     */
    public function email($address, $mailto = false)
    {
        //thanks dgx for this tip
        $obfuscated = str_replace('@', '&#64;<!---->', $address);
        if (!$mailto) {
            return $obfuscated;
        } else {
            $mailtoAdress = str_replace('@', '&#64;', $address);
            $mailto = '<a href="mailto:' . $mailtoAdress . '">' . $obfuscated . '</a>';
            return $mailto;
        }
    }
}