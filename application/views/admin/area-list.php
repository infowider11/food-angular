

		
		
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
                                <h4 class="card-title">Area List</h4>
                                <a href="<?=base_url()?>admin/add-area" class="btn btn-primary mb-1">Add area</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <!-- <th></th> -->
                                                <th>S.N.</th>
                                                <th>Name</th>
                                                <th>Zipcode</th>
                                                <th>Area Group</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php 
                                        		if(!empty($area)){
                                        			$i = 1;
                                        			foreach ($area as $key => $val) { ?>
                                        				<tr>
                                        					<td><?= $i; ?></td>
														    <!-- <td><img class="rounded-circle" width="35" src="images/profile/small/pic1.jpg" alt=""></td> -->
														    <td><?= $val['area_name'] ?></td>
														    <!-- <td><img src="<?= base_url().'/'.$val['icon']; ?>" width="100"></td> -->
														    <td>
                                  <p><?= $val['area_post_code'] ?></p>
                                </td>
                                <td>
                                  <p><?= $val['area_group'] ?></p>
                                </td>
							    <td>
							    	<a href="<?=base_url()?>admin/edit-area/<?=$val['id']?>" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="javascript:;" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#viewModal<?= $val['id']; ?>"><i class="fas fa-eye"></i></a>
							    	 <a href="javascript:;" id="delbtn<?= $val['id']; ?>" onclick="deleteRow(<?= $val['id']; ?>)" class="btn btn-danger shadow btn-xs sharp me-1"><i class="fa fa-trash"></i></a>
							    </td>
							</tr>



<div class="modal fade" id="viewModal<?= $val['id']; ?>">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Area</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
                <div class="modal-body">                    
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label><strong>Background Image :</strong></label><br/>
                               <img width="200px" src="<?=base_url() ?><?=$val['location_background_image']?>" >
                            </div>
                            <div class="mb-3 col-md-12">
                                <label><strong>Slider Image :</strong></label>
                                <div class="ombre-externe">
                                    <div class="ombre-interne">
                                            <div id="carouselExampleCaptions" class="carousel slide " data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    <?php $images = $this->common_model->GetAllData('location_image' , array('area_group_id' => $val['id'])); ?>
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
                                <label><strong>Area Name :</strong></label> <?= $val['area_name'] ?>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label><strong>Area Zipcode : </strong></label> <?= $val['area_post_code']?>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label><strong>Area Group : </strong></label> <?= $val['area_group']; ?>
                            </div>
                            <div class="mb-3 col-md-12">
                                <?php if( $val['has_pickup'] == 1) { ?>
                                    <label><strong>Has Picked Up : </strong></label> Yes
                                <?php } else { ?>
                                    <label><strong>Has Picked Up : </strong></label> No
                                <?php } ?>
                            </div>
                            <div class="mb-3 col-md-12">
                                <?php if( $val['has_home_delivery'] == 1) { ?>
                                    <label><strong>Has Home Delivery : </strong></label> Yes
                                <?php } else { ?>
                                    <label><strong>Has Home Delivery : </strong></label> No
                                <?php } ?>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label><strong>Banner heading : </strong></label> <?= $val['location_heading']; ?>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label><strong>Banner Description : </strong></label> <?= $val['location_description']; ?>
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
          url: '<?= base_url()?>Admin/AreaServed/delete_area',
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