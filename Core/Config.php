<?php
/**
 * Created by PhpStorm.
 * User: MatiusDevelopment
 * Date: 10.11.2019
 * Time: 19:40
 */

namespace Core;


class Config
{
    private static $config;

    public static function get($option) {
        if(!self::$config){
            //wczytanie configu
            self::$config = [
                'debug' => false,
                'dbHost' => 's34.mydevil.net',
                'dbUser' => 'm1056_solveq',
                'dbPassword' => 'Solveq1',
                'dbSchema' => 'm1056_solveq1',
            ];
        }
        return self::$config[$option];
    }

}