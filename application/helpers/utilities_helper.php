<?php

	function assets_url($file = ''){
		return base_url('assets/' . $file);
	}
	function get_start_number($segment_numb){
		if (! $this->CI->uri->segment($segment_numb)) {
			$no = 1;
		}else{
			$no = $this->CI->uri->segment($segment_numb) + 1;
		}
		
		return $no;
	}
	function now($time = false){
		return date('Y-m-d' . ($time ? ' H:i:s' : ''));
	}