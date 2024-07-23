
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
.seq_no {
	width: 50px;
	float: right;
	margin-bottom: 2px;
}
.required {
	color: red;
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
						<li class="breadcrumb-item"><?= _r('SMS Unit Management', 'SMS Unit Management'); ?></li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo add_photo_unit_url(); ?>">{{ menu }}</a>
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
					
                    
                    <div style="width:100%; margin-top: 50px;">
                        <div class="row">
						  <div class="col-md-12 text-centered" style="text-align: center;">
						  <h4>
							<?php 
							//print_r($gallery_photos);
							
							echo _r($first['unit_name_en'], $first['unit_name_th']); ;?>
						  </h4>
						  <?php if (has_permission('unit_management', 'edit')) : ?>												
							<button class="btn btn-sms" style="float: right;" data-toggle="modal" data-target="#modal_add_new">
								<?= _r('Add New Photo', 'Add New Photo'); ?>
							</button>
						<?php endif; ?>
						  </div>
						  
						  <div class="column text-centered" v-for="(item, index) in sms_unit_photos" v-bind:key="item.id_unit_photo">
							<div v-if="item.unit_photo_url">

							<span>{{ <?= _r('item.unit_photo_desc_en', 'item.unit_photo_desc_th'); ?> }}</span>
							<img :src="item.image" style="width:100%;" onclick="show_Img(this);">
							<p style="margin-top: 3px;">
							<button class="btn btn-sms btn-sm" @click="get_photo(index)"><?= _r('Edit', 'Edit'); ?></button> 
							<button class="btn btn-sms btn-sm" @click="delete_photo(index)"><?= _r('Delete', 'Delete'); ?></button>
							</p>
							</div>
						  </div>
						  
						</div>
						
						<div class="container">
						  <span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
						  <img id="expandedImg" style="width:100%">
						  <div id="imgtext"></div>
						</div>
						
                    </div>
                </div>
            </div>

        </div>
		
		
    </section>
<!-- MODALS-->
<div class="modal fade" id="modal_add_new" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">New Photo Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form>
		<input type="hidden" v-model="id_sms_unit">
		<div class="input-group mb-3">
			<div class="input-group-prepend">				
			  <span class="input-group-text"><font color="red">*</font>Sequence</span>
			</div>
			<input type="text" v-model="sequence_order" class="form-control" placeholder="Order Sequence" required>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">				
			  <span class="input-group-text"><font color="red">*</font>Photo Description</span>
			</div>
			<input type="text" v-model="unit_photo_desc_en" class="form-control" placeholder="Photo Description" required>
		</div>
		
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				
			  <span class="input-group-text"><font color="red">*</font>Upload Photo</span>
			</div>
			<input class="form-control"  type="file" id="file" ref="file" required />
		</div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-sms" @click="uploadFile()">Submit</button>
      </div>
    </div>
  </div>
</div>

<!-- UPDATE -->
<div class="modal fade" id="modal_edit_photo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Update Photo Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form>
		<input type="hidden" v-model="id_sms_unit">
		<input type="hidden" v-model="photo_row_update.id_unit_photo">
		<div class="input-group mb-3">
			<div class="input-group-prepend">				
			  <span class="input-group-text"><font color="red">*</font>Sequence</span>
			</div>
			<input type="text" v-model="photo_row_update.sequence_order" class="form-control" placeholder="Order Sequence" required>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
			  
			  <span class="input-group-text"><font color="red">*</font>Photo Description</span>
			</div>
			<input type="text" v-model="photo_row_update.unit_photo_desc_en" class="form-control" placeholder="Photo Description" required>
		</div>
		
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				
			  <span class="input-group-text"><font color="red">*</font>Change Photo</span>
			</div>
			<input class="form-control" type="file" id="file_upd" ref="fileUpdate" required />
		</div>
		<div class="input-group mb-3">
			<img :src="photo_row_update.image" style="width:30%;">
		</div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
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
            menu: "<?= _r('Add Photo', 'Add Photo'); ?>",
			sms_unit_photos: <?php echo json_encode($sms_unit_photos); ?>,
			unit_photo_desc_en: '',
			first: <?php echo json_encode($first); ?>,
			id_sms_unit : "<?php echo json_encode($first['id_sms_unit']); ?>",
			file: "",
			fileUpdate: "",
			sequence_order: <?php echo ($photo_count+1); ?>,
			photo_row_update : {}
        },
        mounted() {
			console.log(this);
        },
        methods: {
			
			uploadFile: function(){

			   this.file = this.$refs.file.files[0];
				
			   let formData = new FormData();
			   formData.append('sequence_order', this.sequence_order);
			   formData.append('unit_photo_desc_en', this.unit_photo_desc_en);
			   formData.append('id_sms_unit', this.id_sms_unit);
			   formData.append('file', this.file);
			   console.log(this.id_sms_unit)
			   axios.post('<?php echo save_sms_unit_photo_url(); ?>', formData,
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
                            alert('Save Photo Success');
                            location.reload();
                        }

			   })
			   .catch(function (error) {
				   console.log(error);
			   });
				
			 },		
			 updateFile: function(){

			   this.fileUpdate = this.$refs.fileUpdate.files[0];
				console.log(this.fileUpdate)
				
			   let formData = new FormData();
			   formData.append('sequence_order', this.photo_row_update.sequence_order);
			   formData.append('unit_photo_desc_en', this.photo_row_update.unit_photo_desc_en);
			   formData.append('id_unit_photo', this.photo_row_update.id_unit_photo);
			   formData.append('id_gallery_category', this.id_gallery_category);
			   formData.append('file', this.fileUpdate);
			   
			   axios.post('<?php echo update_unit_photo_url(); ?>', formData,
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
                            alert('Update Photo Success');
                            location.reload();
                        }

			   })
			   .catch(function (error) {
				   console.log(error);
			   });
				
			 },					 
			 get_photo: function(id) {
				//console.log(this.gallery_photos[id])
				let self = this;
                self.photo_row_update = JSON.parse(JSON.stringify(this.sms_unit_photos[id]));
                $('#modal_edit_photo').modal('show');
            },
			delete_gallery_photo: function(id) {
				let selected = this.gallery_photos[id];
				var r = confirm ("Are you sure you want to delete this photo?");
				if (r) {
					let formData = new FormData();
					formData.append('id_gallery_photo', selected.id_gallery_photo);
                    axios.post('<?php echo delete_photo_url(); ?>', formData,
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
								alert('Delete Photo Success');
								location.reload();
							}

				   })
				   .catch(function (error) {
					   console.log(error);
				   });
					
				}
			},
			delete_photo: function(id) {
				let selected = this.sms_unit_photos[id];
				var r = confirm ("Are you sure you want to delete this photo?");
				if (r) {
					let param = {'id_unit_photo': selected.id_unit_photo};
					console.log(param);
					
                    $.post("<?php echo delete_sms_unit_photo_url(); ?>", param, function(res) {
                        console.log(res);
						if (res.result == 'false') {
                            alert(res.message);
                            return;
                        } 
						alert('Delete Photo Success');
                        location.reload();
                    });
				}
			}
        }
		
    });
	
	
});
function show_Img(imgs) {
  var expandImg = document.getElementById("expandedImg");
  var imgText = document.getElementById("imgtext");
  expandImg.src = imgs.src;
  imgText.innerHTML = imgs.alt;
  expandImg.parentElement.style.display = "block";
}
</script>