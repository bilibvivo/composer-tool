<?php
namespace Dtool;

class Help
{
    public static function hello() {
        return "hello world!";
    }

    public static function echo2($msg) {
        return sprintf("[%s] %s" . PHP_EOL, date("Y-m-d H:i:s"), $msg);
    }

    public static function cut($start,$end,$file){
        $content = @explode($start,$file);
        $content = @explode($end,$content[1]);

        return  trim($content[0]);
    }
}