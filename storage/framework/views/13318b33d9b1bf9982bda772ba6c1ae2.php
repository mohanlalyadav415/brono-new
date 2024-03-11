<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="<?php echo e(URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/simplebar/simplebar.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/node-waves/waves.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/feather-icons/feather.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/pages/plugins/lord-icon-2.1.0.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/plugins.js')); ?>"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="<?php echo e(URL::asset('build/js/pages/datatables.init.js')); ?>"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>  -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script> 
<?php echo $__env->yieldContent('script'); ?>
<?php echo $__env->yieldContent('script-bottom'); ?>
<script type="text/javascript"> 
    $('#region_id').change(function() {
        var region_id = $(this).val();

        $.ajax({
            url: '/get-comuna/' + region_id,
            type: 'GET',
            success: function(comuna) { 
                $('#comuna_id').empty();
                $.each(comuna, function(index, comunaVal) {
                    $('#comuna_id').append('<option value="' + comunaVal.comuna_id + '">' + comunaVal.name + '</option>');
                });
            }
        });
    });
</script>  
<?php if(isset($getCompany->region_id) && !empty($getCompany->region_id)): ?>
<script type="text/javascript">
    $.ajax({
        url: '/get-comuna/' + <?php echo $getCompany->region_id; ?>,
        type: 'GET',
        success: function(comuna) { 
            $('#comuna_id').empty();
            $.each(comuna, function(index, comunaVal) {
                $('#comuna_id').append('<option value="' + comunaVal.comuna_id + '">' + comunaVal.name + '</option>');
            });
        }
    });
    setTimeout(function(){$('#comuna_id').val(<?php echo e($getCompany->comuna_id); ?>).change(); }, 1000);
</script>
<?php endif; ?>

<script>
    /*$(document).ready(function(e) { 

        $("#addmore").on("click",function(){
            var rowCount = $('#sortable >tbody >tr').length;

               $.ajax({
                type:'POST',
                url: 'action-form-ajax',
                data:{'action':'addDataRow',"_token": "<?php echo e(csrf_token()); ?>",'counter':rowCount},
                success: function(data){
                    $('#tb').append(data);
                }
            });
        });
 

    });*/

</script> 
<?php /**PATH D:\xampp\htdocs\atgo\resources\views/layouts/vendor-scripts.blade.php ENDPATH**/ ?>