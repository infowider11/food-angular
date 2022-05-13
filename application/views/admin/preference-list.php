

        
        
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
                        <h4 class="card-title">Preference List</h4>
                        <a href="javascript:void(0);" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#addPreferenceModal">Add Preference</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <!-- <th></th> -->
                                        <th>S.N.</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(!empty($preference)){
                                        $i = 1;
                                        foreach ($preference as $key => $val) { ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><p><?= $val['title'] ?></p></td>
                                                <td><p><?php 
                                                $getCategory = $this->common_model->GetColumnName('category', array('id'=>$val['category_id']), array('title'));
                                                echo $getCategory['title'];
                                                 ?></p></td>
                                                <td>
                                                    <a href="javascript:;" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#updatePreferenceModal<?= $val['id']; ?>"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="javascript:;" id="delbtn<?= $val['id']; ?>" onclick="deleteRow(<?= $val['id']; ?>)" class="btn btn-danger shadow btn-xs sharp me-1"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>



<div class="modal fade" id="updatePreferenceModal<?= $val['id']; ?>">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Preference</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" onsubmit="return updatPreference(this, event, <?= $val['id']; ?>)" id="updatPreference" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $val['id']; ?>">
                <div class="modal-body">
                    <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label"><strong>Select Category</strong></label>
                                <select class="form-control" name="category_id" required >
                                    <option value="">---Select Category---</option>
<?php
foreach ($category as $key => $categoryV) {
    ?>
        <option value="<?= $categoryV['id']; ?>" <?= ($categoryV['id']==$val['category_id']) ? "selected":""; ?> ><?= $categoryV['title'] ?></option>
    <?php
}
?>

                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Preference Name</label>
                                <input type="text"  name="title" placeholder="Preference name.." class="form-control" value="<?= $val['title'] ?>" required>
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
<div class="modal fade" id="addPreferenceModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Preference</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
                <div id="msgdiv"></div>
                <form method="post" onsubmit="return addPreference(event)" id="addPreference" enctype="multipart/form-data">
                    <div class="modal-body">
                    
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label"><strong>Select Category</strong></label>
                                <select class="form-control" name="category_id" required >
                                    <option value="">---Select Category---</option>
<?php
foreach ($category as $key => $categoryV) {
    ?>
        <option value="<?= $categoryV['id'] ?>"><?= $categoryV['title'] ?></option>
    <?php
}
?>

                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label"><strong>Preference Name</strong></label>
                                <input type="text"  name="title" placeholder="Preference name.." class="form-control" required>
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
    function addPreference(event) {
        event.preventDefault();
    $('.alert-danger').remove();
        var data = new FormData($('#addPreference')[0]);

        $.ajax({
              url: '<?= base_url()?>Admin/Meal/add_preference',
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

  function updatPreference(el, event, id) {
    event.preventDefault();
    $('.alert-danger').remove();
    var data = new FormData($(el)[0]);

    $.ajax({
        url: '<?= base_url()?>Admin/Meal/update_preference',
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
          url: '<?= base_url()?>Admin/Meal/delete_preference',
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