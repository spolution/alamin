<?php
    
	ob_start ("ob_gzhandler");
	header("Content-type: text/css; charset: UTF-8");
	header("Cache-Control: must-revalidate");
	$offset = 60 * 60 ;
	$ExpStr = "Expires: " .
	gmdate("D, d M Y H:i:s",
	time() + $offset) . " GMT";
	header($ExpStr);
	
	require_once("../../application/config/config.php");
	define("base_url", $config["base_url"]);

?>

@charset "UTF-8";

ul.dropdown {
 padding-bottom: 1px;
 background: url(<?=base_url;?>assets/img/pattern1.png) 0 100% repeat-x;
 font-weight:bold;
}

	ul.dropdown li {
	 padding: 4px 6px;
	 color: #1361aa;
	}

	ul.dropdown li.divider {
	 border-top: solid 1px #e5e5e5;
	}

	ul.dropdown li.hover,
	ul.dropdown li:hover {
	 color: #0063dc;
	}

	ul.dropdown a:link,
	ul.dropdown a:visited	{ color: #0063dc; text-decoration: none; }
	ul.dropdown a:hover		{ color: #0063dc; text-decoration: underline; }
	ul.dropdown a:active	{ color: #ff0084; }


	/* -- level mark -- */

	ul.dropdown ul {
	 width: 150px;
	 padding: 3px 6px;
	 border-style: solid;
	 border-width: 1px;
	 border-color: #f0f0f0 #666 #666 #f0f0f0;
	 background-color: #f0f0f0;
	 font-weight: normal;
	}

		ul.dropdown ul li span.dir:hover{
			background:#dedede;
		}



/*-------------------------------------------------/
 * @section		Support Class `dir`
 * @level sep	ul, .class
 */


ul.dropdown *.dir {
 padding-right: 25px;
 background-image: url(<?=base_url;?>assets/img/nav-arrow-down.png);
 background-position: 95% 50%;
 background-repeat: no-repeat;
}


/* -- Components override -- */

ul.dropdown-vertical ul {
 top: 0;
 left: 100%;
}

ul.dropdown-vertical-rtl ul {
 right: 100%;
}

ul.dropdown-horizontal,
ul.dropdown-linear,
ul.dropdown-upward {
 width: 100%;
}

ul.dropdown-horizontal ul *.dir {
 padding-right: 25px;
 background-image: url(<?=base_url;?>assets/img/nav-arrow-right.png);
 background-position: 100% 50%;
 background-repeat: no-repeat;
}

ul.dropdown-upward *.dir {
 background-image: url(<?=base_url;?>assets/img/nav-arrow-up.png);
}

ul.dropdown-vertical *.dir {
 background-image: url(<?=base_url;?>assets/img/nav-arrow-right.png);
 background-position: 180px 50%;
}

ul.dropdown-vertical ul *.dir,
ul.dropdown-upward ul *.dir {
 background-image: url(<?=base_url;?>assets/img/nav-arrow-right.png);
 background-position: 100% 50%;
}

ul.dropdown-vertical-rtl *.dir {
 padding-right: 6px;
 padding-left: 25px;
 background-image: url(<?=base_url;?>assets/img/nav-arrow-left.png);
 background-position: 5px 50%;
}

ul.dropdown-vertical-rtl ul *.dir {
 padding-right: 0;
 background-image: url(<?=base_url;?>assets/img/nav-arrow-left.png);
 background-position: 0 50%;
}