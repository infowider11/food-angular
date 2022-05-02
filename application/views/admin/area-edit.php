

		
		
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
                        <h4 class="card-title">Pickup Location Edit</h4>
                    </div>
                    <div class="card-body">
                        
                    <?php if(!empty($single_data)) { ?>
    			         <form method="post" onsubmit="return updateArea(event)" id="updateArea" enctype="multipart/form-data">
    				        <input type="hidden" name="id" value="<?= $single_data['id']; ?>">
    					
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Area Name</strong></label>
                                        <input type="text"  name="area_name" placeholder="area name.." class="form-control" value="<?= $single_data['area_name'] ?>" required>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Area Post code</strong></label>
                                        <input type="number" name="area_post_code" placeholder="area zipcode.." class="form-control" value="<?= $single_data['area_post_code'] ?>">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Area group</strong></label>
                                        <input type="text" name="area_group" class="form-control" required value="<?= $single_data['area_group']; ?>" placeholder="area group..">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Banner heading</strong></label>
                                        <input type="text" name="location_heading" class="form-control" required value="<?= $single_data['location_heading']; ?>" placeholder="banner heading..">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Has Pick Up</strong></label><br/>
                                        <?php if($single_data['has_pickup'] == 1) { ?>
                                            <input type="radio" name="has_pickup"  value="1" checked="checked"> Yes
                                            <input type="radio" name="has_pickup"  value="0"> No
                                        <?php } else { ?>
                                            <input type="radio" name="has_pickup"  value="1" > Yes
                                        <input type="radio" name="has_pickup"  value="0" checked="checked"> No
                                        <?php } ?>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Has Home Delivery</strong></label><br/>
                                        <?php if($single_data['has_home_delivery'] == 1) { ?>
                                            <input type="radio" name="has_home_delivery"  value="1" checked="checked"> Yes
                                            <input type="radio" name="has_home_delivery"  value="0"> No
                                        <?php } else { ?>
                                            <input type="radio" name="has_home_delivery"  value="1" > Yes
                                        <input type="radio" name="has_home_delivery"  value="0" checked="checked"> No
                                        <?php } ?>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Background Image</strong></label>
                                        <input type="file" name="banner" class="form-control">
                                        <img width="150px" src="<?=base_url() ?><?=$single_data['location_background_image']?>" >
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <?php $location_image = $this->common_model->GetAllData('location_image' , array('area_group_id' => $single_data['id'])); ?>
                                        <label class="form-label"><strong>Slider image</strong></label>
                                        <input type="file" name="image[]" class="form-control" multiple  >
                                        
                                        <div class="p_img row">
                                        <?php foreach ($location_image as $key => $img): ?>
                                        
                                            <div class="img-item col-md-3">
                                                <img class="img-fluid" src="<?= base_url().$img['image']; ?>">
                                                <span data-id="<?=$img['id']?>" class="remove_img">X</span>
                                                <input type="hidden" name="image_id" value="<?=$img['id']?>">
                                            </div>
                                        <?php endforeach ?>
                                        </div><br/>
                                    
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label"><strong>Banner description</strong></label>
                                        <textarea type="text" name="location_description" class="form-control textarea" placeholder="banner description.."><?= $single_data['location_description']; ?></textarea>
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

  function updateArea(event) {
    event.preventDefault();
    $('.alert-danger').remove();
    var data = new FormData($('#updateArea')[0]);

    $.ajax({
        url: '<?= base_url()?>Admin/AreaServed/update_area',
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
            $('#upbtn').text('Add');
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
          url: '<?= base_url() ?>Admin/AreaServed/deleteImg/'+img_id,
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