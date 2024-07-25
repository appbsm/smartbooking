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
                <!-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><?= _r('Setting', 'การตั้งค่า'); ?></li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo water_management_url(); ?>">{{ menu }}</a>
                        </li>
                    </ol>
                </div> -->

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

                <?php if (has_permission('water_management', 'edit')) : ?>
                    <a href="<?php echo edit_water_url(); ?>" style="color:white;">
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
                <div class="col-md-12">
                    <?php //if (has_permission('water_management', 'edit')) : ?>
                    <!-- <a href="<?php echo edit_water_url(); ?>" style="color:white;">
                        <button class="btn" style="float:right; width:170px; height:30px; line-height:9px; background-color:#0275d8; color:white; margin-bottom:20px;">
                            <?= _r('Create', 'สร้าง'); ?>
                        </button>
                    </a> -->
                    <?php //endif; ?>

                    <div style="width:100%; overflow:auto;">
                        <table id="roomTable" class="display" style="width:99%;">

                            <thead style="text-align:center;">
                                <tr>
                                    <th style="width:100px;"><?= _r('No', 'ลำดับ'); ?></th>
                                    <th style="width:160px;"><?= _r('Project', 'โครงการ'); ?></th>
                                    <th style="width:60px;"><?= _r('Rooms type', 'ห้อง'); ?></th>
                                    <th style="width:60px;"><?= _r('Room Number', 'หมายเลขห้อง'); ?></th>
                                    <th style="width:80px;"><?= _r('Meter ID', 'รหัสมิเตอร์'); ?></th>
                                    <th style="width:60px;"><?= _r('Serial No', 'หมายเลขซีเรียล'); ?></th>
                                    <!-- <th style="width:60px;"><?= _r('Status', 'สถานะ'); ?></th> -->

                                    <?php if (has_permission('water_management', 'view') || has_permission('water_management', 'delete')) : ?>
                                    <th style="width:80px;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                    <?php endif; ?>

                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="r in water_list">
                                    <td class="text-center">{{ r.run_id }}
                                        <!-- <img :src="r.image" style="width:100%;"> -->
                                    </td>
                                    <td>{{ <?= _r('r.project_name_en', 'r.project_name_th'); ?> }}</td>
                                    <td>{{ <?= _r('r.room_type_name_en', 'r.room_type_name_th'); ?> }}</td>
                                    <td>{{ <?= _r('r.room_name_en', 'r.room_name_th'); ?> }}</td>
                                    <td class="text-center">{{ r.meter_id }}</td>
                                    <td class="text-center">{{ r.serial_no }}</td>
                                    
                                    <!-- <td class="text-center">
                                        <span class="badge badge-success" v-if="r.is_active == 1">Active</span>
                                        <span class="badge badge-danger" v-if="r.is_active == 0">Inactive</span>
                                    </td> -->

                                    <?php if (has_permission('water_management', 'view') || has_permission('water_management', 'delete')) : ?>
                                    <td class="text-center">
                                        <?php if (has_permission('water_management', 'view')) : ?>
                                        <button class="btn btn-sm btn-warning" @click="editRoomType(r.id)">
                                            <i class="fa fa-pencil" style="color:black !important;"></i>
                                        </button>
                                        <?php endif; ?>
                                        <?php if (has_permission('water_management', 'delete')) : ?>
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

<script>
$(document).ready(function() {
    app = new Vue({
        el: '#vApp',
        data: {
            menu: "<?= _r('Water Meter List', 'รายการมิเตอร์น้ำ'); ?>",
            water_list: <?php echo json_encode($water_list); ?>
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
            editRoomType: function(id) {
                <?php if (has_permission('water_management', 'view')) : ?>
                location.href = '<?php echo edit_water_url(); ?>'+ id;
                <?php endif; ?>
            },
            deleteRoomType: function(id) {
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
            }
        }
    });
});
</script>