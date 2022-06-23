

		
		
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
                        <h4 class="card-title">User  List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php 
                                	if(!empty($user_list)){
                                		$i = 1;
                                		foreach ($user_list as $key => $val) { ?>
                                			<tr>
                                                <td><p><?= $i; ?></p></td>
                                				<td><p><?= $val["name"]; ?></p></td>
												<td><p><?= $val["email"]; ?></p></td>
												<td><p><?= $val["phone"]; ?></p></td>
                                                <td><p><?= $val['address'] ?></p></td>
                                                <td>
                                                    <?php if($val['status'] == 1) {
                                                        echo "<span Class='badge badge-success'>Active</span>";
                                                    } else {
                                                        echo "<span Class='badge badge-danger'>Blocked</span>";
                                                    }?>
                                                </td> 
					                            <td>
                                              <?php
                                                  if ($val['status'] == 0) {
                                                  ?>
                                                  <button class="btn btn-success btn-sm" onclick="accept_status(<?php echo $val['id']; ?>,1)" id="btn_load<?= $val['id']; ?>" >Unblock<div style="display: none;" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="btn_load<?= $val['id']; ?>"></div></button> 
                                                  <?php
                                                  } else{
                                                    ?>
                                                     <button class="btn btn-danger btn-sm" onclick="accept_status(<?php echo $val['id']; ?>,0)" id="btn_load<?= $val['id']; ?>" >Block<div style="display: none;" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="btn_load<?= $val['id']; ?>"></div></button>
                                                    <?php
                                                  }
                                                  ?>
                                                    <a href="<?= base_url() ?>admin/address-view/<?= $val['id']; ?>" class="btn btn-info btn-sm" >View Address</i></a>
					                            </td>
					                        </tr> <?php $i++; }

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
   function accept_status(id,status)
   {
     //alert('hello');
    if(confirm('Are you sure?'))
    {
    $.ajax({
          type: "POST",
          url: "<?= base_url()?>/Admin/User/block_unblock",
          data: {id:id,status:status},
          dataType: "json",
          beforeSend:function(){
          $('#submit'+id).prop('disabled',true);
          $('#btn_load'+id).show();
        },
          success: function(data){
            if(data.status == 1)  //json status return by controller
            {
               window.location.reload();
            }
            else
            {
              $('.error-msg').html(data.message);
              $('#submit'+id).prop('disabled',false);
              $('#btn_load'+id).hide();
            }
              
          },
          
     });
    }

   }
</script>