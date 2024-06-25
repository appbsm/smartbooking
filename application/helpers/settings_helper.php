<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	
	
	if (!function_exists('app_settings')) {

          function app_settings ($to_search) {
          	$CI =& get_instance();
          	$CI->load->model('m_settings');  	
          	$result = '';
          	$setting = $CI->m_settings->get_settings($to_search);
          	//echo $to_search;
          	foreach ($setting as $key => $val) {
          		//echo $val->name.'<br>';
          		if ($val->name == $to_search) {
          			$result = $val->value;
          			break;
          		}
          	}  
          	
			return $result;
          }
	}
	
	if (!function_exists('dateDiff')) {
		function dateDiff($date1, $date2) {
	        $d1 = strtotime($date1);
	        $d2 = strtotime($date2);
	    
	        $dif = $d2 - $d1;
	        $daydiff = $dif / (60 * 60 * 24);
	    
	        return $daydiff;
	    }
	}
	
	if (!function_exists('formatDate')) {
		function hourDiff($date1, $date2) {
			$d1 = strtotime($date1);
			$d2 = strtotime($date2);
		
			$dif = $d2 - $d1;
			$hourdiff = $dif / (60 * 60);
		
			return $hourdiff;
	 
		}
	}
	
	if (!function_exists('formatDate')) {
		function formatDate($date) {
	        if (strpos($date, '/') !== false) {
	            $date = convertDateDash($date);
	        }
	    
	        $d = explode('-', $date);
	        $months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
	        return $months[intval($d[1]) - 1] .' '. intval($d[2]) .', '. $d[0];
	    }
	}
	
	if (!function_exists('date_reformat')) {
		function date_reformat($date, $type) {
			$new_date = '';
			if ($type = 'day_to_year_dash') {
				$in_date = explode('-', $date);
				$new_date = $in_date[2].'-'.$in_date[1].'-'.$in_date[0];
			}
			return $new_date;
		}
	}
	
	/*
	if (!function_exists('_t')) {
		function _t($en_str, $th_str) {
			$CI =& get_instance();
			$lang = ($CI->session->userdata('site_lang') !== null) ? $CI->session->userdata('site_lang') : 'thai';
			return ($lang == 'thai') ? iconv('UTF-8', 'TIS-620', $th_str) : $en_str;
		}
	}
	*/
	
	if (!function_exists('getLang')) {
		function getLang() {
			$CI =& get_instance();
			$lang = ($CI->session->userdata('site_lang') !== null) ? $CI->session->userdata('site_lang') : 'thai';
			return $lang;
		}
	}
	
	if (!function_exists('_r')) {
		function _r($en = '', $th = '') {
			$lang = getLang();
			return $lang == 'thai' ? $th : $en;
		}
	}
	
	if (!function_exists('_t')) {
		function _t($en = '', $th = '') {
			$lang = getLang();
			return $lang == 'thai' ? iconv('UTF-8', 'TIS-620', $th) : $en;
		}
	}
	
	if (!function_exists('numberFormatArray')) {
	    function numberFormatArray($arr) {
	        $tmp = array();
	        foreach ($arr as $a) {
	            $tmp[] = number_format($a);
	        }
	        return $tmp;
	    }
	}
	