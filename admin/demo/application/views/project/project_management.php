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
                            <a href="<?php echo project_management_url(); ?>">{{ menu }}</a>
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
                <div class="col-md-10 offset-md-1">
                    <?php if (has_permission('project_management', 'edit')) : ?>
                    <a href="<?php echo edit_project_url(); ?>" style="color:white;">
                        <button class="btn" style="float:right; width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white; margin-bottom:20px;">
                            <?= _r('Add New Project', 'เพิ่มโปรเจกต์ใหม่'); ?>
                        </button>
                    </a>
                    <?php endif; ?>
                    <div style="width:100%; overflow:auto;">
                        <table id="projectTable" class="display" style="width:99%;">
                            <thead style="text-align:center;">
                                <tr>
                                    <th><?= _r('Project Name', 'ชื่อโปรเจกต์'); ?></th>
                                    <th style="width:320px;"><?= _r('Business Name', 'ชื่อบริษัท'); ?></th>
                                    <th style="width:200px;"><?= _r('Email', 'อีเมล'); ?></th>
                                    <th style="width:120px;"><?= _r('Phone Number', 'เบอร์โทร'); ?></th>

                                    <?php if (has_permission('project_management', 'view') || has_permission('project_management', 'delete')) : ?>
                                    <th style="width:100px;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="p in project_info">
                                    <td>{{ <?= _r('p.project_name_en', 'p.project_name_th'); ?> }}</td>
                                    <td>{{ <?= _r('p.business_name_en', 'p.business_name_th'); ?> }}</td>
                                    <td>{{ p.project_info_email }}</td>
                                    <td class="text-right">{{ p.project_info_phone_number }}</td>

                                    <?php if (has_permission('project_management', 'view') || has_permission('project_management', 'delete')) : ?>
                                    <td class="text-center">
                                        <?php if (has_permission('project_management', 'view')) : ?>
                                        <button class="btn btn-sm btn-warning" @click="editProject(p.id_project_info)">
                                            <i class="fa fa-pencil" style="color:black !important;"></i>
                                        </button>
                                        <?php endif; ?>
                                        <?php if (has_permission('project_management', 'delete')) : ?>
                                        <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deleteProject(p.id_project_info)">
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
            menu: "<?= _r('Project Management', 'ตั้งค่าโปรเจกต์'); ?>",
            project_info: <?php echo json_encode($project_info); ?>
        },
        mounted() {
            $("#projectTable").DataTable();
        },
        methods: {
            editProject: function(id) {
                <?php if (has_permission('project_management', 'view')) : ?>
                location.href = '<?php echo edit_project_url(); ?>'+ id;
                <?php endif; ?>
            },
            deleteProject: function(id) {
                if (confirm('Delete this Project ?')) {
                    let param = {'id': id};
                    $.post("<?php echo delete_project_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                        } else {
                            alert('Delete Project Success');
                            location.reload();
                        }
                    });
                }
            }
        }
    });
});
</script>