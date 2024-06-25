<?php
class M_stringlib extends CI_Model {
 
    public function __construct(){
        parent::__construct();
	}
	
	public function useMD5($str1, $str2) {
		return hash("MD5", $str1 . $str2, FALSE);
	}
	
	public function uniqueNum10 () {
		$random = substr(number_format(time() * rand(),0,'',''),0,10);
		return $random;
	}
	
	public function uniqueNum6 () {
		$random = substr(number_format(time() * rand(),0,'',''),0,6);
		return $random;
	}
	
	public function uniqueAlphaNum6 () {
		$random = substr(md5(time() * rand()),0,6);
		return $random;
	}
	
	public function uniqueAlphaNum8 () {
		$random = substr(md5(time() * rand()),0,8);
		return $random;
	}
	
	public function uniqueAlphaNum10 () {
		$random = substr(md5(time() * rand()),0,10);
		return $random;
	}
	
	public function uniqueAlphaNum32 () {
		$random = substr(md5(time() * rand()),0,32);
		return $random;
	}

	public function isBlank ($str) {
		
	}
	
	public function isnot_sql_injection ($str) {
		$is_valid = true;
		
		if(preg_match('/SELECT/i',$str))
			$result = false;
		if(preg_match('/DELETE/i',$str))
			$result = false;
		if(preg_match('/UPDATE/i',$str))
			$result = false;
		if(preg_match('/INSERT/i',$str))
			$result = false;
		if(preg_match('/UNION/i',$str))
			$result = false;
		
		return $result;
	}
	
	
}
?>