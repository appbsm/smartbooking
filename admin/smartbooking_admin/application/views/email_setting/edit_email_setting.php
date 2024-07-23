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
                            <a href="<?php echo edit_email_setting_url(); ?>">{{ menu }}</a>
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
                <div class="col-md-12" style="overflow-x:auto;">
                    <span v-for="(m, i) in sub_menu" :class="step == i+1 ? 'col-md-3 sub-menu active' : 'col-md-3 sub-menu'" @click="changeStep(i+1)">
                        <b>{{ m }}</b>
                    </span>
                </div>

                <div class="col-md-12 text-center" style="margin-top:20px;">
                    <h3>{{ sub_menu[step - 1] }}</h3>
                <div>

                <!-- Booked Email -->
                <div class="col-md-12" style="margin:15px 0px 0px 15px; padding-right:30px;" v-show="step == '1'">
                    <div>
                        <textarea id="booked">{{ email_template.booked }}</textarea>
                    </div>
                    <?php if (has_permission('edit_email_setting', 'edit')) : ?>
                    <div style="margin-top:20px;">
                        <button class="btn" style="width:200px; float:right; background-color:#0275d8; color:white;" @click="saveEmailSetting('booked')"><?= _r('Save', 'บันทึก'); ?> Booked Email</button>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Verifying Email -->
                <div class="col-md-12" style="margin:15px 0px 0px 15px; padding-right:30px;" v-show="step == '2'">
                    <div>
                        <textarea id="verifying">{{ email_template.verifying }}</textarea>
                    </div>
                    <?php if (has_permission('edit_email_setting', 'edit')) : ?>
                    <div style="margin-top:20px;">
                        <button class="btn" style="width:200px; float:right; background-color:#0275d8; color:white;" @click="saveEmailSetting('verifying')"><?= _r('Save', 'บันทึก'); ?> Verifying Email</button>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Confirmed Email -->
                <div class="col-md-12" style="margin:15px 0px 0px 15px; padding-right:30px;" v-show="step == '3'">
                    <div>
                        <textarea id="confirmed">{{ email_template.confirmed }}</textarea>
                    </div>
                    <?php if (has_permission('edit_email_setting', 'edit')) : ?>
                    <div style="margin-top:20px;">
                        <button class="btn" style="width:200px; float:right; background-color:#0275d8; color:white;" @click="saveEmailSetting('confirmed')"><?= _r('Save', 'บันทึก'); ?> Confirmed Email</button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </section>

</div>

<script src="<?php echo site_url(); ?>/asset/plugins/ckeditor/ckeditor.js"></script>
<script>
$(document).ready(function() {
    app = new Vue({
        el: '#vApp',
        data: {
            menu: "<?= _r('Email Setting', 'ตั้งค่าอีเมล'); ?>",
            step: '<?php echo empty($step) ? 1 : $step; ?>',
            sub_menu: ['Booked Email Template', 'Verifying Email Template', 'Confirmed Email Template'],
            email_template: {
                'booked': `<?php echo $settings['booked_email_template']; ?>`,
                'verifying': `<?php echo $settings['verifying_email_template']; ?>`,
                'confirmed': `<?php echo $settings['confirmed_email_template']; ?>`
            }
        },
        mounted() {
            CKEDITOR.replace('booked');
            CKEDITOR.replace('verifying');
            CKEDITOR.replace('confirmed');
            function CKupdate() {
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
            }
        },
        methods: {
            changeStep: function(v) {
                this.step = v;
            },
            saveEmailSetting: function(action) {
                let self = this;
                let param = {
                    'action': action,
                    'data': CKEDITOR.instances[action].getData()
                };

                $.post("<?php echo save_email_setting_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Update Email Setting Success');
                        location.href = "<?php echo edit_email_setting_url(); ?>?step="+ self.step;
                    }
                });
            }
        }
    });
});
</script>