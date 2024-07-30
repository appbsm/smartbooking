
<!-- Content Header (Page header) -->
<div class="content-wrapper" id="vApp" style="padding-bottom:50px;" v-cloak>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link" :class="{ active: currentTab === 'tab1' }" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true"><?= _r('Email', 'อีเมล'); ?></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" :class="{ active: currentTab === 'tab2' }" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false"><?= _r('Rental Agreement', 'สัญญาเช่า'); ?></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" :class="{ active: currentTab === 'tab3' }" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false"><?= _r('Bill', 'บิล'); ?></a>
        </li>
    </ul>

    <div class="tab-content" >
        <div class="tab-pane fade" :class="{ 'show active': currentTab === 'tab1' }" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>{{ menu }}</h1>
                        </div>
                    </div>
                </div>
            </section>

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

        <div class="tab-pane fade" :class="{ 'show active': currentTab === 'tab2' }" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">

			<section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>{{ menu2 }}</h1>
                        </div>
                    </div>
                </div>
            </section>

            <div class="col-md-12" style="margin:15px 0px 0px 15px; padding-right:30px;" v-show="step == '1'">
                <div>
                    <textarea id="booked2">{{ email_template.booked }}</textarea>
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

        <div class="tab-pane fade" :class="{ 'show active': currentTab === 'tab3' }" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
            
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>{{ menu3 }}</h1>
                        </div>
                    </div>
                </div>
            </section>

            <div class="col-md-12" style="margin:15px 0px 0px 15px; padding-right:30px;" v-show="step == '1'">
                <div>
                    <textarea id="booked3">{{ email_template.booked }}</textarea>
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

</div>

<script src="<?php echo site_url(); ?>/asset/plugins/ckeditor/ckeditor.js"></script>
<script>
$(document).ready(function() {
    app = new Vue({
        el: '#vApp',
        data: {
            menu: "<?= _r('Email Setting', 'ตั้งค่าอีเมล'); ?>",
            menu2: "<?= _r('Email Setting2', 'ตั้งค่าอีเมล2'); ?>",
            menu3: "<?= _r('Email Setting3', 'ตั้งค่าอีเมล3'); ?>",
            step: '<?php echo empty($step) ? 1 : $step; ?>',
            sub_menu: ['Booked Email Template', 'Verifying Email Template', 'Confirmed Email Template'],
            currentTab: 'tab1',
            email_template: {
                'booked': `<?php echo $settings['booked_email_template']; ?>`,
                'verifying': `<?php echo $settings['verifying_email_template']; ?>`,
                'confirmed': `<?php echo $settings['confirmed_email_template']; ?>`
            },
        },
        mounted() {

            const urlParams = new URLSearchParams(window.location.search);
            const tabParam = urlParams.get('tab');
            if (tabParam === '2') {
                this.currentTab = 'tab2';
            } else if (tabParam === '3') {
                this.currentTab = 'tab3';
            }else {
                this.currentTab = 'tab1';
            }

            CKEDITOR.replace('booked');
            CKEDITOR.replace('booked2');
            CKEDITOR.replace('booked3');
            function CKupdate() {
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
            }


            // alert('currentTab : '+this.currentTab);
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