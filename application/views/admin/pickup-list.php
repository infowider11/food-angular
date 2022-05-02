

        
        
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
                                <a href="javascript:void(0);" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#addAreaModal">Add area</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <!-- <th></th> -->
                                                <th>S.N.</th>
                                                <th>Area Group</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Address</th>
                                                <th>Zipcode</th>
                                                <!-- <th>Mobile</th>
                                                <th>Gender</th>
                                                <th>Status</th> -->
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                if(!empty($pickup)){
                                                    $i = 1;
                                                    foreach ($pickup as $key => $val) { ?>
                                                        <tr>
                                                            <td><?= $i; ?></td>
                                                            <td><?php $data = $this->common_model->GetSingleData('area_served',array('id'=>$val['area_group_id'])); ?>
                                                            <?= $data['area_group']; ?></td>
                                                            <td>
                                  <p><?= $val['location_name'] ?></p>
                                </td>
                                <td>
                                  <p><?= $val['location_description'] ?></p>
                                </td>
                                <td>
                                  <p><?= $val['location_address'] ?></p>
                                </td>
                                <td>
                                  <p><?= $val['location_postcode'] ?></p>
                                </td>
                                                            <td>
                                                                <a href="javascript:;" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#updateAreaModal<?= $val['id']; ?>"><i class="fas fa-pencil-alt"></i></a>
                                                                 <a href="javascript:;" id="delbtn<?= $val['id']; ?>" onclick="deleteRow(<?= $val['id']; ?>)" class="btn btn-danger shadow btn-xs sharp me-1"><i class="fa fa-trash"></i></a>
                                                            </td>
                                                        </tr>



<div class="modal fade" id="updateAreaModal<?= $val['id']; ?>">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div id="msgdiv<?= $val['id']; ?>"></div>
            <form method="post" onsubmit="return updatLocation(this, event, <?= $val['id']; ?>)" id="updatLocation" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $val['id']; ?>">
                <div class="modal-body">
                    
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                    <label class="form-label"><strong>Area Group</strong></label>
                                    <?php $area_data = $this->common_model->GetAllData('area_served');?>
                                    <select class="form-control" name="area_group_id">
                                    <?php $selected = ""; 
                                    foreach($area_data as $value) { ?>
                                        <?php if($value['id'] == $val['area_group_id'])
                                        {
                                            $selected = 'selected;' ?>
                                            <option  <?= $selected ?> value="<?= $value['id'] ?>"><?= $value['area_group'] ?></option>
                                        <?php } else { ?>
                                        
                                            <option  value="<?= $value['id'] ?>"><?= $value['area_group'] ?></option>
                                        <?php } } ?>
                                    </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Location_Name</label>
                                <input type="text"  name="location_name" placeholder="Category area name.." class="form-control" value="<?= $val['location_name'] ?>" required>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Location Description</label>
                                <input type="text" name="location_description" placeholder="location description.." class="form-control" value="<?= $val['location_description'] ?>">
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Location Address</label>
                                <input type="text" name="location_address" placeholder="location address.." class="form-control" value="<?= $val['location_address'] ?>">
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Zipcode</label>
                                <input type="text" name="location_postcode" class="form-control" required value="<?= $val['location_postcode']; ?>" placeholder="zipcode..">
                            </div>
                        </div>
                        
                        <button class="btn btn-primary" id="upbtn<?= $val['id']; ?>" type="submit">Update</button>
                </div>
            </form>
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
<div class="modal fade" id="addAreaModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Area</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
                <div id="msgdiv"></div>
            <form method="post" onsubmit="return addLocation(event)" id="addLocation" enctype="multipart/form-data">
                <div class="modal-body">
                    
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                    <label class="form-label"><strong>Area Group</strong></label>
                                    <?php $area_data = $this->common_model->GetAllData('area_served');?>
                                    <select class="form-control" name="area_group_id">
                                    <?php $selected = ""; 
                                    foreach($area_data as $value) { ?>
                                        
                                            <option  value="<?= $value['id'] ?>"><?= $value['area_group'] ?></option>
                                        <?php } ?>
                                    </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Location Name</label>
                                <input type="text"  name="location_name" placeholder="location name.." class="form-control" required>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Location description</label>
                                <input type="text"  name="location_description" placeholder="location description.." class="form-control" required>
                            </div>                            
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Location Address</label>
                                <input type="text" name="location_address" class="form-control" required placeholder="location address..">
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Zipcode</label>
                                <input type="number" name="location_postcode" placeholder="zipcode.." class="form-control" required>
                            </div>
                        </div>
                        
                        <button class="btn btn-primary" id="addbtn" type="submit">Add</button>
                </div>
            </form>
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
    function addLocation(event) {
        event.preventDefault();
    $('.alert-danger').remove();
        var data = new FormData($('#addLocation')[0]);

        $.ajax({
              url: '<?= base_url()?>Admin/PickupLocation/add_loaction',
              data: data,
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

  function updatLocation(el, event, id) {
    event.preventDefault();
    $('.alert-danger').remove();
    var data = new FormData($(el)[0]);

    $.ajax({
        url: '<?= base_url()?>Admin/PickupLocation/update_location',
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
          url: '<?= base_url()?>Admin/PickupLocation/delete_location',
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