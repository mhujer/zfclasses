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
 * 
 */
class Mhujer_View_Helper_FileSizeSimple
{
    /**
     * Size of one Kilobyte
     */
    const SIZE_KILOBYTES = 1024;
    
    /**
     * Size of one Megabyte
     */
    const SIZE_MEGABYTES = 1048576;
    
    /**
     * Size of one Gigabyte
     */
    const SIZE_GIGABYTES = 1073741824;
    
    /**
     * Size of one Terabyte
     */
    const SIZE_TERABYTES = 1099511627776;
    
    /**
     * Formats filesize with specified precision
     * 
     * @param integer $fileSize Filesize in bytes
     * @param integer $precision Precision
     */
    public function fileSize($fileSize, $precision = 3)
    {
        if ($fileSize >= self::SIZE_TERABYTES) {
            $newFilesize = $fileSize / self::SIZE_TERABYTES;
            $sizeName = 'TB';
        } else if ($fileSize >= self::SIZE_GIGABYTES) {
            $newFilesize = $fileSize / self::SIZE_GIGABYTES;
            $sizeName = 'GB';
        } else if ($fileSize >= self::SIZE_MEGABYTES) {
            $newFilesize = $fileSize / self::SIZE_MEGABYTES;
            $sizeName = 'MB';
        } else if ($fileSize >= self::SIZE_KILOBYTES) {
            $newFilesize = $fileSize / self::SIZE_KILOBYTES;
            $sizeName = 'KB';
        } else {
            $newFilesize = $fileSize;
            $sizeName = 'B';
        }
        
        $newFilesize = round($newFilesize, $precision);
        return $newFilesize . ' ' . $sizeName;
    }
    
   
}

