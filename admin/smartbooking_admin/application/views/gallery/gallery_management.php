
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
                            <a href="<?php echo gallery_management_url(); ?>">{{ menu }}</a>
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
                    <?php if (has_permission('gallery_management', 'edit')) : ?>
						
						
                        <button class="btn btn-sms" data-toggle="modal" data-target="#exampleModal">
 
                            <?= _r('Add Gallery Type', 'เพิ่ม Gallery Type ใหม่'); ?>
                        </button>

                    <?php endif; ?>
                    <div style="width:100%; margin-top: 50px;">
                        <div class="row">
						
						  <div class="column text-centered" v-for="(r, index) in gallery_categories">
							<span>{{ <?= _r('r.gallery_name_en', 'r.gallery_name_th'); ?> }}</span>
							<a style="color:white;" @click="addPhoto(r.id_gallery_category)">
							<img :src="r.image" style="width:100%;">
							</a>
							<p style="margin-top: 3px;">
							<button class="btn btn-sms btn-sm" @click="get_category(index)"><?= _r('Edit', 'Edit'); ?></button> 
							<button class="btn btn-sms btn-sm" @click="delete_gallery(index)"><?= _r('Delete', 'Delete'); ?></button>
							</p>
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
        <h5 class="modal-title" id="exampleModalLongTitle">New Gallery Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form>
		<form>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
			  <span class="input-group-text">Gallery Name (En)</span>
			</div>
			<input type="text" v-model="gallery_name_en" class="form-control" placeholder="English Description" required>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
			  <span class="input-group-text">Gallery Name (Th)</span>
			</div>
			<input type="text" v-model="gallery_name_th" class="form-control" placeholder="Thai Description" required>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
			  <span class="input-group-text">Category Thumbnail</span>
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
        <h5 class="modal-title" id="exampleModalLongTitle">Update Gallery Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

		<form>
		<input type="hidden" v-model="category_row_update.id_gallery_photo">
		<div class="input-group mb-3">
			<div class="input-group-prepend">
			  <span class="input-group-text">Gallery Name (En)</span>
			</div>
			<input type="text" v-model="category_row_update.gallery_name_en" class="form-control" placeholder="English Description" required>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
			  <span class="input-group-text">Gallery Name (Th)</span>
			</div>
			<input type="text" v-model="category_row_update.gallery_name_th" class="form-control" placeholder="Thai Description" required>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
			  <span class="input-group-text">Category Thumbnail</span>
			</div>
			<input class="form-control"  type="file" id="file_upd" ref="fileUpdate" required />
		</div>
		<div class="input-group mb-3">
			<img :src="category_row_update.image" style="width:30%;">
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
            menu: "<?= _r('Gallery Management', 'ตั้งค่าห้องพัก'); ?>",
			gallery_categories: <?php echo json_encode($gallery_categories); ?>,
			gallery_name_en: '',
			gallery_name_th: '',
			file: "",
			fileUpdate: "",
			category_row_update : {}

        },
        mounted() {
        },
        methods: {
			addPhoto: function(id){
				//alert(id)
				location.href = "<?php echo add_photo_gallery_url('"+id+"');?>";
			},
			uploadFile: function(){

			   this.file = this.$refs.file.files[0];

			   let formData = new FormData();
			   formData.append('gallery_name_en', this.gallery_name_en);
			   formData.append('gallery_name_th', this.gallery_name_th);
			   formData.append('file', this.file);
			   
			   axios.post('<?php echo save_gallery_category_url(); ?>', formData,
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
                            alert('Save Gallery Category Success');
                            location.reload();
                        }

			   })
			   .catch(function (error) {
				   console.log(error);
			   });
				
			 },
			 updateFile: function(){

			   this.fileUpdate = this.$refs.fileUpdate.files[0];

			   let formData = new FormData();
			   formData.append('gallery_name_en', this.category_row_update.gallery_name_en);
			   formData.append('gallery_name_th', this.category_row_update.gallery_name_th);
			   formData.append('id_gallery_category', this.category_row_update.id_gallery_category);
			   formData.append('file', this.fileUpdate);
			   
			   axios.post('<?php echo update_gallery_category_url(); ?>', formData,
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
			 get_category: function(id) {				 
				let self = this;
                self.category_row_update = JSON.parse(JSON.stringify(this.gallery_categories[id]));
                $('#modal_category_edit').modal('show');
            },
			delete_gallery: function(id) {
				let selected = this.gallery_categories[id];
				var r = confirm ("Are you sure you want to delete this photo?");
				if (r) {
					let param = {'id_gallery_category': selected.id_gallery_category};
					console.log(param);
					
                    $.post("<?php echo delete_gallery_url(); ?>", param, function(res) {
                        console.log(res);
						if (res.result == 'false') {
                            alert(res.message);
                            return;
                        } 
						alert('Delete Gallery Success');
                        location.reload();
                    });
				}
			}			 
        }
    });
	
	
});

</script>