<?php $lang = $this->input->get('lang');?>


<main class="main-2">

  <section class="text-center container">
    <!-- SECTION FOR SEARCH -->
    <div class="container-fluid text-center bg-light">
		<div class="row" style="display: flex; flex-direction: row;">
				<div class="col-md-6" style="display: flex; flex-direction: row; padding: 10px;">
					<div class="group">
					    <label for="name">Check-in Date</label>
					    <input type='text' class=" datepicker" name="dateSelect" id="dateSelect" value=""/>
					</div>
					<div class="group">
					    <label for="name">Check-out Date</label>
					    <input type='text' class=" datepicker" name="dateSelect" id="dateSelect" value=""/>
					</div>
				</div>
				
				<div class="col-md-3" style="display: flex; flex-direction: row; justify-content: center; padding: 10px;">
					<div class="dropdown" >
						  <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    <span id="div_adult">2</span> Adults, <span id="div_children">0</span> Kids, <span id="div_room">1</span> Rooms
						  </button>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							    <div class="stepper">
							    <div style="display: flex; justify-content: center;">Adult</div>
							    <div style="display: flex; justify-content: center; background-color: white; ">							    
							    <button class="btn_stepper " id="decrement-adult" onClick="stepper(this);"> - </button>
							    <input class="input_number" type="number" min="0" max="100" step="1" value="2" id ="adult" readonly>
							    <button class="btn_stepper " id="increment-adult" onClick="stepper(this);"> + </button>
							    </div>

							    <div style="display: flex; justify-content: center;">Children</div>
							    <div style="display: flex; justify-content: center; background-color: ">							    
							    <button class="btn_stepper " id="decrement-children" onClick="stepper(this);"> - </button>
							    <input class="input_number" type="number" min="0" max="100" step="1" value="0" id ="children" readonly>
							    <button class="btn_stepper " id="increment-children" onClick="stepper(this);"> + </button>
							    </div>
							    
							    <div style="display: flex; justify-content: center;">Rooms</div>
							    <div style="display: flex; justify-content: center; background-color: white; box-shadow: 0 20px 30px rgba(0,0,0,0.1)">							    
							    <button class="btn_stepper " id="decrement-room" onClick="stepper(this);"> - </button>
							    <input class="input_number" type="number" min="0" max="100" step="1" value="1" id ="room" readonly>
							    <button class="btn_stepper " id="increment-room" onClick="stepper(this);"> + </button>
							    </div>
						    </div>
						  </div>
						</div>
				</div>
				
				<div class="col-md-3" style="display: flex; flex-direction: row; padding: 10px;">
					<button id="search" class="form-control">SEARCH</button>
				</div>

		</div>
	</div>
  </section>
  <div class="container-fluid" >
  	<div class="row"> 
    	<div class="col-md-6 top-left-grid" style="text-align: right;">
    	<img class="myImg imgThumbnail_bg img_border" data-id="1" src="<?php echo site_url().'images/Home/home_1.jpg'?>" style="max-width: 100%;">
    	</div>
    	
    	
    	<div class="col-md-6" style="padding-right: 30px;">
    		<div class="row">
    			<div class="col-md-6 top-right-grid">
    			<img class="myImg imgThumbnail_bg img_border" data-id="2" src="<?php echo site_url().'images/Home/home_2.jpg'?>" style="max-width: 100%;">
    			</div>
    			
    			<div class="col-md-6 top-right-grid">
    			<img class="myImg imgThumbnail_bg img_border" data-id="3" src="<?php echo site_url().'images/Home/home_3.jpg'?>" style="max-width: 100%;">
    			</div>
    			
    			<div class="col-md-6 top-right-grid">
    			<img class="myImg imgThumbnail_bg img_border" data-id="4" src="<?php echo site_url().'images/Home/home_4.jpg'?>" style="max-width: 100%;">
    			</div>
    			
    			<div class="col-md-6 top-right-grid">
    			<img class="myImg imgThumbnail_bg img_border" data-id="5" src="<?php echo site_url().'images/Home/home_5.jpg'?>" style="max-width: 100%;">
    			</div>
    			
    			
    		</div>
    		
    		<!-- 
    		<div class="row" > 
    			
    			<div class="col-md-6">
    			<img src="<?php echo site_url().'/images/Type_C/Type_C_1.jpg'?>" style="max-width: 100%;">
    			</div>
    			<div class="col-md-6">
    			<img src="<?php echo site_url().'/images/Type_C/Type_C_2.jpg'?>" style="max-width: 100%;">
    			</div>
    			
    			<div class="col-md-6">
    			<img class="myImg imgThumbnail_bg" data-id="4" src="<?php echo site_url().'/images/Type_C/Type_C_3.jpg'?>" style="max-width: 100%;">
    			</div>
    			<div class="col-md-6">
    			<img class="myImg imgThumbnail_bg" data-id="5" src="<?php echo site_url().'/images/Type_C/Type_C_4.jpg'?>" style="max-width: 100%;">
    			</div>
    		</div> -->
    	</div>
    </div>


	<div><hr></div>

	<!-- Room Types -->
	<div class="container-fluid text-center">
		<div class="row" >
			<div class="col-md-12" style="margin-top:10px;">
				<span class="roomtypes"><?php echo $lang == 'en' ? 'Room Types' : 'รูปแบบห้องพัก'; ?></span>
			</div>
			
			
			<div class="col-md-6" style="padding:2px 17px 2px 17px;">
				<div class="row room_type">
					<div class="col-md-12">
						<div class="room-type-name">SMS1 - Standard Room</div>
					</div>
					<div class="col-md-7">
						<div class="row">
							<div class="col-md-12 imgThumbnail_sm" ><img class="room_img myImgA" data-id="1" src="<?php echo site_url().'images/Type_A/Type_A_1.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm" ><img class="room_img myImgA" data-id="2" src="<?php echo site_url().'images/Type_A/Type_A_2.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm"><img class="room_img myImgA" data-id="3" src="<?php echo site_url().'images/Type_A/Type_A_3.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm"><img class="room_img myImgA" data-id="4" src="<?php echo site_url().'images/Type_A/Type_A_4.jpg'?>" style="max-width: 100%;"></div>
						</div>
					</div>
					<div class="col-md-5">
						<div class="price" style="margin-bottom:15px; margin-top:5px; margin-left:-15px;"><b><?php echo $lang == 'en' ? '2,500/Night' : 'ราคา 2,500/คืน'; ?></b></div>
						
						<div class="container text-left">
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/house.svg" height="20"></object></span> 
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? 'Area 18 Sq.m' : 'ขนาดพื้นที่ห้อง: 18 ตรม.'; ?></span>
						</div>
						</div>

						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container" >
							<span class="icon-content" style="margin-left:1px; margin-top:-3px;"><img class="icon" src="<?php echo site_url();?>images/icons/icons8-bedroom-50.png" height="18"></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? '1 Queen-bed' : 'เตียงนอน: 1 Queen-bed'; ?></span>
						</div>
						</div>
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container" >
							<span class="icon-content" style="margin-left:1px;"><object data="<?php echo site_url();?>images/icons/person-fill.svg" height="18"></object></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? '2 Adults' : 'จำนวนผู้เข้าพัก: 2' ;?></span>
						</div>		
						</div>
						
						<div class="row" >
						<div class="col-md-2 col-sm-2 icon_container">
							<object data="<?php echo site_url();?>images/icons/tv.svg" height="20"> </object>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content">TV (Internet)</span>
						</div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/snow.svg" height="20"> </object></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? 'Air Conditioning' : 'เครื่องปรับอากาศ'; ?></span>
						</div>
						</div>
						
						<div class="row" >
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/wifi.svg" height="20"> </object></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content">Free WIFI</span>
						</div>						
						</div>
						
						
						</div>
					</div>
					
					
				</div>
			</div>
			<div class="col-md-6" style="padding:2px 17px 2px 17px;">
				<div class="row room_type">
					<div class="col-md-12">
						<div class="room-type-name">SMS2 - Superior Room</div>
					</div>
					<div class="col-md-7">
						<div class="row">
							<div class="col-md-12 imgThumbnail_sm" ><img class="room_img myImgB" data-id="1" src="<?php echo site_url().'images/Type_B/Type_B_1.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm" ><img class="room_img myImgB" data-id="2" src="<?php echo site_url().'images/Type_B/Type_B_2.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm"><img class="room_img myImgB" data-id="3" src="<?php echo site_url().'images/Type_B/Type_B_3.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm"><img class="room_img myImgB" data-id="4" src="<?php echo site_url().'images/Type_B/Type_B_4.jpg'?>" style="max-width: 100%;"></div>
						</div>
					</div>
					<div class="col-md-5">
						<div class="price" style="margin-bottom:15px; margin-top:5px; margin-left:-15px;"><b><?php echo $lang == 'en' ? '3,000/Night' : 'ราคา 3,000/คืน'; ?></b></div>
						<div class="container text-left">
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/house.svg" height="20"></object></span> 
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? 'Area 18 Sq.m' : 'ขนาดพื้นที่ห้อง: 18 ตรม.'; ?></span>
						</div>
						</div>

						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content" style="margin-left:1px; margin-top:-3px;"><img class="icon" src="<?php echo site_url();?>images/icons/icons8-bedroom-50.png" width="18"></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? '1 Queen-bed' : 'เตียงนอน: 1 Queen-bed'; ?></span>
						</div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content" style="margin-left:1px;"><object data="<?php echo site_url();?>images/icons/person-fill.svg" height="18"> </object></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? '2 Adults' : 'จำนวนผู้เข้าพัก: 2'; ?></span>
						</div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/tv.svg" height="20"> </object></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content">TV (Internet)</span>
						</div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/snow.svg" height="20"> </object></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? 'Air Conditioning' : 'เครื่องปรับอากาศ'; ?></span>
						</div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/wifi.svg" height="20"> </object></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content">Free WIFI</span>
						</div>						
						</div>												
						
						</div>
					</div>
					
					
				</div>
			</div>
			<div class="col-md-6" style="padding:2px 17px 2px 17px;">
				<div class="row room_type">
					<div class="col-md-12">
						<div class="room-type-name">SMS3 - Junior Suite</div>
					</div>
					<div class="col-md-7">
						<div class="row">
							<div class="col-md-12 imgThumbnail_sm" ><img class="room_img myImgC" data-id="1" src="<?php echo site_url().'images/Type_C/Type_C_1.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm" ><img class="room_img myImgC" data-id="2" src="<?php echo site_url().'images/Type_C/Type_C_2.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm"><img class="room_img myImgC" data-id="3" src="<?php echo site_url().'images/Type_C/Type_C_3.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm"><img class="room_img myImgC" data-id="4" src="<?php echo site_url().'images/Type_C/Type_C_4.jpg'?>" style="max-width: 100%;"></div>
						</div>
					</div>
					<div class="col-md-5">
						<div class="price" style="margin-bottom:15px; margin-top:5px; margin-left:-15px;"><b><?php echo $lang == 'en' ? '4,000/Night' : 'ราคา 4,000/คืน'; ?></b></div>
						<div class="container text-left">
						
						<div class="row" style="margin-top:5px;">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/house.svg" height="20"></object></span> 
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? 'Area 36 Sq.m' : 'ขนาดพื้นที่ห้อง: 36 ตรม.'; ?></span>
						</div>
						</div>

						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content" style="margin-left:1px; margin-top:-3px;"><img class="icon" src="<?php echo site_url();?>images/icons/icons8-bedroom-50.png" height="18"></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? '1 Bedroom/1 Queen-bed' : 'เตียงนอน: 1 Queen-bed'; ?></span>
						</div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content" style="margin-left:1px;"><object data="<?php echo site_url();?>images/icons/person-fill.svg" height="18"> </object></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? '2 Adults' : 'จำนวนผู้เข้าพัก: 2'; ?></span>
						</div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/tv.svg" height="20"> </object></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content">TV (Internet)</span>
						</div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/snow.svg" height="20"> </object></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? 'Air Conditioning' : 'เครื่องปรับอากาศ'; ?></span>
						</div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/wifi.svg" height="20"> </object></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content">Free WIFI</span>
						</div>						
						</div>

						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content" style="font-size:16px; margin-top:-2px;">
								<object data="<?php echo site_url();?>images/icons/sofa.png" height="14"></object>
							</span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? '1 Extra bed (800/each)' : '1 เตียงเสริม (800/เตียง)'; ?></span>
						</div>						
						</div>
												
						</div>
					</div>
					
					
				</div>
			</div>
			<div class="col-md-6" style="padding:2px 17px 2px 17px;">
				<div class="row room_type">
					<div class="col-md-12">
						<div class="room-type-name">SMS4 - Family Junior Suite</div>
					</div>
					<div class="col-md-7">
						<div class="row">
							<div class="col-md-12 imgThumbnail_sm" ><img class="room_img myImgD" data-id="1" src="<?php echo site_url().'/images/Type_E/Type_E_1.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm" ><img class="room_img myImgD" data-id="2" src="<?php echo site_url().'/images/Type_E/Type_E_2.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm"><img class="room_img myImgD" data-id="3" src="<?php echo site_url().'/images/Type_E/Type_E_3.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm"><img class="room_img myImgD" data-id="4" src="<?php echo site_url().'/images/Type_E/Type_E_4.jpg'?>" style="max-width: 100%;"></div>
						</div>
					</div>
					<div class="col-md-5">
						<div class="price" style="margin-bottom:15px; margin-top:5px; margin-left:-15px;"><b><?php echo $lang == 'en' ? '7,500/Night' : 'ราคา 7,500/คืน'; ?></b></div>
						<div class="container text-left">
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/house.svg" height="20"></object></span> 
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? 'Area 72 Sq.m' : 'ขนาดพื้นที่ห้อง: 72 ตรม.'; ?></span>
						</div>
						</div>

						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content" style="margin-left:1px; margin-top:-3px;"><img class="icon" src="<?php echo site_url();?>images/icons/icons8-bedroom-50.png" height="18"></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? '3 Bedrooms/1 Queen-bed' : 'เตียงนอน:  3 ห้องนอน/Queen-bed'; ?></span>
						</div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content" style="margin-left:1px;"><object data="<?php echo site_url();?>images/icons/person-fill.svg" height="18"> </object></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? '6 Adults' : 'จำนวนผู้เข้าพัก: 6'; ?></span>
						</div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/tv.svg" height="20"> </object></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content">TV (Internet)</span>
						</div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<object data="<?php echo site_url();?>images/icons/snow.svg" width="20" height="20"> </object>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? 'Air Conditioning' : 'เครื่องปรับอากาศ'; ?></span>
						</div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/wifi.svg" height="20"> </object></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content">Free WIFI</span>
						</div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content" style="font-size:16px; margin-top:-2px;">
								<object data="<?php echo site_url();?>images/icons/sofa.png" height="14"></object>
							</span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? '2 Extra beds (800/each)' : '2 เตียงเสริม (800/เตียง)'; ?></span>
						</div>						
						</div>
						
						</div>
					</div>
					
					
				</div>
			</div>
			
		</div>
  	</div>

  	<div><hr></div>
  	
  </div>

