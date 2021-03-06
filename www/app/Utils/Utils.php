<?php
/**
 * Utilities function
 * @author velacorp
 * @version 0.1
 */
namespace App\Utils;

/**
 * Utilities class contains static helper function.
 * It is final class because does not need to extends it.
 */
final class Utils
{
    /**
     * get avatar from gravatar.com
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param boole $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source https://gravatar.com/site/implement/images/php/
     */
    public static function get_gravatar($email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array())
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val) {
                $url .= ' ' . $key . '="' . $val . '"';
            }

            $url .= ' />';
        }
        
        return $url;
    }

    public static function novalidate()
    {
        if (env('APP_ENV') == 'local' || env('APP_ENV') == 'testing') {
            echo 'novalidate';
        } else {
            return;
        }
    }

    public static function imageUrl($url)
    {
        if(strrpos($url, 'http://') !== false || strrpos($url, 'https://') !== false) {
            return $url;
        }

        return asset('storage/' . $url);
    }
}
