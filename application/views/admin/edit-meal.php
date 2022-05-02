

		
		
        <!--**********************************
            Header start
        ***********************************-->
<?php $this->load->view('admin/includes/header'); ?>
<!--********************************Header end ti-comment-alt********************************-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
<style type="text/css">
    .discript{width: 250px; white-space: nowrap; overflow: hidden;text-overflow: ellipsis;}
    .set-days .choose-date {
        position: relative;
    }
    .choose-date {
        width: 100%;
    }
    .set-days .choose-date .form-control {
        line-height: 27px;
        padding-right: 40px;
    }
    .date {
        font-family: "MetaSerifPro", serif;
    }
    .set-days .choose-date .fa-calendar-alt {
        position: absolute;
        top: 8px;
        right: 9px;
        font-size: 23px;
        color: #ffae00;
    }
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
                        <h4 class="card-title">Update Meal</h4>
                    </div>
                    <div class="card-body">
                        <?php if(!empty($mealData)) { ?>
        			        <form method="post" onsubmit="return updateMeal(event)" id="updateMeal" enctype="multipart/form-data">
        				       
        					
                                <div class="row">
                                    
                                        <input type="hidden"  name="id" placeholder="meal name.." class="form-control" value="<?= $mealData['id'] ?>" required>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Name</strong></label>
                                        <input type="text"  name="name" placeholder="meal name.." class="form-control" value="<?= $mealData['name'] ?>" required>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Heading</strong></label>
                                        <input type="text" name="heading" placeholder="Meal heading.." value="<?= $mealData['heading'] ?>" class="form-control" >
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Price</strong></label>
                                        <input type="text" name="price" class="form-control" value="<?= $mealData['price'] ?>" required  placeholder="price..">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Category</strong></label>
                                        <select name="category" class="form-control" required>
                                            <?php $cat = $this->common_model->GetAllData('category');
                                            $selected = ""; ?>
                                            <?php foreach ($cat as $key => $data) : ?>
                                                <?php if($data['id'] == $mealData['category'])
                                                { 
                                                    $selected = 'selected'; ?>
                                                    <option <?=$selected?> value="<?=$data['id']?>"><?=$data['title']?></option>
                                                <?php } else { ?>
                                                <option value="<?=$data['id']?>"><?=$data['title']?></option>
                                            <?php } ?>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Meal Type</strong></label>
                                        <select name="meal_type" class="form-control" required>
                                            <?php $meal = $this->common_model->GetAllData('meal_type'); 
                                            $selected = "";?>
                                            <?php foreach ($meal as $key => $data) : ?>
                                                <?php if($data['id'] == $mealData['meal_type'])
                                                { 
                                                    $selected = 'selected'; ?>
                                                    <option <?=$selected?> value="<?=$data['id']?>"><?=$data['title']?></option>
                                                <?php } else { ?>
                                                <option value="<?=$data['id']?>"><?=$data['title']?></option>
                                            <?php } ?>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Area Group</strong></label>
                                        <select name="area_group" class="form-control" required>
                                            <?php $area = $this->common_model->GetAllData('area_served'); 
                                            $selected = 'selected'; ?>
                                            <?php foreach ($area as $key => $data) : ?>
                                                <?php if($data['id'] == $mealData['area_group'])
                                                { 
                                                    $selected = 'selected'; ?>
                                                    <option <?=$selected?> value="<?=$data['id']?>"><?=$data['area_group']?></option>
                                                <?php } else { ?>
                                                <option value="<?=$data['id']?>"><?=$data['area_group']?></option>
                                            <?php } ?>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                    <?php if($mealData['is_enabled'] == 1) { ?>
                                        <input type="checkbox" name="is_enabled" value="1" checked/>
                                        <label class="form-label"><strong>Is Enabled</strong></label>
                                    <?php } else { ?>
                                        <input type="checkbox" name="is_enabled" value="1" />
                                        <label class="form-label"><strong>Is Enabled</strong></label>

                                    <?php } ?>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <?php if($mealData['is_taking'] == 1) { ?>
                                        <input type="checkbox" name="is_taking" value="1" checked/>
                                        <label class="form-label"><strong>Is Taking</strong></label>
                                    <?php } else { ?>
                                        <input type="checkbox" name="is_taking" value="1" />
                                        <label class="form-label"><strong>Is Taking</strong></label>

                                    <?php } ?>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <div class="choose-date">
                                            <label class="form-label"><strong>Select Disable Dates</strong></label>
                                            <input type="text" name="disabled_dates" class="form-control date" placeholder="Please Pick dates" value="<?= $mealData['disabled_dates'] ?>" autocomplete="off">
                                            <?php $dates = explode(',',$mealData['disabled_dates']);?>
                                            <?php foreach($dates as $value)
                                            { ?>
                                                <script>var datesForDisable = $value 
                                                    </script>
                                            <?php }?>
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <div class="choose-date">
                                            <label class="form-label"><strong>Select Disable Days</strong></label>
                                            <select name="disabled_days[]" value="$mealData['disabled_days']" class="form-control select2" multiple >

                                                <option data-select="<?= $selected ?>" value="sunday">Sunday</option>
                                                <option data-select="<?= $selected ?>" value="monday">Monday</option>
                                                <option  value="tuesday">Tuesday</option>
                                                <option  value="wednesday">Wednesday</option>
                                                <option  value="thursday">Thursday</option>
                                                <option value="friday">Friday</option>
                                                <option  value="saturday">Saturday</option>
                                            
                                            
                                        </select>
                                        
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <?php $meal_image = $this->common_model->GetAllData('meal_images' , array('meal_id' => $mealData['id'])); ?>
                                        <label class="form-label"><strong>Meal images</strong></label>
                                        <input type="file" name="image[]" class="form-control" multiple  >
                                        
                                        <div class="p_img row">
                                        <?php foreach ($meal_image as $key => $img): ?>
                                        
                                            <div class="img-item col-md-3">
                                                <img class="img-fluid" src="<?= base_url().$img['image']; ?>">
                                                <span data-id="<?=$img['id']?>" class="remove_img">X</span>
                                                <input type="hidden" name="image_id" value="<?=$img['id']?>">
                                            </div>
                                        <?php endforeach ?>
                                        </div><br/>
                                    
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Meal Short Description</strong></label>
                                        <textarea  name="short_description" class="form-control" required placeholder="short description.."><?= $mealData['short_description']?></textarea>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label"><strong>Maximum Orders Per day</strong></label>
                                        <textarea  name="maximum_order_per_day" class="form-control" required placeholder="Maximum Order Per day.."><?= $mealData['maximum_order_per_day']?></textarea>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label"><strong>Detail Description</strong></label>
                                        <textarea type="text" name="detail_description" class="form-control textarea" placeholder="Detail description.."><?= $mealData['detail_description']?></textarea>
                                    </div>
                                </div>
                            
                                <button class="btn btn-primary" id="addbtn" type="submit">Update</button>
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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
 --><script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" ></script>


    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">


  function updateMeal(event) {
    event.preventDefault();
    $('.alert-danger').remove();
    var data = new FormData($('#updateMeal')[0]);
    $.ajax({
        url: '<?= base_url()?>Admin/Meal/updateMeal',
        data: data ,
        processData: false,
        contentType: false,
        type: 'POST',
        dataType:'json',
        beforeSend: function() {        
            $('#addbtn').prop('disabled' , true);
            $('#addbtn').text('Processing..');
          },
        success: function(result){
            $('#addbtn').prop('disabled' , false);
            $('#addbtn').text('Add');
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
  $('.date').datepicker({
    multidate: true,
    format: 'dd-mm-yyyy',
    datesDisabled: datesForDisable    
    });
 
    $(document).ready(function() {
        $('.select2').select2();

    });
    $(document).ready(function() {
    $('[name="disabled_days[]"]').trigger('change');
    selected = [];
    $('.select2').find('option').each(function() {
        
        if($(this).data('select') == 'selected')
        {
            console.log($(this).val())
            selected.push($(this).val())
        }
    });
    $(".select2").select2().val(selected).trigger('change.select2');
});

   $('.img-item').on('click' , '.remove_img' , function(){
    var img_id = $(this).data('id');
     $(this).parent('div').remove();
    if(confirm('Are you sure ?'))
    {
        $.ajax({
          url: '<?= base_url() ?>Admin/Meal/deleteImg/'+img_id,
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