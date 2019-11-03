<?php
namespace Dtool\Singer;

use Dtool\BaseSearch;
use Dtool\Singer\Nineku\SingerSearchNineku;

class Search extends BaseSearch
{
    /**
     * @param $site
     * @return SingerSearchNineku
     * @throws \Exception
     */
    public static function getInstance($site) {
        switch ($site) {
            case "Nineku":
                $obj = new SingerSearchNineku();
                break;
            default:
                throw new \Exception("未知网站类型");
        }

        return $obj;
    }
}