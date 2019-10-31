<?php
namespace Dtool;

class Help
{
    public static function hello() {
        return "hello world!";
    }

    public static function cut($start,$end,$file){
        $content = @explode($start,$file);
        $content = @explode($end,$content[1]);

        return  trim($content[0]);
    }
}