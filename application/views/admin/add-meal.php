

		
		
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
                        <h4 class="card-title">Add Meal</h4>
                    </div>
                    <div class="card-body">
    			        <form method="post" onsubmit="return addMeal(event)" id="addMeal" enctype="multipart/form-data">
    				       
    					
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label"><strong>Name</strong></label>
                                    <input type="text"  name="name" placeholder="meal name.." class="form-control" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label"><strong>Heading</strong></label>
                                    <input type="text" name="heading" placeholder="Meal heading.." class="form-control" >
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label"><strong>Price</strong></label>
                                    <input type="text" name="price" class="form-control" required placeholder="price..">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label"><strong>Category</strong></label>
                                    <select name="category" class="form-control" required>
                                        <?php $cat = $this->common_model->GetAllData('category'); ?>
                                        <?php foreach ($cat as $key => $data) : ?>
                                            <option value="<?=$data['id']?>"><?=$data['title']?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label"><strong>Meal Type</strong></label>
                                    <select name="meal_type" class="form-control" required>
                                        <?php $meal = $this->common_model->GetAllData('meal_type'); ?>
                                        <?php foreach ($meal as $key => $data) : ?>
                                            <option value="<?=$data['id']?>"><?=$data['title']?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label"><strong>Area Group</strong></label>
                                    <select name="area_group" class="form-control" required>
                                        <?php $area = $this->common_model->GetAllData('area_served'); ?>
                                        <?php foreach ($area as $key => $data) : ?>
                                            <option value="<?=$data['id']?>"><?=$data['area_name']?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    
                                    <input type="checkbox" name="is_enabled" value="1" />
                                    <label class="form-label"><strong>Is Enabled</strong></label>
                                </div>
                                <div class="mb-3 col-md-6">
                                    
                                    <input type="checkbox" name="is_taking" value="1" />
                                    <label class="form-label"><strong>Is Taking</strong></label>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <div class="choose-date">
                                        <label class="form-label"><strong>Select Disable Dates</strong></label>
                                        <input type="text" name="disabled_dates" class="form-control date" placeholder="Please Pick dates" autocomplete="off">
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <div class="choose-date">
                                        <label class="form-label"><strong>Select Disable Days</strong></label>
                                        <select name="disabled_days[]" class="form-control select2" multiple >
                                        
                                        <option value="1">Sunday</option>
                                        <option value="2">Monday</option>
                                        <option value="3">Tuesday</option>
                                        <option value="4">Wednesday</option>
                                        <option value="5">Thursday</option>
                                        <option value="6">Friday</option>
                                        <option value="7">Saturday</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label"><strong>Meal Images</strong></label>
                                    <input type="file" multiple accept="image/png, image/gif, image/jpeg" name="image[]" class="form-control"  required>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label"><strong>Meal Short Description</strong></label>
                                    <textarea  name="short_description" class="form-control" required placeholder="short description.."></textarea>
                                </div>
                                <div class="mb-3 col-md-12">
                                        <label class="form-label"><strong>Maximum Orders Per day</strong></label>
                                        <input name="maximum_order_per_day" value="100" class="form-control" required placeholder="Maximum Order Per day..">
                                    </div>
                                <div class="mb-3 col-md-12">
                                    <label class="form-label"><strong>Detail Description</strong></label>
                                    <textarea type="text" name="detail_description" class="form-control textarea" placeholder="Detail description.."></textarea>
                                </div>
                            </div>
                        
                            <button class="btn btn-primary" id="addbtn" type="submit">Add</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" ></script>
<script type="text/javascript">

  function addMeal(event) {
    event.preventDefault();
    $('.alert-danger').remove();
    var data = new FormData($('#addMeal')[0]);
    $.ajax({
        url: '<?= base_url()?>Admin/Meal/addMeal',
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
        format: 'dd-mm-yyyy'
    });
    $(document).ready(function() {
        $('.select2').select2();

    });
</script>