

		
		
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
                        <h4 class="card-title">Order  List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th style="display: none;">Sl. No.</th>
                                        <th>Order Id</th>
                                        <th>User</th>
                                        <th>Sub Total</th>
                                        <th>Grand Total</th>
                                        <th>Delivery Address</th>
                                        <th>Pickup Location</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php 
                                	if(!empty($data)){
                                		$i = 1;
                                		foreach ($data as $key => $val) { ?>
                                			<tr>
                                                <td style="display: none;"><?= $i; ?></td>
                                				<td>#<?= $val["id"]; ?></td>
												<td>
                                                    <?php
                                                    $user = $this->common_model->GetColumnName("users", array("id"=>$val['user_id']), array("name"));
                                                    echo ($user) ? $user["name"]:""; 
                                                    ?> </td>
												<td><p>$<?= $val['sub_total'] ?></p></td>
                                                <td><p>$<?= $val['grand_total'] ?></p></td>
                                                <td><p>
                                                <?php
                                                    $address = $this->common_model->GetColumnName("user_address", array("id"=>$val['delivery_address_id']));
                                                    echo ($address) ? $address["delivery_address"]:"";
                                                    ?> 
                                                </p></td>
                                                <td><p>
                                                    <?php
                                                    $location = $this->common_model->GetColumnName("pickup_location", array("id"=>$val['pickup_location']));
                                                    echo ($location) ? $location["location_name"]." ".$location["location_address"]." ".$location["location_postcode"]:"";
                                                    ?> </p></td>
                                                <td>
                                                    <?php if($val['status'] == 1) {
                                                        echo "<span Class='badge badge-success'>Completed</span>";
                                                    } else {
                                                        echo "<span Class='badge badge-danger'>Pending</span>";
                                                    }?>
                                                </td>
					                            <td>
                                                <a href="<?= base_url() ?>admin/order-view/<?= $val['id']; ?>" class="btn btn-danger btn-xs" >View Order</i></a>
                                                <!-- <?php
                                                if ($val['status'] == 0) {
                                                  ?>
                                               <a href="<?= base_url() ?>Admin/Meal/mark_as_complete/<?= $val['id']; ?>" class="btn btn-success shadow btn-xs sharp me-1" onclick="return confirm('Are you sure?')"><i class="fa fa-check"></i></a> 
                                                  <?php
                                                }
                                                ?> -->

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
<script type="text/javascript">
	

</script>