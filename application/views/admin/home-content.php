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
                        <h4 class="card-title">Why Order Edit</h4>
                    </div>
                    <div class="card-body">
                        
                    <?php if(!empty($homeContent)) { ?>
    			         <form method="post" onsubmit="return updateHomeContent(event)" id="updateHomeContent" enctype="multipart/form-data">
    				        <input type="hidden" name="id" value="<?= $homeContent['id']; ?>">
    					
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label"><strong>Image</strong></label><br/>
                                        
                                        <img width="150px" src="<?=base_url() ?><?=$homeContent['image']?>" >
                                        <input type="file" name="banner" class="form-control">
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label"><strong>Heading</strong></label>
                                        <input type="text" name="title" class="form-control" value="<?= $homeContent['title']; ?>" required placeholder="heading..">
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label"><strong>Sub Heading</strong></label>
                                        <input type="text" name="subheading" class="form-control" value="<?= $homeContent['subheading']; ?>" required placeholder="heading..">
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label"><strong>Description</strong></label>
                                        <textarea type="text" name="description" class="form-control textarea" placeholder="description.."><?= $homeContent['description']; ?></textarea>
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

  function updateHomeContent(event) {
    event.preventDefault();
    $('.alert-danger').remove();
    var data = new FormData($('#updateHomeContent')[0]);

    $.ajax({
        url: '<?= base_url()?>Admin/Home/update__home_content',
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
              window.location.href = result.redirect;
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