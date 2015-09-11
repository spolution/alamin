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
@import "default.php";


/*-------------------------------------------------/
 * @section		Base Style Extension
 */

ul.dropdown a,
ul.dropdown span {
 display: block;
 padding: 4px 6px;
}

ul.dropdown ul a,
ul.dropdown ul span {
 padding: 4px 0;
}


/*-------------------------------------------------/
 * @section		Base Style Override
 */

ul.dropdown li {
 padding: 0;
 border: none;
}


/*-------------------------------------------------/
 *	@section	Custom Styles
 */

ul.dropdown li a,
ul.dropdown *.dir {
 border-style: solid;
 border-width: 1px 1px 0;
 border-color: #fff;
}

ul.dropdown ul li a,
ul.dropdown ul *.dir {
 border: none;
}


ul.dropdown-vertical li a,
ul.dropdown-vertical *.dir {
 border-width: 1px 0 1px 1px;
}

ul.dropdown-vertical-rtl li a,
ul.dropdown-vertical-rtl *.dir {
 border-width: 1px 1px 1px 0;
}


/*-------------------------------------------------/
 * @section		Support Class `open` Usage
 * @source		js, artificial
 *
 */

ul.dropdown li.hover *.open {
 position: relative;
 z-index: 600;
 margin: -1px 0;
 padding-top: 5px;
 padding-bottom: 5px;
 border-color: #f0f0f0 #666 #666 #f0f0f0;
 background-color: #fff;
 background-image: url(<?=base_url;?>assets/img/nav-arrow-down-open.png);
 color: #0063dc;
 zoom: 1;
}

ul.dropdown-horizontal li.hover *.open,
ul.dropdown-upward li.hover *.open,
ul.dropdown-linear li.hover *.open {
 float: left;
 zoom: none;
}

ul.dropdown-vertical li.hover *.open {
 margin: 0 -1px;
 padding-top: 4px;
 padding-bottom: 4px;
 padding-left: 7px;
}

ul.dropdown-vertical-rtl li.hover *.open {
 padding-right: 7px;
}

ul.dropdown-vertical ul li.hover *.open {
 padding-right: 0;
 padding-left: 0;
}

ul.dropdown ul li.hover *.open {
 position: static;
 z-index: 0;
 float: none;
 margin: 0;
 padding-top: 4px;
 padding-bottom: 4px;
 border: none;
}

ul.dropdown ul li.hover *.open,
ul.dropdown-vertical li.hover *.open {
 background-image: url(<?=base_url;?>assets/img/nav-arrow-right-open.png);
}

ul.dropdown-vertical-rtl li.hover *.open,
ul.dropdown-vertical-rtl ul li.hover *.open {
 background-image: url(<?=base_url;?>assets/img/nav-arrow-left-open.png);
}

ul.dropdown-upward li.hover *.open {
 background-image: url(<?=base_url;?>assets/img/nav-arrow-up-open.png);
}

ul.dropdown-upward ul li.hover *.open {
 background-image: url(<?=base_url;?>assets/img/nav-arrow-right-open.png);
}

ul.dropdown a.dir:hover {
 background-image: url(<?=base_url;?>assets/img/nav-arrow-down-on.png) !important;
}

ul.dropdown-upward a.dir:hover {
 background-image: url(<?=base_url;?>assets/img/nav-arrow-up-on.png) !important;
}

ul.dropdown ul a.dir:hover,
ul.dropdown-vertical a.dir:hover {
 background-image: url(<?=base_url;?>assets/img/nav-arrow-right-on.png) !important;
}

ul.dropdown-vertical-rtl a.dir:hover,
ul.dropdown-vertical-rtl ul a.dir:hover {
 background-image: url(<?=base_url;?>assets/img/nav-arrow-left-on.png) !important;
}


	/* CSS2 clone */

	ul.dropdown li:hover > *.dir {
	 position: relative;
	 z-index: 600;
	 margin: -1px 0;
	 padding-top: 5px;
	 padding-bottom: 5px;
	 border-color: #f0f0f0 #666 #666 #f0f0f0;
	 background-color: #fff;
	 background-image: url(<?=base_url;?>assets/img/nav-arrow-down-open.png);
	 color: #0063dc;
	}

	ul.dropdown-horizontal li:hover > *.dir,
	ul.dropdown-upward li:hover > *.dir,
	ul.dropdown-linear li:hover > *.dir {
	 float: left;
	}

	ul.dropdown-vertical li:hover > *.dir {
	 margin: 0 -1px;
	 padding-top: 4px;
	 padding-bottom: 4px;
	 padding-left: 7px;
	 *position: static;
	}

	ul.dropdown-vertical-rtl li:hover > *.dir {
	 padding-right: 7px;
	}

	ul.dropdown-vertical ul li:hover > *.dir {
	 padding-right: 0;
	 padding-left: 0;
	}

	ul.dropdown ul li:hover > *.dir {
	 position: static;
	 z-index: 0;
	 float: none;
	 margin: 0;
	 padding-top: 4px;
	 padding-bottom: 4px;
	 border: none;
	}

	ul.dropdown ul li:hover > *.dir,
	ul.dropdown-vertical li:hover > *.dir {
	 background-image: url(<?=base_url;?>assets/img/nav-arrow-right-open.png);
	}

	ul.dropdown-vertical-rtl li:hover > *.dir,
	ul.dropdown-vertical-rtl ul li:hover > *.dir {
	 background-image: url(<?=base_url;?>assets/img/nav-arrow-left-open.png);
	}

	ul.dropdown-upward li:hover > *.dir {
	 background-image: url(<?=base_url;?>assets/img/nav-arrow-up-open.png);
	}

	ul.dropdown-upward ul li:hover > *.dir {
	 background-image: url(<?=base_url;?>assets/img/nav-arrow-right-open.png);
	}