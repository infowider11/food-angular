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
                        <h4 class="card-title">Setting Management</h4>
                    </div>
                    <div class="card-body">    
    			         <form method="post" onsubmit="return updateSetting(event)" id="updateSetting" enctype="multipart/form-data">    					
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Commission (%)</strong></label><br/>
                                        <input type="text" name="transaction" class="form-control" required value="<?= $setting['transaction']?>" placeholder="Commission..">
                                    </div>
                                </div>
                            
                                <button class="btn btn-primary" id="upbtn" type="submit">Update</button>
                            </form>
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

  function updateSetting(event) {
    event.preventDefault();
    $('.alert-danger').remove();
    var data = new FormData($('#updateSetting')[0]);

    $.ajax({
        url: '<?= base_url()?>Admin/Home/update_setting',
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
</script>