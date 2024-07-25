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
            

                <div class="col-sm-6 d-flex justify-content-end align-items-center">
                    <div class="dropdown mr-2">
                        <button class="btn btn-success dropdown-toggle" style="width:170px; height:30px; line-height:9px; background-color:#1aac75; color:white;" data-toggle="dropdown">
                            <?= _r('Export Data', 'ส่งออกข้อมูล'); ?>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a @click="exportToExcel" style="display: inline-flex; align-items: center; margin-left: 10px; cursor: pointer;">
                                    <img src='<?php echo site_url();?>images/xls.png' width="30" style="margin-right: 10px;" /> XLS
                                </a>
                            </li>
                            <li>
                                <a @click="exportToPDF" style="display: inline-flex; align-items: center; margin-left: 10px; cursor: pointer;">
                                    <img src='<?php echo site_url();?>images/pdf.png' width="30" style="margin-right: 10px;" /> PDF
                                </a>
                            </li> 
                        </ul>
                    </div>

                    <?php if (has_permission('unit_management', 'edit')) : ?>
                        <a href="<?php echo edit_unit_url(); ?>" style="color:white;">
                            <button class="btn" style="width:170px; height:30px; line-height:9px; background-color:#0275d8; color:white;">
                                <?= _r('Create', 'สร้าง'); ?>
                            </button>
                        </a>
                    <?php endif; ?>
                </div>

            </div>    
        </div>
    </section>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12 " >
                    <div style="width:100%; overflow:auto;">
                        <table id="roomTable" class="display" style="width:99%;">

                            <thead style="text-align:center;">
                                <tr>
                                    <th style="width:100px;"><?= _r('No', 'ลำดับ'); ?></th>
                                    <th style="width:160px;"><?= _r('Price List Desc', 'รายการราคา'); ?></th>
                                    <th style="width:160px;"><?= _r('Unit Rate', 'อัตราต่อหน่วย'); ?></th>
                                    <th style="width:230px;"><?= _r('Start Date', 'วันเริ่ม'); ?></th>
                                    <th style="width:160px;"><?= _r('End Date', 'วันสิ้นสุด'); ?></th>
                                    <th style="width:60px;"><?= _r('Status', 'สถานะ'); ?></th>

                                    <?php if (has_permission('unit_management', 'view') || has_permission('unit_management', 'delete')) : ?>
                                    <th style="width:80px;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                    <?php endif; ?>


                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="r in setting_unit_rate">
                                    <td class="text-center">{{ r.run_id }}
                                    </td>
                                    <td class="text-center">{{ r.type }}</td>
                                    <td class="text-center">{{ (parseFloat(r.unit_rate)).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                    <td class="text-center">{{ r.start_date }}</td>
                                    <td class="text-center">{{ r.expire_date }}</td>

                                    <td class="text-center">
                                        <span class="badge badge-success" v-if="r.status == 1">Active</span>
                                        <span class="badge badge-danger" v-else>Inactive</span>
                                    </td>
                                   
                                    <?php if (has_permission('unit_management', 'view') || has_permission('unit_management', 'delete')) : ?>
                                    <td class="text-center">
                                        <?php if (has_permission('unit_management', 'view')) : ?>
                                        <button class="btn btn-sm btn-warning" @click="loadEditDiscount(r.id)">
                                            <i class="fa fa-pencil" style="color:black !important;"></i>
                                        </button>
                                        <?php endif; ?>

                                        <?php if (has_permission('unit_management', 'delete')) : ?>
                                        <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deleteRoomType(r.id)">
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

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>

<script>
$(document).ready(function() {
    app = new Vue({
        el: '#vApp',
        data: {
            menu: "<?= _r('Setting Unit Rate', 'การตั้งค่าอัตราต่อหน่วย'); ?>",
            setting_unit_rate: <?php echo json_encode($setting_unit_rate); ?>,
            edit_setting: {}
        },
        mounted() {
            $("#roomTable").DataTable();
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

                doc.save('electric_records.pdf');
            },
            EditUnitInfo: function() {
                // alert('current_unit:'+this.edit_electric.current_unit);
                if (!this.edit_setting.current_unit) {
                // แสดงข้อความแจ้งเตือน
                    alert('กรุณากรอกข้อมูลทั้งหมด');
                    return; // หยุดการทำงานต่อไปถ้ามีค่าว่าง
                }

                if(this.edit_setting.current_unit <= this.edit_setting.previous_unit){
                    alert('มิเตอร์ปัจจุบันต้องมากกว่ามิเตอร์ก่อนหน้า');
                    return;
                }

                $.post("<?php echo edit_unit_id(); ?>", {
                    id: this.edit_setting.id,
                    current_unit: this.edit_setting.current_unit,
                    previous_unit: this.edit_setting.previous_unit,
                    qty: this.edit_setting.qty,
                    unit_rate: this.edit_setting.unit_rate
                }, function(response) {
                    // alert('success');
                    // ตรวจสอบการส่งค่ากลับ
                    if (response.success) {
                        // alert('บันทึกข้อมูลสำเร็จ');
                        alert('บันทึกข้อมูลสำเร็จ');
                        // ทำสิ่งที่ต้องการหลังจากบันทึกข้อมูลสำเร็จ เช่น รีเฟรชหน้าเว็บ
                        location.href = "<?php echo unit_management_url(); ?>";
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
                this.setting_unit_rate.forEach((v) => {
                    if (v.id == id) {
                        self.edit_setting = JSON.parse(JSON.stringify(v));
                    }
                });
                $('#editUnitModal').modal('show');
            },
            editRoomType: function(id) {
                <?php if (has_permission('unit_management', 'view')) : ?>
                location.href = '<?php echo edit_setting_url(); ?>'+ id;
                <?php endif; ?>
            },
            deleteRoomType: function(id) {
                if (confirm('Delete this Setting Unit ?')) {
                    let param = {'id': id};
                    $.post("<?php echo delete_setting_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                        } else {
                            alert('Delete Setting Unit Success');
                            location.reload();
                        }
                    });
                }
            }
        }
    });
});
</script>