 <!-- CDN for SheetJS -->
<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
<!-- CDN for jsPDF -->
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.4.0/dist/jspdf.umd.min.js"></script>
<!-- CDN for jsPDF autoTable -->
<script src="https://cdn.jsdelivr.net/npm/jspdf-autotable@3.5.23/dist/jspdf.plugin.autotable.min.js"></script>
<!-- CDN for xlsx-style -->
<script src="https://cdn.jsdelivr.net/npm/xlsx-style/dist/xlsx-style.full.min.js"></script>

<!-- Content Header (Page header) -->
<div class="content-wrapper" id="vApp" style="padding-bottom:50px;" v-cloak>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ menu }}</h1>
                </div>
               <!--  <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><?= _r('Setting', 'การตั้งค่า'); ?></li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo electric_management_url(); ?>">{{ menu }}</a>
                        </li>
                    </ol>
                </div> -->
            </div>
        </div>
    </section>

<section class="content">
<form action="<?php echo site_url('record_electric/record_electric_management') ?>" method="get">

    <div class="container-fluid center-content">
        <!-- justify-content-center -->
        <div class="row  w-100">
            <!-- justify-content-center -->
            <div class="col-md-12 d-flex ">
                <!-- <div class="form-inline"> -->
                    <label class="px-2" >Date From :</label> 
                    <div class="form-group px-3">
                        <input type="text" class="form-control date-picker" id="date_from" name="date_from" autocomplete="off" value="<?php if($date_from){echo $date_from;} ?>"> 
                     </div>
                     <label class="px-2" >Date To :</label>
                     <div class="form-group px-3">
                        <input type="text" class="form-control date-picker" id="date_to" name="date_to" autocomplete="off" value="<?php if($date_to){echo $date_to;} ?>"> 
                     </div>
                <!-- </div> -->
            </div>

            <div class="col-md-12 d-flex ">
                <!-- <div class="form-inline"> -->
                    <label class="px-2"><?= _r('Project :', 'โปรเจกต์ :'); ?></label> 
                    <div class="form-group px-3">
                        <select class="form-control" name="project" v-model="electric_info.id_project_info">
                            <option v-for="p in project_info" :value="p.id_project_info">{{ <?= _r('p.project_name_en', 'p.project_name_th'); ?> }}</option>
                        </select>
                     </div>

                     <label class="px-2" ><?= _r('Room Type :', 'ประเภทห้อง :'); ?></label>

                     <?php //if($date_from){echo $date_from;} ?>
                     <?php //if($date_to){echo $date_to;} ?>
                     <!-- v-model="electric_info.id_room_type" -->
                     <div class="form-group px-3">
                        <select class="form-control" name="room_type" @change="handleRoomTypeChange" v-model="electric_info.id_room_type" >
                            <option v-for="r in room_type" :value="r.id_room_type">{{ <?= _r('r.room_type_name_en', 'r.room_type_name_th'); ?> }}</option>
                        </select> 
                     </div>

                     <label class="px-2" ><?= _r('Room Number :', 'หมายเลขห้อง :'); ?></label>
                     <div class="form-group px-3">
                        <select class="form-control" name="room_details" v-model="electric_info.id_room_details" @change="handleRoomNumberChange" >
                            <option v-for="r in room_details" :value="r.id_room_details">{{ <?= _r('r.room_name_en', 'r.room_name_th'); ?> }}</option>
                        </select> 
                     </div>

                <!-- </div> -->
            </div>

        </div>

        <br>

        <div class="row justify-content-center w-100">
            <button style="background-color:#0275d8;" type="submit" class="btn btn-info">Search</button>
            <!-- &nbsp;&nbsp;&nbsp;
            <button type="button" id="btn_clear" class="btn btn-danger px-5">Clear Filter</button>   -->     
        </div>
    </div>

