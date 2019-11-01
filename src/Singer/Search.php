<?php
namespace Dtool\Singer;

use Dtool\Singer\Nineku\SinggerSearchNineku;

class Search
{
    /**
     * @param $site
     * @return SinggerSearchNineku
     * @throws \Exception
     */
    public static function getInstance($site) {
        switch ($site) {
            case "Nineku":
                $obj = new SinggerSearchNineku();
                break;
            default:
                throw new \Exception("未知网站类型");
        }

        return $obj;
    }
}