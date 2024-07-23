<?php
    function check_auth() {
        $CI =& get_instance();

        if ($CI->router->fetch_class() != 'user' && $CI->router->method != 'login') {
            $user_data = $CI->session->userdata('user_data');
            if (empty($user_data)) {
                header("Location: ". user_login_url());
                die();
            }

            if ($CI->router->fetch_class() != 'hr' && $CI->router->method != 'edit_user') {
                $userdata = $CI->session->userdata('user_data');
                if (empty($userdata['last_login'])) {
                    header('Location: '. edit_user_url($userdata['id_user']) .'?action=first_login');
                    die();
                }
            }
        }
    }

    function useMD5($str) {
        return hash("MD5", $str . strtolower($str), false);
    }

    function getLang() {
        $CI =& get_instance();
        $lang = $CI->session->userdata('lang');
        return $lang;
    }

    function _r($en = '', $th = '') {
        $lang = getLang();
        return $lang == 'TH' ? $th : $en;
    }

    function _t($en = '', $th = '') {
        $lang = getLang();
        return $lang == 'TH' ? iconv('UTF-8', 'TIS-620', $th) : $en;
    }

    function has_permission($name = '', $action = '') {
        if (empty($name) || empty($action)) {
            return false;
        }

        $CI =& get_instance();
        $userdata = $CI->session->userdata('user_data');
        if (empty($userdata['id_role'])) {
            return false;
        }
        $id_role = $userdata['id_role'];

        $CI->db->where('module_name', $name);
        $modules = $CI->db->get('module_mgt')->result_array();

        if (count($modules) == 0) {
            return false;
        } else {
            $module = $modules[0];
            $CI->db->where('id_module', $module['id_module']);
            $CI->db->where('id_role', $id_role);
            $role_modules = $CI->db->get('role_module')->result_array();

            if (count($role_modules) == 0) {
                return false;
            } else {
                $role_module = $role_modules[0];
                return empty($role_module['can_'. $action]) ? false : true;
            }
        }
    }

    function pr($arr, $repeat = false) {
        if (!$repeat) {
            header('Content-Type: text/html; charset=utf-8');
        }
        echo "<pre>". print_r($arr, true) ."</pre>";
    }

    function getImageUrl($url) {
       return 'https://sharefolder.buildersmart.com/sms_booking/'. $url;
       //return '/../share_folder/sms_booking/'. $url;
       
    }

    function _upload($folder = 'tmp', $data = '', $id = '') {
        if (empty($data)) {
            return '';
        }

        $parts = explode(";base64,", $data);
		//print_r($parts);
		if (count($parts) == 2) {
			$imagebase64 = base64_decode($parts[1]);
			$imageparts  = explode("image/", @$parts[0]);
            if (count($imageparts) < 2) {
                return '-';
            }

            $imagetype   = $imageparts[1];
            $allow_type = array('gif', 'jpg', 'png', 'jpeg', 'pdf');
            if (!in_array($imagetype, $allow_type)) {
                return '-';
            }

			$imagename   = (empty($id) ? '' : ($id .'_')) . uniqid() .'.'. $imagetype;

            $path        = "upload/". $folder ."/";
			$file        = server_path() . share_folder() . $path . $imagename;

            file_put_contents($file, $imagebase64);
            return $path . $imagename;
		} else {
            return str_replace(getImageUrl(''), '', $data);
        }
		//return str_replace(getImageUrl(''), '', $data);
    }

    function dateDiff($date1, $date2) {
        $d1 = strtotime($date1);
        $d2 = strtotime($date2);
    
        $dif = $d2 - $d1;
        $daydiff = $dif / (60 * 60 * 24);
    
        return $daydiff;
    }
    
    function hourDiff($date1, $date2) {
        $d1 = strtotime($date1);
        $d2 = strtotime($date2);
    
        $dif = $d2 - $d1;
        $hourdiff = $dif / (60 * 60);
    
        return $hourdiff;
 
    }

    function convertDateDash($date) {
        if (strpos($date, '/') !== false) {
            $d = explode('/', $date);
            return $d[2] .'-'. $d[1] .'-'. $d[0];
        } else {
            return $date;
        }
    }
	
	function convertToThaiDateSlash($date) {
        if (strpos($date, '-') !== false) {
            
            return date_format('d/m/Y');
			//return $d[2] .'/'. $d[1] .'/'. $d[0];
        } else {
            return $date;
        }
    }

    function convertDateSlash($date) {
        if (strpos($date, '-') !== false) {
            $d = explode('-', $date);
            return $d[2] .'/'. $d[1] .'/'. $d[0];
        } else {
            return $date;
        }
    }

    function formatDate($date) {
        if (strpos($date, '/') !== false) {
            $date = convertDateDash($date);
        }
    
        $d = explode('-', $date);
        $months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        return $months[intval($d[1]) - 1] .' '. intval($d[2]) .', '. $d[0];
    }

    function formatBaht($v = 0) {
        return number_format($v, 2);
    }

    function generateRandomString($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function array_col($arr, $key) {
        $tmp = array();
        foreach ($arr as $a) {
            $tmp[] = $a[$key];
        }
        return $tmp;
    }

    function numberFormatArray($arr) {
        $tmp = array();
        foreach ($arr as $a) {
            $tmp[] = number_format($a);
        }
        return $tmp;
    }

    function startWith($haystack, $needle) {
        if (empty($haystack) || empty($needle)) {
            return false;
        }

        $length = strlen($needle);
        return substr($haystack, 0, $length) === $needle;
    }

    function endWith($haystack, $needle) {
        if (empty($haystack) || empty($needle)) {
            return false;
        }

        $length = strlen($needle);
        return substr($haystack, -$length) === $needle;
    }
?>