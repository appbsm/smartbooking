<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facility   extends CI_Controller {

	//$first_load = true;
	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
		
	}
	
	public function index()
	{		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://10.100.100.30:8123/api/states');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiI3YWU0MzVkZjEyNWE0Y2FiYmEwMTdkZWM2YmY1N2IyMCIsImlhdCI6MTcwNTM3Mjg4NSwiZXhwIjoyMDIwNzMyODg1fQ.1aDL9Tfz_rZiJHxH1BN8zZTBmD99t3LyJkCoGOlpiG8'
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		//echo $result;
		//echo '<br>';

		$info = json_decode($result,true);
		//var_dump($info);

		//$entity_id = $info['entity_id'];
		//$state = $info['state'];
		//$last_changed = $info['last_changed'];
		//var_dump($info);
		$doors = array();
		$state_en = array('unavailable' => 'Offline', 'off' => 'Not Available', 'on' => 'Available');
		$state_th = array('unavailable' => 'ไม่พร้อมใช้งาน', 'off' => 'ไม่ว่าง', 'on' => 'ว่าง');
		foreach ($info as $i) {
			//print_r($i);
			
		    if (array_key_exists('device_class', $i['attributes']) && $i['attributes']['device_class'] == 'door') {
				//print_r($i['attributes']);
				
				foreach ($i['attributes'] as $attribute => $val) {
					if ($attribute == 'friendly_name') {
						$door = new stdClass();
						$door->door_name = $val;
						$door->entity_id = $i['entity_id'];
						$door->state = $state_en[$i['state']];
						$door->class_state = $i['state'];
						//print_r($door);
						//echo "<br><br>";
						//echo $val . ' ' .$i['state'];
						$doors[] = $door;
						
					}					
				}			
				//echo "<br><br>";
			}
			//echo "<br><br>";
		}
		//echo $info.'  '.$state.'  '.$last_changed;
		
		$data['doors'] = $this->aasort($doors, "door_name");
        //print_r($data['doors']);
        ;
		$this->load->view('v_header');
		$this->load->view('v_ha_doors', $data);
		$this->load->view('v_footer');
	}
	
	public function api()
	{
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, 'http://10.100.100.30:8123/api/states');
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	        'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiI3YWU0MzVkZjEyNWE0Y2FiYmEwMTdkZWM2YmY1N2IyMCIsImlhdCI6MTcwNTM3Mjg4NSwiZXhwIjoyMDIwNzMyODg1fQ.1aDL9Tfz_rZiJHxH1BN8zZTBmD99t3LyJkCoGOlpiG8'
	    ));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $result = curl_exec($ch);
	    curl_close($ch);
	    //echo $result;
	    //echo '<br>';
	    
	    $info = json_decode($result,true);
	    //var_dump($info);
	    
	    //$entity_id = $info['entity_id'];
	    //$state = $info['state'];
	    //$last_changed = $info['last_changed'];
	    //var_dump($info);
	    $doors = array();
	    $state_en = array('unavailable' => 'Offline', 'off' => 'Not Available', 'on' => 'Available');
	    $state_th = array('unavailable' => 'ไม่พร้อมใช้งาน', 'off' => 'ไม่ว่าง', 'on' => 'ว่าง');
	    foreach ($info as $i) {
	        //print_r($i);
	        
	        if (array_key_exists('device_class', $i['attributes']) && $i['attributes']['device_class'] == 'door') {
	            echo "ATTRIBUTES<br>";
	            print_r($i['attributes']);
	            
	            foreach ($i['attributes'] as $attribute => $val) {
	                echo $attribute ."=>".$val."<br>";
    	                if ($attribute == 'friendly_name') {
    	                    $door = new stdClass();
    	                    $door->door_name = $val;
    	                    $door->entity_id = $i['entity_id'];
    	                    $door->state = $state_en[$i['state']];
    	                    $door->class_state = $i['state'];
    	                    //print_r($door);
    	                    //echo "<br><br>";
    	                    //echo $val . ' ' .$i['state'];
    	                    $doors[] = $door;
    	                    
    	                }
	            }
	            echo "<br><br>";
	        }
	        //echo "<br><br>";
	    }
	    //echo $info.'  '.$state.'  '.$last_changed;
	    echo "<br><br>";
	    echo "DOORS";
	    //echo "<br><br>";
	    $data['doors'] = $this->aasort($doors, "door_name");
	    print_r($data['doors']);
	  
	}
	
	function aasort (&$array, $key) {
	    $sorter = array();
	    $ret = array();
	    reset($array);
	    foreach ($array as $ii => $va) {
	        $sorter[$ii] = $va->$key;
	    }
	    asort($sorter);
	    $ctr = 0;
	    foreach ($sorter as $ii => $va) {
	        $ret[$ctr++] = $array[$ii];
	    }
	    $array = $ret;
	    return $array;
	}
	
	
	
}