</main>

<!-- The Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      
      <div class="modal-body">
        <img class="modal-content" id="img01">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>        
      </div>
    </div>
  </div>
</div>


<div class="container text-center">

<!-- Modal Main Slide -->
<div class="modal fade" id="ModalCarousel" tabindex="-1" role="dialog" aria-labelledby="ModalCarouselLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div id="carousel-modal-demo" class="carousel slide" data-ride="carousel">

<!-- Main Slide --> 
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="slide 1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1" class="slide 2"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2" class="slide 3"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="3" class="slide 4"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="4" class="slide 5"></li>
	<li data-target="#carouselExampleIndicators" data-slide-to="5" class="slide 6"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="6" class="slide 7"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="7" class="slide 8"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="8" class="slide 9"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="9" class="slide 10"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="10" class="slide 11"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="11" class="slide 12"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="12" class="slide 13"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="13" class="slide 14"></li>
	<li data-target="#carouselExampleIndicators" data-slide-to="14" class="slide 15"></li>
	<li data-target="#carouselExampleIndicators" data-slide-to="15" class="slide 16"></li>
  </ol>
  <div class="carousel-inner">
  	<div class="carousel-item 1 active">
      <img class="d-block w-100" src="<?php echo site_url().'images/Home/home_1.jpg'?>" alt="First slide">
    </div>
    <div class="carousel-item 2 ">
      <img class="d-block w-100" src="<?php echo site_url().'images/Home/home_2.jpg'?>" alt="Second slide">
    </div>
    <div class="carousel-item 3">
      <img class="d-block w-100" src="<?php echo site_url().'images/Home/home_3.jpg'?>" alt="Third slide">
    </div>
    <div class="carousel-item 4">
      <img class="d-block w-100" src="<?php echo site_url().'images/Home/home_4.jpg'?>" alt="Fourth slide">
    </div>
    <div class="carousel-item 5">
      <img class="d-block w-100" src="<?php echo site_url().'images/Home/home_5.jpg'?>" alt="Fifth slide">
    </div>
    <div class="carousel-item 6">
      <img class="d-block w-100" src="<?php echo site_url().'images/Home/home_6.jpg'?>" alt="Sixth slide">
    </div>
    <div class="carousel-item 7">
      <img class="d-block w-100" src="<?php echo site_url().'images/Home/home_7.jpg'?>" alt="Seventh slide">
    </div>
    <div class="carousel-item 8">
      <img class="d-block w-100" src="<?php echo site_url().'images/Home/home_8.jpg'?>" alt="Eight slide">
    </div>
	<div class="carousel-item 9">
      <img class="d-block w-100" src="<?php echo site_url().'images/Home/home_9.jpg'?>" alt="Ninth slide">
    </div>
    <div class="carousel-item 10">
      <img class="d-block w-100" src="<?php echo site_url().'images/Home/home_10.jpg'?>" alt="Tenth slide">
    </div>
	<div class="carousel-item 11">
      <img class="d-block w-100" src="<?php echo site_url().'images/Home/home_11.jpg'?>" alt="Eleventh slide">
    </div>
    <div class="carousel-item 12">
      <img class="d-block w-100" src="<?php echo site_url().'images/Home/home_12.jpg'?>" alt="Twelfth slide">
    </div>
	<div class="carousel-item 13">
      <img class="d-block w-100" src="<?php echo site_url().'images/Home/home_13.jpg'?>" alt="Thirteenth slide">
    </div>
    <div class="carousel-item 14">
      <img class="d-block w-100" src="<?php echo site_url().'images/Home/home_14.jpg'?>" alt="Fourteenth slide">
    </div>
	<div class="carousel-item 15">
      <img class="d-block w-100" src="<?php echo site_url().'images/Home/home_15.jpg'?>" alt="Fifteenth slide">
    </div>
	<div class="carousel-item 16">
      <img class="d-block w-100" src="<?php echo site_url().'images/Home/home_16.jpg'?>" alt="Sixteenth slide">
    </div>

  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
  
	  </div>
    </div>
  </div>
