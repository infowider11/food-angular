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
        <?php if(!empty($innerContent)) { ?>
        <!-- about us row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">About us</h4>
                    </div>
                    <div class="card-body">
                        
                    
    			         <form method="post" onsubmit="return updateInnerContent(event,this)" id="updateAboutContent" enctype="multipart/form-data">    					
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <textarea type="text" name="about" class="form-control textarea" placeholder="about us page content.."><?= $innerContent['about']; ?></textarea>
                                    </div>
                                </div>
                            
                                <button class="btn btn-primary upbtn" id="upbtn" type="submit">Update</button>
                            </form>
				    </div>
			
		        </div>
	       </div>
        </div>
        <!--!about us row-->
        <!--privacy row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Privacy Policy</h4>
                    </div>
                    <div class="card-body">
                         <form method="post" onsubmit="return updateInnerContent(event,this)" id="updatePrivacyContent" enctype="multipart/form-data">                        
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <textarea type="text" name="privacy" class="form-control textarea" placeholder="privacy page content.."><?= $innerContent['privacy']; ?></textarea>
                                    </div>
                                </div>
                            
                                <button class="btn btn-primary upbtn" id="upbtn1" type="submit">Update</button>
                            </form>
                    </div>
            
                </div>
           </div>
        </div>
        <!--!privacy row -->
        <!--terms row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Terms</h4>
                    </div>
                    <div class="card-body">
                         <form method="post" onsubmit="return updateInnerContent(event,this)" id="updateTermsContent" enctype="multipart/form-data">                        
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <textarea type="text" name="terms" class="form-control textarea" placeholder="terms page content.."><?= $innerContent['terms']; ?></textarea>
                                    </div>
                                </div>
                            
                                <button class="btn btn-primary upbtn"  type="submit">Update</button>
                            </form>
                    </div>
            
                </div>
           </div>
        </div>
        <!--!terms row -->
    <?php } ?>
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

  function updateInnerContent(event, el) {
    event.preventDefault();
    $('.alert-danger').remove();
    var data = new FormData($(el)[0]);

    $.ajax({
        url: '<?= base_url()?>Admin/Home/update__inner_content',
        data: data,
        processData: false,
        contentType: false,
        type: 'POST',
        dataType:'json',
        beforeSend: function() {        
            $('.upbtn').prop('disabled' , true);
            $('.upbtn').text('Processing..');
          },
        success: function(result){
            $('.upbtn').prop('disabled' , false);
            $('.upbtn').text('Update');
            if(result.status == 1)
            {
              window.location.reload();
            }
            else
            {
              for (var err in result.message) {
            
              $("[name='" + err + "']").after("<div  class='label alert-danger'>" + result.message[err] + "</div>");
              }
            }
        }
    });
    return false;
  }
</script>