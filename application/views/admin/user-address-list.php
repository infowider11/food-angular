

		
		
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
                        <h4 class="card-title">Users Address List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>User Name</th>
                                        <th>Delivery Details</th>
                                        <!-- <th>Delivery Address</th>
                                        <th>Delivery Email</th>
                                        <th>Delivery Phone</th>
                                        <th>Delivery Remark</th>
                                        <th>Delivery Name</th>
                                        <th>Delivery Title</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php 
                                	if(!empty($address_list)){
                                		$i = 1;
                                		foreach ($address_list as $key => $val) { ?>
                                			<tr>
                                                <td><p><?= $i; ?></p></td>
                                				        <td>
                                                    <?php
                                                    $user = $this->common_model->GetColumnName("users", array("id"=>$val['user_id']), array("name"));
                                                    echo ($user) ? $user["name"]:""; 
                                                    ?> </td>
												                        <!-- <td><p><?= $val["delivery_address"]; ?></p></td>
												                        <td><p><?= $val["delivery_email"]; ?></p></td>
                                                <td><p><?= $val['delivery_phone'] ?></p></td>
                                                <td><p><?= $val['delivery_remark'] ?></p></td>
                                                <td><p><?= $val['delivery_name'] ?></p></td>
                                                <td><p><?= $val['delivery_title'] ?></p></td> -->
                                                <td>
                                                  <p>Title: <?= $val["delivery_title"]; ?></p>
                                                    <p>Delivery Person Name: <?= $val["delivery_name"]; ?></p>
                                                  <p>Delivery person Email: <?= $val["delivery_email"]; ?></p>
                                                  <p>Delivery person Phone: <?= $val["delivery_phone"]; ?></p>
                                                  <p>Delivery Address: <?= $val["delivery_address"]; ?></p>
                                                  <p>Remark: <?= $val["delivery_remark"]; ?></p>
                                                </td>
					                                  <td><p>
                                               <a href="javascript:;" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#updateaddressModal<?= $val['id']; ?>"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="javascript:;" id="delbtn<?= $val['id']; ?>" onclick="deleteRow(<?= $val['id']; ?>)" class="btn btn-danger shadow btn-xs sharp me-1"><i class="fa fa-trash"></i></a>
					                                 </p></td>
					                        </tr>

<!-- edit modal -->
    <div class="modal fade" id="updateaddressModal<?= $val['id']; ?>">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" onsubmit="return updatAddress(this, event, <?= $val['id']; ?>)" id="updatAddress" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $val['id']; ?>">
                <div class="modal-body">
                    
                        <div class="row">
                          <!--  <div class="mb-3 col-md-12">
                                <label class="form-label">User Name</label>
                                <input type="text"  name="delivery_add" placeholder="Delivery Address" class="form-control" value="<?= $user["name"] ?>" readonly>
                            </div> -->
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Title</label>
                                <input type="text"  name="delivery_title" placeholder="Delivery Title" class="form-control" value="<?= $val['delivery_title'] ?>" required>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Delivery Person Name</label>
                                <input type="text"  name="delivery_name" placeholder="Delivery Name" class="form-control" value="<?= $val['delivery_name'] ?>" required>
                            </div>
                             <div class="mb-3 col-md-12">
                                <label class="form-label">Delivery Person Email</label>
                                <input type="text"  name="delivery_email" placeholder="Delivery Email" class="form-control" value="<?= $val['delivery_email'] ?>" required>
                            </div>
                             <div class="mb-3 col-md-12">
                                <label class="form-label">Delivery Person Phone</label>
                                <input type="text"  name="delivery_phone" placeholder="Delivery Phone" class="form-control" value="<?= $val['delivery_phone'] ?>" required>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Delivery Address</label>
                                <input type="text"  name="delivery_add" placeholder="Delivery Address" class="form-control" value="<?= $val['delivery_address'] ?>" required>
                            </div>
                             
                            
                             <div class="mb-3 col-md-12">
                                <label class="form-label">Remark</label>
                                <input type="text"  name="delivery_remark" placeholder="Delivery Remark" class="form-control" value="<?= $val['delivery_remark'] ?>" required>
                            </div>
                             
                             
                        </div>
                        
                        <button class="btn btn-primary" id="upbtn<?= $val['id']; ?>" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- edit modal -->






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
<script>
    function updatAddress(el, event, id) {
    event.preventDefault();
    $('.alert-danger').remove();
    var data = new FormData($(el)[0]);

    $.ajax({
        url: '<?= base_url()?>Admin/User/update_address',
        data: data,
        processData: false,
        contentType: false,
        type: 'POST',
        dataType:'json',
        beforeSend: function() {        
            $('#upbtn'+id).prop('disabled' , true);
            $('#upbtn'+id).text('Processing..');
          },
        success: function(result){
            $('#upbtn'+id).prop('disabled' , false);
            $('#upbtn'+id).text('Add');
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

  function deleteRow(id) {
    if(confirm('Are you sure ?')){
      $.ajax ({
          url: '<?= base_url()?>Admin/User/delete_address',
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