</div>

<!-- Modal Type A Slide -->
<div class="modal fade" id="ModalCarouselA" tabindex="-1" role="dialog" aria-labelledby="ModalCarouselLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div id="carousel-modal-demo" class="carousel slide" data-ride="carousel">

<!-- Type A Slide --> 
<div id="carouselExampleIndicatorsA" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicatorsA" data-slide-to="0" class="slide A1"></li>
    <li data-target="#carouselExampleIndicatorsA" data-slide-to="1" class="slide A2"></li>
    <li data-target="#carouselExampleIndicatorsA" data-slide-to="2" class="slide A3"></li>
    <li data-target="#carouselExampleIndicatorsA" data-slide-to="3" class="slide A4"></li>
    <li data-target="#carouselExampleIndicatorsA" data-slide-to="4" class="slide A5"></li>
	<li data-target="#carouselExampleIndicatorsA" data-slide-to="5" class="slide A6"></li>
    <li data-target="#carouselExampleIndicatorsA" data-slide-to="6" class="slide A7"></li>
  </ol>
  <div class="carousel-inner">
  	<div class="carousel-item A1 active">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_A/Type_A_1.jpg'?>" alt="First slide">
    </div>
    <div class="carousel-item A2">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_A/Type_A_2.jpg'?>" alt="Second slide">
    </div>
    <div class="carousel-item A3">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_A/Type_A_3.jpg'?>" alt="Third slide">
    </div>
    <div class="carousel-item A4">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_A/Type_A_4.jpg'?>" alt="Fourth slide">
    </div>
    <div class="carousel-item A5">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_A/Type_A_5.jpg'?>" alt="Fifth slide">
    </div>
    <div class="carousel-item A6">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_A/Type_A_6.jpg'?>" alt="Sixth slide">
    </div>
    <div class="carousel-item A7">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_A/Type_A_7.jpg'?>" alt="Seventh slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicatorsA" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicatorsA" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
  
	  </div>
    </div>
  </div>
