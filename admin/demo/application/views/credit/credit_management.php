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
                            <a href="<?php echo credit_url(); ?>">{{ menu }}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="editCreditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="height:90vh; overflow-y:auto;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{ edit_credit.id_credit == 0 ? '<?= _r('Add', 'เพิ่ม'); ?>' : '<?= _r('Update', 'แก้ไข'); ?>' }}<?= _r(' Credit', 'Credit'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <div class="col-md-11">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Credit Term', 'Credit Term'); ?></small>
                                <input type="number" class="form-control" style="margin-top:-3px;" v-model="edit_credit.credit_term">
                            </div>
                            <div class="col-md-6">
                                <small><?= _r('Credit Description', 'Credit Description'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_credit.credit_description">
                            </div>
                        </div>
                        
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;" @click="saveCredit()">{{ edit_credit.id_credit == 0 ? '<?= _r('Add', 'เพิ่ม'); ?>' : '<?= _r('Update', 'แก้ไข'); ?>' }}</button>
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
                <div class="col-md-10 offset-md-1">
                    <?php if (has_permission('credit_management', 'edit')) : ?>
                    <span style="width:100%;">
                        <button class="btn" style="float:right; width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white; margin-bottom:20px;" @click="loadEditCredit(0)">
                            <?= _r('Add Credit Term', 'Add Credit Term'); ?>
                        </button>
                    </span>
                    <?php endif; ?>

                    <div style="width:100%; overflow:auto;">
                        <table id=creditTable" class="display" style="width:99%;">
                            <thead>
                                <tr>
                                    <th class="w150"><?= _r('Credit Term', 'Credit Term'); ?></th>
                                    <th class="w150"><?= _r('Credit Description', 'Credit Description'); ?></th>
                                    <?php if (has_permission('credit_management', 'edit') || has_permission('credit_management', 'delete')) : ?>
                                    <th class="w70"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="c in shift_json(credit)">
                                    <td class="text-left">{{ <?= _r('c.credit_term', 'c.credit_term'); ?> }}</td>                                    
                                    <td class="text-right">{{ c.credit_description }}</td>
                                    <?php if (has_permission('credit_management', 'edit') || has_permission('credit_management', 'delete')) : ?>
                                    <td class="text-center">
                                        <?php if (has_permission('discount_management', 'edit')) : ?>
                                        <button class="btn btn-sm btn-warning" @click="loadEditCredit(c.id_credit)">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <?php endif; ?>
                                        <?php if (has_permission('credit_management', 'delete')) : ?>
                                        <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deleteCredit(c.id_credit)">
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
            menu: "<?= _r('Credit Management', 'Credit Management'); ?>",
            edit_credit: {},
            credit: <?php echo empty($credit) ? '{}' : json_encode($credit); ?>,
        },
        mounted() {
            let self = this;

           

            $("#creditTable").DataTable();
        },
        methods: {
            loadEditCredit: function(id) {
                let self = this;
                this.credit.forEach((v) => {
                    if (v.id_credit == id) {
                        self.edit_credit = JSON.parse(JSON.stringify(v));
                    }
                });
                $('#editCreditModal').modal('show');
            },
            deleteCredit: function(id) {
                if (confirm("Delete this Credit ?")) {
                    let param = {'id': id};
                    $.post("<?php echo delete_credit_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                            return;
                        } else {
                            alert('Delete Credit Success');
                            location.reload();
                        }
                    });
                }
            },
            saveCredit: function() {
                let self = this;
                
                var valid = true;
                var keys = Object.keys(this.edit_credit);
                keys.forEach((v) => {
                    if (valid && v != 'notes' && self.edit_credit[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                //
                
                $.post("<?php echo save_credit_url(); ?>", this.edit_credit, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Save Credit Success');
                        location.reload();
                    }
                });
                
            },
        }
    });
});
</script>