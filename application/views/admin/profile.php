
	
		<!--**********************************
            Header start
        ***********************************-->
        <?php $this->load->view('admin/includes/header'); ?>

        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <?php $this->load->view('admin/includes/sidebar'); ?>
        <!--**********************************
            Sidebar end
        ***********************************-->
		
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
				
                <!-- <div class="row page-titles"> -->
                    <?php echo $this->session->flashdata('msgs'); ?>
                <!-- </div> -->
				
				<div class="row page-titles" id="msgdivcont" style="display:none">
					
                </div>
                <!-- row -->
               
                <div class="row">
                    
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="profile-tab">
                                    <div class="custom-tab-1">
                                        <div class="tab-content">
                                            <div id="my-posts" class="tab-pane fade active show">
                                                <div class="settings-form">
                                                        <h4 class="text-primary">Update  Profile</h4>
                                                        <form method="post" onsubmit="return update_profile(event)" id="profileform">
                                                            <div class="row">
                                                                <div class="mb-3 col-md-12" >
                                                                    <label class="form-label">Name</label>
                                                                    <input type="text" name="name" placeholder="Type name" value="<?= $data['name']; ?>" class="form-control" required>
                                                                </div>
                                                                <div class="mb-3 col-md-12">
                                                                    <label class="form-label">Email</label>
                                                                    <input type="email" name="email" placeholder="Email" class="form-control" required value="<?= $data['email']; ?>">
                                                                </div>
                                                            </div>
                                                           
                                                            <button id="sub_btn" class="btn btn-primary" type="submit">Update</button>
                                                        </form>
                                                    </div>
                                            </div>
                                            
                                            
                                        </div>
                                    </div>
									
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="profile-tab">
                                    <div class="custom-tab-1">
                                        <div class="tab-content">
                                            <div id="my-posts" class="tab-pane fade active show">
                                                <div class="settings-form">
                                                    <h4 class="text-primary">Change Password</h4>
                                                        <form method="post" onsubmit="return change_password(event)" id="changepass">
                                                            <div class="row">
                                                                <div class="mb-3 col-md-12">
                                                                    <label class="form-label">Password</label>
                                                                    <input type="password"  name="password" placeholder="Current Password" class="form-control" required>
                                                                </div>
                                                                <div id="result"></div>
                                                                <div class="mb-3 col-md-12">
                                                                    <label class="form-label">New Password</label>
                                                                    <input type="password" name="npassword" placeholder="New Password" class="form-control" required>
                                                                </div>
                                                                <div class="mb-3 col-md-12">
                                                                    <label class="form-label">Confirm Password</label>
                                                                    <input type="password" name="cpassword" placeholder="confirm Password" class="form-control" required>
                                                                </div>
                                                            </div>
                                                            
                                                            <button class="btn btn-primary" type="submit" id="update">Update</button>
                                                        </form>
                                                    </div>
                                            </div>
                                            
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


		  <!--**********************************
            Footer start
        ***********************************-->
        <?php $this->load->view('admin/includes/footer'); ?>
       
        <!--**********************************
            Footer end
        ***********************************-->
<script type="text/javascript">
    // admin/change-password
function change_password(event){
    event.preventDefault();
        $('.alert-danger').remove();
        $.ajax({
          url: '<?= base_url() ?>Admin/Profile/change_password',
          type: 'POST',
          cache:false,
          contentType: false,
          processData: false,
          data:new FormData($('#changepass')[0]),
          dataType: 'json',
          beforeSend: function() {
            $('#update').prop('disabled' , true);
            $('#update').text('Processing..');
          },
          success : function(res){
            $('#update').prop('disabled' , false);
            $('#update').text('Update');
            if (res.status == 1) {
              window.location.reload();
            }
            else
            { 

              $('#result').html(res.messages);
              for (var err in res.message) {
            
              $("[name='" + err + "']").after("<div  class='label alert-danger'>" + res.message[err] + "</div>");
          }
            }
          }
        });
}

function update_profile(event) {
        event.preventDefault();
        $('.alert-danger').remove();
        $.ajax({
          url: '<?= base_url() ?>Admin/Profile/edit',
          type: 'POST',
          cache:false,
          contentType: false,
          processData: false,
          data:new FormData($('#profileform')[0]),
          dataType: 'json',
          beforeSend: function() {
            $('#sub_btn').prop('disabled' , true);
            $('#sub_btn').text('Processing..');
          },
          success : function(res){
            $('#sub_btn').prop('disabled' , false);
            $('#sub_btn').text('Update');
            if (res.status == 1) {
              window.location.reload();
            }
            else
            {
              for (var err in res.message) {
            
              $("[name='" + err + "']").after("<div  class='label alert-danger'>" + res.message[err] + "</div>");
          }
            }
          }
        });
    }

</script>