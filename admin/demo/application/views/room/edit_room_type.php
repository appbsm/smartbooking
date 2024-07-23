<style>
    .display-image {
        height: 100%;
        width: 100%;
        border: 0px solid black;
        background-position: center;
        background-size: cover;
    }
</style>
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
                            <a href="<?php echo room_management_url(); ?>"><?= _r('Room Management', 'ตั้งค่าห้องพัก'); ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo edit_room_type_url($room_type_info['id_room_type']); ?>">{{ menu }}<?php echo $room_type_info['id_room_type'] ? (' ('. $room_type_info['room_type_name_en'] .')') : ''; ?></a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="amenityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="height:94vh;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1"><?= _r('Edit', 'จัดการ'); ?> Amenities</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <?php if (has_permission('room_management', 'edit')) : ?>
                    <button class="btn btn-sm" style="float:right; font-size:13px; background-color:#809f4e; color:white; margin-bottom:20px;" @click="loadEditAmenity(0)"><?= _r('Add New Amenity', 'เพิ่ม Amenity ใหม่'); ?></button>
                    <?php endif; ?>
                    <table id="amenityTable" class="display" style="width:99%;">
                        <thead>
                            <tr>
                                <th><?= _r('Icon', 'ไอคอน'); ?></th>
                                <th style="width:200px;"><?= _r('Desc', 'รายละเอียด'); ?></th>
                                <?php if (has_permission('room_management', 'edit') || has_permission('room_management', 'delete')) : ?>
                                <th style="font-size:13px; font-weight:normal;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="a in shift_json(amenity)">
                                <td style="text-align:center;"><img style="width:50px;" :src="a.icon"></td>
                                <td style="text-align:left;">{{ <?= _r('a.desc_en', 'a.desc_th'); ?> }}</td>
                                <?php if (has_permission('room_management', 'edit') || has_permission('room_management', 'delete')) : ?>
                                <td style="text-align:center;">
                                    <?php if (has_permission('room_management', 'edit')) : ?>
                                    <button class="btn btn-sm btn-warning" @click="loadEditAmenity(a.id_amenities)">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <?php endif; ?>
                                    <?php if (has_permission('room_management', 'delete')) : ?>
                                    <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deleteAmenity(a.id_amenities)">
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
    </div>
    <div class="modal fade" id="editAmenityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="height:94vh; overflow-y:auto;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">{{ edit_amenity.id_amenities == 0 ? '<?= _r("Add", "เพิ่ม"); ?>' : '<?= _r("Update", "แก้ไข"); ?>' }} Amenity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <div class="col-md-11">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Desc EN', 'รายละเอียด (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_amenity.desc_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Desc TH', 'รายละเอียด (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_amenity.desc_th">
                            </div>
                        </div>
                        <div class="row" style="margin-top:5px;">
                            <div class="col-md-12">
                                <input type="hidden" id="url-image-input-amenity" v-model="edit_amenity.icon">
                                <input type="file" style="display:none;" class="image-input image-input-amenity" id="image-input-amenity" accept="image/jpeg, image/png, image/jpg">
                                <div style="width:150px !important;">
                                    <small><font color="red">*</font> <?= _r('Icon', 'ไอคอน'); ?></small><br>
                                    <span class="display-image" id="display-image-input-amenity" style="margin-top:-3px;">
                                        <img :src="edit_amenity.icon" style="margin-top:-1px; height:77px;">
                                    </span>
                                </div>
                                <div style="width:150px !important;">
                                    <button style="background-color:black; color:white;" @click="uploadImage('amenity')">Browse...</button>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;" @click="saveAmenity()">{{ edit_amenity.id_amenities == 0 ? '<?= _r("Add", "เพิ่ม"); ?>' : '<?= _r("Update", "แก้ไข"); ?>' }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateRoomDetailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="overflow-y:auto;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3"><?= _r('Update Room Detail', 'แก้ไขรายละเอียดห้อง'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Room Name EN', 'ชื่อห้อง (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="room_detail_update_row.room_name_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Room Name TH', 'ชื่อห้อง (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="room_detail_update_row.room_name_th">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <small><font color="red">*</font> <?= _r('Room Number', 'หมายเลขห้อง'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="room_detail_update_row.room_number">
                            </div>
                            <div class="col-md-4">
                                <small>Tags</small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="room_detail_update_row.tags">
                            </div>
                            <div class="col-md-4">
                                <small><font color="red">*</font> <?= _r('Status', 'สถานะ'); ?></small>
                                <select class="form-control" style="margin-top:-3px;" v-model="room_detail_update_row.active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;" @click="updateRoomDetail()"><?= _r('Update', 'แก้ไข'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editSeasonalPriceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="height:90vh; overflow-y:auto;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4"><?= _r('Update', 'แก้ไข'); ?> Seasonal Price</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <div class="col-md-11">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font> Title <?= _r('EN', '(ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_seasonal_price.title_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> Title <?= _r('TH', '(ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_seasonal_price.title_th">
                            </div>
                        </div>
                        <div class="row" style="margin-top:5px;">
                            <div class="col-md-3">
                                <small><font color="red">*</font> <?= _r('Start Date', 'วันเริ่มต้น'); ?></small>
                                <input type="text" id="start_date_seasonal_price_modal" class="form-control" style="margin-top:-3px;" :value="convertDateSlash(edit_seasonal_price.start_date)">
                            </div>
                            <div class="col-md-3">
                                <small><font color="red">*</font> <?= _r('End Date', 'วันสิ้นสุด'); ?></small>
                                <input type="text" id="end_date_seasonal_price_modal" class="form-control" style="margin-top:-3px;" :value="convertDateSlash(edit_seasonal_price.end_date)">
                            </div>
                            <div class="col-md-3">
                                <small><font color="red">*</font> <?= _r('Season Repeat', 'ซ้ำทุกปี'); ?></small>
                                <select class="form-control" style="margin-top:-3px;" v-model="edit_seasonal_price.season_repeat">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <small><font color="red">*</font> <?= _r('Is Priority', 'ใช้ราคานี้ก่อนราคาอื่น'); ?></small>
                                <select class="form-control" style="margin-top:-3px;" v-model="edit_seasonal_price.is_priority">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top:5px;">
                            <div class="col-md-3">
                                <small><font color="red">*</font> <?= _r('Rate', 'ราคา'); ?></small>
                                <input type="number" class="form-control" style="margin-top:-3px;" v-model="edit_seasonal_price.rate">
                            </div>
                            <div class="col-md-3">
                                <small><font color="red">*</font> <?= _r('Mon Rate', 'ราคาวันจันทร์'); ?></small>
                                <input type="number" class="form-control" style="margin-top:-3px;" v-model="edit_seasonal_price.mon_rate">
                            </div>
                            <div class="col-md-3">
                                <small><font color="red">*</font> <?= _r('Tue Rate', 'ราคาวันอังคาร'); ?></small>
                                <input type="number" class="form-control" style="margin-top:-3px;" v-model="edit_seasonal_price.tue_rate">
                            </div>
                            <div class="col-md-3">
                                <small><font color="red">*</font> <?= _r('Wed Rate', 'ราคาวันพุธ'); ?></small>
                                <input type="number" class="form-control" style="margin-top:-3px;" v-model="edit_seasonal_price.wed_rate">
                            </div>
                        </div>
                        <div class="row" style="margin-top:5px;">
                            <div class="col-md-3">
                                <small><font color="red">*</font> <?= _r('Thu Rate', 'ราคาวันพฤหัส'); ?></small>
                                <input type="number" class="form-control" style="margin-top:-3px;" v-model="edit_seasonal_price.thu_rate">
                            </div>
                            <div class="col-md-3">
                                <small><font color="red">*</font> <?= _r('Fri Rate', 'ราคาวันศุกร์'); ?></small>
                                <input type="number" class="form-control" style="margin-top:-3px;" v-model="edit_seasonal_price.fri_rate">
                            </div>
                            <div class="col-md-3">
                                <small><font color="red">*</font> <?= _r('Sat Rate', 'ราคาวันเสาร์'); ?></small>
                                <input type="number" class="form-control" style="margin-top:-3px;" v-model="edit_seasonal_price.sat_rate">
                            </div>
                            <div class="col-md-3">
                                <small><font color="red">*</font> <?= _r('Sun Rate', 'ราคาวันอาทิตย์'); ?></small>
                                <input type="number" class="form-control" style="margin-top:-3px;" v-model="edit_seasonal_price.sun_rate">
                            </div>
                        </div>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;" @click="saveSeasonalPrice('update')"><?= _r('Update', 'แก้ไข'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12" style="overflow-x:auto;">
                    <span v-for="(m, i) in (room_type_info.id_room_type ? sub_menu : ['Room Type Info'])" :class="step == i+1 ? 'col-md-3 sub-menu active' : 'col-md-3 sub-menu'" @click="changeStep(i+1)">
                        <b>{{ m }}</b>
                    </span>
                </div>

                <!-- Room Type Info -->
                <div class="col-md-12" v-show="step == '1'">
                    <!-- Button trigger modal -->
                    <div class="col-md-11" style="margin-top:50px;">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Project', 'โปรเจกต์'); ?></small>
                                <select class="form-control" v-model="room_type_info.id_project_info">
                                    <option v-for="p in project_info" :value="p.id_project_info">{{ <?= _r('p.project_name_en', 'p.project_name_th'); ?> }}</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Status', 'สถานะ'); ?></small>
                                <select class="form-control" v-model="room_type_info.active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Room Type Name EN', 'ชื่อ Room Type (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" v-model="room_type_info.room_type_name_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Room Type Name TH', 'ชื่อ Room Type (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" v-model="room_type_info.room_type_name_th">
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Modular Type EN', 'ประเภท Modular (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" v-model="room_type_info.modular_type_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Modular Type TH', 'ประเภท Modular (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" v-model="room_type_info.modular_type_th">
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Room Type Detail EN', 'รายละเอียด Room Type (ภาษาอังกฤษ)'); ?></small>
                                <textarea rows="3" class="form-control" v-model="room_type_info.room_details_en"></textarea>
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Room Type Detail TH', 'รายละเอียด Room Type (ภาษาไทย)'); ?></small>
                                <textarea rows="3" class="form-control" v-model="room_type_info.room_details_th"></textarea>
                            </div>
                        </div>

                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Bathroom EN', 'ห้องน้ำ (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" v-model="room_type_info.bathroom_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Bathroom TH', 'ห้องน้ำ (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" v-model="room_type_info.bathroom_th">
                            </div>
                        </div>

                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><?= _r('Sofa EN', 'โซฟา (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" v-model="room_type_info.sofa_en">
                            </div>
                            <div class="col-md-6">
                                <small><?= _r('Sofa TH', 'โซฟา (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" v-model="room_type_info.sofa_th">
                            </div>
                        </div>

                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Area EN', 'พื้นที่ (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" v-model="room_type_info.area_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Area TH', 'พื้นที่ (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" v-model="room_type_info.area_th">
                            </div>
                        </div>

                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Include Breakfast', 'รวมอาหารเช้า'); ?></small>
                                <select class="form-control" v-model="room_type_info.include_breakfast">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Is Big Room?', 'เป็นห้องใหญ่หรือไม่?'); ?></small>
                                <select class="form-control" v-model="room_type_info.is_big_room">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Display Sequence', 'ลำดับการแสดง'); ?></small>
                                <input type="number" class="form-control" v-model="room_type_info.display_sequence">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Default Rate', 'ราคาห้อง'); ?></small>
                                <input type="number" class="form-control" v-model="room_type_info.default_rate">
                            </div>
                        </div>

                        <div class="row" style="margin-top:10px">
                            <div class="col-md-4">
                                <small><font color="red">*</font> <?= _r('# of Adult', 'จำนวนผู้ใหญ่'); ?></small>
                                <input type="number" class="form-control" v-model="room_type_info.number_of_adults">
                            </div>
                            <div class="col-md-4">
                                <small><font color="red">*</font> <?= _r('# of Children', 'จำนวนเด็ก'); ?></small>
                                <input type="number" class="form-control" v-model="room_type_info.number_of_children">
                            </div>
                            <div class="col-md-4">
                                <small><font color="red">*</font> <?= _r('Max Children Age', 'อายุเด็กสูงสุด'); ?></small>
                                <input type="number" class="form-control" v-model="room_type_info.max_children_age">
                            </div>
                        </div>

                        <?php if (has_permission('room_management', 'edit')) : ?>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;" @click="saveRoomTypeInfo()"><?= _r('Save', 'บันทึก'); ?></button>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-11" style="margin-top:50px; text-align:center;" v-if="room_type_info.id_room_type">
                        <u><b><?= _r('Upload Room Type Photos', 'อัพโหลดรูปภาพ Room Type'); ?></b></u><br><br>
                        <div class="row" style="border:1px solid black; background-color:#d9d9d9;">
                            <input type="hidden" id="url-image-input-0" v-model="room_type_photo[0].room_photo_url">
                            <input type="file" style="display:none;" class="image-input image-input-room-type" id="image-input-0" accept="image/jpeg, image/png, image/jpg">
                            <div class="col-md-12" style="text-align:right; position:absolute;"><?= _r('Main Photo', 'รูปภาพหลัก'); ?></div>
                            <div class="col-md-2" style="text-align:left;">
                                <span class="display-image" id="display-image-input-0">
                                    <img :src="room_type_photo[0].room_photo_url" style="margin-top:5px; height:78px;">
                                    <div><button style="background-color:black; color:white;" @click="uploadImage(0)">Browse...</button></div>
                                </span>
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="desc-image-input-0" style="width:100%; margin-right:5px; margin-top:40px;" v-model="room_type_photo[0].photo_desc_en">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="desc-th-image-input-0" style="width:100%; margin-right:5px; margin-top:40px;" v-model="room_type_photo[0].photo_desc_th">
                            </div>
                            <div class="col-md-2">
                                <input type="number" id="seq-image-input-0" style="width:100%; margin-right:5px; text-align:right; margin-top:40px;" v-model="room_type_photo[0].display_sequence" disabled>
                            </div>
                        </div>

                        <div class="row" style="background-color:#d9d9d9; margin-top:10px;">
                            <div class="col-md-2" style="text-align:left; padding-left:27px;"><?= _r('Photo', 'รูปภาพ'); ?></div>
                            <div class="col-md-4" style="text-align:center;"><?= _r('Description EN', 'รายละเอียด (ภาษาอังกฤษ)'); ?></div>
                            <div class="col-md-4" style="text-align:center;"><?= _r('Description TH', 'รายละเอียด (ภาษาไทย)'); ?></div>
                            <div class="col-md-2" style="text-align:center;"><?= _r('Photo Sequence', 'ลำดับรูปภาพ'); ?></div>
                        </div>
                        <?php if (has_permission('room_management', 'edit')) : ?>
                        <div class="row" style="margin-top:5px;">
                            <span class="col-md-12" style="text-align:right;">
                                <button class="btn btn-sm btn-secondary" style="width:78px; font-size:13px;" @click="addPhotoRoomType()"><?= _r('Add Photo', 'เพิ่มรูปภาพ'); ?></button>
                            </span>
                        </div>
                        <?php endif; ?>
                        <span v-for="(p, i) in room_type_photo">
                            <div class="row" v-if="i > 0">
                                <input type="hidden" :id="'url-image-input-'+ i" v-model="p.room_photo_url">
                                <input type="file" style="display:none;" class="image-input image-input-room-type" :id="'image-input-'+ i" accept="image/jpeg, image/png, image/jpg">
                                <div class="col-md-2" style="text-align:left;">
                                    <span class="display-image" :id="'display-image-input-'+ i">
                                        <img :src="p.room_photo_url" style="margin-top:5px; height:78px;">
                                        <div><button style="background-color:black; color:white;" @click="uploadImage(i)">Browse...</button></div>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" :id="'desc-image-input-'+ i" style="width:100%; margin-right:5px; margin-top:40px;" v-model="p.photo_desc_en">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" :id="'desc-th-image-input-'+ i" style="width:100%; margin-right:5px; margin-top:40px;" v-model="p.photo_desc_th">
                                </div>
                                <div class="col-md-1">
                                    <input type="number" :id="'seq-image-input-'+ i" style="width:100%; margin-right:5px; text-align:right; margin-top:40px;" v-model="p.display_sequence">
                                </div>
                                <div class="col-md-1">
                                    <?php if (has_permission('room_management', 'delete')) : ?>
                                    <button class="btn btn-sm btn-danger" style="padding:0px 5px 0px 5px; margin-top:42px;" @click="removePhotoRoomType(i)">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                                <hr style="width:100%;">
                            </div>
                        </span>
                        <?php if (has_permission('room_management', 'edit')) : ?>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;" @click="savePhotoRoomType()"><?= _r('Save', 'บันทึก'); ?></button>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Amenities -->
                <div class="col-md-12" v-show="step == '2'">
                    <div class="col-md-12" style="margin-top:50px;">
                        <div class="row">
                            <?php if (has_permission('room_management', 'view')) : ?>
                            <div class="col-md-12">
                                <button class="btn" data-toggle="modal" data-target="#amenityModal" style="float:right; width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;"><?= _r('Edit', 'จัดการ'); ?> Amenities</button>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div style="margin-top:-5px;">
                            <small><font color="#33cc33">* <?= _r('green color', 'สีเขียว'); ?></font> = is_featured</small>
                        </div>
                        <div class="row">
                            <span class="col-md-3" v-for="(a, i) in tmp_amenity" style="margin-top:20px;">
                                <input type="checkbox" class="form-control" style="width:17px; height:17px; display:inline-block; vertical-align:top;" @click="selectAmenity(a.id_amenities)" :checked='select_amenity[a.id_amenities]'
                                <?php if (!has_permission('room_management', 'edit')) : ?>disabled<?php endif; ?>>
                                <span style="width:calc(100% - 25px); display:inline-block; height:50px; font-size:14px; overflow:hidden; text-overflow:ellipsis; margin-left:5px; position:absolute; top:-2px;">
                                    <img :src="a.icon" style="width:20px;">
                                    <span :style="select_amenity[a.id_amenities] && select_amenity[a.id_amenities].is_featured ? 'color:#33cc33' : 'color:black'">{{ <?= _r('a.desc_en', 'a.desc_th'); ?> }}</span>
                                </span>
                            </span>
                        </div>

                    </div>
                </div>

                <!-- Rooms -->
                <div class="col-md-12" v-show="step == '3'">
                    <div class="col-md-11" style="margin-top:50px;">
                        <?php if (has_permission('room_management', 'edit')) : ?>
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Room Name EN', 'ชื่อห้อง (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" v-model="room_detail_add_row.room_name_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Room Name TH', 'ชื่อห้อง (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" v-model="room_detail_add_row.room_name_th">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <small><font color="red">*</font> <?= _r('Room Number', 'หมายเลขห้อง'); ?></small>
                                <input type="text" class="form-control" v-model="room_detail_add_row.room_number">
                            </div>
                            <div class="col-md-4">
                                <small>Tags</small>
                                <input type="text" class="form-control" v-model="room_detail_add_row.tags">
                            </div>
                            <div class="col-md-4">
                                <small><font color="red">*</font> <?= _r('Status', 'สถานะ'); ?></small>
                                <select class="form-control" v-model="room_detail_add_row.active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;" @click="addRoomDetail()"><?= _r('Add New', 'เพิ่มใหม่'); ?></button>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="row" style="overflow:auto; margin-top:40px">
                            <table style="min-width:600px; width:100%;">
                                <thead style="text-align:center;">
                                    <tr>
                                        <th style="width:30%;"><?= _r('Room Name EN', 'ชื่อห้อง (ภาษาอังกฤษ)'); ?></th>
                                        <th style="width:30%;"><?= _r('Room Name TH', 'ชื่อห้อง (ภาษาไทย)'); ?></th>
                                        <th style="width:20%;"><?= _r('Room Number', 'หมายเลขห้อง'); ?></th>
                                        <th style="width:10%;"><?= _r('Status', 'สถานะ'); ?></th>
                                        <?php if (has_permission('room_management', 'edit') || has_permission('room_management', 'delete')) : ?>
                                        <th style="width:10%; font-size:13px; font-weight:normal;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(r, i) in room_details">
                                        <td>{{ r.room_name_en }}</td>
                                        <td>{{ r.room_name_th }}</td>
                                        <td>{{ r.room_number }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-success" v-if="r.active == 1">Active</span>
                                            <span class="badge badge-danger" v-if="r.active == 0">Inactive</span>
                                        </td>
                                        <?php if (has_permission('room_management', 'edit') || has_permission('room_management', 'delete')) : ?>
                                        <td class="text-center">
                                            <?php if (has_permission('room_management', 'edit')) : ?>
                                            <button class="btn btn-sm btn-warning" @click="loadUpdateRoomDetail(i)">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <?php endif; ?>
                                            <?php if (has_permission('room_management', 'delete')) : ?>
                                            <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deleteRoomDetail(r.id_room_details)">
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

                <!-- Seasonal Price -->
                <div class="col-md-12" v-show="step == '4'">
                    <div class="col-md-11" style="margin-top:50px;">
                        <div class="row" style="margin-top:40px">
                            <?php if (has_permission('room_management', 'edit')) : ?>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <small><font color="red">*</font> Title <?= _r('EN', '(ภาษาอังกฤษ)'); ?></small>
                                        <input type="text" class="form-control" style="margin-top:-3px;" v-model="seasonal_price[0].title_en">
                                    </div>
                                    <div class="col-md-6">
                                        <small><font color="red">*</font> Title <?= _r('TH', '(ภาษาไทย)'); ?></small>
                                        <input type="text" class="form-control" style="margin-top:-3px;" v-model="seasonal_price[0].title_th">
                                    </div>
                                </div>
                                <div class="row" style="margin-top:5px;">
                                    <div class="col-md-3">
                                        <small><font color="red">*</font> <?= _r('Start Date', 'วันเริ่มต้น'); ?></small>
                                        <input type="text" id="start_date_seasonal_price" class="form-control" style="margin-top:-3px;" :value="convertDateSlash(seasonal_price[0].start_date)">
                                    </div>
                                    <div class="col-md-3">
                                        <small><font color="red">*</font> <?= _r('End Date', 'วันสิ้นสุด'); ?></small>
                                        <input type="text" id="end_date_seasonal_price" class="form-control" style="margin-top:-3px;" :value="convertDateSlash(seasonal_price[0].end_date)">
                                    </div>
                                    <div class="col-md-3">
                                        <small><font color="red">*</font> <?= _r('Season Repeat', 'ซ้ำทุกปี'); ?></small>
                                        <select class="form-control" style="margin-top:-3px;" v-model="seasonal_price[0].season_repeat">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <small><font color="red">*</font> <?= _r('Is Priority', 'ใช้ราคานี้ก่อนราคาอื่น'); ?></small>
                                        <select class="form-control" style="margin-top:-3px;" v-model="seasonal_price[0].is_priority">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" style="margin-top:5px;">
                                    <div class="col-md-3">
                                        <small><font color="red">*</font> <?= _r('Rate', 'ราคา'); ?></small>
                                        <input type="number" class="form-control" style="margin-top:-3px;" v-model="seasonal_price[0].rate">
                                    </div>
                                    <div class="col-md-3">
                                        <small><font color="red">*</font> <?= _r('Mon Rate', 'ราคาวันจันทร์'); ?></small>
                                        <input type="number" class="form-control" style="margin-top:-3px;" v-model="seasonal_price[0].mon_rate">
                                    </div>
                                    <div class="col-md-3">
                                        <small><font color="red">*</font> <?= _r('Tue Rate', 'ราคาวันอังคาร'); ?></small>
                                        <input type="number" class="form-control" style="margin-top:-3px;" v-model="seasonal_price[0].tue_rate">
                                    </div>
                                    <div class="col-md-3">
                                        <small><font color="red">*</font> <?= _r('Wed Rate', 'ราคาวันพุธ'); ?></small>
                                        <input type="number" class="form-control" style="margin-top:-3px;" v-model="seasonal_price[0].wed_rate">
                                    </div>
                                </div>
                                <div class="row" style="margin-top:5px;">
                                    <div class="col-md-3">
                                        <small><font color="red">*</font> <?= _r('Thu Rate', 'ราคาวันพฤหัส'); ?></small>
                                        <input type="number" class="form-control" style="margin-top:-3px;" v-model="seasonal_price[0].thu_rate">
                                    </div>
                                    <div class="col-md-3">
                                        <small><font color="red">*</font> <?= _r('Fri Rate', 'ราคาวันศุกร์'); ?></small>
                                        <input type="number" class="form-control" style="margin-top:-3px;" v-model="seasonal_price[0].fri_rate">
                                    </div>
                                    <div class="col-md-3">
                                        <small><font color="red">*</font> <?= _r('Sat Rate', 'ราคาวันเสาร์'); ?></small>
                                        <input type="number" class="form-control" style="margin-top:-3px;" v-model="seasonal_price[0].sat_rate">
                                    </div>
                                    <div class="col-md-3">
                                        <small><font color="red">*</font> <?= _r('Sun Rate', 'ราคาวันอาทิตย์'); ?></small>
                                        <input type="number" class="form-control" style="margin-top:-3px;" v-model="seasonal_price[0].sun_rate">
                                    </div>
                                </div>
                                <div class="row" style="margin-top:15px">
                                    <div class="col-md-12" style="text-align:center">
                                        <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;" @click="saveSeasonalPrice('add')"><?= _r('Add New', 'เพิ่มใหม่'); ?></button>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div style="width:100%; overflow:auto;">
                                <table style="min-width:600px; width:100%; margin-top:40px;">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th style="width:100px;"><?= _r('Start Date', 'วันเริ่มต้น'); ?></th>
                                            <th style="width:100px;"><?= _r('End Date', 'วันสิ้นสุด'); ?></th>
                                            <th style="width:100px;"><?= _r('Season Repeat', 'ซ้ำทุกปี'); ?></th>
                                            <th style="width:100px;"><?= _r('Is Priority', 'ใช้ราคานี้ก่อนราคาอื่น'); ?></th>
                                            <th style="width:100px;"><?= _r('Rate', 'ราคา'); ?></th>
                                            <th style="width:100px; font-size:13px; font-weight:normal;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="p in shift_json(seasonal_price)">
                                            <td class="text-left">{{ <?= _r('p.title_en', 'p.title_th'); ?> }}</td>
                                            <td class="text-center">{{ convertDateSlash(p.start_date) }}</td>
                                            <td class="text-center">{{ convertDateSlash(p.end_date) }}</td>
                                            <td class="text-center">
                                                <span class="badge badge-success" v-if="p.season_repeat == 1">Yes</span>
                                                <span class="badge badge-danger" v-if="p.season_repeat == 0">No</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-success" v-if="p.is_priority == 1">Yes</span>
                                                <span class="badge badge-danger" v-if="p.is_priority == 0">No</span>
                                            </td>
                                            <td class="text-right">{{ formatBaht(p.rate) }}</td>
                                            <td class="text-center">
                                                <?php if (has_permission('room_management', 'edit')) : ?>
                                                <button class="btn btn-sm btn-warning" @click="loadEditSeasonalPrice(p.id_seasonal_price)">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <?php endif; ?>
                                                <?php if (has_permission('room_management', 'delete')) : ?>
                                                <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deleteSeasonalPrice(p.id_seasonal_price)">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
            menu: '<?php echo empty($room_type_info['id_room_type']) ? _r("Add Room Type", "เพิ่ม Room Type") : _r("Update Room Type", "แก้ไข Room Type"); ?>',
            step: '<?php echo empty($room_type_info['id_room_type']) ? 1 : $step; ?>',
            sub_menu: ['Room Type Info', 'Amenities', 'Rooms', 'Seasonal Price'],
            edit_amenity: {},
            tmp_amenity: {},
            amenity: <?php echo empty($amenity) ? '{}' : json_encode($amenity); ?>,
            select_amenity: <?php echo empty($select_amenity) ? '{}' : json_encode($select_amenity); ?>,
            room_type_info: <?php echo empty($room_type_info) ? '{}' : json_encode($room_type_info); ?>,
            project_info: <?php echo empty($project_info) ? '{}' : json_encode($project_info); ?>,
            room_type_photo: <?php echo empty($room_type_photo) ? '{}' : json_encode($room_type_photo); ?>,
            room_type_photo_blank_row: <?php echo empty($room_type_photo_blank_row) ? '{}' : json_encode($room_type_photo_blank_row); ?>,
            edit_seasonal_price: {},
            seasonal_price: <?php echo empty($seasonal_price) ? '{}' : json_encode($seasonal_price); ?>,
            room_details: <?php echo empty($room_details) ? '{}' : json_encode($room_details); ?>,
            room_detail_add_row: <?php echo empty($room_detail_blank_row) ? '{}' : json_encode($room_detail_blank_row); ?>,
            room_detail_update_row: <?php echo empty($room_detail_blank_row) ? '{}' : json_encode($room_detail_blank_row); ?>
        },
        mounted() {
            let self = this;
            self.tmp_amenity = JSON.parse(JSON.stringify(shift_json(self.amenity)));

            $("#start_date_seasonal_price").datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function(d) {
                    self.seasonal_price[0].start_date = convertDateDash(d);
                }
            });
            $("#end_date_seasonal_price").datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function(d) {
                    self.seasonal_price[0].end_date =  convertDateDash(d);
                }
            });
            $("#start_date_seasonal_price_modal").datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function(d) {
                    self.edit_seasonal_price.start_date =  convertDateDash(d);
                }
            });
            $("#end_date_seasonal_price_modal").datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function(d) {
                    self.edit_seasonal_price.end_date =  convertDateDash(d);
                }
            });

            $("#amenityTable").DataTable();
        },
        methods: {
            changeStep: function(v) {
                this.step = v;
            },
            uploadImage: function(id) {
                $('#image-input-'+ id).trigger('click');
            },
            saveRoomTypeInfo: function() {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.room_type_info);
                keys.forEach((v) => {
                    if (valid && !['id_room_type', 'sofa_en', 'sofa_th', 'date_created'].includes(v) && self.room_type_info[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                //
                $.post("<?php echo save_room_type_url(); ?>", this.room_type_info, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Save Room Type Success');
                        location.href = "<?php echo edit_room_type_url(); ?>"+ res.message;
                    }
                });
            },
            loadEditSeasonalPrice: function(id) {
                let self = this;
                this.seasonal_price.forEach((v) => {
                    if (v.id_seasonal_price == id) {
                        self.edit_seasonal_price = JSON.parse(JSON.stringify(v));
                    }
                });
                $('#editSeasonalPriceModal').modal('show');
            },
            deleteSeasonalPrice: function(id) {
                let self = this;
                if (confirm("Delete this Seasonal Price Info ?")) {
                    let param = {'id': id};
                    $.post("<?php echo delete_seasonal_price_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                            return;
                        } else {
                            alert('Delete Seasonal Price Success');
                            location.href = "<?php echo edit_room_type_url(); ?>"+ self.room_type_info.id_room_type +"?step="+ self.step;
                        }
                    });
                }
            },
            saveSeasonalPrice: function(action) {
                let self = this;
                var valid = true;
                var input = action == 'add' ? this.seasonal_price[0] : this.edit_seasonal_price;

                var keys = Object.keys(input);
                keys.forEach((v) => {
                    if (valid && v != 'id_room_type' && input[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                if (input.start_date > input.end_date) {
                    alert("Start Date  must less than  End Date");
                    return;
                }
                if (dateDiff(input.start_date, input.end_date) >= 365) {
                    alert("Date Range is too long");
                    return;
                }

                //
                input.id_room_type = this.room_type_info.id_room_type;
                $.post("<?php echo save_seasonal_price_url(); ?>", input, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Save Seasonal Price Success');
                        location.href = "<?php echo edit_room_type_url(); ?>"+ self.room_type_info.id_room_type +"?step="+ self.step;
                    }
                });
            },
            addPhotoRoomType: function() {
                tmp = JSON.parse(JSON.stringify(this.room_type_photo_blank_row));
                this.room_type_photo.push(tmp);
            },
            removePhotoRoomType: function(id) {
                tmp = [];
                this.room_type_photo.forEach((v, i) => {
                    if (i != id) {
                        tmp.push(JSON.parse(JSON.stringify(v)));
                    }
                });
                this.room_type_photo = JSON.parse(JSON.stringify(tmp));
            },
            savePhotoRoomType: function() {
                let self = this;

                let valid = true;
                tmp = JSON.parse(JSON.stringify(this.room_type_photo));
                tmp.forEach((row, i) => {
                    let keys = Object.keys(row);
                    keys.forEach((k, j) => {
                        if (valid && k != 'id_room_type_photo' && !row[k]) {
                            valid = false;
                            alert('Empty '+ k +' (row '+ (i+1) +')');
                        }

                        if (valid && i > 0 && k == 'display_sequence' && row[k] <= 1) {
                            valid = false;
                            alert('Invalid display_sequence (row '+ (i+1) +')');
                        }
                    });
                });

                if (!valid) {
                    return;
                }

                //
                let param = {
                    'id_room_type': this.room_type_info.id_room_type,
                    'room_type_photo': tmp
                };

                $.post("<?php echo save_room_type_photo_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Save Room Type Photo Success');
                        location.href = "<?php echo edit_room_type_url(); ?>"+ self.room_type_info.id_room_type +"?step="+ self.step;
                    }
                });
            },
            loadEditAmenity: function(id) {
                let self = this;
                this.amenity.forEach((v) => {
                    if (v.id_amenities == id) {
                        self.edit_amenity = JSON.parse(JSON.stringify(v));
                    }
                });
                $('#editAmenityModal').modal('show');
            },
            deleteAmenity: function(id) {
                let self = this;
                if (confirm("Delete this Amenity ?")) {
                    let param = {'id': id};
                    $.post("<?php echo delete_amenity_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                            return;
                        } else {
                            alert('Delete Amenity Success');
                            location.href = "<?php echo edit_room_type_url(); ?>"+ self.room_type_info.id_room_type +"?step="+ self.step;
                        }
                    });
                }
            },
            saveAmenity: function() {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.edit_amenity);
                keys.forEach((v) => {
                    if (valid && self.edit_amenity[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                if (this.edit_amenity.icon == '<?php echo site_url(); ?>asset/image/upload.jpg') {
                    alert("Empty Icon");
                    return;
                }

                //
                console.log(this.edit_amenity);
                $.post("<?php echo save_amenity_url(); ?>", this.edit_amenity, function(res) {
                    console.log(res);
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Save Amenity Success');
                        location.href = "<?php echo edit_room_type_url(); ?>"+ self.room_type_info.id_room_type +"?step="+ self.step;
                    }
                });
            },
            selectAmenity: function(id) {
                let self = this;

                let is_featured = 0;
                let action = 'Select';
                if (!this.select_amenity[id]) {
                    if (confirm('Is Featured ?\n(OK = "yes", Cancel = "no")')) {
                        is_featured = 1;
                    }

                    this.select_amenity[id] = {
                        'id_amenities': id,
                        'id_room_type': this.room_type_info.id_room_type,
                        'is_featured': is_featured
                    };
                } else {
                    action = 'Remove';
                    this.select_amenity[id] = false;
                }
                this.tmp_amenity = JSON.parse(JSON.stringify(shift_json(this.amenity)));

                let param = {
                    'id_room_type': this.room_type_info.id_room_type,
                    'id_amenities': id,
                    'is_featured': is_featured
                };

                $.post("<?php echo select_amenity_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                    } else {
                        alert(action +' Amenity Success');
                    }
                });
            },
            addRoomDetail: function() {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.room_detail_add_row);
                keys.forEach((v) => {
                    if (valid && self.room_detail_add_row[v] === '' && v != 'tags') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                //
                let param = {'room_detail': this.room_detail_add_row};
                $.post("<?php echo save_room_detail_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Add Room Detail Success');
                        location.href = "<?php echo edit_room_type_url(); ?>"+ self.room_type_info.id_room_type +"?step="+ self.step;
                    }
                });
            },
            loadUpdateRoomDetail: function(id) {
                this.room_detail_update_row = JSON.parse(JSON.stringify(this.room_details[id]));
                $('#updateRoomDetailModal').modal('show');
            },
            updateRoomDetail: function(id) {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.room_detail_update_row);
                keys.forEach((v) => {
                    if (valid && self.room_detail_update_row[v] === '' && v != 'tags') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                //
                let param = {'room_detail': this.room_detail_update_row};
                $.post("<?php echo save_room_detail_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Update Room Detail Success');
                        location.href = "<?php echo edit_room_type_url(); ?>"+ self.room_type_info.id_room_type +"?step="+ self.step;
                    }
                });
            },
            deleteRoomDetail: function(id) {
                let self = this;
                if (confirm("Delete this Room Detail ?")) {
                    let param = {'id': id};
                    $.post("<?php echo delete_room_detail_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                            return;
                        } else {
                            alert('Delete Room Detail Success');
                            location.href = "<?php echo edit_room_type_url(); ?>"+ self.room_type_info.id_room_type +"?step="+ self.step;
                        }
                    });
                }
            }
        }
    });

    $(document).on('change', '.image-input', function() {
        let self = $(this);
        let id = $(this).attr('id');

        const reader = new FileReader();
        reader.addEventListener("load", () => {
            const uploaded_image = reader.result;

            if (self.hasClass('image-input-amenity')) {
                app.edit_amenity.icon = uploaded_image;
            } else if (self.hasClass('image-input-room-type')) {
                let ids = id.split('-');
                app.room_type_photo[ids[ids.length - 1]].room_photo_url = uploaded_image;
            }
        });
        reader.readAsDataURL(this.files[0]);
    });
});
</script>