</div>

<!-- Modal Type B Slide -->
<div class="modal fade" id="ModalCarouselB" tabindex="-1" role="dialog" aria-labelledby="ModalCarouselLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div id="carousel-modal-demo" class="carousel slide" data-ride="carousel">

<!-- Type B Slide --> 
<div id="carouselExampleIndicatorsB" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicatorsB" data-slide-to="0" class="slide B1"></li>
    <li data-target="#carouselExampleIndicatorsB" data-slide-to="1" class="slide B2"></li>
    <li data-target="#carouselExampleIndicatorsB" data-slide-to="2" class="slide B3"></li>
    <li data-target="#carouselExampleIndicatorsB" data-slide-to="3" class="slide B4"></li>
    <li data-target="#carouselExampleIndicatorsB" data-slide-to="4" class="slide B5"></li>
	<li data-target="#carouselExampleIndicatorsB" data-slide-to="5" class="slide B6"></li>
    <li data-target="#carouselExampleIndicatorsB" data-slide-to="6" class="slide B7"></li>
    <li data-target="#carouselExampleIndicatorsB" data-slide-to="7" class="slide B8"></li>
    <li data-target="#carouselExampleIndicatorsB" data-slide-to="8" class="slide B9"></li>
    <li data-target="#carouselExampleIndicatorsB" data-slide-to="9" class="slide B10"></li>
    <li data-target="#carouselExampleIndicatorsB" data-slide-to="10" class="slide B11"></li>
    <li data-target="#carouselExampleIndicatorsB" data-slide-to="11" class="slide B12"></li>
  </ol>
  <div class="carousel-inner">
  	<div class="carousel-item B1 active">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_B/Type_B_1.jpg'?>" alt="First slide">
    </div>
    <div class="carousel-item B2">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_B/Type_B_2.jpg'?>" alt="Second slide">
    </div>
    <div class="carousel-item B3">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_B/Type_B_3.jpg'?>" alt="Third slide">
    </div>
    <div class="carousel-item B4">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_B/Type_B_4.jpg'?>" alt="Fourth slide">
    </div>
    <div class="carousel-item B5">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_B/Type_B_5.jpg'?>" alt="Fifth slide">
    </div>
    <div class="carousel-item B6">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_B/Type_B_6.jpg'?>" alt="Sixth slide">
    </div>
    <div class="carousel-item B7">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_B/Type_B_7.jpg'?>" alt="Seventh slide">
    </div>
	<div class="carousel-item B8">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_B/Type_B_8.jpg'?>" alt="Eighth slide">
    </div>
	<div class="carousel-item B9">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_B/Type_B_9.jpg'?>" alt="Nineth slide">
    </div>
	<div class="carousel-item B10">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_B/Type_B_10.jpg'?>" alt="Tenth slide">
    </div>
	<div class="carousel-item B11">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_B/Type_B_11.jpg'?>" alt="Eleventh slide">
    </div>
	<div class="carousel-item B12">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_B/Type_B_12.jpg'?>" alt="Twelfth slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicatorsB" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicatorsB" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
  
	  </div>
    </div>
  </div>
