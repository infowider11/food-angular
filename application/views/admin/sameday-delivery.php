

        
        
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
                        <h4 class="card-title">Same Day Delivery Request</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <!-- <th></th> -->
                                        <th>S.N.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Delivery Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(!empty($sameday)){
                                        $i = 1;
                                        foreach ($sameday as $key => $val) { ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><p><?= $val['name'] ?></p></td>
                                                <td><p><?= $val['email'] ?></p></td>
                                                <td><p><?= $val['phone'] ?></p></td>
                                                <td><p><?= $val['delivery_address'] ?></p></td>
                                            </tr>                                                      <!-- Modal -->
                                        
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