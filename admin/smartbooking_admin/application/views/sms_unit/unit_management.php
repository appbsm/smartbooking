
<style>
* {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: Arial;
}

/* The grid: Four equal columns that floats next to each other */
.column {
  float: left;
  width: 25%;
  padding: 10px;
  text-align: center;
}

/* Style the images inside the grid */
.column img {
  opacity: 0.8; 
  cursor: pointer; 
}

.column img:hover {
  opacity: 1;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* The expanding image container */
.container {
  position: relative;
  display: none;
}

/* Expanding image text */
#imgtext {
  position: absolute;
  bottom: 15px;
  left: 15px;
  color: white;
  font-size: 20px;
}

/* Closable button inside the expanded image */
.closebtn {
  position: absolute;
  top: 10px;
  right: 15px;
  color: white;
  font-size: 35px;
  cursor: pointer;
}

.btn-sms {
	background-color:#809f4e; 
	color:white;
}
</style>


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
                            <a href="<?php echo sms_unit_management_url(); ?>">{{ menu }}</a>
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
                <div class="col-md-12">
                    <?php if (has_permission('unit_management', 'edit')) : ?>
						
						
                        <button class="btn btn-sms" data-toggle="modal" data-target="#exampleModal">
                            <?= _r('Add Unit Type', 'เพิ่ม Unit Type ใหม่'); ?>
                        </button>

                    <?php endif; ?>
                    <div style="width:100%; margin-top: 50px;">
                        <div class="row">
						
						  <div class="column text-centered" v-for="(r, index) in sms_units">
							<p style="margin-top: 3px;">
							<button class="btn btn-sms btn-sm" @click="get_sms_unit(index)"><?= _r('Edit', 'Edit'); ?></button> 
							<button class="btn btn-sms btn-sm" @click="delete_sms_unit(index)"><?= _r('Delete', 'Delete'); ?></button>
							</p>
							<a style="color:white;" @click="addPhoto(r.id_sms_unit)">
							<img :src="r.image" style="width:100%;">
							</a>
							<span>{{ <?= _r('r.unit_name_en', 'r.unit_name_th'); ?> }}</span>
							
						  </div>
						  
						</div>
						<!--
						<div class="container">
						  <span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
						  <img id="expandedImg" style="width:100%">
						  <div id="imgtext"></div>
						</div>
						-->
                    </div>
                </div>
            </div>

        </div>
    </section>
	
	
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">New SMS Unit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
			  <span class="input-group-text">Unit Name (En)</span>
			</div>
			<input type="text" v-model="unit_name_en" class="form-control" placeholder="English Name" required>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
			  <span class="input-group-text">Description (En)</span>
			</div>
			<!--<input type="text" v-model="unit_row_update.unit_name_en" class="form-control" placeholder="English Description" required>-->
			<textarea name="unit_description_en" v-model="unit_description_en" class="form-control" placeholder="English Description"></textarea>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
			  <span class="input-group-text">Unit Name (Th)</span>
			</div>
			<input type="text" v-model="unit_name_th" class="form-control" placeholder="Thai Name" required>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
			  <span class="input-group-text">Description (Th)</span>
			</div>
			<!--<input type="text" v-model="unit_row_update.unit_name_en" class="form-control" placeholder="English Description" required>-->
			<textarea name="unit_description_th" v-model="unit_description_th" class="form-control" placeholder="Thai Description"></textarea>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
			  <span class="input-group-text">Unit Thumbnail</span>
			</div>
			<input class="form-control"  type="file" id="file" ref="file" required />
		</div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
        <button type="submit" class="btn btn-sms" @click="uploadFile()">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_category_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Update SMS Unit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

		<form>
		<input type="hidden" v-model="unit_row_update.id_unit_photo">
		<div class="input-group mb-3">
			<div class="input-group-prepend">
			  <span class="input-group-text">Unit Name (En)</span>
			</div>
			<input type="text" v-model="unit_row_update.unit_name_en" class="form-control" placeholder="English Name" required>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
			  <span class="input-group-text">Description (En)</span>
			</div>
			<!--<input type="text" v-model="unit_row_update.unit_name_en" class="form-control" placeholder="English Description" required>-->
			<textarea name="unit_description_en" class="form-control" v-model="unit_row_update.unit_description_en"></textarea>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
			  <span class="input-group-text">Unit Name (Th)</span>
			</div>
			<input type="text" v-model="unit_row_update.unit_name_th" class="form-control" placeholder="Thai Name" required>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
			  <span class="input-group-text">Description (Th)</span>
			</div>
			<!--<input type="text" v-model="unit_row_update.unit_name_en" class="form-control" placeholder="English Description" required>-->
			<textarea name="unit_description_th" class="form-control" v-model="unit_row_update.unit_description_th"></textarea>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
			  <span class="input-group-text">Unit Thumbnail</span>
			</div>
			<input class="form-control"  type="file" id="file_upd" ref="fileUpdate" required />
		</div>
		<div class="input-group mb-3">
			<img :src="unit_row_update.image" style="width:30%;">
		</div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-sms" @click="updateFile()">Submit</button>
      </div>
    </div>
  </div>
