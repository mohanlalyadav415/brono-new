<?php $__env->startSection('title'); ?> User Card <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<style type="text/css">
    .access-tbls table tr td {
        padding: 10px;
        font-size: 15px;
    }

    .cust_pop_cls label {
        display: block;
        font-size: 15px;
    }

    .popup.cust_pop_cls {
        max-width: 520px;
        width: 100%;
    }

    .popup.cust_pop_cls .btm-btns {
        margin-top: 15px;
    }

    .popup.cust_pop_cls .btm-btns input.set-value-button, .popup.cust_pop_cls .btm-btns button {
        background: #cc563d;
        color: #fff;
        border: solid 1px #cc563d;
        padding: 8px 15px;
        border-radius: 5px;
        margin-right: 10px;
        font-size: 14px;
    }

    .popup.cust_pop_cls .btm-btns button{
       color: #cc563d;
       background: transparent; 
   }

   .cust_pop_cls label input.checkbox {
    vertical-align: middle;
}
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1 text-center">USER CARD EDIT</h4> 
            </div>

            <div class="card-body">
                <div class="live-preview">
                    <form class="row g-3 needs-validation" method="post" action="<?php echo e(url('user_card_edit')); ?>/<?php echo e($getUser->user_id); ?>" enctype="multipart/form-data" novalidate>
                        <?php echo csrf_field(); ?>
                        

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="dni" class="form-label">DNI <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="dni" id="dni" value="<?php echo e($getUser->dni); ?>" required="" placeholder="11.111.111-1"> 
                            <span style="color: red;"><?php if($errors->has('dni')): ?>
                                <?php echo e($errors->first('dni')); ?> 
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="name" class="form-label">Name <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" value="<?php echo e($getUser->name); ?>" required> 
                            <span style="color: red;"><?php if($errors->has('name')): ?>
                                <?php echo e($errors->first('name')); ?> 
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="last_name_1" class="form-label">Last Name 1 <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="last_name_1" value="<?php echo e($getUser->last_name_1); ?>" id="last_name_1" > 
                            <span style="color: red;"><?php if($errors->has('last_name_1')): ?>
                                <?php echo e($errors->first('last_name_1')); ?> 
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="last_name_2" class="form-label">Last Name 2 <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="last_name_2" value="<?php echo e($getUser->last_name_2); ?>" id="last_name_1" > 
                            <span style="color: red;"><?php if($errors->has('last_name_2')): ?>
                                <?php echo e($errors->first('last_name_2')); ?> 
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="email" class="form-label">Email <span style="color: red">*</span></label>
                            <input type="email" class="form-control" name="email" value="<?php echo e($getUser->email); ?>" id="email" > 
                            <span style="color: red;"><?php if($errors->has('email')): ?>
                                <?php echo e($errors->first('email')); ?> 
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="phone" class="form-label">Phone </label>
                            <input type="text" class="form-control" name="phone" value="<?php echo e($getUser->phone); ?>" id="phone"> 
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="superadmin" class="form-label">Superadmin </label> &nbsp;&nbsp;
                            <input type="checkbox" name="superadmin" value="1" id="superadmin" <?php echo (isset($getUser->superadmin) && $getUser->superadmin==1 ? "checked" : "") ?>> 
                        </div>
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative hideSuperadmin" style="<?php if($getUser->superadmin == 1){ echo "display: none"; }?>"></div>
                        <div class="col-md-6 position-relative hideSuperadmin" style="<?php if($getUser->superadmin == 1){ echo "display: none"; }?>">
                            <h4 for="phone" class="form-label">Roles </h4>
                            <table class="table table-bordered table-striped" id="sortable">
                                <thead>
                                    <tr>
                                        <th width="80">ID</th> 
                                        <th>Company</th> 
                                        <th>Role</th> 
                                        <th colspan="2">
                                            <a href="javascript:;" class="btn btn-danger add-more" id=""><i class="ri-add-box-line"></i> New</a> 
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="after-add-more">
                                    <?php  
                                    if (isset($listUserAccess) && !empty($listUserAccess)) {
                                        $i = 1;
                                        foreach ($listUserAccess as $key => $value1) { ?>
                                            <tr>  
                                                <td><input type="text" name="id[]" class="form-control"  value="<?php echo $value1->user_access_id;?>"></td>
                                                <td>
                                                    <select name="company_id[]" id="company_id" class="form-control form-select" data-live-search="true" required="required">
                                                        <option value="">Select</option>
                                                        <?php 
                                                        foreach ($listCompany as $key => $value) { ?>
                                                            <option value="<?php echo $value->company_id; ?>" <?php echo ($value1->company_id==$value->company_id ? "selected" : "") ?> ><?php echo $value->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="role_id[]" id="role_id" class="form-control role_id form-select" data-live-search="true" required="required">
                                                        <option value="">Select</option>
                                                        <?php 
                                                        foreach ($listRole as $key => $value) { ?>
                                                            <option value="<?php echo $value->role_id; ?>" <?php echo ($value1->role_id==$value->role_id ? "selected" : "") ?>><?php echo $value->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td> 
                                                <td>

                                                    <button type="button" id="btnacessval_<?php echo $value1->user_access_id; ?>"  class="btn btn-danger access-button btnAccess_<?php echo $value1->user_access_id; ?>" data-id="<?php echo $value1->user_access_id; ?>" style="<?php echo ($value1->role_id==1 ? 'display: none':''); ?>">Access</button>
                                                    <input type="hidden" id="btn_val_hidden_<?php echo $value1->user_access_id; ?>" name="btn_access_1[]" class="hidden-input" value="<?php echo $value1->access_id; ?>">

                                                </td>
                                                <td align="center" class="text-danger">
                                                    <button type="button" data-toggle="tooltip" data-placement="right" title="Click To Remove" onclick="if(confirm('Are you sure to remove?')){$(this).closest('tr').remove();}" class="btn btn-danger">Delete</button>
                                                </td>
                                            </tr>
                                            <?php 
                                            $i++;
                                        }
                                    }
                                    ?>




                                </tbody> 
                                <!-- <tbody id="tb">

                                </tbody>  -->
                            </table> 
                        </div> 
                        <div class="col-md-3 position-relative hideSuperadmin" style="<?php if($getUser->superadmin == 1){ echo "display: none"; }?>"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative form-check form-switch form-switch-lg">
                            <label class="form-check-label" for="customSwitchsizelg">Status</label>
                            <input type="checkbox" class="form-check-input" id="customSwitchsizelg" name="status" <?php echo e(($getUser->status == 1 ? "checked" : "")); ?>>
                        </div> 
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-2">
                            <a href="javascript:window.history.back()" class="btn btn-danger" ><i class="ri-close-line"></i> Cancel</a>
                        </div>
                        <div class="col-md-3 position-relative">
                            <a href="<?php echo e(url('user_card_delete')); ?>/<?php echo e($getUser->user_id); ?>" onclick="return confirm('Are you sure you want to delete this record?')" class="btn btn-danger" ><i class="ri-delete-bin-line"></i> Delete</a>
                        </div>
                        <div class="col-md-2 position-relative">
                            <button class="btn btn-primary" type="submit"><i class="ri-edit-line"></i> Update</button>
                        </div> 
                        <div class="col-md-3 position-relative"></div>
                    </form>
                </div> 
            </div>
        </div>
    </div>
</div>

<div class="popup cust_pop_cls">
    <h3 style="text-align: center;">User Access.</h3>
    <div style="text-align: center;margin-top: 25px;" id="replaceDiv">
        <input type="hidden" id="getAccessval" name="getAccessval" value="">
        <?php if(isset($getAccess)): ?>
        <?php $i = 1;?>
        <?php $__currentLoopData = $getAccess; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <label><input type="checkbox" name="access_id[]"  class="checkbox" value="<?php echo e($value->access_id); ?>" id="ASDF_<?php echo $i; ?>"> <?php echo e($value->name); ?> </label>
        <?php $i++;?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <div class="btm-btns">
            <input type="button" class="set-value-button" name="setvaluehidden" value="Set Value">

            <button class="closeButton">Close</button>
        </div>
    </div> 
</div>
<style>
    /* Styles for the popup */
    .popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }
</style>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/libs/prismjs/prism.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/pages/form-validation.init.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {


        $('input[name="superadmin"]').click(function() { 
            if ($(this).prop("checked") == true) {
                $('.hideSuperadmin').hide();
                $('#company_id').prop('required',false);
                $('#role_id').prop('required',false);
            } else {
                $('.hideSuperadmin').show();
                $('#company_id').prop('required',true);
                $('#role_id').prop('required',true);
            }
        }); 

        $("table").on("change", ".role_id", function() {
            if ($(this).val() == 1) { 
                $(this).closest('tr').find('.access-button').hide();
            } else {
                $(this).closest('tr').find('.access-button').show();
            }
        });


        $(".set-value-button").on("click", function () { 
            var getAccessval = $("#getAccessval").val(); 

            var checkboxValues = $(".popup .checkbox:checked").map(function () {
                return $(this).val();
            }).get();


            var checkboxValueString = checkboxValues.join(',');

            const myArray = getAccessval.split("btnacessval_");
            let word = myArray[1];

            $("#btn_val_hidden_"+word).val(checkboxValueString);

            $(".popup .checkbox").prop('checked', false);
            $(".popup").hide();
        });


        $("table").on("click", ".access-button", function() {

            var d = $(this).attr("id");
            $("#getAccessval").val(d);
            
            $(".popup").show();
        });

        $/*("table").on("click", ".access-button1", function() {

            var d = $(this).attr("data-id"); 

            $.ajax({
                type:'POST',
                url:'<?php echo e(url("get-user-access-module")); ?>',
                data:{'user_access_id':d,"_token": "<?php echo e(csrf_token()); ?>",},
                success: function(data){ 
                    $(".popup").show(); 
                } 
            });
        });*/

        $(".closeButton").on("click", function() { 
            $(".popup").hide();
        });


        var rowCount = $("#sortable tr").length-1; 


        var max_fields      = 10;
        var wrapper         = $(".after-add-more");
        var add_button      = $(".add-more"); 

        var x = rowCount;
        $(add_button).on("click",function(e){ 
            e.preventDefault();
            if(x < max_fields){ 
                x++; 
                $(wrapper).append('<tr><td><input type="text" name="id[]" class="form-control" value="'+x+'" ></td><td><select name="company_id[]" id="company_id" class="form-control form-select" data-live-search="true" required="required"><option value="">Select</option><?php 
                    foreach ($listCompany as $key => $value) { ?>
                        <option value="<?php echo $value->company_id; ?>"><?php echo $value->name; ?></option><?php } ?>
                        </select></td><td><select name="role_id[]" id="role_id" class="form-control role_id form-select" data-live-search="true" required="required"><option value="">Select</option><?php 
                        foreach ($listRole as $key => $value) { ?>
                            <option value="<?php echo $value->role_id; ?>"><?php echo $value->name; ?></option><?php } ?>
                            </select></td> <td><button type="button" id="btnacessval_'+x+'" class="btn btn-danger access-button btnAccess_'+x+'">Access</button><input id="btn_val_hidden_'+x+'" type="hidden" class="hidden-input" name="btn_access_1[]" value=""></td><td align="center" class="text-danger"><button type="button" data-toggle="tooltip" data-placement="right" title="Click To Remove" class="btn btn-danger remove_field">Delete</button></td></tr>');
            }
        }); 
        $(".btnAccess_"+x+"").click(function(){
            $("#myModal_"+x+"").modal('show');
        }); 

        $(wrapper).on("click",".remove_field", function(e){  
            e.preventDefault(); $(this).closest('tr').remove(); x--;
        })

    }); 
</script> 
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\atgo\resources\views/configure/user_card_edit.blade.php ENDPATH**/ ?>