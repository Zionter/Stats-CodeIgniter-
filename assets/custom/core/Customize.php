<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 13.09.14
 * Time: 19:03
 */
/*
 * Code by Kudinov Ruslan
 * https://github.com/Zionter

*/

namespace assets\custom\core;


    class Customize
    {
        private static $cssURL;
        private static $jsURL;
        private static $css = array(
            'bootstrap' => 'bootstrap',
            'bootflat' => 'site',
            'custom' => 'custom'
        );
        private static $js = array(
            'bootstrap' => 'bootstrap'
        );

        private static $includeAll = true;

        public static function getCssPath()
        {
            return self::$cssURL;
        }

        public static function getJSPath()
        {
            return self::$jsURL;
        }


        public static function  construct()
        {
            self::$cssURL = base_url() . 'assets/custom/css/';
            self::$jsURL = base_url() . 'assets/custom/js/';
        }

    }

    Customize:: construct();



    ?>