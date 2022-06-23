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
                        <h4 class="card-title">Order Details</h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-3">
                                <label>Order Id # <?= $data['id']; ?></label>
                            </div>
                            <div class="col-3">
                                <label>User Name : <?php
                                    $user = $this->common_model->GetColumnName("users", array("id"=>$data['user_id']), array("name"));
                                    echo ($user) ? $user["name"]:""; 
                                    ?></label>
                             </div>
                            <div class="col-3"><label>Transaction Id : <?php echo $data["payment_id"]; ?></label></div>
                            <div class="col-3"><label>Order Amount : $<?php echo $data["grand_total"]; ?></label></div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-3">
                                <label>Delivery Address : <?php
                                                    $address = $this->common_model->GetColumnName("user_address", array("id"=>$data['delivery_address_id']));
                                                    echo ($address) ? $address["delivery_address"]:"";
                                                    ?> </label>
                            </div>
                            <div class="col-3">
                                <label>Pickup Location : <?php
                                                    $location = $this->common_model->GetColumnName("pickup_location", array("id"=>$data['pickup_location']));
                                                    echo ($location) ? $location["location_name"]." ".$location["location_address"]." ".$location["location_postcode"]:"";
                                                    ?></label>
                             </div>
                            <div class="col-3"><label>Status : <?php
                                              if($data['status'] == 1) {
                                                        echo "<span Class='badge badge-success'>Completed</span>";
                                                    } else {
                                                        echo "<span Class='badge badge-danger'>Pending</span>";
                                                    }?></label></div>
                         </div>
                        <hr>
                        <div class="card-header">
                        <h4 class="card-title">Order Items</h4>
                        </div>

                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <!-- <th></th> -->
                                        <th>S.N.</th>
                                        <th>Meal Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
                                        <th>Prefrences</th>
                                        <th>Remark</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(!empty($orders_items)){
                                        $i = 1;
                                        foreach ($orders_items as $key => $val) { ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td>
                                                    <?php
                                                    $meal = $this->common_model->GetColumnName("meals", array("id"=>$val['meal_id']), array("name"));
                                                    echo ($meal) ? $meal["name"]:""; 
                                                    ?> </td>
                                                <td><p>$<?= $val['price'] ?></p></td>
                                                <td><p><?= $val['quantity'] ?></p></td>
                                                <td><p>$<?= $val["total_price"]; ?> </p></td>
                                                <td><p><?php
                                                if (!empty($val["preference"])) {
                                                $preference = $this->common_model->GetColumnName("preference", "id in (".$val["preference"].")", array("title"), true);
                                               // print_r($preference);
                                                $preference_name = '';
                                                 if ($preference) {
                                                    foreach ($preference as $keyG => $valueP) {
                                                        $preference_name .= $valueP["title"].",";
                                                    }
                                                 }
                                                echo rtrim($preference_name,',');
                                                } ?> </p></td>
                                                <td><p><?= $val["remark"]; ?></p></td> 
                                                <td><p><?= $val["date"]; ?></p></td>
                                                <td><p>
                                                    <?php if($val['status'] == 1) {
                                                        echo "<span Class='badge badge-success'>Completed</span>";
                                                    } else {
                                                        echo "<span Class='badge badge-danger'>Pending</span>";
                                                    }?>


                                                </p></td>
                                                <td><p>
                                                    <?php if($val['status'] == 0) {
                                                    ?>
                                                        <a href="<?= base_url() ?>Admin/Meal/mark_as_complete/<?= $val['id']; ?>/<?= $data['id']; ?>/<?= $val['user_id']; ?>" class="btn btn-info btn-xs" >Mark As Complete</i></a>
                                                   <?php
                                                    }
                                                     ?>
                                                     

                                                </p></td>
                                            </tr> <?php $i++; }

                                    }

                                    ?>
                                            
                                <tbody>

                            </table>
                        </div>

                        <div class="row">
                            <div class="col-3">
                                <label>Sub Total Amount $<?= $data['sub_total']; ?></label>
                            </div> 
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">
                                <label>Tax Amount $<?= $data['tax_price']; ?></label>
                            </div> 
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">
                                <label>Grand Total Amount $<?= $data['grand_total']; ?></label>
                            </div> 
                        </div>
                        <hr>









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