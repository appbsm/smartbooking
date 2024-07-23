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
                            <a href="<?php echo project_management_url(); ?>"><?= _r('Project Management', 'ตั้งค่าโปรเจกต์'); ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo edit_project_url($project_info['id_project_info']); ?>">{{ menu }}<?php echo $project_info['id_project_info'] ? (' ('. $project_info['project_name_en'] .')') : ''; ?></a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="businessModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="height:90vh;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1"><?= _r('Edit Business', 'จัดการบริษัท'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <?php if (has_permission('project_management', 'edit')) : ?>
                    <button class="btn btn-sm" style="float:right; font-size:13px; background-color:#809f4e; color:white; margin-bottom:20px;" @click="loadEditBusiness(0)"><?= _r('Add New Business', 'เพิ่มบริษัทใหม่'); ?></button>
                    <?php endif; ?>
                    <div style="width:100%; overflow:auto;">
                        <table style="min-width:550px; margin-left:5%; width:90%;">
                            <thead>
                                <tr>
                                    <th><?= _r('Business Name', 'ชื่อบริษัท'); ?></th>
                                    <th style="width:120px;"><?= _r('Phone Number', 'เบอร์โทรบริษัท'); ?></th>
                                    <?php if (has_permission('project_management', 'edit') || has_permission('project_management', 'delete')) : ?>
                                    <th style="width:100px; font-size:13px; font-weight:normal;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="b in shift_json(business_info)">
                                    <td>{{ <?= _r('b.business_name_en', 'b.business_name_th'); ?> }}</td>
                                    <td class="text-right">{{ b.phone_number }}</td>
                                    <?php if (has_permission('project_management', 'edit') || has_permission('project_management', 'delete')) : ?>
                                    <td class="text-center">
                                        <?php if (has_permission('project_management', 'edit')) : ?>
                                        <button class="btn btn-sm btn-warning" @click="loadEditBusiness(b.id_business_info)">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <?php endif; ?>
                                        <?php if (has_permission('project_management', 'delete')) : ?>
                                        <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deleteBusiness(b.id_business_info)">
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
    </div>
    <div class="modal fade" id="editBusinessModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="height:90vh; overflow-y:auto;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">{{ edit_business_info.id_business_info == 0 ? '<?= _r("Add", "เพิ่ม"); ?>' : '<?= _r("Update", "แก้ไข"); ?>' }} <?= _r('Business', 'บริษัท'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <div class="col-md-11">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Business Name EN', 'ชื่อบริษัท (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_business_info.business_name_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Business Name TH', 'ชื่อบริษัท (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_business_info.business_name_th">
                            </div>
                        </div>
                        <div class="row" style="margin-top:5px;">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Business Address EN', 'ที่อยู่บริษัท (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_business_info.business_address_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Business Address TH', 'ที่อยู่บริษัท (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_business_info.business_address_th">
                            </div>
                        </div>
                        <div class="row" style="margin-top:5px;">
                            <div class="col-md-4">
                                <small><font color="red">*</font> <?= _r('Business TAX ID', 'หมายเลขประจำตัวผู้เสียภาษีบริษัท'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_business_info.business_tax_id">
                            </div>
                            <div class="col-md-4">
                                <small><font color="red">*</font> <?= _r('Business Phone Number', 'เบอร์โทรบริษัท'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_business_info.phone_number">
                            </div>
                            <div class="col-md-4">
                                <small><font color="red">*</font> <?= _r('Business Email', 'อีเมลบริษัท'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_business_info.email">
                            </div>
                        </div>
                        <div class="row" style="margin-top:5px;">
                            <div class="col-md-12">
                                <input type="hidden" id="url-image-input-business" v-model="edit_business_info.logo">
                                <input type="file" style="display:none;" class="image-input image-input-business" id="image-input-business" accept="image/jpeg, image/png, image/jpg">
                                <div style="width:150px !important;">
                                    <small><font color="red">*</font> <?= _r('Business Logo', 'โลโก้บริษัท'); ?></small>
                                    <div class="display-image" id="display-image-input-business">
                                        <img :src="edit_business_info.logo" style="margin-top:-1px; height:77px;">
                                    </div>
                                </div>
                                <div style="width:150px !important;">
                                    <button style="background-color:black; color:white;" @click="uploadImage('business')">Browse...</button>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;" @click="saveBusinessInfo()">{{ edit_business_info.id_business_info == 0 ? '<?= _r("Add", "เพิ่ม"); ?>' : '<?= _r("Update", "แก้ไข"); ?>' }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updatePointOfInterestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="overflow-y:auto;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3"><?= _r('Update Point of Interest', 'แก้ไข Point of Interest'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5">
                                <small><font color="red">*</font> Title <?= _r('EN', '(ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="point_of_interest_update_row.location_name_en">
                            </div>
                            <div class="col-md-5">
                                <small><font color="red">*</font> Title <?= _r('TH', '(ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="point_of_interest_update_row.location_name_th">
                            </div>
                            <div class="col-md-2">
                                <small><font color="red">*</font> <?= _r('Distance', 'ระยะทาง'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="point_of_interest_update_row.distance_km">
                            </div>
                        </div>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;" @click="updatePointOfInterest()"><?= _r('Update', 'แก้ไข'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="facilityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="height:94vh;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4"><?= _r('Edit', 'จัดการ'); ?> Facilities</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <?php if (has_permission('project_management', 'edit')) : ?>
                    <button class="btn btn-sm" style="float:right; font-size:13px; background-color:#809f4e; color:white; margin-bottom:20px;" @click="loadEditFacility(0)"><?= _r('Add New Facility', 'เพิ่ม Facility ใหม่'); ?></button>
                    <?php endif; ?>
                    <table id="facilityTable" class="display" style="width:99%;">
                        <thead>
                            <tr>
                                <th><?= _r('Icon', 'ไอคอน'); ?></th>
                                <th style="width:200px;"><?= _r('Short Desc', 'รายละเอียดย่อ'); ?></th>
                                <?php if (has_permission('project_management', 'edit') || has_permission('project_management', 'delete')) : ?>
                                <th style="font-size:13px; font-weight:normal;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="f in shift_json(project_facility)">
                                <td style="text-align:center;"><img style="width:50px;" :src="f.icon"></td>
                                <td style="text-align:left;">{{ <?= _r('f.short_desc_en', 'f.short_desc_th'); ?> }}</td>
                                <?php if (has_permission('project_management', 'edit') || has_permission('project_management', 'delete')) : ?>
                                <td style="text-align:center;">
                                    <?php if (has_permission('project_management', 'edit')) : ?>
                                    <button class="btn btn-sm btn-warning" @click="loadEditFacility(f.id_property_facility)">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <?php endif; ?>
                                    <?php if (has_permission('project_management', 'delete')) : ?>
                                    <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deleteFacility(f.id_property_facility)">
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
    <div class="modal fade" id="editFacilityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel5" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="height:94vh; overflow-y:auto;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel5">{{ edit_facility.id_property_facility == 0 ? '<?= _r("Add", "เพิ่ม"); ?>' : '<?= _r("Update", "แก้ไข"); ?>' }} Facility</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <div class="col-md-11">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Short Description EN', 'รายละเอียดย่อ (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_facility.short_desc_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Short Description TH', 'รายละเอียดย่อ (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_facility.short_desc_th">
                            </div>
                        </div>
                        <div class="row" style="margin-top:5px;">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Long Description EN', 'รายละเอียดเต็ม (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_facility.long_desc_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Long Description TH', 'รายละเอียดเต็ม (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_facility.long_desc_th">
                            </div>
                        </div>
                        <div class="row" style="margin-top:5px;">
                            <div class="col-md-12">
                                <input type="hidden" id="url-image-input-facility" v-model="edit_facility.icon">
                                <input type="file" style="display:none;" class="image-input image-input-facility" id="image-input-facility" accept="image/jpeg, image/png, image/jpg">
                                <div style="width:150px !important;">
                                    <small><font color="red">*</font> <?= _r('Icon', 'ไอคอน'); ?></small><br>
                                    <span class="display-image" id="display-image-input-facility" style="margin-top:-3px;">
                                        <img :src="edit_facility.icon" style="margin-top:-1px; height:77px;">
                                    </span>
                                </div>
                                <div style="width:150px !important;">
                                    <button style="background-color:black; color:white;" @click="uploadImage('facility')">Browse...</button>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;" @click="saveFacility()">{{ edit_facility.id_property_facility == 0 ? '<?= _r("Add", "เพิ่ม"); ?>' : '<?= _r("Update", "แก้ไข"); ?>' }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updatePolicyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel6" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="overflow-y:auto;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel6"><?= _r('Update Policy', 'แก้ไขนโยบาย'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Policy Type EN', 'ชื่อนโยบาย (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="policy_update_row.policy_type_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Description EN', 'รายละเอียด (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="policy_update_row.description_en">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Policy Type TH', 'ชื่อนโยบาย (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="policy_update_row.policy_type_th">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Description TH', 'รายละเอียด (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="policy_update_row.description_th">
                            </div>
                        </div>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;" @click="updatePolicy()"><?= _r('Update', 'แก้ไข'); ?></button>
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
                    <span v-for="(m, i) in (project_info.id_project_info ? sub_menu : ['Project Info'])" :class="step == i+1 ? 'col-md-3 sub-menu active' : 'col-md-3 sub-menu'" @click="changeStep(i+1)">
                        <b>{{ m }}</b>
                    </span>
                </div>

                <!-- Project Info -->
                <div class="col-md-12" v-show="step == '1'">
                    <!-- Button trigger modal -->
                    <?php if (has_permission('project_management', 'view')) : ?>
                    <button class="btn" data-toggle="modal" data-target="#businessModal" style="float:right; width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;"><?= _r('Edit Business', 'จัดการบริษัท'); ?></button>
                    <?php endif; ?>
                    <div class="col-md-11" style="margin-top:50px;">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Project Name EN', 'ชื่อโปรเจกต์ (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.project_name_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Project Name TH', 'ชื่อโปรเจกต์ (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.project_name_th">
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-12">
                                <small><font color="red">*</font> <?= _r('Business', 'บริษัท'); ?></small>
                                <select class="form-control" v-model="project_info.id_business_info">
                                    <option v-for="b in shift_json(business_info)" :value="b.id_business_info">{{ <?= _r('b.business_name_en' ,'b.business_name_th'); ?> }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Overview EN', 'ภาพรวม (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.overview_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Overview TH', 'ภาพรวม (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.overview_th">
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Latitude', 'ละติจูด'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.latitude">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Longitude', 'ลองจิจูด'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.longitude">
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Map Link', 'ลิงก์แผนที่'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.map_url">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Email', 'อีเมล'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.email">
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Facebook URL', 'ลิงก์เฟสบุ๊ค'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.facebook_url">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Line ID', 'ไอดีไลน์'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.line_id">
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Address Line 1 EN', 'ที่อยู่ Line 1 (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.address_1_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Address Line 1 TH', 'ที่อยู่ Line 1 (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.address_1_th">
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Sub District EN', 'แขวง/ตำบล (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.subdistrict_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Sub District TH', 'แขวง/ตำบล (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.subdistrict_th">
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('District EN', 'เขต/อำเภอ (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.district_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('District TH', 'เขต/อำเภอ (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.district_th">
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Province EN', 'จังหวัด (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.province_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Province TH', 'จังหวัด (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.province_th">
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Country EN', 'ประเทศ (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.country_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Country TH', 'ประเทศ (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.country_th">
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Post Code', 'รหัสไปรษณีย์'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.postcode">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Phone Number', 'เบอร์โทร'); ?></small>
                                <input type="text" class="form-control" v-model="project_info.phone_number">
                            </div>
                        </div>
                        <?php if (has_permission('project_management', 'edit')) : ?>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;" @click="saveProjectInfo()"><?= _r('Save', 'บันทึก'); ?></button>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-11" style="margin-top:50px; text-align:center;" v-if="project_info.id_project_info">
                        <u><b><?= _r('Upload Project Photos', 'อัพโหลดรูปภาพโปรเจกต์'); ?></b></u><br><br>
                        <div class="row" style="border:1px solid black; background-color:#d9d9d9;">
                            <input type="hidden" id="url-image-input-0" v-model="project_photos[0].project_photo_url">
                            <input type="file" style="display:none;" class="image-input image-input-project" id="image-input-0" accept="image/jpeg, image/png, image/jpg">
                            <div class="col-md-12" style="text-align:right; position:absolute;"><?= _r('Main Photo', 'รูปภาพหลัก'); ?></div>
                            <div class="col-md-2" style="text-align:left;">
                                <span class="display-image" id="display-image-input-0">
                                    <img :src="project_photos[0].project_photo_url" style="margin-top:5px; height:78px;">
                                    <div><button style="background-color:black; color:white;" @click="uploadImage(0)">Browse...</button></div>
                                </span>
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="desc-image-input-0" style="width:100%; margin-right:5px; margin-top:40px;" v-model="project_photos[0].photo_desc_en">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="desc-th-image-input-0" style="width:100%; margin-right:5px; margin-top:40px;" v-model="project_photos[0].photo_desc_th">
                            </div>
                            <div class="col-md-2">
                                <input type="number" id="seq-image-input-0" style="width:100%; margin-right:5px; text-align:right; margin-top:40px;" v-model="project_photos[0].display_sequence" disabled>
                            </div>
                        </div>

                        <div class="row" style="background-color:#d9d9d9; margin-top:10px;">
                            <div class="col-md-2" style="text-align:left; padding-left:27px;"><?= _r('Photo', 'รูปภาพ'); ?></div>
                            <div class="col-md-4" style="text-align:center;"><?= _r('Description EN', 'รายละเอียด (ภาษาอังกฤษ)'); ?></div>
                            <div class="col-md-4" style="text-align:center;"><?= _r('Description TH', 'รายละเอียด (ภาษาไทย)'); ?></div>
                            <div class="col-md-2" style="text-align:center;"><?= _r('Photo Sequence', 'ลำดับรูปภาพ'); ?></div>
                        </div>
                        <?php if (has_permission('project_management', 'edit')) : ?>
                        <div class="row" style="margin-top:5px;">
                            <span class="col-md-12" style="text-align:right;">
                                <button class="btn btn-sm btn-secondary" style="width:78px; font-size:13px;" @click="addPhotoProject()"><?= _r('Add Photo', 'เพิ่มรูปภาพ'); ?></button>
                            </span>
                        </div>
                        <?php endif; ?>
                        <span v-for="(p, i) in project_photos">
                            <div class="row" v-if="i > 0">
                                <input type="hidden" :id="'url-image-input-'+ i" v-model="p.project_photo_url">
                                <input type="file" style="display:none;" class="image-input image-input-project" :id="'image-input-'+ i" accept="image/jpeg, image/png, image/jpg">
                                <div class="col-md-2" style="text-align:left;">
                                    <span class="display-image" :id="'display-image-input-'+ i">
                                        <img :src="p.project_photo_url" style="margin-top:5px; height:78px;">
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
                                    <?php if (has_permission('project_management', 'delete')) : ?>
                                    <button class="btn btn-sm btn-danger" style="padding:0px 5px 0px 5px; margin-top:42px;" @click="removePhotoProject(i)">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                                <hr style="width:100%;">
                            </div>
                        </span>
                        <?php if (has_permission('project_management', 'edit')) : ?>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;" @click="savePhotoProject()"><?= _r('Save', 'บันทึก'); ?></button>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Point of Interest -->
                <div class="col-md-12" v-show="step == '2'">
                    <div class="col-md-11" style="margin-top:50px;">
                        <?php if (has_permission('project_management', 'edit')) : ?>
                        <div class="row">
                            <div class="col-md-5">
                                <small><font color="red">*</font> Title <?= _r('EN', '(ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" v-model="point_of_interest_add_row.location_name_en">
                            </div>
                            <div class="col-md-5">
                                <small><font color="red">*</font> Title <?= _r('TH', '(ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" v-model="point_of_interest_add_row.location_name_th">
                            </div>
                            <div class="col-md-2">
                                <small><font color="red">*</font> <?= _r('Distance', 'ระยะทาง'); ?></small>
                                <input type="text" class="form-control" v-model="point_of_interest_add_row.distance_km">
                            </div>
                        </div>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;" @click="addPointOfInterest()"><?= _r('Add New', 'เพิ่มใหม่'); ?></button>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="row" style="overflow:auto; margin-top:40px">
                            <table style="min-width:500px; width:100%;">
                                <thead style="text-align:center;">
                                    <tr>
                                        <th style="width:40%;">Title <?= _r('EN', '(ภาษาอังกฤษ)'); ?></th>
                                        <th style="width:40%;">Title <?= _r('TH', '(ภาษาไทย)'); ?></th>
                                        <th style="width:10%;"><?= _r('Distance', 'ระยะทาง'); ?></th>
                                        <?php if (has_permission('project_management', 'edit') || has_permission('project_management', 'delete')) : ?>
                                        <th style="width:10%; font-size:13px; font-weight:normal;">Action</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(p, i) in point_of_interest">
                                        <td>{{ p.location_name_en }}</td>
                                        <td>{{ p.location_name_th }}</td>
                                        <td class="text-right">{{ p.distance_km }}</td>

                                        <?php if (has_permission('project_management', 'edit') || has_permission('project_management', 'delete')) : ?>
                                        <td class="text-center">
                                            <?php if (has_permission('project_management', 'edit')) : ?>
                                            <button class="btn btn-sm btn-warning" @click="loadUpdatePointOfInterest(i)">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <?php endif; ?>
                                            <?php if (has_permission('project_management', 'delete')) : ?>
                                            <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deletePointOfInterest(p.id_project_location)">
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

                <!-- Property Facilities -->
                <div class="col-md-12" v-show="step == '3'">
                    <div class="col-md-12" style="margin-top:50px;">
                        <div class="row">
                            <?php if (has_permission('project_management', 'view')) : ?>
                            <div class="col-md-12">
                                <button class="btn" data-toggle="modal" data-target="#facilityModal" style="float:right; width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;"><?= _r('Edit Facilities', 'จัดการ Facilities'); ?></button>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div style="margin-top:-5px;">
                            <small><font color="#33cc33">* <?= _r('green color', 'สีเขียว'); ?></font> = is_featured</small>
                        </div>
                        <div class="row">
                            <span class="col-md-3" v-for="(f, i) in tmp_project_facility" style="margin-top:20px;">
                                <input type="checkbox" class="form-control" style="width:17px; height:17px; display:inline-block; vertical-align:top;" @click="selectFacility(f.id_property_facility)" :checked='select_facility[f.id_property_facility]'
                                <?php if (!has_permission('project_management', 'edit')) : ?>disabled<?php endif; ?>>
                                <span style="width:calc(100% - 25px); display:inline-block; height:50px; font-size:14px; overflow:hidden; text-overflow:ellipsis; margin-left:5px; position:absolute; top:-2px;">
                                    <img :src="f.icon" style="width:20px;">
                                    <span :style="select_facility[f.id_property_facility] && select_facility[f.id_property_facility].is_featured ? 'color:#33cc33' : 'color:black'">{{ <?= _r('f.short_desc_en', 'f.short_desc_th'); ?> }}</span>
                                </span>
                            </span>
                        </div>

                    </div>
                </div>

                <!-- Project Highlights -->
                <div class="col-md-12" v-show="step == '4'">
                    <div class="col-md-11" style="margin-top:50px; text-align:center;" v-if="project_info.id_project_info">
                        <div class="row" style="background-color:#d9d9d9; margin-top:10px;">
                            <div class="col-md-2" style="text-align:left; padding-left:27px;"><?= _r('Icon', 'ไอคอน'); ?></div>
                            <div class="col-md-4" style="text-align:center;"><?= _r('Description EN', 'รายละเอียด (ภาษาอังกฤษ)'); ?></div>
                            <div class="col-md-4" style="text-align:center;"><?= _r('Description TH', 'รายละเอียด (ภาษาไทย)'); ?></div>
                        </div>
                        <?php if (has_permission('project_management', 'edit')) : ?>
                        <div class="row" style="margin-top:5px;">
                            <span class="col-md-12" style="text-align:right;">
                                <button class="btn btn-sm btn-secondary" style="width:85px; padding-left:2px; padding-right:2px; font-size:13px;" @click="addPhotoHighlight()"><?= _r('Add', 'เพิ่ม'); ?> Highlight</button>
                            </span>
                        </div>
                        <?php endif; ?>
                        <span class="row" v-for="(h, i) in project_highlights">
                            <input type="hidden" :id="'url-image-input-highlight-'+ i" v-model="h.icon">
                            <input type="file" style="display:none;" class="image-input image-input-highlight" :id="'image-input-highlight-'+ i" accept="image/jpeg, image/png, image/jpg">
                            <div class="col-md-2" style="text-align:left;">
                                <span class="display-image" :id="'display-image-input-highlight-'+ i">
                                    <img :src="h.icon" style="margin-top:5px; height:78px;">
                                    <div><button style="background-color:black; color:white;" @click="uploadImage('highlight-'+ i)">Browse...</button></div>
                                </span>
                            </div>
                            <div class="col-md-4">
                                <input type="text" :id="'desc-image-input-highlight-'+ i" style="width:100%; margin-right:5px; margin-top:40px;" v-model="h.description_en">
                            </div>
                            <div class="col-md-4">
                                <input type="text" :id="'desc-th-image-input-highlight-'+ i" style="width:100%; margin-right:5px; margin-top:40px;" v-model="h.description_th">
                            </div>
                            <div class="col-md-2">
                                <?php if (has_permission('project_management', 'delete')) : ?>
                                <button class="btn btn-sm btn-danger" style="padding:0px 5px 0px 5px; margin-top:42px;" @click="removePhotoHighlight(i)">
                                    <i class="fa fa-times"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                            <hr style="width:100%;">
                        </span>
                        <?php if (has_permission('project_management', 'edit')) : ?>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;" @click="savePhotoHighlight()"><?= _r('Save', 'บันทึก'); ?></button>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Project Policy -->
                <div class="col-md-12" v-show="step == '5'">
                    <div class="col-md-11" style="margin-top:50px;">
                        <?php if (has_permission('project_management', 'edit')) : ?>
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Policy Type EN', 'ชื่อนโยบาย (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" v-model="policy_add_row.policy_type_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Description EN', 'รายละเอียด (ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" v-model="policy_add_row.description_en">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Policy Type TH', 'ชื่อนโยบาย (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" v-model="policy_add_row.policy_type_th">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Description TH', 'รายละเอียด (ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" v-model="policy_add_row.description_th">
                            </div>
                        </div>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;" @click="addPolicy()"><?= _r('Add New', 'เพิ่มใหม่'); ?></button>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="row" style="overflow:auto; margin-top:40px">
                            <table style="min-width:550px; width:100%;">
                                <thead style="text-align:center;">
                                    <tr>
                                        <th style="width:30%;"><?= _r('Policy Type EN', 'ชื่อนโยบาย (ภาษาไทย)'); ?></th>
                                        <th style="width:60%;"><?= _r('Description EN', 'รายละเอียด (ภาษาไทย)'); ?></th>
                                        <?php if (has_permission('project_management', 'edit') || has_permission('project_management', 'delete')) : ?>
                                        <th style="width:10%; font-size:13px; font-weight:normal;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(p, i) in policy">
                                        <td>{{ <?= _r('p.policy_type_en', 'p.policy_type_th'); ?> }}</td>
                                        <td>{{ <?= _r('p.description_en', 'p.description_th'); ?> }}</td>
                                        <?php if (has_permission('project_management', 'edit') || has_permission('project_management', 'delete')) : ?>
                                        <td class="text-center">
                                            <?php if (has_permission('project_management', 'edit')) : ?>
                                            <button class="btn btn-sm btn-warning" @click="loadUpdatePolicy(i)">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <?php endif; ?>
                                            <?php if (has_permission('project_management', 'delete')) : ?>
                                            <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deletePolicy(p.id_project_policy)">
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
        </div>
    </section>

</div>

<script>
$(document).ready(function() {
    app = new Vue({
        el: '#vApp',
        data: {
            menu: '<?php echo empty($project_info['id_project_info']) ? _r("Add Project", "เพิ่มโปรเจกต์") : _r("Update Project", "แก้ไขโปรเจกต์"); ?>',
            project_info: <?php echo empty($project_info) ? '{}' : json_encode($project_info); ?>,
            step: '<?php echo empty($project_info['id_project_info']) ? 1 : $step; ?>',
            sub_menu: ['Project Info', 'Point of Interest', 'Property Facilities', 'Project Highlights', 'Project Policy'],
            edit_facility: {},
            tmp_project_facility: {},
            project_facility: <?php echo empty($project_facility) ? '{}' : json_encode($project_facility); ?>,
            select_facility: <?php echo empty($select_facility) ? '{}' : json_encode($select_facility); ?>,
            edit_business_info: {},
            business_info: <?php echo empty($business_info) ? '{}' : json_encode($business_info); ?>,
            project_photos: <?php echo empty($project_photos) ? '{}' : json_encode($project_photos); ?>,
            project_photo_blank_row: <?php echo empty($project_photo_blank_row) ? '{}' : json_encode($project_photo_blank_row); ?>,
            project_highlights: <?php echo empty($project_highlights) ? '[]' : json_encode($project_highlights); ?>,
            project_highlights_blank_row: <?php echo empty($project_highlights_blank_row) ? '{}' : json_encode($project_highlights_blank_row); ?>,
            point_of_interest: <?php echo empty($point_of_interest) ? '{}' : json_encode($point_of_interest); ?>,
            point_of_interest_add_row: <?php echo empty($point_of_interest_blank_row) ? '{}' : json_encode($point_of_interest_blank_row); ?>,
            point_of_interest_update_row: <?php echo empty($point_of_interest_blank_row) ? '{}' : json_encode($point_of_interest_blank_row); ?>,
            policy: <?php echo empty($policy) ? '{}' : json_encode($policy); ?>,
            policy_add_row: <?php echo empty($policy_blank_row) ? '{}' : json_encode($policy_blank_row); ?>,
            policy_update_row: <?php echo empty($policy_blank_row) ? '{}' : json_encode($policy_blank_row); ?>
        },
        mounted() {
            let self = this;
            self.tmp_project_facility = JSON.parse(JSON.stringify(shift_json(self.project_facility)));

            $("#facilityTable").DataTable();
        },
        methods: {
            changeStep: function(v) {
                this.step = v;
            },
            uploadImage: function(id) {
                $('#image-input-'+ id).trigger('click');
            },
            loadEditBusiness: function(id) {
                let self = this;
                this.business_info.forEach((v) => {
                    if (v.id_business_info == id) {
                        self.edit_business_info = JSON.parse(JSON.stringify(v));
                    }
                });
                $('#editBusinessModal').modal('show');
            },
            deleteBusiness: function(id) {
                let self = this;

                if (confirm("Delete this Business Info ?")) {
                    let param = {'id': id};
                    $.post("<?php echo delete_business_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                            return;
                        } else {
                            alert('Delete Business Info Success');
                            location.href = "<?php echo edit_project_url(); ?>"+ self.project_info.id_project_info +"?step="+ self.step;
                        }
                    });
                }
            },
            saveBusinessInfo: function() {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.edit_business_info);
                keys.forEach((v) => {
                    if (valid && self.edit_business_info[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                if (this.edit_business_info.logo == '<?php echo site_url(); ?>asset/image/upload.jpg') {
                    alert("Empty Logo");
                    return;
                }

                if (!validateEmail(this.edit_business_info.email)) {
                    alert("Invalid Email");
                    return;
                }

                //
                $.post("<?php echo save_business_url(); ?>", this.edit_business_info, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Save Business Info Success');
                        location.href = "<?php echo edit_project_url(); ?>"+ self.project_info.id_project_info +"?step="+ self.step;
                    }
                });
            },
            saveProjectInfo: function() {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.project_info);
                keys.forEach((v) => {
                    if (valid && !['id_project_info', 'whole_address_en', 'whole_address_th', 'date_created'].includes(v) && self.project_info[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                if (!validateEmail(this.project_info.email)) {
                    alert("Invalid Email");
                    return;
                }

                //
                $.post("<?php echo save_project_url(); ?>", this.project_info, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Save Project Info Success');
                        location.href = "<?php echo edit_project_url(); ?>"+ res.message;
                    }
                });
            },
            addPhotoProject: function() {
                tmp = JSON.parse(JSON.stringify(this.project_photo_blank_row));
                this.project_photos.push(tmp);
            },
            removePhotoProject: function(id) {
                tmp = [];
                this.project_photos.forEach((v, i) => {
                    if (i != id) {
                        tmp.push(JSON.parse(JSON.stringify(v)));
                    }
                });
                this.project_photos = JSON.parse(JSON.stringify(tmp));
            },
            savePhotoProject: function() {
                let self = this;

                let valid = true;
                tmp = JSON.parse(JSON.stringify(this.project_photos));
                tmp.forEach((row, i) => {
                    let keys = Object.keys(row);
                    keys.forEach((k, j) => {
                        if (valid && k != 'id_project_photo' && !row[k]) {
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
                    'id_project_info': this.project_info.id_project_info,
                    'project_photos': tmp
                };

                $.post("<?php echo save_project_photo_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Save Project Photo Success');
                        location.href = "<?php echo edit_project_url(); ?>"+ self.project_info.id_project_info +"?step="+ self.step;
                    }
                });
            },
            addPhotoHighlight: function() {
                tmp = JSON.parse(JSON.stringify(this.project_highlights_blank_row));
                this.project_highlights.push(tmp);
            },
            removePhotoHighlight: function(id) {
                tmp = [];
                this.project_highlights.forEach((v, i) => {
                    if (i != id) {
                        tmp.push(JSON.parse(JSON.stringify(v)));
                    }
                });
                this.project_highlights = JSON.parse(JSON.stringify(tmp));
            },
            savePhotoHighlight: function() {
                let self = this;

                let valid = true;
                tmp = JSON.parse(JSON.stringify(this.project_highlights));
                tmp.forEach((row, i) => {
                    let keys = Object.keys(row);
                    keys.forEach((k, j) => {
                        if (valid && k != 'id_highlights' && !row[k]) {
                            valid = false;
                            alert('Empty '+ k +' (row '+ (i+1) +')');
                        }
                    });
                });

                if (!valid) {
                    return;
                }

                //
                let param = {
                    'id_project_info': this.project_info.id_project_info,
                    'project_highlights': tmp
                };

                $.post("<?php echo save_project_highlights_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Save Project Highlights Success');
                        location.href = "<?php echo edit_project_url(); ?>"+ self.project_info.id_project_info +"?step="+ self.step;
                    }
                });
            },
            addPointOfInterest: function() {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.point_of_interest_add_row);
                keys.forEach((v) => {
                    if (valid && self.point_of_interest_add_row[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                //
                let param = {'point_of_interest': this.point_of_interest_add_row};
                $.post("<?php echo save_point_of_interest_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Add Point of Interest Success');
                        location.href = "<?php echo edit_project_url(); ?>"+ self.project_info.id_project_info +"?step="+ self.step;
                    }
                });
            },
            loadUpdatePointOfInterest: function(id) {
                this.point_of_interest_update_row = JSON.parse(JSON.stringify(this.point_of_interest[id]));
                $('#updatePointOfInterestModal').modal('show');
            },
            updatePointOfInterest: function(id) {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.point_of_interest_update_row);
                keys.forEach((v) => {
                    if (valid && self.point_of_interest_update_row[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                //
                let param = {'point_of_interest': this.point_of_interest_update_row};
                $.post("<?php echo save_point_of_interest_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Update Point of Interest Success');
                        location.href = "<?php echo edit_project_url(); ?>"+ self.project_info.id_project_info +"?step="+ self.step;
                    }
                });
            },
            deletePointOfInterest: function(id) {
                let self = this;
                if (confirm("Delete this Point of Interest ?")) {
                    let param = {'id': id};
                    $.post("<?php echo delete_point_of_interest_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                            return;
                        } else {
                            alert('Delete Point of Interest Success');
                            location.href = "<?php echo edit_project_url(); ?>"+ self.project_info.id_project_info +"?step="+ self.step;
                        }
                    });
                }
            },
            addPolicy: function() {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.policy_add_row);
                keys.forEach((v) => {
                    if (valid && self.policy_add_row[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                //
                let param = {'policy': this.policy_add_row};
                $.post("<?php echo save_policy_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Add Policy Success');
                        location.href = "<?php echo edit_project_url(); ?>"+ self.project_info.id_project_info +"?step="+ self.step;
                    }
                });
            },
            loadUpdatePolicy: function(id) {
                this.policy_update_row = JSON.parse(JSON.stringify(this.policy[id]));
                $('#updatePolicyModal').modal('show');
            },
            updatePolicy: function(id) {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.policy_update_row);
                keys.forEach((v) => {
                    if (valid && self.policy_update_row[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                //
                let param = {'policy': this.policy_update_row};
                $.post("<?php echo save_policy_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Update Policy Success');
                        location.href = "<?php echo edit_project_url(); ?>"+ self.project_info.id_project_info +"?step="+ self.step;
                    }
                });
            },
            deletePolicy: function(id) {
                let self = this;
                if (confirm("Delete this Policy ?")) {
                    let param = {'id': id};
                    $.post("<?php echo delete_policy_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                            return;
                        } else {
                            alert('Delete Policy Success');
                            location.href = "<?php echo edit_project_url(); ?>"+ self.project_info.id_project_info +"?step="+ self.step;
                        }
                    });
                }
            },
            loadEditFacility: function(id) {
                let self = this;
                this.project_facility.forEach((v) => {
                    if (v.id_property_facility == id) {
                        self.edit_facility = JSON.parse(JSON.stringify(v));
                    }
                });
                $('#editFacilityModal').modal('show');
            },
            deleteFacility: function(id) {
                let self = this;
                if (confirm("Delete this Facility ?")) {
                    let param = {'id': id};
                    $.post("<?php echo delete_facility_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                            return;
                        } else {
                            alert('Delete Facility Success');
                            location.href = "<?php echo edit_project_url(); ?>"+ self.project_info.id_project_info +"?step="+ self.step;
                        }
                    });
                }
            },
            saveFacility: function() {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.edit_facility);
                keys.forEach((v) => {
                    if (valid && self.edit_facility[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                if (this.edit_facility.icon == '<?php echo site_url(); ?>asset/image/upload.jpg') {
                    alert("Empty Icon");
                    return;
                }

                //
                $.post("<?php echo save_facility_url(); ?>", this.edit_facility, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Save Facility Success');
                        location.href = "<?php echo edit_project_url(); ?>"+ self.project_info.id_project_info +"?step="+ self.step;
                    }
                });
            },
            selectFacility: function(id) {
                let self = this;

                let is_featured = 0;
                let action = 'Select';
                if (!this.select_facility[id]) {
                    if (confirm('Is Featured ?\n(OK = "yes", Cancel = "no")')) {
                        is_featured = 1;
                    }

                    this.select_facility[id] = {
                        'id_property_facility': id,
                        'id_project_info': this.project_info.id_project_info,
                        'is_featured': is_featured
                    };
                } else {
                    action = 'Remove';
                    this.select_facility[id] = false;
                }
                this.tmp_project_facility = JSON.parse(JSON.stringify(shift_json(this.project_facility)));

                let param = {
                    'id_project_info': this.project_info.id_project_info,
                    'id_property_facility': id,
                    'is_featured': is_featured
                };

                $.post("<?php echo select_facility_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                    } else {
                        alert(action +' Facility Success');
                    }
                });
            }
        }
    });

    $(document).on('change', '.image-input', function() {
        let self = $(this);
        let id = $(this).attr('id');

        const reader = new FileReader();
        reader.addEventListener("load", () => {
            const uploaded_image = reader.result;

            if (self.hasClass('image-input-business')) {
                app.edit_business_info.logo = uploaded_image;
            } else if (self.hasClass('image-input-facility')) {
                app.edit_facility.icon = uploaded_image;
            } else if (self.hasClass('image-input-project')) {
                let ids = id.split('-');
                app.project_photos[ids[ids.length - 1]].project_photo_url = uploaded_image;
            } else if (self.hasClass('image-input-highlight')) {
                let ids = id.split('-');
                app.project_highlights[ids[ids.length - 1]].icon = uploaded_image;
            }
        });
        reader.readAsDataURL(this.files[0]);
    });
});
</script>