    <?php
    /*
     * Created by PhpStorm.
     * User: admin
     * Date: 13.09.14
     * Time: 19:03
     */
    /*
     * Code by Kudinov Ruslan
     * https://github.com/Zionter

    */
	$this->load->helper('url');
  
    class Customize
    {
    	// PATH
        private static $cssURL;
        private static $jsURL;
        private static $fontURL;
        private static $imgURL;
        
        // FILES
        private static $css = array(
            	'bootstrap' => 'bootstrap',
            	'bootflat' => 'site',
            	'custom' => 'custom'
    		 ); 
        private static $js = array(
        		'bootstrap' => 'bootstrap',
        		'jQuery' => 'jquery-2.1.1.min'
        	);
		private static $font = array(
				'flaticon' => 'flaticon'
			);
		
		// GET PATHS	
        public static function getCssPath()
        {
            return self::$cssURL;
        }

        public static function getJSPath()
        {
            return self::$jsURL;
        }

		public static function getFontPath() 
		{
			return self::$fontURL;
		}
		public static function getImgPath() 
		{
			return self::$imgURL;
		}
		
		// INIT 
        public static function init()
        {
            self::$cssURL = base_url() . 'assets/custom/css/';
            self::$jsURL =  base_url() . 'assets/custom/js/';
            self::$fontURL = base_url() .  'assets/custom/fonts/';
			self::$imgURL = base_url() . 'assets/custom/img/';
        }
        
        // OTUPUTS     
        public static function generateStyles() 
        {
        	foreach (self::$css as $key => $value)
        	{
        		print "<link type='text/css' rel='stylesheet'href='" . self::$cssURL . $value . ".css' />";
        	}
        }
        
        public static function generateJS() 
        {
        	foreach (self::$js as $key => $value)
        	{
        		print "<script type='text/javascript' src='" . self::$jsURL . $value . ".js' />";
        	}
        }
        
        public static function generateFonts() 
        {
        	foreach (self::$font as $key => $value)
        	{
        		print "<link type='text/css' rel='stylesheet'href='" . self::$fontURL . $value . ".css' />";
        	}
        }
        

    }
    
    Customize:: init();

    ?>