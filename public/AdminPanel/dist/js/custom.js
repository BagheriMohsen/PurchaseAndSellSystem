$(document).ready(function(){
//Create users
    // enabled agent_id option when agent role selected
    $('#user_role').on('click',function(event){
        var user_value = event.target.value;
        if(user_value === '2'){
            $('#agent_id').prop('disabled',false);
            $('#agent_id').removeClass('disabled');
        }else{
            $('#agent_id').prop('disabled',true);
            $('#agent_id').addClass('disabled');
        }
    });
    // enabled tariff inputs when agent and agent manager roles selected
    $('#user_role').on('click',function(event){
        var user_value = event.target.value;
        if(user_value === '2' || user_value === '3'){
            $('#tariff_internal,#tariff_locally,#tariff_village').prop('disabled',false);
            $('#tariff_internal,#tariff_locally,#tariff_village').parent().removeClass('disabled');
        }else{
            $('#tariff_internal,#tariff_locally,#tariff_village').prop('disabled',true);
            $('#tariff_internal,#tariff_locally,#tariff_village').parent().addClass('disabled');
        }
     });
     // enabled commission input when seller role selected
     $('#user_role').on('click',function(event){
        var user_value = event.target.value;
        if(user_value === '4'){
            $('#porsantSeller').prop('disabled',false);
            $('#porsantSeller').parent().removeClass('disabled');
        }else{
            $('#porsantSeller').prop('disabled',true);
            $('#porsantSeller').parent().addClass('disabled');
        }
     });
     // enabled return product checkbox when agent/agent manager/stucker fund roles selected
     $('#user_role').on('click',function(event){
        var user_value = event.target.value;
        if(user_value === '2' || user_value === '3' || user_value === '8'){
            $('#return_product').prop('disabled',false);
            $('#return_product').parent().prop('disabled',false);
            $('#return_product').parent().removeClass('disabled');
        }else{
            $('#return_product').prop('disabled',true);
            $('#return_product').parent().prop('disabled',true);
            $('#return_product').parent().addClass('disabled');
        }
     });
     // enabled send order checkbox when agent role selected
     $('#user_role').on('click',function(event){
        var user_value = event.target.value;
        if(user_value === '2'){
            $('#send_order').prop('disabled',false);
            $('#send_order').parent().prop('disabled',false);
            $('#send_order').parent().removeClass('disabled');
        }else{
            $('#send_order').prop('disabled',true);
            $('#send_order').parent().prop('disabled',true);
            $('#send_order').parent().addClass('disabled');
        }
     });
     // Setup table for seller information
     $('#sellerInfoTable').DataTable();
     //Adding product type via ajax
     $('.storeTypeForm').submit(function(event){
        event.preventDefault();
        $(this).find('button[type="submit"]').html('<i class="fas fa-spinner"></i>');
        var actionUrl = $(this).attr('action');
        var CSRF_TOKEN = $(this).find('input[name="_token"]').val();
        var product_id = $(this).find('input[name="product"]').val();
        var name = $(this).find('input[name="name"]').val();
        $.ajax({
            url:actionUrl,
            type:'post',
            data:{
                _token:CSRF_TOKEN,
                product:product_id,
                name:name
            },
            success:function(response){
                console.log(response);
            }
        });
     });
     //Deleting product type via ajax
     $('.deleteTypeButton').on('click',function(event){
        event.preventDefault();
        $(this).html('<i class="fas fa-spinner"></i>');
        var form = $(this).parent('form');
        var actionUrl = form.attr('action');
        var CSRF_TOKEN = form.find('input[name="_token"]').val();
        var _method = form.find('input[name="_method"]').val();
        $.ajax({
            url:actionUrl,
            type:'post',
            data:{
                _token:CSRF_TOKEN,
                _method:_method,
            },
            success:function(response){
                console.log(response);
            }
        });
     });
     //Editing product type via ajax
     $('.editTypeButton').on('click',function(event){
        event.preventDefault();
        var row = $(this).parent('td').parent('tr');
        row.find('.editTypeButton').addClass('d-none');
        row.find('.cancelEdit').removeClass('d-none');
        row.find('.confirmEdit').removeClass('d-none');
        row.find('.productTypeName').children('span').addClass('d-none');
        row.find('.productTypeName').children('input').removeClass('d-none');
     });
     //Cancel Editing product type
     $('.cancelEdit').on('click',function(){
        event.preventDefault();
        var row = $(this).parent('td').parent('tr');
        row.find('.editTypeButton').removeClass('d-none');
        row.find('.cancelEdit').addClass('d-none');
        row.find('.confirmEdit').addClass('d-none');
        row.find('.productTypeName').children('span').removeClass('d-none');
        row.find('.productTypeName').children('input').addClass('d-none');
    });
    //Confirm Editing product type
    $('.confirmEdit').on('click',function(event){
        event.preventDefault();
        $(this).html('<i class="fas fa-spinner"></i>');
        var form = $(this).parent('form');
        var row = $(this).parent('form').parent('td').parent('tr');
        var actionUrl = form.attr('action');
        var CSRF_TOKEN = form.find('input[name="_token"]').val();
        var _method = form.find('input[name="_method"]').val();
        var product_id = form.find('input[name="product"]').val();
        var name = row.find('.productTypeName').children('input').val();
        $.ajax({
            url:actionUrl,
            type:'put',
            data:{
                _token:CSRF_TOKEN,
                _method:_method,
                product:product_id,
                name:name
            },
            success:function(response){
                console.log(response);
            }
        });
    });
    //Deleting special tariffs for users via ajax
    $('.deleteSpecialTariff').on('click',function(event){
        event.preventDefault();
        $(this).html('<i class="fas fa-spinner"></i>');
        var form = $(this).parent('form');
        var actionUrl = form.attr('action');
        var CSRF_TOKEN = form.find('input[name="_token"]').val();
        var _method = form.find('input[name="_method"]').val();
        $.ajax({
            url:actionUrl,
            type:'post',
            data:{
                _token:CSRF_TOKEN,
                _method:_method,
            },
            success:function(response){
                console.log(response);
            }
        });
    });
    //Storing special tariffs for users via ajax
    $('.storeSTariffForm').submit(function(event){
        event.preventDefault();
        $(this).find('button[type="submit"]').html('<i class="fas fa-spinner"></i>');
        var actionUrl = $(this).attr('action');
        var CSRF_TOKEN = $(this).find('input[name="_token"]').val();
        var user_id = $(this).find('input[name="user_id"]').val();
        var product_id = $(this).find('select[name="product_id"]').val();
        var tariff_place = $(this).find('select[name="tariff_place"]').val();
        var tariff_price = $(this).find('input[name="tariff_price"]').val();
        console.log(actionUrl,CSRF_TOKEN,user_id,product_id,tariff_price,tariff_place);
        

        // $.ajax({
        //     url:actionUrl,
        //     type:'post',
        //     data:{
        //         _token:CSRF_TOKEN,
        //         product:product_id,
        //         name:name
        //     },
        //     success:function(response){
        //         console.log(response);
        //     }
        // });
     });

});