</form>
</section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12 " >

                    <div class="col-md-12 d-flex justify-content-end mt-3">
                    <div class="btn-group pull-right">

                    <button style="margin-right: 20px; width:170px; height:30px; line-height:9px; background-color:#1aac75; color:white;" class="btn btn-success dropdown-toggle" data-toggle="dropdown"><?= _r('Export Data', 'ส่งออกข้อมูล'); ?></button>

                    <ul class="dropdown-menu" >
                        <li>
                            <a @click="exportToExcel" style="display: inline-flex; align-items: center; margin-left: 10px; cursor: pointer;">
                                <img src='<?php echo site_url();?>images/xls.png' width="30" style="margin-right: 10px;" /> XLS</a>
                       </li>
                       <li>
                            <a @click="exportToPDF" style="display: inline-flex; align-items: center; margin-left: 10px; cursor: pointer;">
                                <img src='<?php echo site_url();?>images/pdf.png' width="30" style="margin-right: 10px;" /> PDF</a>
                       </li>
                    </ul>

                    <?php if (has_permission('electric_management', 'edit')) : ?>

                    <a href="<?php echo edit_record_electric_url(); ?>" style="color:white;">
                        <button class="btn" style="width:170px; height:30px; line-height:9px; background-color:#0275d8; color:white; margin-bottom:20px;">
                            <?= _r('Create', 'สร้าง'); ?>
                        </button>
                    </a>
                    <?php endif; ?>

                    </div>
                    </div>

                    <div style="width:100%; overflow:auto;">
                        <table id="roomTable" class="display" style="width:99%;">

                            <thead style="text-align:center;">
                                <tr>
                                    <th style="width:100px;"><?= _r('No', 'ลำดับ'); ?></th>
                                    <th style="width:160px;"><?= _r('Record Date', 'วันที่บันทึก'); ?></th>
                                    <th style="width:230px;"><?= _r('Meter ID', 'หมายเลขมิเตอร์'); ?></th>
                                    <th style="width:160px;"><?= _r('Project', 'โครงการ'); ?></th>
                                    <th style="width:60px;"><?= _r('Rooms type', 'ห้อง'); ?></th>
                                    <th style="width:60px;"><?= _r('Room Number', 'หมายเลขห้อง'); ?></th>
                                    <th style="width:80px;"><?= _r('Previous Unit', 'หน่วยก่อนหน้า'); ?></th>
                                    <th style="width:60px;"><?= _r('Current Unit', 'หน่วยปัจจุบัน'); ?></th>
                                    <th style="width:60px;"><?= _r('Qty', 'จำนวน'); ?></th>
                                    <th style="width:60px;"><?= _r('CT Value', 'CT Value'); ?></th>
                                    <th style="width:60px;"><?= _r('Qty*CT Value', 'จำนวน*CT Value'); ?></th>
                                    <th style="width:60px;"><?= _r('Unit Rate', 'อัตราต่อหน่วย'); ?></th>
                                    <th style="width:60px;"><?= _r('Amount(Inc. VAT)', 'ยอดรวม(ไม่รวม VAT)'); ?></th>

                                    <!-- <th style="width:60px;"><?= _r('Status', 'สถานะ'); ?></th> -->

                                    <?php if (has_permission('electric_management', 'view') || has_permission('electric_management', 'delete')) : ?>
                                    <th style="width:80px;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                    <?php endif; ?>


                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="r in electric_record">
                                    <td class="text-center">{{ r.run_id }}
                                        <!-- <img :src="r.image" style="width:100%;"> -->
                                    </td>
                                    <td class="text-center">{{ r.record_date_f }}</td>
                                    <td class="text-center">{{ r.meter_id }}</td>
                                    
                                    <td>{{ <?= _r('r.project_name_en', 'r.project_name_th'); ?> }}</td>
                                    <td>{{ <?= _r('r.room_type_name_en', 'r.room_type_name_th'); ?> }}</td>
                                    <td>{{ <?= _r('r.room_name_en', 'r.room_name_th'); ?> }}</td>
                                    <td class="text-center">{{ (parseFloat(r.previous_unit)).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                    <td class="text-center">{{ (parseFloat(r.current_unit)).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                    <td class="text-center">{{ (parseFloat(r.qty)).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                    <td class="text-center">{{ (parseFloat(r.ct)).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>

                                    <td class="text-center">{{ r.ct !== 0 && r.ct !== '' ? (r.qty * r.ct).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") : (parseFloat(r.qty)).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                    <td class="text-center">{{ (parseFloat(r.unit_rate)).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                    <td class="text-center">{{ r.ct !== 0 && r.ct !== '' ? ((r.qty * r.ct) * r.unit_rate).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") : (r.qty * r.unit_rate).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>

                                    <?php if (has_permission('electric_management', 'view') || has_permission('electric_management', 'delete')) : ?>
                                    <td class="text-center">
                                        <?php if (has_permission('electric_management', 'view')) : ?>
                                        <button class="btn btn-sm btn-warning" @click="loadEditDiscount(r.id)">
                                            <i class="fa fa-pencil" style="color:black !important;"></i>
                                        </button>
                                        <?php endif; ?>
                                    </td>
                                    <?php endif; ?>
                                    
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="10" class="text-right"><strong>Total:</strong></td>
                                    <td class="text-center">{{ totalQtyCTValue }}</td>
                                    <td class="text-center"></td>
                                    <td class="text-center">{{ totalAmount }}</td>
                                    <td class="text-center"></td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="editElectricModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="height:90vh; overflow-y:auto;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{ edit_electric.id == 0 ? '<?= _r('Add', 'เพิ่ม'); ?>' : '<?= _r('Update Record Eletric', 'แก้ไขรายละเอียดการใช้ไฟฟ้า'); ?>' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Record Date', 'วันที่จดบันทึก'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_electric.record_date_f" disabled="true">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Meter ID', 'รหัสมิเตอร์'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_electric.meter_id" disabled="true">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Project', 'โปรเจกต์'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="<?= _r('edit_electric.project_name_en', 'edit_electric.project_name_th'); ?>" disabled="true">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Room Type', 'ประเภทห้อง'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="<?= _r('edit_electric.room_type_name_en', 'edit_electric.room_type_name_th'); ?>" disabled="true">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Room Number', 'หมายเลขห้อง'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="<?= _r('edit_electric.room_name_th', 'edit_electric.room_name_en'); ?>" disabled="true">
                            </div>
                            
                        </div>
                    </div>

                    <hr>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Current Unit', 'หน่วยปัจจุบัน'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_electric.current_unit" >
                            </div>

                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Previous Unit', 'หน่วยก่อนหน้า'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_electric.previous_unit" disabled="true">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Qty', 'จำนวน'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_electric.qty" disabled="true">
                            </div>
                            
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Unit Rate', 'อัตราต่อหน่วย'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_electric.unit_rate" disabled="true">
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="row justify-content-center w-100">
                        <button type="button" class="btn btn-secondary"  onclick="close_edit()">Close</button>&nbsp;&nbsp;&nbsp;
                        <!-- <button type="submit" class="btn btn-info" style="background-color:#0275d8;" >Save</button> -->
                        <button type="button" class="btn btn-info" style="background-color:#0275d8;" @click="EditElectricInfo()" >Save</button>
                    </div>

                    
                </div>
            </div>        
        </div>
    </div>
        
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
<script>
    function close_edit() {
      $('#editElectricModal').modal('hide');
    }
</script>

<script>
$(document).ready(function() {
    app = new Vue({
        el: '#vApp',
        data: {
            menu: "<?= _r('Eletric Using Record Detail', 'บันทึกรายละเอียดการใช้ไฟฟ้า'); ?>",
            electric_record: <?php echo json_encode($electric_record); ?>,
            edit_electric: {},
            electric_info: <?php echo empty($electric_info) ? '{}' : json_encode($electric_info); ?>,
            project_info: <?php echo empty($project_info) ? '{}' : json_encode($project_info); ?>,
            room_type: <?php echo empty($room_type) ? '{}' : json_encode($room_type); ?>,
            room_details: <?php echo empty($room_details) ? '{}' : json_encode($room_details);?>
        },
        mounted() {
            $("#roomTable").DataTable();
            $("#date_from").datepicker({
                dateFormat: "dd-mm-yy",
                onSelect: function(d) {
                    const convertedDate = convertDateDash(d);
                    self.electric_info.record_date = convertedDate;
                    self.lastRecordDateChange(convertedDate);
                }
            });
            $("#date_to").datepicker({
                dateFormat: "dd-mm-yy",
                onSelect: function(d) {
                    const convertedDate = convertDateDash(d);
                    self.electric_info.record_date = convertedDate;
                    self.lastRecordDateChange(convertedDate);
                }
            });
            if (this.project_info.length > 0) {
                this.electric_info.id_project_info = this.project_info[0].id_project_info;
                this.fetchRoomTypes_start(this.electric_info.id_project_info);
            }
        },
        computed: {
            totalQtyCTValue() {
                return this.electric_record.reduce((total, r) => {
                    const qtyCTValue = (r.ct !== 0 && r.ct !== '') ? (r.qty * r.ct) : r.qty;
                    return total + (qtyCTValue || 0);
                }, 0).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            totalAmount() {
                return this.electric_record.reduce((total, r) => {
                    const qtyCTValue = (r.ct !== 0 && r.ct !== '') ? (r.qty * r.ct) : r.qty;
                    const amount = qtyCTValue * r.unit_rate;
                    return total + (amount || 0);
                }, 0).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        },
        methods: {
            exportToExcel() {
                const table = document.getElementById('roomTable');
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
                XLSX.writeFile(wb, 'electric_records.xlsx');
            },
            arrayBufferToBase64(buffer) {
                let binary = '';
                let bytes = new Uint8Array(buffer);
                let len = bytes.byteLength;
                for (let i = 0; i < len; i++) {
                    binary += String.fromCharCode(bytes[i]);
                }
                return window.btoa(binary);
            },
            fetchFontAsBase64(fontUrl) {
                try {
                    // const response = await fetch(fontUrl);
                    // if (!response.ok) {
                    //     throw new Error('Network response was not ok');
                    // }
                    // const arrayBuffer = await response.arrayBuffer();
                    // return this.arrayBufferToBase64(arrayBuffer);
                } catch (error) {
                    // console.error('Error fetching font:', error);
                    // throw error;
                }
            },
            exportToPDF() {
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

                const table = document.getElementById('roomTable');

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

                //ความกว้างหน้ากระดาษ A4 210
                // const columnStyles = {
                //     0: { cellWidth: 10 },
                //     1: { cellWidth: 20 },
                //     2: { cellWidth: 20 },
                //     3: { cellWidth: 20 },
                //     4: { cellWidth: 20 },
                //     5: { cellWidth: 10 },
                //     6: { cellWidth: 10 },
                //     7: { cellWidth: 12 },
                //     8: { cellWidth: 12 },
                //     9: { cellWidth: 12 },
                //     10: { cellWidth: 12 },
                //     11: { cellWidth: 12 },
                //     12: { cellWidth: 20 },
                // };

                const columnStyles = {
                    0: { halign: 'center' },
                    6: { halign: 'right' },
                    7: { halign: 'right' },
                    8: { halign: 'right' },
                    9: { halign: 'right' },
                    10: { halign: 'right' },
                    11: { halign: 'right' },
                    12: { halign: 'right' },
                };

                doc.autoTable({
                    head: [headers],  // หัวข้อของตาราง
                    body: combinedRows,  // ข้อมูลของตารางรวมฟุตเตอร์
                    startY: 10,  // ระยะห่างจากขอบบนของหน้า
                    margin: { left: 10, right: 10 },  // ระยะห่างจากขอบซ้ายและขวา
                    theme: 'grid',  // รูปแบบของตาราง
                    styles: { overflow: 'linebreak', halign: 'left' },  // ใช้เพื่อให้แน่ใจว่าข้อความในเซลล์ไม่ล้นออกนอกขอบเขต และจัดตำแหน่งข้อความเริ่มต้นเป็นซ้าย
                    columnStyles: columnStyles,
                    headStyles: {halign: 'center',fillColor: [16, 41, 88] }
                });

                doc.save('electric_records.pdf');
            },
            fetchRoomTypes_start: function(projectId) {
                var vm = this;
                $.ajax({
                    url: '<?php echo get_record_electric_by_project(); ?>/' + projectId,
                    method: 'GET',
                    success: function(response) {
                        vm.room_type = JSON.parse(response);
                        // vm.electric_list = null;
                        // vm.electric_info.id_room_type = null;
                        // vm.electric_info.id_room_details = null;
                        // vm.electric_info.electric_list_id = null;
                    },
                    error: function() {
                        alert('Failed to fetch room types.');
                    }
                });
            },
            fetchRoomTypes: function(projectId) {
                var vm = this;
                $.ajax({
                    url: '<?php echo get_record_electric_by_project(); ?>/' + projectId,
                    method: 'GET',
                    success: function(response) {
                        vm.room_type = JSON.parse(response);
                        vm.electric_list = null;
                        vm.electric_info.id_room_type = null;
                        vm.electric_info.id_room_details = null;
                        vm.electric_info.electric_list_id = null;
                        
                        // alert('success');
                    },
                    error: function() {
                        alert('Failed to fetch room types.');
                    }
                });
            },
            handleRoomTypeChange(event) {
                const newVal = event.target.value;
                // // alert('newVal:'+newVal);
                this.fetchRoomId(newVal);
            },
            handleRoomNumberChange(event) {
                const newVal = event.target.value;
                this.fetchRoomNumberId(newVal);
            },
            handleRoomNumberChange(event) {
                // const newVal = event.target.value;
                // this.fetchRoomNumberId(newVal);
            },
            fetchRoomId: function(roomtId) {
                var vm = this;
                $.ajax({
                    url: '<?php echo get_record_electric_by_room_details(); ?>/' + roomtId,
                    method: 'GET',
                    success: function(response) {
                        vm.room_details = JSON.parse(response);
                        vm.electric_list = null;
                        vm.electric_info.id_room_details = null;
                        vm.electric_info.electric_list_id = null;
                        // alert('success');
                    },
                    error: function() {
                        // alert('Failed to fetch room types. test');
                    }
                });
            },
            fetchRoomNumberId: function(roomtId) {
                var vm = this;
                $.ajax({
                    url: '<?php echo get_record_electric_by_room_number(); ?>/' + roomtId,
                    method: 'GET',
                    success: function(response) {
                        vm.electric_info.record_date = '';
                        vm.electric_info.current_unit = '';
                        vm.previous_unit = '';
                        vm.current_using = '';

                        // vm.electric_list = JSON.parse(response);
                        var result = JSON.parse(response);
                        var record = result[0];
                        if (result.length>0) {
                            vm.meter_name = record.meter_id;
                            vm.electric_info.id = record.id;
                            vm.meter_id = record.id;
                            vm.fetchLastDate(vm.meter_id);
                        } else {
                            vm.lastRecordDate = 'Meter data not found';
                            vm.meter_name = '';
                            vm.electric_info.id = null;
                            vm.meter_id = null;
                        }

                        // vm.electric_info.electric_list_id = null;
                        // alert('success'+record.meter_id);
                    },
                    error: function() {
                        alert('Failed to fetch room types. test');
                    }
                });
            },
            EditElectricInfo: function() {
                // alert('current_unit:'+this.edit_electric.current_unit);
                if (!this.edit_electric.current_unit) {
                // แสดงข้อความแจ้งเตือน
                    alert('กรุณากรอกข้อมูลทั้งหมด');
                    return; // หยุดการทำงานต่อไปถ้ามีค่าว่าง
                }

                if(this.edit_electric.current_unit <= this.edit_electric.previous_unit){
                    alert('มิเตอร์ปัจจุบันต้องมากกว่ามิเตอร์ก่อนหน้า');
                    return;
                }

                $.post("<?php echo edit_record_electric_id(); ?>", {
                    id: this.edit_electric.id,
                    current_unit: this.edit_electric.current_unit,
                    previous_unit: this.edit_electric.previous_unit,
                    qty: this.edit_electric.qty,
                    unit_rate: this.edit_electric.unit_rate
                }, function(response) {
                    // alert('success');
                    // ตรวจสอบการส่งค่ากลับ
                    if (response.success) {
                        // alert('บันทึกข้อมูลสำเร็จ');
                        alert('บันทึกข้อมูลสำเร็จ');
                        // ทำสิ่งที่ต้องการหลังจากบันทึกข้อมูลสำเร็จ เช่น รีเฟรชหน้าเว็บ
                        location.href = "<?php echo record_electric_management_url(); ?>";
                    } else {
                        alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' + response.message);
                        // กระทำตามที่ต้องการในกรณีเกิดข้อผิดพลาด
                    }
                }, 'json')
                .fail(function() {
                    alert('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์');
                });
            },
            loadEditDiscount: function(id) {
                let self = this;
                this.electric_record.forEach((v) => {
                    if (v.id == id) {
                        self.edit_electric = JSON.parse(JSON.stringify(v));
                    }
                });
                $('#editElectricModal').modal('show');
            },
            editRoomType: function(id) {
                <?php if (has_permission('electric_management', 'view')) : ?>
                location.href = '<?php echo edit_electric_url(); ?>'+ id;
                <?php endif; ?>
            },
            deleteRoomType: function(id) {
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
            }
        }
    });
});
</script>