</div>

</div>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
$(document).ready(function() {
    app = new Vue({
        el: '#vApp',
        data: {
            menu: "<?= _r('Unit Management', 'Unit Management'); ?>",
			sms_units: <?php echo json_encode($sms_units); ?>,
			unit_name_en: '',
			unit_name_th: '',
			unit_description_en: '',
			unit_description_th: '',
			file: "",
			fileUpdate: "",
			unit_row_update : {}

        },
        mounted() {
        },
        methods: {
			addPhoto: function(id){				
				location.href = "<?php echo add_photo_unit_url('"+id+"');?>";
			},
			uploadFile: function(){

			   this.file = this.$refs.file.files[0];

			   let formData = new FormData();
			   formData.append('unit_name_en', this.unit_name_en);
			   formData.append('unit_name_th', this.unit_name_th);
			   formData.append('unit_description_en', this.unit_description_en);
			   formData.append('unit_description_th', this.unit_description_th);
			   formData.append('file', this.file);
			   console.log(this);
			   
			   axios.post('<?php echo save_sms_unit_url(); ?>', formData,
			   {
				  headers: {
					'Content-Type': 'multipart/form-data'
				  }
			   })
			   .then(function (res) {

				  console.log(res);
						if (res.result == 'false') {
                            alert(res.message);
                        } else {
                            alert('Save SMS Unit Success');
                            location.reload();
                        }

			   })
			   .catch(function (error) {
				   console.log(error);
			   });
			  
				
			 },
			 updateFile: function(){

			   this.fileUpdate = this.$refs.fileUpdate.files[0];
				
			   //console.log(this.unit_row_update);
			   let formData = new FormData();
			   formData.append('unit_name_en', this.unit_row_update.unit_name_en);
			   formData.append('unit_name_th', this.unit_row_update.unit_name_th);
			   formData.append('unit_description_en', this.unit_row_update.unit_description_en);
			   formData.append('unit_description_th', this.unit_row_update.unit_description_th);
			   formData.append('id_sms_unit', this.unit_row_update.id_sms_unit);
			   formData.append('file', this.fileUpdate);
			   
			   
			   axios.post('<?php echo update_sms_unit_url(); ?>', formData,
			   {
				  headers: {
					'Content-Type': 'multipart/form-data'
				  }
			   })
			   .then(function (res) {

				  console.log(res);
						if (res.result == 'false') {
                            alert(res.message);
                        } else {
                            alert('Update Gallery Category Success');
                            location.reload();
                        }

			   })
			   .catch(function (error) {
				   console.log(error);
			   });
				
			 },
			 get_sms_unit: function(id) {				 
				let self = this;
                self.unit_row_update = JSON.parse(JSON.stringify(this.sms_units[id]));
                $('#modal_category_edit').modal('show');
            },
			delete_sms_unit: function(id) {
				let selected = this.sms_units[id];
				var r = confirm ("Are you sure you want to delete this photo?");
				if (r) {
					let param = {'id_sms_unit': selected.id_sms_unit};
					
                    $.post("<?php echo delete_sms_unit_url(); ?>", param, function(res) {
                        console.log(res);
						if (res.result == 'false') {
                            alert(res.message);
                            return;
                        } 
						alert('Delete SMS Unit Success');
                        location.reload();
                    });
				}
			}			 
        }
    });
	
	
});

</script>