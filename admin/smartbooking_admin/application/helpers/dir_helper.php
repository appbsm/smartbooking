<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	
	
	if (!function_exists('share_folder_path')) {

          function share_folder_path () {
          	  return '/../share_folder/sms_booking/';
			  //return 'https://sharefolder.buildersmart.com/sms_booking/';
          }
	} 
	
	if (!function_exists('login_url')) {

          function login_url () {          	 
			  return site_url('login');
          }
	} 
	
	