</div>

<!-- Modal Type C Slide -->
<div class="modal fade" id="ModalCarouselC" tabindex="-1" role="dialog" aria-labelledby="ModalCarouselLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div id="carousel-modal-demo" class="carousel slide" data-ride="carousel">

<!-- Type C Slide --> 
<div id="carouselExampleIndicatorsC" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicatorsC" data-slide-to="0" class="slide C1"></li>
    <li data-target="#carouselExampleIndicatorsC" data-slide-to="1" class="slide C2"></li>
    <li data-target="#carouselExampleIndicatorsC" data-slide-to="2" class="slide C3"></li>
    <li data-target="#carouselExampleIndicatorsC" data-slide-to="3" class="slide C4"></li>
    <li data-target="#carouselExampleIndicatorsC" data-slide-to="4" class="slide C5"></li>
	<li data-target="#carouselExampleIndicatorsC" data-slide-to="5" class="slide C6"></li>
    <li data-target="#carouselExampleIndicatorsC" data-slide-to="6" class="slide C7"></li>
    <li data-target="#carouselExampleIndicatorsC" data-slide-to="7" class="slide C8"></li>
    <li data-target="#carouselExampleIndicatorsC" data-slide-to="8" class="slide C9"></li>
    <li data-target="#carouselExampleIndicatorsC" data-slide-to="9" class="slide C10"></li>
    <li data-target="#carouselExampleIndicatorsC" data-slide-to="10" class="slide C11"></li>
    <li data-target="#carouselExampleIndicatorsC" data-slide-to="11" class="slide C12"></li>
    <li data-target="#carouselExampleIndicatorsC" data-slide-to="12" class="slide C13"></li>
  </ol>
  <div class="carousel-inner">
  	<div class="carousel-item C1 active">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_C/Type_C_1.jpg'?>" alt="First slide">
    </div>
    <div class="carousel-item C2">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_C/Type_C_2.jpg'?>" alt="Second slide">
    </div>
    <div class="carousel-item C3">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_C/Type_C_3.jpg'?>" alt="Third slide">
    </div>
    <div class="carousel-item C4">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_C/Type_C_4.jpg'?>" alt="Fourth slide">
    </div>
    <div class="carousel-item C5">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_C/Type_C_5.jpg'?>" alt="Fifth slide">
    </div>
    <div class="carousel-item C6">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_C/Type_C_6.jpg'?>" alt="Sixth slide">
    </div>
    <div class="carousel-item C7">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_C/Type_C_7.jpg'?>" alt="Seventh slide">
    </div>
	<div class="carousel-item C8">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_C/Type_C_8.jpg'?>" alt="Eighth slide">
    </div>
	<div class="carousel-item C9">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_C/Type_C_9.jpg'?>" alt="Nineth slide">
    </div>
	<div class="carousel-item C10">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_C/Type_C_10.jpg'?>" alt="Tenth slide">
    </div>
	<div class="carousel-item C11">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_C/Type_C_11.jpg'?>" alt="Eleventh slide">
    </div>
	<div class="carousel-item C12">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_C/Type_C_12.jpg'?>" alt="Twelfth slide">
    </div>
	<div class="carousel-item C13">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_C/Type_C_13.jpg'?>" alt="Thirteenth slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicatorsC" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicatorsC" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
  
	  </div>
    </div>
  </div>
