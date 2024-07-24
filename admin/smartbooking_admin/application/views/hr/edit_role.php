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
                        <li class="breadcrumb-item"><?= _r('HR', 'จัดการผู้ใช้งาน'); ?></li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo role_management_url(); ?>"><?= _r('Role Management', 'ตั้งค่า Role'); ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo edit_role_url($role['id_role']); ?>">{{ menu }}</a>
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
                <!-- Role Info -->
                <!--<div class="col-md-10 offset-md-1">-->
				<div class="col-md-12 ">
                    <div class="col-md-11" style="margin-top:30px;">
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-12">
                                <small><font color="red">*</font> <?= _r('Role Name', 'ชื่อ Role'); ?></small>
                                <input type="text" class="form-control" v-model="role.role_name">
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-12">
                                <small><?= _r('Description', 'รายละเอียด'); ?></small>
                                <textarea rows="3" class="form-control" v-model="role.description"></textarea>
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-12">
                                <small><font color="red">*</font> <?= _r('Status', 'สถานะ'); ?></small>
                                <select class="form-control" v-model="role.active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top:20px">
                            <div class="col-md-8 offset-md-2">
                                <small><?= _r('Module Permission', 'สิทธิ์การเข้าถึงเมนู'); ?></small>
                                <div style="width:100%; overflow:auto;">
                                    <table style="min-width:500px; width:100%;">
                                        <thead style="text-align:center;">
                                            <tr>
                                                <th style="width:150px;"><?= _r('Module Name', 'ชื่อเมนู'); ?></th>
                                                <th><?= _r('Module Url', 'ลิงก์เมนู'); ?></th>
                                                <th style="width:80px;"><?= _r('Can View', 'สิทธิ์ดู'); ?></th>
                                                <th style="width:80px;"><?= _r('Can Edit', 'สิทธิ์แก้ไข'); ?></th>
                                                <th style="width:80px;"><?= _r('Can Delete', 'สิทธิ์ลบ'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="m in modules">
                                                <td>{{ m.module_name }}</td>
                                                <td>{{ m.module_url }}</td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-control" :checked='m.can_view' style="width:15px; margin:auto;" v-model="m.can_view">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-control" :checked='m.can_edit' style="width:15px; margin:auto;" v-model="m.can_edit">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-control" :checked='m.can_delete' style="width:15px; margin:auto;" v-model="m.can_delete">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <?php if (has_permission('role_management', 'edit')) : ?>
                        <div class="row" style="margin-top:20px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#0275d8; color:white;" @click="saveRole()"><?php echo empty($role['id_role']) ? "Add" : "Update"; ?></button>
                            </div>
                        </div>
                        <?php endif; ?>
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
            menu: '<?php echo empty($role['id_role']) ? _r("Add Role", "เพิ่ม Role") : _r("Update Role", "แก้ไข Role"); ?>',
            role: <?php echo empty($role) ? '{}' : json_encode($role); ?>,
            modules: <?php echo empty($modules) ? '{}' : json_encode($modules); ?>
        },
        mounted() {},
        methods: {
            saveRole: function() {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.role);
                keys.forEach((v) => {
                    if (valid && v != 'id_role' && v != 'description' && v != 'date_created' && self.role[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                //
                param = {'role': this.role, 'modules': this.modules};
                $.post("<?php echo save_role_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Save Role Success');
                        location.href = "<?php echo edit_role_url(); ?>"+ res.message;
                    }
                });
            }
        }
    });
});
</script>