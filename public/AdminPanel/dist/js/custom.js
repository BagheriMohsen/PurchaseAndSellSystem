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
      // enabled type of product price calculation checkbox when agent role selected
      $('#user_role').on('click',function(event){
        var user_value = event.target.value;
        if(user_value === '2'){
            $('#calType').prop('disabled',false);
            $('#calType').parent().prop('disabled',false);
            $('#calType').parent().removeClass('disabled');
        }else{
            $('#calType').prop('disabled',true);
            $('#calType').parent().prop('disabled',true);
            $('#calType').parent().addClass('disabled');
        }
     });
     // Show callcenter fields and hide other fields when callcenter role selected
     $('#user_role').on('click',function(event){
        var user_value = event.target.value;
        if(user_value === '9'){
            $('.callcenterFields').removeClass('d-none');
            $('.otherRolesFields').addClass('d-none');
        }else{
            $('.callcenterFields').addClass('d-none');
            $('.otherRolesFields').removeClass('d-none');
        }
     });
    
     // Setup table for seller information
     $('#sellerInfoTable').DataTable();
    //Updating product types via ajax
    var updateProductTypes = function(typesList,product_id,CSRF_TOKEN){
        var CSRF_TOKEN = CSRF_TOKEN;
        var typesList = typesList;
        var product_id = product_id;
        var product_type_counter_id = '#typeCounter'+product_id;
        var product_modal_tbody_id = '#types'+product_id+' '+'tbody';
        var product_modal_tbody = document.querySelector(product_modal_tbody_id);
        $(product_type_counter_id).html(typesList.length);
        product_modal_tbody.innerHTML = '';

        $.each(typesList,function(index,value){
            product_modal_tbody.innerHTML +=`
                <tr class="text-center">
                    <td class="productTypeName">
                        <span>${value.name}</span>
                        <input class="d-none text-center" type="text" value="${value.name}">
                    </td>
                    <td class="d-flex justify-content-center">
                    <a  class="editTypeButton text-warning btn-sm" href="#">
                        <i class="far fa-edit crud-icon"></i>
                    </a>
                    <form class="pt-1" action="http://127.0.0.1:8000/types/${value.id}"  method="POST">
                        <input type="hidden" name="_token"  value="${CSRF_TOKEN}" />
                        <input type="hidden" name="_method" value="UPDATE" />
                        <input type="hidden" name="product" value="${value.product_id}">
                        <a class="confirmEdit text-green btn-sm d-none" href="#">
                        <i class="far fa-check-square crud-icon"></i>
                        </a>
                    </form>
                    <a  class="cancelEdit text-danger btn-sm d-none" href="#">
                        <i class="far fa-window-close crud-icon"></i>
                    </a>
                        <form class="pt-1" action="http://127.0.0.1:8000/types/${value.id}"  method="POST">
                            <input type="hidden" name="_token"  value="${CSRF_TOKEN}" />
                            <input type="hidden" name="_method" value="DELETE" />
                            <input type="hidden" name="product" value="${value.product_id}">
                        <a href="javascript:void(0)" class="deleteTypeButton btn-sm">
                            <i class="far fa-trash-alt text-danger crud-icon"></i>
                        </a>
                        </form>
                    </td>
                </tr>
            `;
        });
        //Deleting product type via ajax
        $('.deleteTypeButton').on('click',function(event){
            event.preventDefault();
            $(this).html('<i class="fas fa-spinner"></i>');
            var form = $(this).parent('form');
            var actionUrl = form.attr('action');
            var CSRF_TOKEN = form.find('input[name="_token"]').val();
            var _method = form.find('input[name="_method"]').val();
            var product_id = form.find('input[name="product"]').val();
            $.ajax({
                url:actionUrl,
                type:'post',
                data:{
                    _token:CSRF_TOKEN,
                    _method:_method,
                },
                success:function(response){
                    getProductTypes(product_id,CSRF_TOKEN);
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
                    getProductTypes(product_id,CSRF_TOKEN);
                }
            });
        });
    }
     //Getting product types via ajax
    var getProductTypes = function(product_id,CSRF_TOKEN){
        
        $.ajax({
            url:'http://127.0.0.1:8000/types/'+ product_id,
            type:'Get',
            success:function(response){
                updateProductTypes(response,product_id,CSRF_TOKEN);
            }
        });
    }
     //Adding product type via ajax
     $('.storeTypeForm').submit(function(event){
        event.preventDefault();
        var self = $(this);
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
                self.find('button[type="submit"]').html('<i class="far fa-plus-square crud-icon"></i>');
                getProductTypes(product_id,CSRF_TOKEN);
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
        var product_id = form.find('input[name="product"]').val();
        $.ajax({
            url:actionUrl,
            type:'post',
            data:{
                _token:CSRF_TOKEN,
                _method:_method,
            },
            success:function(response){
                getProductTypes(product_id,CSRF_TOKEN);
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
                getProductTypes(product_id,CSRF_TOKEN);
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
        $.ajax({
            url:actionUrl,
            type:'post',
            data:{
                user_id:user_id,
                product:product_id,
                place:tariff_place
            },
            success:function(response){
                console.log(response);
            }
        });
     });
    //All Orders Chart Setup
    if(document.querySelector('#allOrdersChart')){
        var data = [
            { y: '2014', a: 50, b: 90 , c: 110 , d: 45},
            { y: '2015', a: 65,  b: 75 , c: 190 , d: 65},
            { y: '2016', a: 50,  b: 50 , c: 77 , d: 45},
            { y: '2017', a: 75,  b: 60 , c: 66 , d: 33},
            { y: '2018', a: 80,  b: 65 , c: 55 , d: 22},
            { y: '2019', a: 90,  b: 70 , c: 99 , d: 55},
            { y: '2020', a: 100, b: 75 , c: 75 , d: 66},
            { y: '2021', a: 115, b: 75 , c: 37 , d: 33},
            { y: '2022', a: 120, b: 85 , c: 86 , d: 22},
            { y: '2023', a: 145, b: 85 , c: 97 , d: 11},
            { y: '2024', a: 160, b: 95 , c: 34 , d: 22}
        ],
        config = {
        data: data,
        xkey: 'y',
        ykeys: ['a', 'b' , 'c' , 'd'],
        labels: ['سفارشات وصولی', 'سفارشات کنسلی','سفارشات ثبت شده','پیام های دریافتی'],
        fillOpacity: 0.6,
        hideHover: 'auto',
        behaveLikeLine: true,
        resize: true,
        pointFillColors:['#ffffff'],
        pointStrokeColors: ['black'],
        lineColors:['#33b5e5','#ff3547','#ff3547','#ffbb33']
        };
        config.element = 'allOrdersChart';
        Morris.Line(config);
    }
    
    
});

