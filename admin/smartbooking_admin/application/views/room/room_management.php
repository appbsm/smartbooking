<!-- Content Header (Page header) -->
<div class="content-wrapper" id="vApp" style="padding-bottom:50px;" v-cloak>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ menu }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><?= _r('Setting', 'การตั้งค่า'); ?></li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo room_management_url(); ?>">{{ menu }}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php if (has_permission('room_management', 'edit')) : ?>
                    <a href="<?php echo edit_room_type_url(); ?>" style="color:white;">
                        <button class="btn" style="float:right; width:170px; height:30px; line-height:9px; background-color:#0275d8; color:white; margin-bottom:20px;">
                            <?= _r('Add New Room Type', 'เพิ่ม Room Type ใหม่'); ?>
                        </button>
                    </a>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table id="roomTable" class="display" style="width:100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <input type="checkbox" id="selectAll" @click="selectAllRooms">
                                    </th>
                                    <th class="text-center"style="width:100px;"><?= _r('Image', 'รูปภาพ'); ?></th>
                                    <th class="text-center" style="width:160px;"><?= _r('Project', 'Project'); ?></th>
                                    <th class="text-center" style="width:80px;">Title</th>
                                    <th class="text-center"><?= _r('Room Type Name', 'ชื่อ Room Type'); ?></th>
                                    <th class="text-center" style="width:60px;"><?= _r('# of Rooms', 'จำนวนห้อง'); ?></th>
                                    <th class="text-center" style="width:80px;"><?= _r('Room Price', 'ราคาห้อง'); ?></th>
                                    <th class="text-center" style="width:60px;"><?= _r('# of Adults', 'จำนวนผู้ใหญ่'); ?></th>
                                    <th class="text-center" style="width:60px;"><?= _r('# of Children', 'จำนวนเด็ก'); ?></th>
                                    <th class="text-center" style="width:80px;"><?= _r('Max Children Age', 'อายุเด็กสูงสุด'); ?></th>
                                    <th class="text-center" style="width:80px;"><?= _r('Is Big Room?', 'เป็นห้องใหญ่หรือไม่'); ?></th>
                                    <th class="text-center" style="width:60px;"><?= _r('Status', 'สถานะ'); ?></th>
                                    <?php if (has_permission('room_management', 'view') || has_permission('room_management', 'delete')) : ?>
                                    <th class="text-center" style="width:110px;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="r in room_type">
                                    <td class="text-center">
                                        <input type="checkbox" :value="r.id_room_type" v-model="selectedRooms">
                                    </td>
                                    <td class="text-center"><img :src="r.image" style="width:100%;"></td>
                                    <td>{{ <?= _r('r.project_name_en', 'r.project_name_th'); ?> }}</td>
                                    <td class="text-center">{{ <?= _r('r.modular_type_en', 'r.modular_type_th'); ?> }}</td>
                                    <td>{{ <?= _r('r.room_type_name_en', 'r.room_type_name_th'); ?> }}</td>
                                    <td class="text-center">{{ r.rooms_count }}</td>
                                    <td class="text-center">{{ formatBaht(r.default_rate) }}</td>
                                    <td class="text-center">{{ r.number_of_adults }}</td>
                                    <td class="text-center">{{ r.number_of_children }}</td>
                                    <td class="text-center">{{ r.max_children_age }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-success" v-if="r.is_big_room == 1">Yes</span>
                                        <span class="badge badge-danger" v-if="r.is_big_room == 0">No</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-success" v-if="r.active == 1">Active</span>
                                        <span class="badge badge-danger" v-if="r.active == 0">Inactive</span>
                                    </td>
                                    <?php if (has_permission('room_management', 'view') || has_permission('room_management', 'delete')) : ?>
                                    <td class="text-center">
                                        <?php if (has_permission('room_management', 'view')) : ?>
                                        <button class="btn btn-sm btn-warning" @click="editRoomType(r.id_room_type)">
                                            <i class="fa fa-pencil" style="color:black !important;"></i>
                                        </button>
                                        <button class="btn btn-sm btn-secondary" onclick="document.getElementById('id01').style.display='block'">
                                            <i class="fa fa-gear" style="color:black !important;"></i>
                                        </button>
                                        <?php endif; ?>
                                        <?php if (has_permission('room_management', 'delete')) : ?>
                                        <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deleteRoomType(r.id_room_type)">
                                            <i class="fa fa-times"></i>
                                        </button>
                                        <?php endif; ?>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                            </tbody>
                        </table>
						
                    </div>
					
                </div>
            </div>
			
			<div class="row">
				<div class="col-md-12">
					<div id="id01" class="w3-modal" style="z-index: 1050;">
						<div class="w3-modal-content w3-card-4 w3-animate-zoom">
							<header class="w3-container w3-blue"> 
							   <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-blue w3-xlarge w3-display-topright">&times;</span>
							   <h2><?= _r('Utilities Consumption', 'การใช้สาธารณูปโภค'); ?></h2>
							</header>

							<div class="w3-bar w3-border-bottom">
								<button class="tablink w3-bar-item w3-button" onclick="openUtilities(event, 'Electric')">
									<?= _r('Electric', 'กำหนดค่าไฟฟ้า'); ?>
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="18" height="18" viewBox="0 0 256 256" xml:space="preserve">
									<defs>
									</defs>
									<g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
										<path d="M 36.378 46.603 h 5.473 v 10.425 c 0 0.438 0.286 0.825 0.704 0.955 c 0.098 0.03 0.197 0.045 0.296 0.045 c 0.324 0 0.635 -0.157 0.825 -0.435 L 54.447 41.87 c 0.21 -0.306 0.232 -0.703 0.06 -1.031 s -0.514 -0.534 -0.885 -0.534 h -5.474 V 29.879 c 0 -0.438 -0.285 -0.826 -0.704 -0.955 c -0.416 -0.128 -0.873 0.028 -1.121 0.39 l -10.77 15.723 c -0.209 0.306 -0.232 0.703 -0.06 1.031 C 35.667 46.396 36.007 46.603 36.378 46.603 z M 46.148 33.108 v 8.196 c 0 0.552 0.447 1 1 1 h 4.576 l -7.873 11.493 v -8.196 c 0 -0.552 -0.448 -1 -1 -1 h -4.576 L 46.148 33.108 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
										<path d="M 68.977 13.8 h -7.583 V 4.652 C 61.394 2.087 59.307 0 56.742 0 s -4.651 2.087 -4.651 4.652 V 13.8 H 37.91 V 4.652 C 37.91 2.087 35.823 0 33.258 0 s -4.652 2.087 -4.652 4.652 V 13.8 h -7.583 c -2.646 0 -4.798 2.152 -4.798 4.798 s 2.152 4.797 4.798 4.797 h 0.505 V 44.47 c 0 11.35 8.098 20.842 18.82 23.007 V 89 c 0 0.553 0.448 1 1 1 h 7.303 c 0.553 0 1 -0.447 1 -1 V 67.477 c 10.722 -2.164 18.82 -11.657 18.82 -23.007 V 23.395 h 0.505 c 2.646 0 4.798 -2.152 4.798 -4.797 S 71.622 13.8 68.977 13.8 z M 54.091 4.652 C 54.091 3.189 55.28 2 56.742 2 s 2.651 1.189 2.651 2.652 V 13.8 h -5.303 V 4.652 z M 30.606 4.652 C 30.606 3.189 31.795 2 33.258 2 s 2.652 1.189 2.652 2.652 V 13.8 h -5.304 V 4.652 z M 47.651 88 h -5.303 V 67.787 c 0.828 0.094 1.669 0.146 2.521 0.151 c 0.088 0.001 0.178 0 0.266 0 c 0.85 -0.005 1.689 -0.057 2.516 -0.15 V 88 z M 66.472 44.47 c 0 10.708 -7.886 19.583 -18.151 21.188 c -0.51 0.08 -0.997 0.144 -1.469 0.19 C 46.24 65.9 45.625 65.941 45 65.941 c -0.623 0 -1.237 -0.041 -1.846 -0.094 c -0.516 -0.051 -1.047 -0.119 -1.612 -0.211 C 31.345 63.974 23.528 55.13 23.528 44.47 V 23.395 h 42.943 V 44.47 z M 68.977 21.395 h -1.505 H 22.528 h -1.505 c -1.543 0 -2.798 -1.255 -2.798 -2.797 c 0 -1.543 1.255 -2.798 2.798 -2.798 h 8.583 h 7.304 h 16.181 h 7.303 h 8.583 c 1.543 0 2.798 1.255 2.798 2.798 C 71.774 20.14 70.52 21.395 68.977 21.395 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
									</g>
									</svg>
								</button>
								<button class="tablink w3-bar-item w3-button" onclick="openUtilities(event, 'Water')">
									<?= _r('Water', 'กำหนดค่าน้ำ'); ?>
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="18" height="18" viewBox="0 0 256 256" xml:space="preserve">
										<defs>
										</defs>
										<g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
											<path d="M 45 90.008 c -17.488 0 -31.715 -14.227 -31.715 -31.716 c 0 -22.264 17.854 -42.847 29.669 -56.467 l 1.29 -1.488 c 0.38 -0.44 1.133 -0.44 1.513 0 l 1.289 1.487 c 11.815 13.62 29.67 34.203 29.67 56.468 C 76.716 75.781 62.488 90.008 45 90.008 z M 45 2.519 l -0.535 0.617 c -11.62 13.395 -29.18 33.639 -29.18 55.156 c 0 16.385 13.33 29.715 29.715 29.715 s 29.715 -13.331 29.715 -29.715 c 0 -21.518 -17.561 -41.762 -29.181 -55.157 L 45 2.519 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
											<path d="M 45.528 75.046 c -10.072 0 -18.265 -8.194 -18.265 -18.266 c 0 -0.553 0.448 -1 1 -1 s 1 0.447 1 1 c 0 8.968 7.297 16.266 16.265 16.266 c 0.553 0 1 0.447 1 1 S 46.081 75.046 45.528 75.046 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
										</g>
									</svg>
								</button>
								<button class="tablink w3-bar-item w3-button" onclick="openUtilities(event, 'Internet')">
									<?= _r('Internet', 'กำหนดค่าอินเทอร์เน็ต'); ?>
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="18" height="18" viewBox="0 0 256 256" xml:space="preserve">
										<defs>
										</defs>
										<g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
											<path d="M 87.001 38.06 c -0.798 0 -1.594 -0.316 -2.185 -0.942 C 74.359 26.02 60.219 19.908 45 19.908 S 15.641 26.02 5.183 37.117 c -1.135 1.207 -3.035 1.263 -4.241 0.125 c -1.206 -1.136 -1.262 -3.035 -0.125 -4.241 C 12.42 20.689 28.111 13.908 45 13.908 s 32.58 6.781 44.184 19.094 c 1.136 1.206 1.08 3.104 -0.126 4.241 C 88.478 37.789 87.738 38.06 87.001 38.06 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
											<path d="M 14.867 49.238 c -0.738 0 -1.478 -0.271 -2.057 -0.816 c -1.206 -1.137 -1.262 -3.035 -0.125 -4.241 C 21.189 35.156 32.666 30.187 45 30.187 c 12.334 0 23.812 4.97 32.316 13.994 c 1.136 1.206 1.08 3.104 -0.126 4.241 s -3.104 1.079 -4.241 -0.126 C 65.59 40.487 55.664 36.187 45 36.187 c -10.665 0 -20.59 4.3 -27.949 12.109 C 16.461 48.922 15.665 49.238 14.867 49.238 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
											<path d="M 63.834 59.883 c -0.798 0 -1.594 -0.316 -2.185 -0.942 C 57.265 54.287 51.352 51.725 45 51.725 c -6.352 0 -12.265 2.563 -16.649 7.216 c -1.136 1.205 -3.035 1.263 -4.241 0.126 c -1.206 -1.137 -1.263 -3.035 -0.126 -4.241 c 5.53 -5.868 12.994 -9.101 21.016 -9.101 s 15.486 3.232 21.017 9.101 c 1.136 1.206 1.08 3.104 -0.126 4.241 C 65.311 59.612 64.571 59.883 63.834 59.883 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
											<circle cx="44.997" cy="68.48700000000001" r="4.607" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
										</g>
									</svg>
								</button>
							</div>

							<div id="Electric" class="w3-container Utilities">
								<div class="row">
									<div class="col-xs-12 col-md-6">

										<div class="section s2">
											<div class="topic">
												<div class="round" style="background-color: #E91E63;">1</div>
												<span>เลือกวิธีคิดค่าไฟฟ้า</span>
											</div>

											<div class="content">
												<div class="card-sub-type" @click="clickElecType(1)">
													<input ng-checked="elecModal.type == 1" type="radio" name="radioElecType" value="1" checked>
													เหมาจ่ายรายเดือน
												</div>
												<div class="card-sub-type" @click="clickElecType(2)">
													<input ng-checked="elecModal.type == 2" type="radio" name="radioElecType" value="2">
													คิดตามจริง
												</div>
												<div class="card-sub-type" @click="clickElecType(3)">
													<input ng-checked="elecModal.type == 3" type="radio" name="radioElecType" value="3">
													คิดตามจริง (ขั้นต่ำเป็นจำนวนเงิน)
												</div>
												<div class="card-sub-type" @click="clickElecType(4)">
													<input ng-checked="elecModal.type == 4" type="radio" name="radioElecType" value="4">
													คิดตามจริง (ขั้นต่ำเป็นยูนิต)
												</div>
												<div class="card-sub-type" @click="clickElecType(5)">
													<input ng-checked="elecModal.type == 5" type="radio" name="radioElecType" value="5">
													คิดตามจริง (บวกส่วนต่างจากราคาขั้นต่ำ)
												</div>
											</div>

										</div>
									</div>
									<div class="col-xs-12 col-md-6">
										<div class="section s3">
											<div class="topic">
												<div class="round" style="background-color: #E91E63;">2</div>
												<span>กรุณากรอกข้อมูลค่าไฟฟ้า</span>
											</div>

											<div class="content">
												<div>
													<!-- เหมาจ่ายรายเดือน -->
													<div v-if="elecModal.type == 1">
														<div class="form-group">
															<label>เหมารายเดือน (บาท/เดือน)</label>
															<input ng-model="elecModal.cost_month" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="0">
															<!--
															<button class="btn btn-view-example standard-elec" ng-click="modalExampleCal('elec')" type="button">
																<i class="fa fa-eye" aria-hidden="true" style="margin-right: 5px;"></i>
																ดูตัวอย่างการคำนวณ
															</button>
															-->
															<button class="btn btn-view-example standard-elec" type="button" data-toggle="modal" data-target="#Electric-1">
																<i class="fa fa-eye" aria-hidden="true" style="margin-right: 5px;"></i>
																ดูตัวอย่างการคำนวณ
															</button>
															<!-- Modal -->
															<div id="Electric-1" class="modal fade" tabindex="-1" role="dialog"  style="z-index: 1000;">
															  <div class="modal-dialog modal-lg" role="document">
																<div class="modal-content">
																  <div class="modal-header">
																	<h5 class="modal-title">ตัวอย่างการคำนวณ</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	  <span aria-hidden="true">&times;</span>
																	</button>
																  </div>
																  <!--<div class="modal-body">
																	<img src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/elec-1.png" alt="Calculation Example" class="img-fluid">
																  </div>-->
																  <div class="modal-body">
																	<div class="d-flex flex-column align-items-center">
																		<p class="font-16 font-w-600">เหมาจ่ายรายเดือน</p>
																		<div class="title-formula red" ng-class="{ 'blue' : modalExampleCalData.type == 'water', 'red' : modalExampleCalData.type == 'elec' }">กำหนด ค่าไฟเหมาจ่ายเดือนละ 500 บาท</div>
																	</div>
																	<div class="ex-lists" style="display: flex; justify-content: center;">
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 1
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/elec-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 101 ใช้ไฟ 20 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าไฟที่ต้องจ่าย 500 บาท</p>
																		</div>
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 2
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/elec-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 201 ใช้ไฟ 80 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าไฟที่ต้องจ่าย 500 บาท</p>
																		</div>
																	</div>
																	<div class="d-flex justify-content-center" ng-if="modalExampleCalData.alert">
																		<p class="text-alert">** ใช้ไฟน้อยหรือใช้ไฟมากก็จ่ายเท่ากัน **</p>
																	</div>
																  </div>
																</div>
															  </div>
															</div>


														</div>
													</div>

													<!-- คิดตามจริง -->
													<div v-if="elecModal.type == 2">
														<div class="form-group">
															<label>คิดตามจริง (บาท/ยูนิต)</label>
															<input ng-model="elecModal.cost_unit" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="20">
															<button class="btn btn-view-example standard-elec" type="button" data-toggle="modal" data-target="#Electric-2">
																<i class="fa fa-eye" aria-hidden="true" style="margin-right: 5px;"></i>
																ดูตัวอย่างการคำนวณ
															</button>
															<!-- Modal -->
															<div id="Electric-2" class="modal fade" tabindex="-1" role="dialog"  style="z-index: 1000;">
															  <div class="modal-dialog modal-lg" role="document">
																<div class="modal-content">
																  <div class="modal-header">
																	<h5 class="modal-title">ตัวอย่างการคำนวณ</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	  <span aria-hidden="true">&times;</span>
																	</button>
																  </div>
																  <div class="modal-body">
																	<div class="d-flex flex-column align-items-center">
																		<p class="font-16 font-w-600">คิดตามจริง</p>
																		<div class="title-formula red" ng-class="{ 'blue' : modalExampleCalData.type == 'water', 'red' : modalExampleCalData.type == 'elec' }">กำหนด ค่าไฟหน่วยละ 7 บาท</div>
																	</div>
																	<div class="ex-lists" style="display: flex; justify-content: center;">
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 1
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/elec-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 101 ใช้ไฟ 20 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าไฟ 20 x 7 = 140 บาท</p>
																		</div>
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 2
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/elec-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 201 ใช้ไฟ 80 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าไฟ 80 x 7 = 560 บาท</p>
																		</div>
																	</div>
																	<!--
																	<div class="d-flex justify-content-center" ng-if="modalExampleCalData.alert">
																		<p class="text-alert">** ใช้ไฟน้อยหรือใช้ไฟมากก็จ่ายเท่ากัน **</p>
																	</div>
																	-->
																  </div>
																</div>
															  </div>
															</div>
														</div>
													</div>
													<!-- คิดตามจริง (ขั้นต่ำเป็นจำนวนเงิน) -->
													<div v-if="elecModal.type == 3">
														<div class="form-group">
															<label>คิดตามจริง (บาท/ยูนิต)</label>
															<input ng-model="elecModal.cost_unit" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="20">
														</div>
														<div class="form-group">
															<label>ขั้นต่ำ (บาท)</label>
															<input ng-model="elecModal.minimum_cost" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="0">
															<button class="btn btn-view-example standard-elec" type="button" data-toggle="modal" data-target="#Electric-3">
																<i class="fa fa-eye" aria-hidden="true" style="margin-right: 5px;"></i>
																ดูตัวอย่างการคำนวณ
															</button>
															<!-- Modal -->
															<div id="Electric-3" class="modal fade" tabindex="-1" role="dialog"  style="z-index: 1000;">
															  <div class="modal-dialog modal-lg" role="document">
																<div class="modal-content">
																  <div class="modal-header">
																	<h5 class="modal-title">ตัวอย่างการคำนวณ</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	  <span aria-hidden="true">&times;</span>
																	</button>
																  </div>
																  <div class="modal-body">
																	<div class="d-flex flex-column align-items-center">
																		<p class="font-16 font-w-600">คิดตามจริง ขั้นต่ำเป็นจำนวนเงิน</p>
																		<div class="title-formula red" ng-class="{ 'blue' : modalExampleCalData.type == 'water', 'red' : modalExampleCalData.type == 'elec' }">กำหนด ค่าไฟหน่วยละ 7 บาท</div>
																	</div>
																	<div class="ex-lists" style="display: flex; justify-content: center;">
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 1
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/elec-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 101 ใช้ไฟ 20 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าไฟ 20 x 7 = 140 บาท</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">(น้อยกว่า 500 บาท) จ่าย 500 บาท</p>
																		</div>
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 2
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/elec-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 201 ใช้ไฟ 80 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าไฟ 80 x 7 = 560 บาท</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px; color: #fff;">..</p>
																		</div>
																	</div>
																  </div>
																</div>
															  </div>
															</div>
														</div>
													</div>
													<!-- คิดตามจริง (ขั้นต่ำเป็นยูนิต) -->
													<div v-if="elecModal.type == 4">
														<div class="form-group">
															<label>คิดตามจริง (บาท/ยูนิต)</label>
															<input ng-model="elecModal.cost_unit" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="20">
														</div>
														<div class="form-group">
															<label>ขั้นต่ำ (ยูนิต)</label>
															<input ng-model="elecModal.minimum_units" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="0">
														</div>
														<div class="form-group">
															<label>คิดเป็นเงิน (บาท)</label>
															<input ng-model="elecModal.unit_al_cost" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="0" fdprocessedid="0x32dh">
															<button class="btn btn-view-example standard-elec" type="button" data-toggle="modal" data-target="#Electric-4">
																<i class="fa fa-eye" aria-hidden="true" style="margin-right: 5px;"></i>
																ดูตัวอย่างการคำนวณ
															</button>
															<!-- Modal -->
															<div id="Electric-4" class="modal fade" tabindex="-1" role="dialog"  style="z-index: 1000;">
															  <div class="modal-dialog modal-lg" role="document">
																<div class="modal-content">
																  <div class="modal-header">
																	<h5 class="modal-title">ตัวอย่างการคำนวณ</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	  <span aria-hidden="true">&times;</span>
																	</button>
																  </div>
																  <div class="modal-body">
																	<div class="d-flex flex-column align-items-center">
																		<p class="font-16 font-w-600">คิดตามจริง ขั้นต่ำเป็นยูนิต</p>
																		<div class="title-formula red" ng-class="{ 'blue' : modalExampleCalData.type == 'water', 'red' : modalExampleCalData.type == 'elec' }">กำหนด ค่าไฟหน่วยละ 7 บาท (ขั้นต่ำ 75 หน่วย เหมาจ่าย 500 บาท)</div>
																	</div>
																	<div class="ex-lists" style="display: flex; justify-content: center;">
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 1
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/elec-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 101 ใช้ไฟ 20 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าไฟ 20 x 7 = 140 บาท</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">(อยู่ใน 75 หน่วย) จ่าย 500 บาท</p>
																		</div>
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 2
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/elec-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 201 ใช้ไฟ 75 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าไฟ 75 x 7 = 525 บาท</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">(อยู่ใน 75 หน่วย) จ่าย 500 บาท</p>
																		</div>
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 2
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/elec-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 301 ใช้ไฟ 76 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าไฟ 76 x 7 = 532 บาท</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px; color: #fff;">..</p>
																		</div>
																	</div>
																  </div>
																</div>
															  </div>
															</div>
														</div>
													</div>
													<!-- คิดตามจริง (บวกส่วนต่างจากราคาขั้นต่ำ) -->
													<div v-if="elecModal.type == 5">
														<div class="form-group">
															<label>คิดตามจริง (บาท/ยูนิต)</label>
															<input ng-model="elecModal.cost_unit" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="20">
														</div>
														<div class="form-group">
															<label>ขั้นต่ำ (ยูนิต)</label>
															<input ng-model="elecModal.base_rate" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="0">
														</div>
														<div class="form-group">
															<label>คิดเป็นเงิน (บาท)</label>
															<input ng-model="elecModal.unit_al_cost" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="0" fdprocessedid="0x32dh">
															<button class="btn btn-view-example standard-elec" type="button" data-toggle="modal" data-target="#Electric-5">
																<i class="fa fa-eye" aria-hidden="true" style="margin-right: 5px;"></i>
																ดูตัวอย่างการคำนวณ
															</button>
															<!-- Modal -->
															<div id="Electric-5" class="modal fade" tabindex="-1" role="dialog"  style="z-index: 1000;">
															  <div class="modal-dialog modal-lg" role="document">
																<div class="modal-content">
																  <div class="modal-header">
																	<h5 class="modal-title">ตัวอย่างการคำนวณ</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	  <span aria-hidden="true">&times;</span>
																	</button>
																  </div>
																  <div class="modal-body">
																	<div class="d-flex flex-column align-items-center">
																		<p class="font-16 font-w-600">คิดตามจริง บวกส่วนต่างจากราคาขั้นต่ำ</p>
																		<div class="title-formula red" ng-class="{ 'blue' : modalExampleCalData.type == 'water', 'red' : modalExampleCalData.type == 'elec' }">กำหนด ค่าไฟหน่วยละ 7 บาท (ขั้นต่ำ 20 หน่วย เหมาจ่าย 150 บาท)</div>
																	</div>
																	<div class="ex-lists" style="display: flex; justify-content: center;">
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 1
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/elec-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 101 ใช้ไฟ 15 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">(อยู่ใน 20 หน่วย) จ่าย 150 บาท</p>
																		</div>
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 2
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/elec-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 201 ใช้ไฟ 20 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">(อยู่ใน 20 หน่วย) จ่าย 150 บาท</p>
																		</div>
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 2
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/elec-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 301 ใช้ไฟ 21 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">เกินขั้นต่ำ 1 หน่วย (21-20 = 1 หน่วย)</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าไฟ 150+(1x7) = 157 บาท</p>
																		</div>
																	</div>
																  </div>
																</div>
															  </div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							
							<div id="Water" class="w3-container Utilities">
								<div class="row">
									<div class="col-xs-12 col-md-6">
										<div class="section s2">
											<div class="topic">
												<div class="round" style="background-color: #2D7DC2;">1</div>
												<span>เลือกวิธีคิดค่าน้ำ</span>
											</div>

											<div class="content">
												<div class="card-sub-type" @click="clickWaterType(1)">
													<input ng-checked="waterModal.type == 1" type="radio" name="radioWaterTtype" value="1" checked="checked">
													เหมาจ่ายรายเดือน
												</div>
												<div class="card-sub-type" @click="clickWaterType(6)">
													<input ng-checked="waterModal.type == 6" type="radio" name="radioWaterTtype" value="6">
													เหมาจ่ายรายหัว
												</div>
												<div class="card-sub-type" @click="clickWaterType(2)">
													<input ng-checked="waterModal.type == 2" type="radio" name="radioWaterTtype" value="2">
													คิดตามจริง
												</div>
												<div class="card-sub-type" @click="clickWaterType(3)">
													<input ng-checked="waterModal.type == 3" type="radio" name="radioWaterTtype" value="3">
													คิดตามจริง (ขั้นต่ำเป็นจำนวนเงิน)
												</div>
												<div class="card-sub-type" @click="clickWaterType(4)">
													<input ng-checked="waterModal.type == 4" type="radio" name="radioWaterTtype" value="4">
													คิดตามจริง (ขั้นต่ำเป็นยูนิต)
												</div>
												<div class="card-sub-type" @click="clickWaterType(5)">
													<input ng-checked="waterModal.type == 5" type="radio" name="radioWaterTtype" value="5">
													คิดตามจริง (บวกส่วนต่างจากราคาขั้นต่ำ)
												</div>
											</div>
										</div>
									</div>

								<div class="col-xs-12 col-md-6">
									<div class="section s3">
										<div class="topic">
											<div class="round" style="background-color: #2D7DC2;">2</div>
											<span>กรุณากรอกข้อมูลค่าน้ำ</span>
										</div>
										<div class="content">
											<div>
												<!-- เหมาจ่ายรายเดือน -->
													<div v-if="waterModal.type == 1">
														<div class="form-group">
															<label>เหมารายเดือน (บาท/เดือน)</label>
															<input ng-model="waterModal.cost_month" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="0">
															
															<button class="btn btn-view-example standard-elec" type="button" data-toggle="modal" data-target="#Water-1">
																<i class="fa fa-eye" aria-hidden="true" style="margin-right: 5px;"></i>
																ดูตัวอย่างการคำนวณ
															</button>
															<!-- Modal -->
															<div id="Water-1" class="modal fade" tabindex="-1" role="dialog"  style="z-index: 1000;">
															  <div class="modal-dialog modal-lg" role="document">
																<div class="modal-content">
																  <div class="modal-header">
																	<h5 class="modal-title">ตัวอย่างการคำนวณ</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	  <span aria-hidden="true">&times;</span>
																	</button>
																  </div>
																  <div class="modal-body">
																	<div class="d-flex flex-column align-items-center">
																		<p class="font-16 font-w-600">เหมาจ่ายรายเดือน</p>
																		<div class="title-formula blue" ng-class="{ 'blue' : modalExampleCalData.type == 'water', 'blue' : modalExampleCalData.type == 'elec' }">กำหนด ค่าน้ำเหมาจ่ายเดือนละ 100 บาท</div>
																	</div>
																	<div class="ex-lists" style="display: flex; justify-content: center;">
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 1
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/water-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 101 ใช้น้ำ 5 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าน้ำที่ต้องจ่าย 100 บาท</p>
																		</div>
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 2
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/water-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 201 ใช้น้ำ 20 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าน้ำที่ต้องจ่าย 100 บาท</p>
																		</div>
																	</div>
																	<div class="d-flex justify-content-center" ng-if="modalExampleCalData.alert">
																		<p class="text-alert">** ใช้น้ำน้อยหรือใช้น้ำมากก็จ่ายเท่ากัน **</p>
																	</div>
																  </div>
																</div>
															  </div>
															</div>


														</div>
													</div>
												<!-- เหมาจ่ายรายหัว  -->
													<div v-if="waterModal.type == 6">
														<div class="form-group">
															<label>เหมาหัวละ (บาท/เดือน)</label>
															<input ng-model="waterModal.cost_unit" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="0">
														</div>
														<div class="form-group">
															<label>จำนวนผู้เช่า (คน)</label>
															<input ng-model="waterModal.minimum_cost" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="0">
															<button class="btn btn-view-example standard-elec" type="button" data-toggle="modal" data-target="#Water-6">
																<i class="fa fa-eye" aria-hidden="true" style="margin-right: 5px;"></i>
																ดูตัวอย่างการคำนวณ
															</button>
															<!-- Modal -->
															<div id="Water-6" class="modal fade" tabindex="-1" role="dialog"  style="z-index: 1000;">
															  <div class="modal-dialog modal-lg" role="document">
																<div class="modal-content">
																  <div class="modal-header">
																	<h5 class="modal-title">ตัวอย่างการคำนวณ</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	  <span aria-hidden="true">&times;</span>
																	</button>
																  </div>
																  <div class="modal-body">
																	<div class="d-flex flex-column align-items-center">
																		<p class="font-16 font-w-600">คิดตามจริง ขั้นต่ำเป็นจำนวนเงิน</p>
																		<div class="title-formula blue" ng-class="{ 'blue' : modalExampleCalData.type == 'water', 'blue' : modalExampleCalData.type == 'elec' }">กำหนด ค่าน้ำเหมาจ่ายหัวละ 100 บาท</div>
																	</div>
																	<div class="ex-lists" style="display: flex; justify-content: center;">
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 1
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/water-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 101 มีผู้เช่า 1 คน</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าน้ำที่ต้องจ่าย 100 บาท/เดือน</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px; color: #fff;">..</p>
																		</div>
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 2
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/water-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 201 มีผู้เช่า 2 คน</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าน้ำที่ต้องจ่าย 200 บาท/เดือน</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px; color: #fff;">..</p>
																		</div>
																	</div>
																  </div>
																</div>
															  </div>
															</div>
														</div>
													</div>
												<!-- คิดตามจริง -->
													<div v-if="waterModal.type == 2">
														<div class="form-group">
															<label>คิดตามจริง (บาท/ยูนิต)</label>
															<input ng-model="waterModal.cost_unit" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="15">
															<button class="btn btn-view-example standard-elec" type="button" data-toggle="modal" data-target="#Water-2">
																<i class="fa fa-eye" aria-hidden="true" style="margin-right: 5px;"></i>
																ดูตัวอย่างการคำนวณ
															</button>
															<!-- Modal -->
															<div id="Water-2" class="modal fade" tabindex="-1" role="dialog"  style="z-index: 1000;">
															  <div class="modal-dialog modal-lg" role="document">
																<div class="modal-content">
																  <div class="modal-header">
																	<h5 class="modal-title">ตัวอย่างการคำนวณ</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	  <span aria-hidden="true">&times;</span>
																	</button>
																  </div>
																  <div class="modal-body">
																	<div class="d-flex flex-column align-items-center">
																		<p class="font-16 font-w-600">คิดตามจริง</p>
																		<div class="title-formula blue" ng-class="{ 'blue' : modalExampleCalData.type == 'water', 'blue' : modalExampleCalData.type == 'elec' }">กำหนด ค่าน้ำหน่วยละ 15 บาท</div>
																	</div>
																	<div class="ex-lists" style="display: flex; justify-content: center;">
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 1
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/water-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 101 ใช้น้ำ 5 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าน้ำ 5 x 15 = 75 บาท</p>
																		</div>
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 2
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/water-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 201 ใช้น้ำ 20 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าน้ำ 20 x 15 = 300 บาท</p>
																		</div>
																	</div>
																  </div>
																</div>
															  </div>
															</div>
														</div>
													</div>
												<!-- คิดตามจริง (ขั้นต่ำเป็นจำนวนเงิน) -->
													<div v-if="waterModal.type == 3">
														<div class="form-group">
															<label>คิดตามจริง (บาท/ยูนิต)</label>
															<input ng-model="waterModal.cost_unit" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="15">
														</div>
														<div class="form-group">
															<label>ขั้นต่ำ (บาท)</label>
															<input ng-model="waterModal.minimum_cost" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="0">
															<button class="btn btn-view-example standard-elec" type="button" data-toggle="modal" data-target="#Water-3">
																<i class="fa fa-eye" aria-hidden="true" style="margin-right: 5px;"></i>
																ดูตัวอย่างการคำนวณ
															</button>
															<!-- Modal -->
															<div id="Water-3" class="modal fade" tabindex="-1" role="dialog"  style="z-index: 1000;">
															  <div class="modal-dialog modal-lg" role="document">
																<div class="modal-content">
																  <div class="modal-header">
																	<h5 class="modal-title">ตัวอย่างการคำนวณ</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	  <span aria-hidden="true">&times;</span>
																	</button>
																  </div>
																  <div class="modal-body">
																	<div class="d-flex flex-column align-items-center">
																		<p class="font-16 font-w-600">คิดตามจริง ขั้นต่ำเป็นจำนวนเงิน</p>
																		<div class="title-formula blue" ng-class="{ 'blue' : modalExampleCalData.type == 'water', 'blue' : modalExampleCalData.type == 'elec' }">กำหนด ค่าน้ำหน่วยละ 15 บาท ขั้นต่ำ 100 บาท</div>
																	</div>
																	<div class="ex-lists" style="display: flex; justify-content: center;">
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 1
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/water-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 101 ใช้น้ำ 5 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าน้ำ 5 x 15 = 75</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">(น้อยกว่า 100 บาท) จ่าย 100 บาท</p>
																		</div>
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 2
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/water-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 201 ใช้น้ำ 20 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าน้ำ 20 x 15 = 300 บาท</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px; color: #fff;">..</p>
																		</div>
																	</div>
																  </div>
																</div>
															  </div>
															</div>
														</div>
													</div>
												<!-- คิดตามจริง (ขั้นต่ำเป็นยูนิต) -->
													<div v-if="waterModal.type == 4">
														<div class="form-group">
															<label>คิดตามจริง (บาท/ยูนิต)</label>
															<input ng-model="waterModal.cost_unit" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="15">
														</div>
														<div class="form-group">
															<label>ขั้นต่ำ (ยูนิต)</label>
															<input ng-model="waterModal.minimum_units" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="0">
														</div>
														<div class="form-group">
															<label>คิดเป็นเงิน (บาท)</label>
															<input ng-model="waterModal.unit_al_cost" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="0" fdprocessedid="0x32dh">
															<button class="btn btn-view-example standard-elec" type="button" data-toggle="modal" data-target="#Water-4">
																<i class="fa fa-eye" aria-hidden="true" style="margin-right: 5px;"></i>
																ดูตัวอย่างการคำนวณ
															</button>
															<!-- Modal -->
															<div id="Water-4" class="modal fade" tabindex="-1" role="dialog"  style="z-index: 1000;">
															  <div class="modal-dialog modal-lg" role="document">
																<div class="modal-content">
																  <div class="modal-header">
																	<h5 class="modal-title">ตัวอย่างการคำนวณ</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	  <span aria-hidden="true">&times;</span>
																	</button>
																  </div>
																  <div class="modal-body">
																	<div class="d-flex flex-column align-items-center">
																		<p class="font-16 font-w-600">คิดตามจริง ขั้นต่ำเป็นยูนิต</p>
																		<div class="title-formula blue" ng-class="{ 'blue' : modalExampleCalData.type == 'water', 'blue' : modalExampleCalData.type == 'elec' }">กำหนด ค่าน้ำหน่วยละ 15 บาท (ขั้นต่ำ 7 หน่วย เหมาจ่าย 100 บาท)</div>
																	</div>
																	<div class="ex-lists" style="display: flex; justify-content: center;">
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 1
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/water-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 101 ใช้น้ำ 5 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าน้ำ 5 x 15 = 75</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">(อยู่ใน 7 หน่วย) จ่าย 100 บาท</p>
																		</div>
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 2
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/water-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 201 ใช้น้ำ 7 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าน้ำ 7 x 15 = 105 บาท</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">(อยู่ใน 7 หน่วย) จ่าย 100 บาท</p>
																		</div>
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 2
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/water-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 301 ใช้น้ำ 8 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าน้ำ 8 x 15 = 120 บาท</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px; color: #fff;">..</p>
																		</div>
																	</div>
																  </div>
																</div>
															  </div>
															</div>
														</div>
													</div>
												<!-- คิดตามจริง (บวกส่วนต่างจากราคาขั้นต่ำ) -->
													<div v-if="waterModal.type == 5">
														<div class="form-group">
															<label>คิดตามจริง (บาท/ยูนิต)</label>
															<input ng-model="waterModal.cost_unit" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="15">
														</div>
														<div class="form-group">
															<label>ขั้นต่ำ (ยูนิต)</label>
															<input ng-model="waterModal.base_rate" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="0">
														</div>
														<div class="form-group">
															<label>คิดเป็นเงิน (บาท)</label>
															<input ng-model="waterModal.unit_al_cost" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="0" fdprocessedid="0x32dh">
															<button class="btn btn-view-example standard-elec" type="button" data-toggle="modal" data-target="#Water-5">
																<i class="fa fa-eye" aria-hidden="true" style="margin-right: 5px;"></i>
																ดูตัวอย่างการคำนวณ
															</button>
															<!-- Modal -->
															<div id="Water-5" class="modal fade" tabindex="-1" role="dialog"  style="z-index: 1000;">
															  <div class="modal-dialog modal-lg" role="document">
																<div class="modal-content">
																  <div class="modal-header">
																	<h5 class="modal-title">ตัวอย่างการคำนวณ</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	  <span aria-hidden="true">&times;</span>
																	</button>
																  </div>
																  <div class="modal-body">
																	<div class="d-flex flex-column align-items-center">
																		<p class="font-16 font-w-600">คิดตามจริง บวกส่วนต่างจากราคาขั้นต่ำ</p>
																		<div class="title-formula blue" ng-class="{ 'blue' : modalExampleCalData.type == 'water', 'blue' : modalExampleCalData.type == 'elec' }">กำหนด ค่าน้ำหน่วยละ 25 บาท (ขั้นต่ำ 5 หน่วย เหมาจ่าย 150 บาท)</div>
																	</div>
																	<div class="ex-lists" style="display: flex; justify-content: center;">
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 1
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/water-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 101 ใช้น้ำ 4 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">(อยู่ใน 5 หน่วย) จ่าย 150 บาท</p>
																		</div>
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 2
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/water-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 201 ใช้น้ำ 5 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">(อยู่ใน 5 หน่วย) จ่าย 150 บาท</p>
																		</div>
																		<div class="ex-card" ng-repeat="exData in modalExampleCalData.list track by $index">
																			<p class="ex-title mb-15 text-color-service-2" ng-class="{ 'text-color-service-1' : modalExampleCalData.type == 'water' , 'text-color-service-2' : modalExampleCalData.type == 'elec' }">
																				กรณีที่ 2
																			</p>
																			<img class="mb-15" ng-if="modalExampleCalData.type == 'elec'" src="https://smartbooking.installdirect.asia/admin/smartbooking_admin/images/Utilities/water-example.png" alt="Calculation Example" class="img-fluid"><!---->
																			<p class="font-14" style="color: #777777; font-weight: 400;">ห้อง 301 ใช้น้ำ 6 หน่วย</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">เกินขั้นต่ำ 1 หน่วย (6-5 = 1 หน่วย)</p>
																			<p class="font-14 font-w-600 text-center" style="margin-bottom: 0px;">คิดเป็นค่าน้ำ 150+(1x25) = 175 บาท</p>
																		</div>
																	</div>
																  </div>
																</div>
															  </div>
															</div>
														</div>
													</div>
													
											</div>
											<button class="btn btn-view-example standard-water" ng-click="modalExampleCal('water')" type="button" fdprocessedid="ybadvn">
											  <i class="fa fa-eye" aria-hidden="true" style="margin-right: 5px;"></i>
												ดูตัวอย่างการคำนวณ</button>
											</div>
									</div>
								  </div>
								</div>
							</div>

							<div id="Internet" class="w3-container Utilities">
								<h1>Internet</h1>
								<p>Internet is the capital of Japan.</p><br>
							</div>
							
							<!--
							<div class="w3-container w3-light-grey w3-padding">
								<button class="w3-button w3-right w3-white w3-border" onclick="document.getElementById('id01').style.display='none'">Close</button>
							</div>
							-->
							<div class="modal-footer">
        <button type="button" data-dismiss="modal" ng-disabled="isSaving" class="btn btn-red" fdprocessedid="h2d46s">ยกเลิก</button>
        <button type="submit" ng-click="saveStandardRateElec()" ng-disabled="isSaving" class="btn btn-green" fdprocessedid="jtakhc">บันทึก</button>
      </div>
						</div>
					</div>
				</div>
			</div>

        </div>
    </section>

</div>

<script>
	$(document).ready(function() {
		app = new Vue({
			el: '#vApp',
			data: {
				menu: "<?= _r('Room Management', 'ตั้งค่าห้องพัก'); ?>",
				room_type: <?php echo json_encode($room_type); ?>,
				elecModal: {
				  type: 1,
				  cost_month: '',
				  cost_unit: ''
				},
                waterModal: {
                  type: 1,
                  cost_month: '',
                  cost_unit: ''
                },
                internetModal: {
                  type: 1,
                  cost_month: '',
                  cost_unit: ''
                },
				selectedRooms: []
			},
			mounted() {
				$("#roomTable").DataTable();
			},
			methods: {
				clickElecType(type) {
				  this.elecModal.type = type;
				},
                clickWaterType(type) {
                  this.waterModal.type = type;
                },
                clickInternetType(type) {
                  this.internetModal.type = type;
                },
				modalExampleCal(type) {
				  // ฟังก์ชันที่ใช้ในการคำนวณตัวอย่าง
				  console.log('Example calculation for:', type);
				},
				editRoomType: function(id) {
					<?php if (has_permission('room_management', 'view')) : ?>
					location.href = '<?php echo edit_room_type_url(); ?>'+ id;
					<?php endif; ?>
				},
				deleteRoomType: function(id) {
					if (confirm('Delete this Room Type ?')) {
						let param = {'id': id};
						$.post("<?php echo delete_room_type_url(); ?>", param, function(res) {
							if (res.result == 'false') {
								alert(res.message);
							} else {
								alert('Delete Room Type Success');
								location.reload();
							}
						});
					}
				},
				selectAllRooms: function(event) {
					if (event.target.checked) {
						this.selectedRooms = this.room_type.map(r => r.id_room_type);
					} else {
						this.selectedRooms = [];
					}
				}
			}
		});
	});
</script>

<script>
	document.getElementsByClassName("tablink")[0].click();

	function openUtilities(evt, UtilitiesName) {
	  var i, x, tablinks;
	  x = document.getElementsByClassName("Utilities");
	  for (i = 0; i < x.length; i++) {
		x[i].style.display = "none";
	  }
	  tablinks = document.getElementsByClassName("tablink");
	  for (i = 0; i < x.length; i++) {
		tablinks[i].classList.remove("w3-light-grey");
	  }
	  document.getElementById(UtilitiesName).style.display = "block";
	  evt.currentTarget.classList.add("w3-light-grey");
	}
</script>


<!-- Bootstrap JavaScript Bundle with Popper -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<!-- modal -->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<style>

	.Utilities {display:none}
	@media screen and (max-width: 640px) {
		.dataTables_wrapper .dataTables_length {
			float: left !important;
		}
	}
	@media screen and (max-width: 640px) {
		.dataTables_wrapper .dataTables_length, .dataTables_filter {
			float: none;
			text-align: right !important;
		}
		.ex-card {
			width: 100% !important;
			height: 100%;
			font-size: small !important;
		}
	}
	@media (min-width: 993px) {
		.w3-modal-content {
			/* width: 900px; */
			width: 50%;
		}
	}
	.w3-xlarge {
		font-size: 18px !important;
	}
	.table-responsive {
		width: 100%;
		overflow-x: auto;
	}

	#roomTable th.text-center, #roomTable td.text-center {
		vertical-align: middle;
		padding: 10px 20px 10px 20px;
	}

	#roomTable th, #roomTable td {
		white-space: nowrap;
	}
	.ex-card {
		width: 40%;
		height: 100%;
		border: 1px solid #ecedf6;
		border-radius: 8px;
		padding: 24px;
		display: flex;
		flex-direction: column;
		align-items: center;
		margin: 6px;
		font-size: 14px;
	}
	.title-formula.red {
		background-color: #ffe0eb;
	}
	.title-formula.blue {
		background-color: #d7e7fb;
	}
	.ex-lists {
		display: flex;
		flex-wrap: wrap;
		align-items: center;
		justify-content: center;
		gap: 10px;
	}
	.ex-lists .ex-card .ex-title {
		font-size: 14px;
		font-weight: 600;
		margin-bottom: 0;
	}
	.text-color-service-2 {
		color: #e91e63;
	}
	.text-alert {
		font-size: 18px;
		font-weight: 600;
		color: #e5772c;
		margin-top: 24px;
	}
	.text-alert {
		font-size: 18px;
		font-weight: 600;
		color: #e5772c;
		margin-top: 24px;
	}
	.modal-footer {
		padding: 15px;
		text-align: right;
		border-top: 1px solid #e5e5e5;
	}
	.btn-red {
		background-color: #f65b63;
		border-color: #e03b35;
		color: #f7f8f9;
		box-shadow: 0 2px 1px #c6495e;
		margin: 0;
	}
	.btn-green {
		background-color: #57c059;
		border-color: #57c059;
		color: #f7f8f9;
		box-shadow: 0 2px 1px #38a33b;
		margin: 0 0 0 10px;
	}
	.modal-footer .btn+.btn {
		margin-bottom: 0;
		margin-left: 8px;
	}
	.modal-apartment-setting .topic .round {
		width: 32px;
		height: 32px;
		color: #fff;
		background-color: rgba(229, 119, 44, 1);
		border-radius: 50%;
		margin-right: 16px;
		display: flex;
		align-items: center;
		justify-content: center;
	}
</style>
