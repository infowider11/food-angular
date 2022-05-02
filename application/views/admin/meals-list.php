

		
		
<!--**********************************
    Header start
***********************************-->
<?php $this->load->view('admin/includes/header'); ?>
            
<!--**********************************
    Header end ti-comment-alt
***********************************-->
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
		
		<div class="row page-titles" id="msgdivcont" style="display: none">
			<!-- <ol class="breadcrumb" id="msgdiv">
				
				<li class="breadcrumb-item active"><a href="javascript:void(0)">Table</a></li>
				<li class="breadcrumb-item"><a href="javascript:void(0)">Datatable</a></li>
			</ol> -->
    	</div>
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
                        <h4 class="card-title">Meals List</h4>
                        <a href="<?=base_url()?>admin/add-meals" class="btn btn-primary mb-1">Add Meal</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <!-- <th></th> -->
                                        <th>S.N.</th>
                                        <th>Name</th>
                                        <th>Heading</th>
                                        <th>Price($)</th>
                                        <th>Category</th>
                                        <th>Meal Type</th>
                                        <th>Area Group</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php 
                                	if(!empty($meals)){
                                		$i = 1;
                                		foreach ($meals as $key => $val) { ?>
                                			<tr>
                                				<td><?= $i; ?></td>
												<td><?= $val['name'] ?></td>
												<td><p><?= $val['heading'] ?></p></td>
                                                <td><p>$<?= $val['price'] ?></p></td>
                                                <?php $cat = $this->common_model->GetSingleData('category', array('id'=>$val['category']));?>
                                                <td><p><?= $cat['title'] ?></p></td>
                                                <?php $meal = $this->common_model->GetSingleData('meal_type', array('id'=>$val['meal_type']));?>
                                                <td><p><?= $meal['title'] ?></p></td>
                                                <?php $area = $this->common_model->GetSingleData('area_served', array('id'=>$val['area_group']));?>
                                                <td><p><?= $area['area_group'] ?></p></td>
                                                <td>
                                                    <?php if($val['is_enabled'] == 1)
                                                    {
                                                        echo "<span Class='badge badge-success'> Enabled</span>";
                                                    } else {
                                                        echo "<span Class='badge badge-danger'> Disabled</span>";
                                                    }?>
                                                </td>
					                            <td>
					    	                        <a href="<?=base_url()?>admin/edit-meal/<?=$val['id']?>" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="javascript:;" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#viewModal<?= $val['id']; ?>"><i class="fas fa-eye"></i></a>
					    	                        <a href="javascript:;" id="delbtn<?= $val['id']; ?>" onclick="deleteRow(<?= $val['id']; ?>)" class="btn btn-danger shadow btn-xs sharp me-1"><i class="fa fa-trash"></i></a>
					                            </td>
					                        </tr>



<div class="modal fade" id="viewModal<?= $val['id']; ?>">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Meals</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">                    
                <div class="row">
                    <div class="mb-3 col-md-12">
                        <label><strong>Product Slider Image :</strong></label>
                        <div class="ombre-externe">
                            <div class="ombre-interne">
                                <div id="carouselExampleCaptions" class="carousel slide " data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <?php $images = $this->common_model->GetAllData('meal_images' , array('meal_id' => $val['id'])); ?>
                                        <?php foreach ($images as $key => $img): ?>
                                        <div class="carousel-item <?= ($key==0) ? 'active' : '' ?>">
                                            <img width="200px" src="<?= base_url().$img['image'] ?>" class="d-block" alt="...">
                                        </div>
                                        <?php endforeach ?>
                                                
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label><strong>Name :</strong></label> <?= $val['name'] ?>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label><strong>Heading : </strong></label> <?= $val['heading']?>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label><strong>Price : </strong></label> <?= $val['price']?>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label><strong>Category : </strong></label> <?= $cat['title']?>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label><strong>Meal type : </strong></label> <?= $meal['title']?>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label><strong>Area Group : </strong></label> <?= $area['area_group']?>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label><strong>Maximum Orders Per Day : </strong></label> <?= $val['maximum_order_per_day']?>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label><strong>Short description : </strong></label> <?= $val['short_description']; ?>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label><strong>Detail Description : </strong></label> <?= $val['detail_description']; ?>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label><strong>Is Disabled : </strong></label> 
                        <?php if($val['is_enabled'] == 1)
                        {
                            echo "<span Class='badge badge-success'> Enabled</span>";
                        } else {
                            echo "<span Class='badge badge-danger'> Disabled</span>";
                        }?>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label><strong>Is Taking : </strong></label> 
                        <?php if($val['is_taking'] == 1)
                        {
                            echo "<span Class='badge badge-success'> Yes</span>";
                        } else {
                            echo "<span Class='badge badge-danger'> No</span>";
                        }?>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label><strong>Disabled Dates : </strong></label> 
                        <?php $dates = explode(',', $val['disabled_dates']);
                        foreach($dates as $value)
                        {
                            echo $value.', ';
                        }
                        ?>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label><strong>Disabled Days : </strong></label> 
                        <?php $days = explode(',', $val['disabled_days']);
                        foreach($days as $value)
                        {
                            echo $value.',';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







														<!-- Modal -->
										
                                        <?php $i++; }

                                    }

                                    ?>
										    
                                <tbody>

                            </table>
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
	
	function deleteRow(id) {
    if(confirm('Are you sure ?')){
      $.ajax ({
          url: '<?= base_url()?>Admin/Meal/delete_meal',
          data: {id:id},
          type: 'POST',
          dataType:'json',
          beforeSend: function() {        
              $('#delbtn'+id).prop('disabled' , true);
              $('#delbtn'+id).text('Processing..');
            },
          success: function(result){
              $('#delbtn'+id).prop('disabled' , false);
              $('#delbtn'+id).text('Add');
              if(result.status == 1)
              {
                window.location.reload();
              }
          }
          });
    }
}

</script>