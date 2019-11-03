<?php
/**
 * Created by PhpStorm.
 * User: dume
 * Date: 19-11-2
 * Time: 下午2:24
 */

namespace Dtool\Gif;

use Dtool\Gif\Giphy\GifSearchGiphy;

class Search
{
    public static function getInstance($site, $proxy = '', $jar = '', $cookie = '') {
        switch ($site) {
            case "Giphy":
                $obj = new GifSearchGiphy($proxy, $jar, $cookie);
                break;
            default:
                throw new \Exception("未知网站类型");
        }

        return $obj;
    }
}