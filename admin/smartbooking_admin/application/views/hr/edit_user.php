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
                            <a href="<?php echo user_management_url(); ?>"><?= _r('User Management', 'ตั้งค่า User'); ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo edit_user_url($user['id_user']); ?>">{{ menu }}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="overflow-y:auto;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1"><?= _r('Change Password', 'เปลี่ยนรหัสผ่าน'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <small><font color="red">*</font> <?= _r('Old Password', 'รหัสผ่านเก่า'); ?></small>
                                <input type="password" class="form-control" style="margin-top:-3px;" v-model="change_password.old_password">
                            </div>
                            <div class="col-md-12">
                                <small><font color="red">*</font> <?= _r('New Password', 'รหัสผ่านใหม่'); ?></small>
                                <input type="password" class="form-control" style="margin-top:-3px;" v-model="change_password.new_password">
                            </div>
                            <div class="col-md-12">
                                <small><font color="red">*</font> <?= _r('Confirm New Password', 'ยืนยันรหัสผ่านใหม่'); ?></small>
                                <input type="password" class="form-control" style="margin-top:-3px;" v-model="change_password.confirm_new_password">
                            </div>
                        </div>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#0275d8; color:white;" @click="changePassword()"><?= _r('Submit', 'ตกลง'); ?></button>
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
                <?php $s = $this->session->userdata('user_data'); ?>
                <?php if (has_permission('user_management', 'edit') || $s['id_user'] == $user['id_user']) : ?>
                <div class="col-md-12">
                    <button class="btn" data-toggle="modal" data-target="#changePasswordModal" style="float:right; width:150px; height:30px; line-height:9px; background-color:#0275d8; color:white; margin-bottom:20px;">
                        <?= _r('Change Password', 'เปลี่ยนรหัสผ่าน'); ?>
                    </button>
                </div>
                <?php endif; ?>
                <div class="col-md-10 offset-md-1">
                    <div class="col-md-11" style="margin-top:30px;">
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Name', 'ชื่อ'); ?></small>
                                <input type="text" class="form-control" v-model="user.name">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Email', 'อีเมล'); ?></small>
                                <input type="text" class="form-control" v-model="user.email">
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Username', 'ยูสเซอร์เนม'); ?></small>
                                <input type="text" rows="3" class="form-control" v-model="user.username">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Password', 'รหัสผ่าน'); ?></small>
                                <input type="text" rows="3" class="form-control" v-model="user.password" disabled v-if="user.id_user">
                                <input type="text" rows="3" class="form-control" v-model="user.password" v-else>
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> Role</small>
                                <select class="form-control" v-model="user.id_role">
                                    <option v-for="role in roles" :value="role.id_role">{{ role.role_name }}</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Status', 'สถานะ'); ?></small>
                                <select class="form-control" v-model="user.active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <?php if (has_permission('user_management', 'edit') || $s['id_user'] == $user['id_user']) : ?>
                        <div class="row" style="margin-top:20px">
                            <div class="col-md-12" style="text-align:center">
								<!-- background-color:#809f4e; -->
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#0275d8; color:white;" @click="saveUser()"><?php echo empty($user['id_user']) ? "Add" : "Update"; ?></button>
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
            menu: '<?php echo empty($user['id_user']) ? _r("Add User", "เพิ่ม User") : _r("Update User", "แก้ไข User"); ?>',
            user: <?php echo empty($user) ? '{}' : json_encode($user); ?>,
            roles: <?php echo empty($roles) ? '{}' : json_encode($roles); ?>,            
            change_password: {
                'id_user': '<?php echo empty($user['id_user']) ? '' : $user['id_user']; ?>',
                'old_password': '',
                'new_password': '',
                'confirm_new_password': '',
                'action': '<?php echo $action; ?>'
            }
        },
        mounted() {
            if (this.change_password.action == 'first_login') {
                $('#changePasswordModal').modal('show');
            }
        },
        methods: {
            saveUser: function() {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.user);
                keys.forEach((v) => {
                    if (valid && !['id_user', 'role_name', 'date_created', 'last_login'].includes(v) && self.user[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                if (!validateEmail(this.user.email)) {
                    alert('Invalid email');
                    return;
                }
                if (this.user.password.length < 8) {
                    alert('Password must have at least 8 characters.');
                    return;
                }

                //
                $.post("<?php echo save_user_url(); ?>", this.user, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Save User Success');
                        location.href = "<?php echo edit_user_url(); ?>"+ res.message;
                    }
                });
            },
            changePassword: function() {
                let self = this;
                if (this.change_password.new_password != this.change_password.confirm_new_password) {
                    alert('Confirm password is not match.');
                    return;
                }

                if (this.change_password.new_password == this.change_password.old_password) {
                    alert('New password can not be the same with old password.');
                    return;
                }

                if (this.change_password.new_password.length < 8) {
                    alert('Password must have at least 8 character.');
                    return;
                }
                if (this.change_password.new_password.search(/[0-9]/) < 0) {
                    alert("Password must contain at least one number.");
                    return;
                }
                if (this.change_password.new_password.search(/[a-z]/) < 0) {
                    alert("Password must contain at least one lowercase letter.");
                    return;
                }
                if (this.change_password.new_password.search(/[A-Z]/) < 0) {
                    alert("Password must contain at least one uppercase letter.");
                    return;
                }
                if (this.change_password.new_password.search(/[#?!@$%^&*-]/) < 0) {
                    alert("Password must contain at least one special character.");
                    return;
                }

                //
                $.post("<?php echo change_password_url(); ?>", this.change_password, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Change Password Success');
                        if (self.change_password.action == 'first_login') {
                            location.href = "<?php echo home_url(); ?>";
                        } else {
                            location.reload();
                        }
                    }
                });
            }
        }
    });
});
</script>