</div>

<!-- Modal Type D Slide -->
<div class="modal fade" id="ModalCarouselD" tabindex="-1" role="dialog" aria-labelledby="ModalCarouselLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div id="carousel-modal-demo" class="carousel slide" data-ride="carousel">

<!-- Type D Slide --> 
<div id="carouselExampleIndicatorsD" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicatorsD" data-slide-to="0" class="slide D1"></li>
    <li data-target="#carouselExampleIndicatorsD" data-slide-to="1" class="slide D2"></li>
    <li data-target="#carouselExampleIndicatorsD" data-slide-to="2" class="slide D3"></li>
    <li data-target="#carouselExampleIndicatorsD" data-slide-to="3" class="slide D4"></li>
    <li data-target="#carouselExampleIndicatorsD" data-slide-to="4" class="slide D5"></li>
	<li data-target="#carouselExampleIndicatorsD" data-slide-to="5" class="slide D6"></li>
    <li data-target="#carouselExampleIndicatorsD" data-slide-to="6" class="slide D7"></li>
    <li data-target="#carouselExampleIndicatorsD" data-slide-to="7" class="slide D8"></li>
    <li data-target="#carouselExampleIndicatorsD" data-slide-to="8" class="slide D9"></li>
    <li data-target="#carouselExampleIndicatorsD" data-slide-to="9" class="slide D10"></li>
    <li data-target="#carouselExampleIndicatorsD" data-slide-to="10" class="slide D11"></li>
    <li data-target="#carouselExampleIndicatorsD" data-slide-to="11" class="slide D12"></li>
    <li data-target="#carouselExampleIndicatorsD" data-slide-to="12" class="slide D13"></li>
    <li data-target="#carouselExampleIndicatorsD" data-slide-to="13" class="slide D14"></li>
    <li data-target="#carouselExampleIndicatorsD" data-slide-to="14" class="slide D15"></li>
    <li data-target="#carouselExampleIndicatorsD" data-slide-to="15" class="slide D16"></li>
	<li data-target="#carouselExampleIndicatorsD" data-slide-to="16" class="slide D17"></li>
    <li data-target="#carouselExampleIndicatorsD" data-slide-to="17" class="slide D18"></li>
  </ol>
  <div class="carousel-inner">
  	<div class="carousel-item D1 active">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_E/Type_E_1.jpg'?>" alt="First slide">
    </div>
    <div class="carousel-item D2">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_E/Type_E_2.jpg'?>" alt="Second slide">
    </div>
    <div class="carousel-item D3">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_E/Type_E_3.jpg'?>" alt="Third slide">
    </div>
    <div class="carousel-item D4">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_E/Type_E_4.jpg'?>" alt="Fourth slide">
    </div>
    <div class="carousel-item D5">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_E/Type_E_5.jpg'?>" alt="Fifth slide">
    </div>
    <div class="carousel-item D6">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_E/Type_E_6.jpg'?>" alt="Sixth slide">
    </div>
    <div class="carousel-item D7">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_E/Type_E_7.jpg'?>" alt="Seventh slide">
    </div>
	<div class="carousel-item D8">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_E/Type_E_8.jpg'?>" alt="Eighth slide">
    </div>
	<div class="carousel-item D9">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_E/Type_E_9.jpg'?>" alt="Nineth slide">
    </div>
	<div class="carousel-item D10">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_E/Type_E_10.jpg'?>" alt="Tenth slide">
    </div>
	<div class="carousel-item D11">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_E/Type_E_11.jpg'?>" alt="Eleventh slide">
    </div>
	<div class="carousel-item D12">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_E/Type_E_12.jpg'?>" alt="Twelfth slide">
    </div>
	<div class="carousel-item D13">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_E/Type_E_13.jpg'?>" alt="Thirteenth slide">
    </div>
	<div class="carousel-item D14">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_E/Type_E_14.jpg'?>" alt="Fourteenth slide">
    </div>
	<div class="carousel-item D15">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_E/Type_E_15.jpg'?>" alt="Fifteenth slide">
    </div>
	<div class="carousel-item D16">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_E/Type_E_16.jpg'?>" alt="Sixteenth slide">
    </div>
	<div class="carousel-item D17">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_E/Type_E_17.jpg'?>" alt="Seventeenth slide">
    </div>
	<div class="carousel-item D18">
      <img class="d-block w-100" src="<?php echo site_url().'images/Type_E/Type_E_18.jpg'?>" alt="Eighteenth slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicatorsD" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicatorsD" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
  
	  </div>
    </div>
  </div>
