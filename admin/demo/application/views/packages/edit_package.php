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
                            <a href="<?php echo package_url(); ?>"><?= _r('Package Management', 'ตั้งค่าแพ็กเกจ'); ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo edit_package_url($package_info['id_package']); ?>">
                                {{ menu }}{{ package_info.id_package ? (' ('+ package_info.id_package +')') : '' }}
                            </a>
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
                <!-- Package Info -->
                <div class="col-md-12">
                    <div class="row" style="margin-top:5px">
                        <div class="col-md-6">
                            <small><font color="red">*</font> <?= _r('Package Name', 'ชื่อแพ็กเกจ'); ?></small>
                            <input type="text" class="form-control" id="name" v-model="package_info.name">
                        </div>
                        <div class="col-md-6">
                            <small><font color="red">*</font> <?= _r('Package Price', 'ราคาแพ็กเกจ'); ?></small>
                            <input type="number" class="form-control" id="price" v-model="package_info.price">
                        </div>
                    </div>
                    <div class="row" style="margin-top:5px">
                        <div class="col-md-6">
                            <small><font color="red">*</font> <?= _r('Start Date', 'ใช้ได้ตั้งแต่วันที่'); ?></small>
                            <input type="text" class="form-control" id="start_date" :value="convertDateSlash(package_info.start_date)" autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <small><font color="red">*</font> <?= _r('End Date', 'ใช้ได้ถึงวันที่'); ?></small>
                            <input type="text" class="form-control" id="end_date" :value="convertDateSlash(package_info.end_date)" autocomplete="off">
                        </div>
                    </div>
                    <div class="row" style="margin-top:5px">
                        <div class="col-md-6">
                            <small><font color="red">*</font> <?= _r('Project', 'โปรเจกต์'); ?></small>
                            <select class="form-control" id="id_project_info" v-model="package_info.id_project_info">
                                <option v-for="p in projects" :value="p.id_project_info">{{ p.project_name_en }}</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <small><font color="red">*</font> <?= _r('Package Status', 'สถานะแพ็กเกจ'); ?></small>
                            <select class="form-control" id="is_active" v-model="package_info.is_active">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-5">
                           

                        <!-- Upload Image Package -->
                        <form method='post' action="<?php echo site_url('upload') . '/upload_image'; ?>" enctype='multipart/form-data'>
                            <input type="hidden" id="package_id" name="package_id" v-model="package_info.id_package">
                            <input type='file' id='package_photo' name='package_photo' accept="image/*"> <br/><br/>                          
                            <input type='submit' value='Upload' name='upload' />
                        </form>
                        <!-- End Upload Image Package -->


                        </div>
                    </div>
                    <div style="margin-top:20px;">
                        <u><b><?= _r('Room', 'ห้องพัก'); ?></b></u>
                        <div class="row" style="margin-top:23px;">
                            <div class="col-md-4" v-for="(r, i) in sort_room" style="margin-bottom:30px;">
                                <span style="font-size:12px; color:#bfbfbf; position:absolute; top:-20px;" v-if="i == 0 || r.id_project_info != sort_room[i - 1].id_project_info">
                                    <i>({{ <?= _r('r.project_name_en', 'r.project_name_th'); ?> }})</i>
                                </span>
                                <input type="checkbox" @click="selectRoom(r.id_room_type, $event)" :checked='r.is_selected' style="width:17px; height:17px;">
                                <span style="font-size:14px; position:absolute; top:-2px; padding-left:5px;">
                                    {{ <?= _r('r.room_type_name_en', 'r.room_type_name_th'); ?> }}
                                    <span style="font-weight:bold;" v-show="r.qty > 0"> (x{{ r.qty }})</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save -->
                <?php if (has_permission('package_management', 'edit')) : ?>
                <div class="col-md-12">
                    <div class="row" style="margin-top:15px">
                        <div class="col-md-12" style="text-align:center">
                            <button class="btn" style="width:200px; height:34.5px; line-height:9px; background-color:#809f4e; color:white;" @click="savePackageInfo()"><?= _r('Save', 'บันทึก'); ?></button>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    app = new Vue({
        el: '#vApp',
        data: {
            menu: '<?php echo empty($package_info['id_package']) ? _r("Add Package", "เพิ่มแพ็กเกจ") : _r("Update Package", "แก้ไขแพ็กเกจ"); ?>',
            package_info: <?php echo empty($package_info) ? '{}' : json_encode($package_info); ?>,
            rooms: <?php echo empty($rooms) ? '{}' : json_encode($rooms); ?>,
            projects: <?php echo empty($projects) ? '{}' : json_encode($projects); ?>,
            sort_room: []
        },
        mounted() {
            let self = this;

            $("#start_date").datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function(d) {
                    self.package_info.start_date = convertDateDash(d);
                }
            });
            $("#end_date").datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function(d) {
                    self.package_info.end_date = convertDateDash(d);
                }
            });

            this.sort_room = this.sortRoom();
        },
        methods: {
            savePackageInfo: function() {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.package_info);
                keys.forEach((v) => {
                    if (valid && self.package_info[v] === '' && !['id_package', 'staff_id'].includes(v)) {
                        valid = false;
                        alert("Empty "+ v);
                        $('#'+ v).focus();
                    }
                });
                if (!valid) {
                    return;
                }

                if (!validateDate(this.package_info.start_date)) {
                    alert("Invalid start_date");
                    $('#start_date').focus();
                    return;
                }
                if (!validateDate(this.package_info.end_date)) {
                    alert("Invalid end_date");
                    $('#end_date').focus();
                    return;
                }
                if (dateDiff(this.package_info.start_date, this.package_info.end_date) < 0) {
                    alert("start_date  must less than or equal to  end_date");
                    $('#start_date').focus();
                    return;
                }

                // check rooms
                let tmp_room = [];
                let rooms_key = Object.keys(this.rooms);
                rooms_key.forEach((k) => {
                    let r = self.rooms[k];
                    if (r.is_selected) {
                        if (valid && r.id_project_info != self.package_info.id_project_info) {
                            valid = false;
                            alert('Must select only rooms in selected project');
                        }

                        tmp_room.push(JSON.parse(JSON.stringify(r)));
                    }
                });
                if (!valid) {
                    return;
                }
                if (tmp_room.length == 0) {
                    alert('Please Select Room');
                    return;
                }

                //////////
                let param = {
                    package_info: this.package_info,
                    rooms: tmp_room
                };

                $.blockUI({css:{'backgroundColor':'#d9d9d9', 'padding-top':'10px'}});
                $.post("<?php echo save_package_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        $.unblockUI();
                        return;
                    } else {
                        alert('Save Package Success');
                        location.href = "<?php echo edit_package_url(); ?>"+ res.message;
                    }
                });
            },
            selectRoom: function(id) {
                if (this.rooms[id]['is_selected']) {
                    this.rooms[id]['is_selected'] = 0;
                    this.rooms[id]['qty'] = 0;
                } else {
                    let qty = prompt("Please enter Quantity", "1");
                    if (!isNumber(qty) || qty <= 0) {
                        alert("Invalid Quantity");
                        let el = event.target;
                        $(el).prop("checked", false);
                        return;
                    }

                    this.rooms[id]['is_selected'] = 1;
                    this.rooms[id]['qty'] = qty;
                }
                this.updatePackagePrice();
            },
            updatePackagePrice: function() {
                let self = this;
                let param = {
                    package: this.package_info,
                    rooms: this.rooms
                };

                $.post("<?php echo calculate_package_price_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        self.package_info.price = res.message.price;
                    }
                });
            },
            sortRoom: function() {
                let tmp = Object.values(this.rooms);
                tmp.sort(function(a, b) {
                    if (a.id_project_info != b.id_project_info) {
                        return parseInt(a.id_project_info) - parseInt(b.id_project_info);
                    } else {
                        if (a.id_room_type != b.id_room_type) {
                            return parseInt(a.id_room_type) - parseInt(b.id_room_type);
                        }
                    }
                });
                return tmp;
            }
        }
    });
});
</script>