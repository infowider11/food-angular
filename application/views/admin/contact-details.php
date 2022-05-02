<!--**********************************
            Header start
        ***********************************-->
<?php $this->load->view('admin/includes/header'); ?>
<!--********************************Header end ti-comment-alt********************************-->
<style type="text/css">
    .discript{width: 250px; white-space: nowrap; overflow: hidden;text-overflow: ellipsis;}
</style>
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
		
		<?php if($this->session->flashdata('msgs')){ ?>
			<div class="row page-titles">
				<?php echo $this->session->flashdata('msgs'); ?>
            </div>
        <?php } ?>
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Contact Details</h4>
                    </div>
                    <div class="card-body">
                        
                    <?php if(!empty($contact)) { ?>
    			         <form method="post" onsubmit="return updateContact(event)" id="updateContact" enctype="multipart/form-data">    					
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Phone Number(first)</strong></label><br/>
                                        <input type="text" name="phone_1" class="form-control" required value="<?= $contact['phone_1']?>" placeholder="Phone number..">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Email(first)</strong></label>
                                        <input type="email" name="email_1" class="form-control" value="<?= $contact['email_1']; ?>" required placeholder="Email..">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Phone Number(second)</strong></label>
                                        <input type="text" name="phone_2" class="form-control" value="<?= $contact['phone_2']; ?>"placeholder="Phone number..">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Email(second)</strong></label>
                                        <input type="email" name="email_2" class="form-control" value="<?= $contact['email_2']; ?>" placeholder="Email..">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Phone Number(third)</strong></label>
                                        <input type="text" name="phone_3" class="form-control" value="<?= $contact['phone_3']; ?>"  placeholder="Phone number..">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Email(third)</strong></label>
                                        <input type="email" name="email_3" class="form-control" value="<?= $contact['email_3']; ?>"  placeholder="Email..">
                                    </div>
                                </div>
                            
                                <button class="btn btn-primary" id="upbtn" type="submit">Update</button>
                            </form>
                        <?php } ?>
				    </div>
			
		        </div>
	       </div>
        </div>
    </div>
</div>





        <!--**********************************
            Footer start
        ***********************************-->
        <?php $this->load->view('admin/includes/footer'); ?>
        <!--**********************************
            Footer end
        ***********************************-->
<script type="text/javascript">

  function updateContact(event) {
    event.preventDefault();
    $('.alert-danger').remove();
    var data = new FormData($('#updateContact')[0]);

    $.ajax({
        url: '<?= base_url()?>Admin/Home/update_contact',
        data: data,
        processData: false,
        contentType: false,
        type: 'POST',
        dataType:'json',
        beforeSend: function() {        
            $('#upbtn').prop('disabled' , true);
            $('#upbtn').text('Processing..');
          },
        success: function(result){
            $('#upbtn').prop('disabled' , false);
            $('#upbtn').text('Update');
            if(result.status == 1)
            {
              window.location.reload();
            }
            else
            {
              console.log(result.message);
              for (var err in result.message) {
            
              $("[name='" + err + "']").after("<div  class='label alert-danger'>" + result.message[err] + "</div>");
              }
            }
        }
    });
    return false;
  }
 $('.img-item').on('click' , '.remove_img' , function(){
    var img_id = $(this).data('id');
     $(this).parent('div').remove();
    if(confirm('Are you sure ?'))
    {
        $.ajax({
          url: '<?= base_url() ?>Admin/Home/deleteImg/'+img_id,
          type: 'POST',
          cache:false,
          contentType:"application/json",
          dataType: 'json',
          data:{img_id : img_id},
          success : function(res){
            if (res.status == 1) {
             
              alert(res.message);
            }
            else
            {
              alert(res.message);
            }
          }
        });
    }
 })
</script>