</div>

</div>

<!-- <script src="//code.jquery.com/jquery.js"></script> -->
<script src="<?php echo site_url();?>js/jquery.min.js"></script>
<script src="<?php echo site_url();?>js/jquery-ui.min.js"></script>
<script src="<?php echo site_url();?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
<script>
function stepper(dis) {
	let btn_id = dis.getAttribute('id');
	let max = dis.getAttribute('max');

	const myArray = btn_id.split("-");
	var myInput = myArray[1];
	let min = $('#'+myInput).val();
	
	var newval = ( myArray[0] == 'increment' ) ? (parseInt(min)+1) : (parseInt(min)-1);
	newval = (newval < 0) ? 0 : newval;
	$('#'+myInput).val(newval);
	$('#div_'+myInput).html(newval);
}

	$(function(){
		

		$('.datepicker').datepicker({ 
		    dateFormat: 'dd-mm-yy',
		    changeMonth: true,
		    changeYear: true,
		  // change : updateDate
		  }).val();

		
		$('.myImg').click(function(){
			var id = $(this).attr('data-id');
			$('.carousel-item').each(function(i, obj) {
			    $(this).removeClass('active');
			});
			$('.slide').each(function(i, obj) {
			    $(this).removeClass('active');
			});
			$('.'+id).addClass('active');
			$('#ModalCarousel').modal('show');
		});

		$('.myImgA').click(function(){
			var id = $(this).attr('data-id');
			console.log(id);
			$('.carousel-item').each(function(i, obj) {
			    $(this).removeClass('active');
			});
			$('.slide').each(function(i, obj) {
			    $(this).removeClass('active');
			});
			$('.A'+id).addClass('active');
			$('#ModalCarouselA').modal('show');
		});

		$('.myImgB').click(function(){
			var id = $(this).attr('data-id');
			$('.carousel-item').each(function(i, obj) {
			    $(this).removeClass('active');
			});
			$('.slide').each(function(i, obj) {
			    $(this).removeClass('active');
			});
			$('.B'+id).addClass('active');
			$('#ModalCarouselB').modal('show');
		});

		$('.myImgC').click(function(){
			var id = $(this).attr('data-id');
			$('.carousel-item').each(function(i, obj) {
			    $(this).removeClass('active');
			});
			$('.slide').each(function(i, obj) {
			    $(this).removeClass('active');
			});
			$('.C'+id).addClass('active');
			$('#ModalCarouselC').modal('show');
		});

		$('.myImgD').click(function(){
			var id = $(this).attr('data-id');
			$('.carousel-item').each(function(i, obj) {
			    $(this).removeClass('active');
			});
			$('.slide').each(function(i, obj) {
			    $(this).removeClass('active');
			});
			$('.D'+id).addClass('active');
			$('#ModalCarouselD').modal('show');
		});

		$('.dropdown-menu').on('click', function(event){
		    // The event won't be propagated up to the document NODE and 
		    // therefore delegated events won't be fired
		    event.stopPropagation();
		});

		/*$(".room_img").on('click', function(e){
			var mymodal = document.getElementById("myModal");
			var self = $(this);
			var name = self.data('name'); // or src = self.attr('src');
			var src = self.attr('src');
			console.log(mymodal);
			var modalImg = document.getElementById("img01");
			var captionText = document.getElementById("caption");
			modalImg.style.display = "block";	
			modalImg.src = src;
			// captionText.innerHTML = this.alt;
			$('#myModal').modal('show');
		});*/
	});
</script>
	
</body>
</html>

