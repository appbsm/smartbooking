 <!-- CDN for SheetJS -->
<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
<!-- CDN for jsPDF -->
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.4.0/dist/jspdf.umd.min.js"></script>
<!-- CDN for jsPDF autoTable -->
<script src="https://cdn.jsdelivr.net/npm/jspdf-autotable@3.5.23/dist/jspdf.plugin.autotable.min.js"></script>
<!-- CDN for xlsx-style -->
<script src="https://cdn.jsdelivr.net/npm/xlsx-style/dist/xlsx-style.full.min.js"></script>

<style>
    .dataTables_filter {
        transform: translateX(-7px);
        /*float: right; !important;
        margin-left: 200px !important; */
    }
</style>

<!-- Content Header (Page header) -->
<div class="content-wrapper" id="vApp" style="padding-bottom:50px;" v-cloak>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link" :class="{ active: currentTab === 'tab1' }" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true"><?= _r('Electric', 'ไฟฟ้า'); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" :class="{ active: currentTab === 'tab2' }" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false"><?= _r('Water', 'น้ำ'); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" :class="{ active: currentTab === 'tab3' }" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false"><?= _r('Internet', 'อินเทอร์เน็ต'); ?></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" :class="{ active: currentTab === 'tab4' }" id="tab4-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false"><?= _r('Service Charge', 'ค่าบริการ'); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" :class="{ active: currentTab === 'tab5' }" id="tab5-tab" data-toggle="tab" href="#tab5" role="tab" aria-controls="tab5" aria-selected="false"><?= _r('Fine', 'ค่าปรับ'); ?></a>
        </li>
    </ul>

     <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" :class="{ 'show active': currentTab === 'tab1' }" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">

                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>{{ menu }}</h1>
                            </div>

                            <div class="col-sm-6 d-flex justify-content-end align-items-center">

                                <div class="mr-2">
                                <?php if (has_permission('electric_management', 'edit')) : ?>
                                <a href="<?php echo edit_electric_url(); ?>" style="color:white;">
                                    <button class="btn" style="width:170px; height:30px; line-height:9px; background-color:#0275d8; color:white;">
                                        <?= _r('Create', 'สร้าง'); ?>
                                    </button>
                                </a>
                                <?php endif; ?>
                                </div>

                                <div class="dropdown ">
                                    <button class="btn btn-success dropdown-toggle" style="width:170px; height:30px; line-height:9px; background-color:#1aac75; color:white;" data-toggle="dropdown">
                                        <?= _r('Export Data', 'ส่งออกข้อมูล'); ?>
                                    </button>

                                    <ul class="dropdown-menu">
                                        <li>
                                            <a @click="exportToExcel('roomTable')" style="display: inline-flex; align-items: center; margin-left: 10px; cursor: pointer;">
                                                <img src='<?php echo site_url();?>images/xls.png' width="30" style="margin-right: 10px;" /> XLS
                                            </a>
                                        </li>
                                        <li>
                                            <a @click="exportToPDF('roomTable')" style="display: inline-flex; align-items: center; margin-left: 10px; cursor: pointer;">
                                                <img src='<?php echo site_url();?>images/pdf.png' width="30" style="margin-right: 10px;" /> PDF
                                            </a>
                                        </li> 
                                    </ul>

                                </div>

                            </div>

                        </div>
                    </div>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">

                                <div style="width:100%; overflow:auto;">
                                    <table id="roomTable" class="display" style="width:99%;">
                                        <thead >
                                            <tr>
                                                <th style="width:40px;text-align:center;"><?= _r('No', 'ลำดับ'); ?></th>
                                                <th style="width:160px;text-align:center;"><?= _r('Project', 'โครงการ'); ?></th>
                                                <th style="width:60px;text-align:center;"><?= _r('Rooms type', 'ห้อง'); ?></th>
                                                <th style="width:60px;text-align:center;"><?= _r('Room Number', 'หมายเลขห้อง'); ?></th>
                                                <th style="width:80px;text-align:center;"><?= _r('Meter ID', 'รหัสมิเตอร์'); ?></th>
                                                <th style="width:60px;text-align:center;"><?= _r('Serial No', 'หมายเลขซีเรียล'); ?></th>
                                                <!-- <th style="width:60px;"><?= _r('Status', 'สถานะ'); ?></th> -->

                                                <?php if (has_permission('electric_management', 'view') || has_permission('electric_management', 'delete')) : ?>
                                                <th style="width:80px;text-align:center;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                                <?php endif; ?>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr v-for="r in electric_list">
                                                <td class="text-center">{{ r.run_id }}
                                                    <!-- <img :src="r.image" style="width:100%;"> -->
                                                </td>
                                                <td>{{ <?= _r('r.project_name_en', 'r.project_name_th'); ?> }}</td>
                                                <td>{{ <?= _r('r.room_type_name_en', 'r.room_type_name_th'); ?> }}</td>
                                                <td class="text-center">{{ <?= _r('r.room_name_en', 'r.room_name_th'); ?> }}</td>
                                                <td class="text-center">{{ r.meter_id }}</td>
                                                <td class="text-center">{{ r.serial_no }}</td>
                                                
                                                <!-- <td class="text-center">
                                                    <span class="badge badge-success" v-if="r.is_active == 1">Active</span>
                                                    <span class="badge badge-danger" v-if="r.is_active == 0">Inactive</span>
                                                </td> -->

                                                <?php if (has_permission('electric_management', 'view') || has_permission('electric_management', 'delete')) : ?>
                                                <td class="text-center">
                                                    <?php if (has_permission('electric_management', 'view')) : ?>
                                                    <button class="btn btn-sm btn-warning" @click="editElectric(r.id)">
                                                        <i class="fa fa-pencil" style="color:black !important;"></i>
                                                    </button>
                                                    <?php endif; ?>
                                                    <?php if (has_permission('electric_management', 'delete')) : ?>
                                                    <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deleteElectric(r.id)">
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
                </section>

            </div>
            
            <div class="tab-pane fade" :class="{ 'show active': currentTab === 'tab2' }" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>{{ menu2 }}</h1>
                            </div>

                            <div class="col-sm-6 d-flex justify-content-end align-items-center">

                                <div class="mr-2">
                                <?php if (has_permission('water_management', 'edit')) : ?>
                                    <a href="<?php echo edit_water_url(); ?>" style="color:white;">
                                        <button class="btn" style="width:170px; height:30px; line-height:9px; background-color:#0275d8; color:white;">
                                            <?= _r('Create', 'สร้าง'); ?>
                                        </button>
                                    </a>
                                <?php endif; ?>
                                </div>

                                <div class="dropdown">
                                    <button class="btn btn-success dropdown-toggle" style="width:170px; height:30px; line-height:9px; background-color:#1aac75; color:white;" data-toggle="dropdown">
                                        <?= _r('Export Data', 'ส่งออกข้อมูล'); ?>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a @click="exportToExcel('roomTable2')" style="display: inline-flex; align-items: center; margin-left: 10px; cursor: pointer;">
                                                <img src='<?php echo site_url();?>images/xls.png' width="30" style="margin-right: 10px;" /> XLS
                                            </a>
                                        </li>
                                        <li>
                                            <a @click="exportToPDF('roomTable2')" style="display: inline-flex; align-items: center; margin-left: 10px; cursor: pointer;">
                                                <img src='<?php echo site_url();?>images/pdf.png' width="30" style="margin-right: 10px;" /> PDF
                                            </a>
                                        </li> 
                                    </ul>
                                </div>

                            </div>

                        </div>
                    </div>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div style="width:100%; overflow:auto;">

                                    <table id="roomTable2" class="display" style="width:99%;">

                                        <thead style="text-align:center;">
                                            <tr>
                                                <th style="width:40px;text-align:center;"><?= _r('No', 'ลำดับ'); ?></th>
                                                <th style="width:160px;text-align:center;"><?= _r('Project', 'โครงการ'); ?></th>
                                                <th style="width:60px;text-align:center;"><?= _r('Rooms type', 'ห้อง'); ?></th>
                                                <th style="width:60px;text-align:center;"><?= _r('Room Number', 'หมายเลขห้อง'); ?></th>
                                                <th style="width:80px;text-align:center;"><?= _r('Meter ID', 'รหัสมิเตอร์'); ?></th>
                                                <th style="width:60px;text-align:center;"><?= _r('Serial No', 'หมายเลขซีเรียล'); ?></th>
                                                <!-- <th style="width:60px;"><?= _r('Status', 'สถานะ'); ?></th> -->

                                                <?php if (has_permission('water_management', 'view') || has_permission('water_management', 'delete')) : ?>
                                                <th style="width:80px;text-align:center;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                                <?php endif; ?>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr v-for="r in water_list">
                                                <td class="text-center">{{ r.run_id }}</td>
                                                <td>{{ <?= _r('r.project_name_en', 'r.project_name_th'); ?> }}</td>
                                                <td>{{ <?= _r('r.room_type_name_en', 'r.room_type_name_th'); ?> }}</td>
                                                <td class="text-center">{{ <?= _r('r.room_name_en', 'r.room_name_th'); ?> }}</td>
                                                <td class="text-center">{{ r.meter_id }}</td>
                                                <td class="text-center">{{ r.serial_no }}</td>
                                                
                                                <?php if (has_permission('water_management', 'view') || has_permission('water_management', 'delete')) : ?>
                                                <td class="text-center">
                                                    <?php if (has_permission('water_management', 'view')) : ?>
                                                    <button class="btn btn-sm btn-warning" @click="editWater(r.id)">
                                                        <i class="fa fa-pencil" style="color:black !important;"></i>
                                                    </button>
                                                    <?php endif; ?>
                                                    <?php if (has_permission('water_management', 'delete')) : ?>
                                                    <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deleteWater(r.id)">
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
                </section>

            </div>
            <div class="tab-pane fade" :class="{ 'show active': currentTab === 'tab3' }" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>{{ menu3 }}</h1>
                            </div>
                            <div class="col-sm-6 d-flex justify-content-end align-items-center">
                                <div class="mr-2">
                                <?php if (has_permission('internet_management', 'edit')) : ?>
                                <a href="<?php echo edit_internet_url(); ?>" style="color:white;">
                                    <button class="btn" style="width:170px; height:30px; line-height:9px; background-color:#0275d8; color:white;">
                                        <?= _r('Create', 'สร้าง'); ?>
                                    </button>
                                </a>
                                <?php endif; ?>
                                </div>

                                <div class="dropdown">
                                    <button class="btn btn-success dropdown-toggle" style="width:170px; height:30px; line-height:9px; background-color:#1aac75; color:white;" data-toggle="dropdown">
                                        <?= _r('Export Data', 'ส่งออกข้อมูล'); ?>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a @click="exportToExcel('roomTable3')" style="display: inline-flex; align-items: center; margin-left: 10px; cursor: pointer;">
                                                <img src='<?php echo site_url();?>images/xls.png' width="30" style="margin-right: 10px;" /> XLS
                                            </a>
                                        </li>
                                        <li>
                                            <a @click="exportToPDF('roomTable3')" style="display: inline-flex; align-items: center; margin-left: 10px; cursor: pointer;">
                                                <img src='<?php echo site_url();?>images/pdf.png' width="30" style="margin-right: 10px;" /> PDF
                                            </a>
                                        </li> 
                                    </ul>
                                </div>

                            </div>

                        </div>
                    </div>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div style="width:100%; overflow:auto;">
                                    <table id="roomTable3" class="display" style="width:99%;">

                                        <thead style="text-align:center;">
                                            <tr>
                                                <th style="width:40px;text-align:center;"><?= _r('No', 'ลำดับ'); ?></th>
                                                <th style="width:160px;text-align:center;"><?= _r('Project', 'โครงการ'); ?></th>
                                                <th style="width:60px;text-align:center;"><?= _r('Rooms type', 'ห้อง'); ?></th>
                                                <th style="width:60px;text-align:center;"><?= _r('Room Number', 'หมายเลขห้อง'); ?></th>
                                               <!--  <th style="width:80px;text-align:center;"><?= _r('Meter ID', 'รหัสมิเตอร์'); ?></th>
                                                <th style="width:80px;text-align:center;"><?= _r('Unit No', 'หมายเลขหน่วย'); ?></th> -->
                                                <th style="width:60px;text-align:center;"><?= _r('ID', 'ID'); ?></th>
                                                <!-- <th style="width:60px;"><?= _r('Status', 'สถานะ'); ?></th> -->
                                                <?php if (has_permission('internet_management', 'view') || has_permission('internet_management', 'delete')) : ?>
                                                <th style="width:80px;text-align:center;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                                <?php endif; ?>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr v-for="r in internet_list">
                                                <td class="text-center">{{ r.run_id }}</td>
                                                <td>{{ <?= _r('r.project_name_en', 'r.project_name_th'); ?> }}</td>
                                                <td>{{ <?= _r('r.room_type_name_en', 'r.room_type_name_th'); ?> }}</td>
                                                <td class="text-center">{{ <?= _r('r.room_name_en', 'r.room_name_th'); ?> }}</td>
                                                <!-- <td class="text-center">{{ r.meter_id }}</td>
                                                <td class="text-center">{{ r.unit_no }}</td> -->
                                                <td class="text-center">{{ r.id_internet }}</td>
                                                
                                                <?php if (has_permission('internet_management', 'view') || has_permission('internet_management', 'delete')) : ?>
                                                <td class="text-center">
                                                    <?php if (has_permission('internet_management', 'view')) : ?>
                                                    <button class="btn btn-sm btn-warning" @click="editInternet(r.id)">
                                                        <i class="fa fa-pencil" style="color:black !important;"></i>
                                                    </button>
                                                    <?php endif; ?>
                                                    
                                                    <?php if (has_permission('internet_management', 'delete')) : ?>
                                                    <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deleteInternet(r.id)">
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
                </section>

            </div>

            <div class="tab-pane fade" :class="{ 'show active': currentTab === 'tab4' }" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">

                <!-- <section class="content-header"> -->
                    <!-- <div class="container-fluid"> -->
                        <!-- <div class="row mb-2"> -->
                            <!-- <div class="col-sm-6">
                                <h1>{{ menu3 }}</h1>
                            </div> -->
                            <!-- <div class="col-sm-6 d-flex justify-content-end align-items-center">
                                <div class="mr-2"> -->
                                <?php //if (has_permission('internet_management', 'edit')) : ?>
                                <!-- <a href="<?php echo edit_internet_url(); ?>" style="color:white;">
                                    <button class="btn" style="width:170px; height:30px; line-height:9px; background-color:#0275d8; color:white;">
                                        <?= _r('Create', 'สร้าง'); ?>
                                    </button>
                                </a> -->
                                <?php //endif; ?>
                                <!-- </div> -->

                                <!-- <div class="dropdown">
                                    <button class="btn btn-success dropdown-toggle" style="width:170px; height:30px; line-height:9px; background-color:#1aac75; color:white;" data-toggle="dropdown">
                                        <?= _r('Export Data', 'ส่งออกข้อมูล'); ?>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a @click="exportToExcel('roomTable3')" style="display: inline-flex; align-items: center; margin-left: 10px; cursor: pointer;">
                                                <img src='<?php echo site_url();?>images/xls.png' width="30" style="margin-right: 10px;" /> XLS
                                            </a>
                                        </li>
                                        <li>
                                            <a @click="exportToPDF('roomTable3')" style="display: inline-flex; align-items: center; margin-left: 10px; cursor: pointer;">
                                                <img src='<?php echo site_url();?>images/pdf.png' width="30" style="margin-right: 10px;" /> PDF
                                            </a>
                                        </li> 
                                    </ul>
                                </div> -->

                            <!-- </div> -->

                        <!-- </div> -->
                    <!-- </div> -->
                <!-- </section> -->
                <br>
                <section class="content">
                    <div class="container-fluid" >

                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="header-bar" style="background-color: #102958; color: white; padding: 10px 20px; border-radius: 5px;">
                                    <!-- <h2 class="text-center">หัวข้อหลัก</h2> -->
                                    <h5 >ค่าบริการ</h5>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-3 mb-3" v-for="r in service_charge_info" :key="r.id" >
                              <button @click="editService(r.id)" class="btn btn-light btn-block custom-btn" style="background-color: white;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);height: 150px;">
                                <img src='<?php echo site_url();?>images/service.png' alt="Image" class="img-fluid mb-2" width="50" >
                                <div class="text-center">{{r.service_name_th}}</div>
                              </button>
                            </div>

                            <div class="col-md-3 mb-3" >
                                <!-- data-toggle="modal" data-target="#addServiceModal" -->
                              <button class="btn btn-light btn-block custom-btn" style="background-color: white;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);height: 150px;" data-toggle="modal" 
                                    data-target="#addServiceModal"  >
                                <img src='<?php echo site_url();?>images/plus-icon.png' alt="Image" class="img-fluid mb-2" width="20" >
                                <div class="text-center">เพิ่มค่าบริการ</div>
                              </button>
                            </div>

                        </div>
                   
                    </div>
                </section>

                <br>
                <section class="content">
                    <div class="container-fluid" >

                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="header-bar" style="background-color: #102958; color: white; padding: 10px 20px; border-radius: 5px;">
                                    <h5 >ส่วนลด</h5>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-3 mb-3" v-for="r in service_charge_info2" :key="r.id" >
                              <button @click="editService(r.id)" class="btn btn-light btn-block custom-btn" style="background-color: white;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);height: 150px;">
                                <img src='<?php echo site_url();?>images/discount.png' alt="Image" class="img-fluid mb-2" width="50" >
                                <div class="text-center">{{r.service_name_th}}</div>
                              </button>
                            </div>

                            <!-- <div class="col-md-3 mb-3" >
                              <button class="btn btn-light btn-block custom-btn" style="background-color: white;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);height: 150px;">
                                <img src='<?php echo site_url();?>images/discount.png' alt="Image" class="img-fluid mb-2" width="50" >
                                <div class="text-center">ส่วนลดวันเกิด</div>
                              </button>
                            </div> -->

                            <div class="col-md-3 mb-3" >
                              <button class="btn btn-light btn-block custom-btn" style="background-color: white;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);height: 150px;" data-toggle="modal" 
                                    data-target="#addDiscountModal">
                                <img src='<?php echo site_url();?>images/plus-icon.png' alt="Image" class="img-fluid mb-2" width="20" >
                                <div class="text-center">เพิ่มส่วนลด</div>
                              </button>
                            </div>

                        </div>

                   
                    </div>
                </section>

            </div>

            <div class="tab-pane fade" :class="{ 'show active': currentTab === 'tab5' }" id="tab5" role="tabpanel" aria-labelledby="tab5-tab">

            </div>

        </div>

    <!-- Modal -->
    <div class="modal fade" id="addServiceModal" tabindex="-1" role="dialog" aria-labelledby="addServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addServiceModalLabel"><?= _r('Add a new service', 'เพิ่มค่าบริการใหม่'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                        <div class="form-group">
                            <label for="serviceName"><?= _r('Service name', 'ชื่อบริการ'); ?></label>
                            <input type="text" class="form-control" id="serviceName" placeholder="<?= _r('Please enter service name', 'กรุณากรอกชื่อบริการ'); ?>" v-model="service_charge.service_name_th">
                        </div>
                        <div class="form-group">
                            <label for="serviceNameEN"><?= _r('Service name (English)', 'ชื่อบริการ (ภาษาอังกฤษ)'); ?></label>
                            <input type="text" class="form-control" id="serviceNameEN" placeholder="<?= _r('Please enter service name in English', 'กรุณากรอกชื่อบริการภาษาอังกฤษ'); ?>" v-model="service_charge.service_name_en" >
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= _r('Close', 'ปิด'); ?></button>
                    <button type="button" class="btn btn-primary" @click="saveService('service')" ><?= _r('Save', 'บันทึก'); ?></button>
                </div>
            </div>
        </div>
    </div>    

    <div class="modal fade" id="addDiscountModal" tabindex="-1" role="dialog" aria-labelledby="addDiscountModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDiscountModalLabel"><?= _r('Add a new discount', 'เพิ่มส่วนลดใหม่'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label for="serviceName"><?= _r('Discount name', 'ชื่อส่วนลด'); ?></label>
                            <input type="text" class="form-control" id="serviceName" placeholder="<?= _r('Please enter the name of the discount', 'กรุณากรอกชื่อส่วนลด'); ?>" v-model="service_charge.service_name_th" >
                        </div>
                        <div class="form-group">
                            <label for="serviceNameEN"><?= _r('Discount name (English)', 'ชื่อส่วนลด (ภาษาอังกฤษ)'); ?></label>
                            <input type="text" class="form-control" id="serviceNameEN" placeholder="<?= _r('Please enter the name of the discount in English', 'กรุณากรอกชื่อส่วนลดภาษาอังกฤษ'); ?>" v-model="service_charge.service_name_en" >
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= _r('Close', 'ปิด'); ?></button>
                    <button type="button" class="btn btn-primary" @click="saveService('discount')"><?= _r('Save', 'บันทึก'); ?></button>
                </div>
            </div>
        </div>
    </div>

</div>


<script>

$(document).ready(function() {
    app = new Vue({
        el: '#vApp',
        data: {
            menu: "<?= _r('Electric Meter List', 'รายการมิเตอร์ไฟฟ้า'); ?>",
            menu2: "<?= _r('Water Meter List', 'รายการมิเตอร์น้ำ'); ?>",
            menu3: "<?= _r('Internet Meter List', 'รายการอินเทอร์เน็ต'); ?>",
            electric_list: <?php echo json_encode($electric_list); ?>,
            water_list: <?php echo json_encode($water_list); ?>,
            internet_list: <?php echo json_encode($internet_list); ?>,
            service_charge: <?php echo json_encode($service_charge); ?>,
            service_charge_info: <?php echo json_encode($service_charge_info); ?>,
            service_charge_info2: <?php echo json_encode($service_charge_info2); ?>,
            edit_service: {},
            currentTab: 'tab1'
        },
        mounted() {
            $("#roomTable").DataTable();
            $("#roomTable2").DataTable();
            $("#roomTable3").DataTable();
            $(".dataTables_filter").addClass("search-left");

            const urlParams = new URLSearchParams(window.location.search);
            const tabParam = urlParams.get('tab');
            // Set the currentTab based on the tab parameter
            if (tabParam === '2') {
                this.currentTab = 'tab2';
            } else if (tabParam === '3') {
                this.currentTab = 'tab3';
            } else if (tabParam === '4') {
                this.currentTab = 'tab4';
            } else if (tabParam === '5') {
                this.currentTab = 'tab5';
            } else {
                this.currentTab = 'tab1';
            }

            // alert('currentTab : '+count(this.service_charge));
            // alert('Number of properties in service_charge: ' + Object.keys(this.service_charge).length);
        },
        methods: {
            editService: function(id) {
                <?php if (has_permission('electric_management', 'view')) : ?>
                location.href = '<?php echo edit_service_url(); ?>/'+ id;
                <?php endif; ?>
            },
            saveService: function(value) {
                if (!this.service_charge.service_name_th) {
                    alert('กรุณากรอกชื่อบริการ');
                    return;
                }

                this.service_charge.type = value;
                
                $.post("<?php echo save_service_url(); ?>", this.service_charge, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Save Success');
                        location.href = "<?php echo electric_management_url(); ?>?tab=4";
                    }
                });
            },
            exportToExcel(value) {
                const table = document.getElementById(value);
                //const table = document.getElementById('roomTable');
                const check_action = "<?php echo (has_permission('electric_management', 'view') || has_permission('electric_management', 'delete')) ? 'true' : 'false'; ?>";

                let headers;
                let rows;
                let footer;

                if(check_action === "true"){
                    headers = Array.from(table.querySelectorAll('thead th'))
                        .slice(0, -1)
                        .map(th => th.innerText.trim());
                    rows = Array.from(table.querySelectorAll('tbody tr')).map(tr => {
                        return Array.from(tr.querySelectorAll('td'))
                            .slice(0, -1)
                            .map(td => td.innerText.trim());
                    });
                    footer = Array.from(table.querySelectorAll('tfoot tr')).map(tr => {
                        let tds = Array.from(tr.querySelectorAll('td'))
                            .slice(0, -1)
                            .map(td => td.innerText.trim());
                        return Array(headers.length - tds.length).fill('').concat(tds); // เพิ่มคอลัมน์ว่างเพื่อขยับ footer ไปทางขวา
                    });
                } else {
                    headers = Array.from(table.querySelectorAll('thead th')).map(th => th.innerText.trim());
                    rows = Array.from(table.querySelectorAll('tbody tr')).map(tr => {
                        return Array.from(tr.querySelectorAll('td')).map(td => td.innerText.trim());
                    });
                    footer = Array.from(table.querySelectorAll('tfoot tr')).map(tr => {
                        let tds = Array.from(tr.querySelectorAll('td'))
                            .map(td => td.innerText.trim());
                        return Array(headers.length - tds.length).fill('').concat(tds); // เพิ่มคอลัมน์ว่างเพื่อขยับ footer ไปทางขวา
                    });
                }

                const data = [headers, ...rows, ...footer];
                const ws = XLSX.utils.aoa_to_sheet(data);
                const wsName = 'Electric Records';
                const wb = XLSX.utils.book_new();

                // คำนวณความกว้างของคอลัมน์ตามความยาวของเนื้อหา
                const colWidths = headers.map((_, index) => {
                    const columnData = data.map(row => row[index] || '');
                    const maxLength = Math.max(...columnData.map(cell => cell.toString().length));
                    return maxLength;
                });

                // กำหนดความกว้างและการจัดตำแหน่งคอลัมน์
                const columnStyles = headers.map((_, index) => {
                    if (index >= 6 && index <= 12) {
                        return {
                            alignment: { horizontal: 'right' },
                            width: colWidths[index] + 5 // เพิ่มความกว้างพอเหมาะ
                        };
                    } else if (index === 0) {
                        return {
                            alignment: { horizontal: 'center' },
                            width: colWidths[index] + 5
                        };
                    } else {
                        return { width: colWidths[index] + 5 }; // ความกว้างพื้นฐานสำหรับคอลัมน์อื่นๆ
                    }
                });

                ws['!cols'] = columnStyles;

                // กำหนดรูปแบบเซลล์สำหรับคอลัมน์ที่เป็นตัวเลข
                for (let i = 6; i <= 12; i++) {
                    data.forEach((row, rowIndex) => {
                        if (row[i] !== undefined) {
                            const cellAddress = XLSX.utils.encode_cell({ r: rowIndex, c: i });
                            const value = parseFloat(row[i].replace(/,/g, ''));
                            if (!isNaN(value)) {
                                ws[cellAddress] = { t: 'n', v: value }; // กำหนดชนิดข้อมูลเป็นตัวเลข
                                ws[cellAddress].z = '#,##0.00'; // รูปแบบตัวเลขทศนิยม 2 ตำแหน่ง
                            }
                        }
                    });
                }

                // จัดตำแหน่งเซลล์ใน rows และ footer สำหรับคอลัมน์ที่ 0
                data.forEach((row, rowIndex) => {
                    if (rowIndex > 0) { // ไม่ทำการเปลี่ยนแปลง header
                        const cellAddress = XLSX.utils.encode_cell({ r: rowIndex, c: 0 }); // คอลัมน์ที่ 0
                        if (ws[cellAddress]) {
                            ws[cellAddress].s = {
                                alignment: { horizontal: 'center' }
                            };
                        }
                    }
                });

                // จัดตำแหน่งเซลล์ใน footer สำหรับคอลัมน์ที่ 0
                const footerStartIndex = rows.length + 1; // Index ของแถวเริ่มต้นสำหรับ footer
                footer.forEach((row, rowIndex) => {
                    const cellAddress = XLSX.utils.encode_cell({ r: footerStartIndex + rowIndex, c: 0 }); // คอลัมน์ที่ 0
                    if (ws[cellAddress]) {
                        ws[cellAddress].s = {
                            alignment: { horizontal: 'center' }
                        };
                    }
                });

                XLSX.utils.book_append_sheet(wb, ws, wsName);
                if(value === "roomTable"){
                    XLSX.writeFile(wb, 'Electric_list.xlsx');
                }else if(value === "roomTable2"){
                    XLSX.writeFile(wb, 'Water_list.xlsx');
                }else{
                    XLSX.writeFile(wb, 'Internet_list.xlsx');
                }
            },
            exportToPDF(value) {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF({ orientation: 'landscape' });  // ตั้งค่าการจัดหน้าเป็นแนวนอน
                // const doc = new jsPDF();

                // const fontUrl = '/assets/fonts/THSarabun.ttf';
                // const fontUrl = '/images/THSarabun.ttf';

                // const base64Font = await this.fetchFontAsBase64(fontUrl);

                // doc.addFileToVFS('THSarabun.ttf', base64Font);
                // doc.addFont('THSarabun.ttf', 'THSarabun', 'normal');
                // doc.setFont('THSarabun');

                // โหลดฟอนต์ TH Sarabun
                // doc.addFileToVFS('THSarabun.ttf',base64Data);
                // doc.addFont('THSarabun.ttf', 'THSarabun', 'normal');
                // doc.setFont('THSarabun');

                const table = document.getElementById(value);
                // const table = document.getElementById('roomTable');

                const check_action = "<?php echo (has_permission('electric_management', 'view') || has_permission('electric_management', 'delete')) ? 'true' : 'false'; ?>";

                let headers;
                let rows;
                let footer;

                if(check_action === "true"){
                     headers = Array.from(table.querySelectorAll('thead th'))
                        .slice(0, -1)
                        .map(th => th.innerText.trim());
                    rows = Array.from(table.querySelectorAll('tbody tr')).map(tr => {
                        return Array.from(tr.querySelectorAll('td'))
                            .slice(0, -1)
                            .map(td => td.innerText.trim());
                    });
                    footer = Array.from(table.querySelectorAll('tfoot tr')).map(tr => {
                        let tds = Array.from(tr.querySelectorAll('td'))
                            .slice(0, -1)
                            .map(td => td.innerText.trim());
                        let emptyCells = Array(headers.length - tds.length).fill(''); // เพิ่มคอลัมน์ว่างตามจำนวนคอลัมน์ที่ขาดหาย
                        return [...emptyCells, ...tds]; // เพิ่มคอลัมน์ว่างที่จุดเริ่มต้นของ footer
                    });
                } else {
                    headers = Array.from(table.querySelectorAll('thead th'))
                        .map(th => th.innerText.trim());
                    rows = Array.from(table.querySelectorAll('tbody tr')).map(tr => {
                        return Array.from(tr.querySelectorAll('td'))
                            .map(td => td.innerText.trim());
                    });
                    footer = Array.from(table.querySelectorAll('tfoot tr')).map(tr => {
                        let tds = Array.from(tr.querySelectorAll('td'))
                            .map(td => td.innerText.trim());
                        let emptyCells = Array(headers.length - tds.length).fill(''); // เพิ่มคอลัมน์ว่างตามจำนวนคอลัมน์ที่ขาดหาย
                        return [...emptyCells, ...tds]; // เพิ่มคอลัมน์ว่างที่จุดเริ่มต้นของ footer
                    });
                }

                const combinedRows = rows.concat(footer);

                // const columnStyles = {
                //     0: { halign: 'center' },
                //     6: { halign: 'right' },
                //     7: { halign: 'right' },
                //     8: { halign: 'right' },
                //     9: { halign: 'right' },
                //     10: { halign: 'right' },
                //     11: { halign: 'right' },
                //     12: { halign: 'right' },
                // };

                doc.autoTable({
                    head: [headers],  // หัวข้อของตาราง
                    body: combinedRows,  // ข้อมูลของตารางรวมฟุตเตอร์
                    startY: 10,  // ระยะห่างจากขอบบนของหน้า
                    margin: { left: 10, right: 10 },  // ระยะห่างจากขอบซ้ายและขวา
                    theme: 'grid',  // รูปแบบของตาราง
                    styles: { overflow: 'linebreak', halign: 'left' },  // ใช้เพื่อให้แน่ใจว่าข้อความในเซลล์ไม่ล้นออกนอกขอบเขต และจัดตำแหน่งข้อความเริ่มต้นเป็นซ้าย
                    // columnStyles: columnStyles,
                    headStyles: {halign: 'center',fillColor: [16, 41, 88] }
                });

                // doc.save('electric_records.pdf');
                if(value === "roomTable"){
                    doc.save('Electric_list.pdf');
                }else if(value === "roomTable2"){
                    doc.save('Water_list.pdf');
                }else{
                    doc.save('Internet_list.pdf');
                }
            },
            editElectric: function(id) {
                <?php if (has_permission('electric_management', 'view')) : ?>
                location.href = '<?php echo edit_electric_url(); ?>'+ id;
                <?php endif; ?>
            },
            editWater: function(id) {
                <?php if (has_permission('water_management', 'view')) : ?>
                location.href = '<?php echo edit_water_url(); ?>'+ id;
                <?php endif; ?>
            },
            deleteElectric: function(id) {
                if (confirm('Delete this Electric ?')) {
                    let param = {'id': id};
                    $.post("<?php echo delete_electric_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                        } else {
                            alert('Delete Electric Success');
                            location.reload();
                        }
                    });
                }
            },
            deleteWater: function(id) {
                if (confirm('Delete this Room Type ?')) {
                    let param = {'id': id};
                    $.post("<?php echo delete_water_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                        } else {
                            alert('Delete Water Success');
                            location.reload();
                        }
                    });
                }
            },
            editInternet: function(id) {
                <?php if (has_permission('internet_management', 'view')) : ?>
                location.href = '<?php echo edit_internet_url(); ?>'+ id;
                <?php endif; ?>
            },
            deleteInternet: function(id) {
                if (confirm('Delete this Room Type ?')) {
                    let param = {'id': id};
                    $.post("<?php echo delete_internet_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                        } else {
                            alert('Delete Internet Success');
                            location.reload();
                        }
                    });
                }
            }
        }
    });
});
</script>