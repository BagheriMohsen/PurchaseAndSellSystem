$(document).ready(function(){
    var baseUrl = 'http://127.0.0.1:8000/';

    // Global variables

    var persianDataTable = {
        "sEmptyTable":     "هیچ داده‌ای در جدول وجود ندارد",
        "sInfo":           "نمایش _START_ تا _END_ از _TOTAL_ ردیف",
        "sInfoEmpty":      "نمایش 0 تا 0 از 0 ردیف",
        "sInfoFiltered":   "(فیلتر شده از _MAX_ ردیف)",
        "sInfoPostFix":    "",
        "sInfoThousands":  ",",
        "sLengthMenu":     "نمایش _MENU_ ",
        "sLoadingRecords": "در حال بارگزاری...",
        "sProcessing":     "در حال پردازش...",
        "sSearch":         "جستجو:",
        "sZeroRecords":    "رکوردی با این مشخصات پیدا نشد",
        "oPaginate": {
            "sFirst":    "برگه‌ی نخست",
            "sLast":     "برگه‌ی آخر",
            "sNext":     "بعدی",
            "sPrevious": "قبلی"
        },
        "oAria": {
            "sSortAscending":  ": فعال سازی نمایش به صورت صعودی",
            "sSortDescending": ": فعال سازی نمایش به صورت نزولی"
        }
    };

    // End Global variables

    //Initiating plugins

    //Initiating datatable js
    $.extend( $.fn.dataTable.defaults, {
        "language": persianDataTable,
    } );

    //End initiating plugins
    
    //Defining functions

    //Check user role in create user page
    var checkUserRole = function(){
        var user_value = $('#user_role').val();

        // enabled agent_id option when agent role selected in create&edit user page
        if(user_value == '2'){
            $('#agent_id').parent().removeClass('d-none');
        }else{
            $('#agent_id').parent().addClass('d-none');
        }

        // enabled callcenter_id option when seller role selected in create&edit user page
        if(user_value == '4'){
            $('#callcenter_id').parent().removeClass('d-none');
        }else{
            $('#callcenter_id').parent().addClass('d-none');
        }

        // enabled tariff inputs when agent and agent manager roles selected in create&edit user page
        if(user_value == '2'){
            $('#tariff_internal,#tariff_locally,#tariff_village,#factorCal').parent().removeClass('d-none');
        }else{
            $('#tariff_internal,#tariff_locally,#tariff_village,#factorCal').parent().addClass('d-none');
        }
        // enabled commission input when seller role selected in create&edit user page
        if(user_value == '4'){
            $('#porsantSeller').parent().removeClass('d-none');
        }else{
            $('#porsantSeller').parent().addClass('d-none');
        }
        // Enable sending order, product return from warehouse and type of calculating product price for agent role in create&edit user page
        if(user_value == '2'){
            $('#send_order,#calType,#return_product').parents('.col-sm-4').removeClass('d-none');
        }else{
            $('#send_order,#calType,#return_product').parents('.col-sm-4').addClass('d-none');
        }

        // Show callcenter fields and hide other fields when callcenter role selected in create&edit user page
        if(user_value == '9'){
            $('.callcenterFields').removeClass('d-none');
            $('.otherRolesFields').addClass('d-none');
        }else{
            $('.callcenterFields').addClass('d-none');
            $('.otherRolesFields').removeClass('d-none');
        }
        // enabled backToFollowManager option when agent role selected in create&edit user page
        if(user_value == '2'){
            $('#backToFollowManager').parents('.col-sm-4').removeClass('d-none');
        }else{
            $('#backToFollowManager').parents('.col-sm-4').addClass('d-none');
        }
        if(user_value == '6'){
            $('#backToSeller').parents('.col-sm-4').removeClass('d-none');
        }else{
            $('#backToSeller').parents('.col-sm-4').addClass('d-none');
        }
    };
    function checkCalType(){
        if($('#calType').prop('checked') == true){
            $('#factorCal').prop('disabled',false);
        }else{
            $('#factorCal').prop('disabled',true);
        }
    }

    checkUserRole();
    checkCalType();

    $('#user_role').on('change', checkUserRole);
    $('.CalTypeBox').on('click', checkCalType);
   

    //Updating product types via ajax in product type modal in products page
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
                    <a  class="editTypeButton text-warning btn-sm d-none" href="#">
                        <i class="far fa-edit crud-icon"></i>
                    </a>
                    <form class="pt-1" action="${baseUrl}/types/${value.id}"  method="POST">
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
                        <form class="pt-1" action="${baseUrl}/types/${value.id}"  method="POST">
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
        //Deleting product type via ajax in product type modal in products page
        $('.deleteTypeButton').on('click', deleteTypeButton);
    }

    // Setup tables 
    
    //Setup order table in agentOrderList page
    var orderTable = $('#orderTable').DataTable({
        dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-4'i><'col-sm-4 text-center'p><'col-sm-4'B>>",
        buttons: [
            {
                extend: 'excelHtml5',
            },
           
        ],
        columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets:   0
        } ],
        select: {
            style:    'multi',
            selector: 'td:first-child'
        },
        order: [[ 1, 'asc' ]],
    });
    var unverifiedOrdersTable = $('#unverifiedOrdersForm').DataTable({
        dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-4'i><'col-sm-4 text-center'p><'col-sm-4'B>>",
        buttons: [
            {
                extend: 'excelHtml5',
            },
           
        ],
        columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets:   0
        } ],
        select: {
            style:    'multi',
            selector: 'td:first-child'
        },
        order: [[ 1, 'asc' ]],
    });
    var sellerNoActionTable = $('#sellerNoActionTable').DataTable({
        dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-4'i><'col-sm-4 text-center'p><'col-sm-4'B>>",
        buttons: [
            {
                extend: 'excelHtml5',
            },
           
        ],
        "language": persianDataTable,
        columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets:   0
        } ],
        select: {
            style:    'multi',
            selector: 'td:first-child'
        },
        order: [[ 1, 'asc' ]],
    });
    $('#productTable').DataTable( {
        dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-4'i><'col-sm-4 text-center'p><'col-sm-4'B>>",
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [2,3,4,5,6,7 ]
                }
            },
           
        ]
    } );
    // $('#storeRoomTable').DataTable( {
    //     dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
    //     "<'row'<'col-sm-12'tr>>" +
    //     "<'row'<'col-sm-4'i><'col-sm-4 text-center'p><'col-sm-4'B>>",
    //     buttons: [
    //         {
    //             extend: 'excelHtml5',
    //         },
           
    //     ]
    // } );
    // city&state section tabless
    $('#cityTable,#stateTable').DataTable({
        dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-4'i><'col-sm-4 text-center'p><'col-sm-4'B>>",
        buttons: [
            {
                extend: 'excelHtml5',
            },
           
        ],
    });
    //User sections tables
    $('#agentTable,#callcenterTable,#sellerTable,#usersTable').DataTable({
        dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-4'i><'col-sm-4 text-center'p><'col-sm-4'B>>",
        buttons: [
            {
                extend: 'excelHtml5',
            },
           
        ],
    });
    //Dashboard tables
    $('#sellerInfoTable').DataTable({
        "order": [[ 1, "desc" ]]
    });

    //Store room tables
    $('#agentInTable,#agentOutTable,#agentReceiveTable,#agentIndexTable,#agentExchangeStorageTable,#fundInStorageTable,#mainReceiveTable,#fundOutStorageTable,#returnFromAgentTable,#sendToAgentTable,#mainInStorageTable,#mainOutStorageTable,#returnFromFundTable,#storageChangeTable,#storeRoomTable').DataTable({
        dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-4'i><'col-sm-4 text-center'p><'col-sm-4'B>>",
        buttons: [
            {
                extend: 'excelHtml5',
            },
           
        ],
    });
    //Warehouse tables
    $('#warehouseInOutTable,#warehouseIndexTable').DataTable({
        dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-4'i><'col-sm-4 text-center'p><'col-sm-4'B>>",
        buttons: [
            {
                extend: 'excelHtml5',
            },
           
        ],
    });
    //Search result table
    $('#searchResult').DataTable({
        dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-4'i><'col-sm-4 text-center'p><'col-sm-4'B>>",
        buttons: [
            {
                extend: 'excelHtml5',
            },
           
        ],
    });

    // End setup tables 

    function deleteTypeButton(event){
        event.preventDefault();
        $(this).html('<i class="fas fa-spinner"></i>');
        $(this).attr('disabled','disabled');
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
                $(this).attr('disabled',false);
            }
        });
    }
   

    // //Editing product type via ajax
    // $('.editTypeButton').on('click',function(event){
    //     event.preventDefault();
    //     var row = $(this).parent('td').parent('tr');
    //     row.find('.editTypeButton').addClass('d-none');
    //     row.find('.cancelEdit').removeClass('d-none');
    //     row.find('.confirmEdit').removeClass('d-none');
    //     row.find('.productTypeName').children('span').addClass('d-none');
    //     row.find('.productTypeName').children('input').removeClass('d-none');
    // });
    // //Cancel Editing product type
    // $('.cancelEdit').on('click',function(){
    //     event.preventDefault();
    //     var row = $(this).parent('td').parent('tr');
    //     row.find('.editTypeButton').removeClass('d-none');
    //     row.find('.cancelEdit').addClass('d-none');
    //     row.find('.confirmEdit').addClass('d-none');
    //     row.find('.productTypeName').children('span').removeClass('d-none');
    //     row.find('.productTypeName').children('input').addClass('d-none');
    // });
    // //Confirm Editing product type
    // $('.confirmEdit').on('click',function(event){
    //     event.preventDefault();
    //     $(this).html('<i class="fas fa-spinner"></i>');
    //     var form = $(this).parent('form');
    //     var row = $(this).parent('form').parent('td').parent('tr');
    //     var actionUrl = form.attr('action');
    //     var CSRF_TOKEN = form.find('input[name="_token"]').val();
    //     var _method = form.find('input[name="_method"]').val();
    //     var product_id = form.find('input[name="product"]').val();
    //     var name = row.find('.productTypeName').children('input').val();
    //     $.ajax({
    //         url:actionUrl,
    //         type:'put',
    //         data:{
    //             _token:CSRF_TOKEN,
    //             _method:_method,
    //             product:product_id,
    //             name:name
    //         },
    //         success:function(response){
    //             getProductTypes(product_id,CSRF_TOKEN);
    //         }
    //     });
    // });

    //Getting product types via ajax in product type modal in products page
    var getProductTypes = function(product_id,CSRF_TOKEN){

        $.ajax({
            url:baseUrl+'/types/'+ product_id,
            type:'Get',
            success:function(response){
                updateProductTypes(response,product_id,CSRF_TOKEN);
            }
        });
    }

    //End Defining functions

    //Submitting Forms

    // In products_create page
    $('#productCreateForm').submit(function(event){
        event.preventDefault();
        //remove comma before submit
        $('input.comma').each(function(index,item){
            item.value = parseInt(item.value.replace(/\,/g,'',10));
        });
        $(this)[0].submit();
    });
    // In products-off page
    $('#offPriceForm').submit(function(event){
        event.preventDefault();
        //remove comma before submit
        $('input.comma').each(function(index,item){
            item.value = parseInt(item.value.replace(/\,/g,'',10));
        });
        $(this)[0].submit();
    });
    // In products-off page
    $('#productEditForm').submit(function(event){
        event.preventDefault();
        //remove comma before submit
        $('input.comma').each(function(index,item){
            item.value = parseInt(item.value.replace(/\,/g,'',10));
        });
        $(this)[0].submit();
    });
    //Adding product type via ajax in product type modal in products page
    $('.storeTypeForm').submit(function(event){
        event.preventDefault();
        var self = $(this);
        $(this).find('button[type="submit"]').html('<i class="fas fa-spinner"></i>');
        $(this).find('button[type="submit"]').attr('disabled','disabled');
        var actionUrl = $(this).attr('action');
        var CSRF_TOKEN = $(this).find('input[name="_token"]').val();
        var product_id = $(this).find('input[name="product"]').val();
        var name = $(this).find('input[name="name"]').val();
        $(this).trigger('reset');
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
                self.find('button[type="submit"]').html('<i class="far fa-plus-square crud-icon"></i>');
                self.find('button[type="submit"]').attr('disabled',false);
                toastr["info"](response);
                getProductTypes(product_id,CSRF_TOKEN);
            }
        });
    });
    //Deleting product type via ajax
    $('.deleteTypeButton').on('click',deleteTypeButton);

    //  //Editing product type via ajax
    //  $('.editTypeButton').on('click',function(event){
    //     event.preventDefault();
    //     var row = $(this).parent('td').parent('tr');
    //     row.find('.editTypeButton').addClass('d-none');
    //     row.find('.cancelEdit').removeClass('d-none');
    //     row.find('.confirmEdit').removeClass('d-none');
    //     row.find('.productTypeName').children('span').addClass('d-none');
    //     row.find('.productTypeName').children('input').removeClass('d-none');
    //  });
    //  //Cancel Editing product type
    //  $('.cancelEdit').on('click',function(){
    //     event.preventDefault();
    //     var row = $(this).parent('td').parent('tr');
    //     row.find('.editTypeButton').removeClass('d-none');
    //     row.find('.cancelEdit').addClass('d-none');
    //     row.find('.confirmEdit').addClass('d-none');
    //     row.find('.productTypeName').children('span').removeClass('d-none');
    //     row.find('.productTypeName').children('input').addClass('d-none');
    // });
    // //Confirm Editing product type
    // $('.confirmEdit').on('click',function(event){
    //     event.preventDefault();
    //     $(this).html('<i class="fas fa-spinner"></i>');
    //     var form = $(this).parent('form');
    //     var row = $(this).parent('form').parent('td').parent('tr');
    //     var actionUrl = form.attr('action');
    //     var CSRF_TOKEN = form.find('input[name="_token"]').val();
    //     var _method = form.find('input[name="_method"]').val();
    //     var product_id = form.find('input[name="product"]').val();
    //     var name = row.find('.productTypeName').children('input').val();
    //     $.ajax({
    //         url:actionUrl,
    //         type:'put',
    //         data:{
    //             _token:CSRF_TOKEN,
    //             _method:_method,
    //             product:product_id,
    //             name:name
    //         },
    //         success:function(response){
    //             getProductTypes(product_id,CSRF_TOKEN);
    //         }
    //     });
    // });

    //Updating special tariff table data
    var updateSpecialTariff = function(specialList,user_id,CSRF_TOKEN,product_name){
        var newSpecial = specialList[specialList.length - 1];
        var user_id = user_id;
        var special_type_counter_id = '#specialCounter'+user_id;
        var special_modal_tbody_selector = '#special'+ user_id +' '+'tbody';
        var special_modal_tbody = document.querySelector(special_modal_tbody_selector);
        $(special_type_counter_id).html(specialList.length);
        // special_modal_tbody.innerHTML = '';

        if(newSpecial.place == 'village'){
            newSpecial.place = 'روستا';
        }else if(newSpecial.place == 'internal'){
            newSpecial.place = 'داخل شهر';
        }else{
            newSpecial.place = 'حومه شهر';
        };
        special_modal_tbody.innerHTML +=`
        <tr class="text-center">
            
        <td>${product_name}</td>
        <th>${numberWithCommas(newSpecial.price)}</th>
        <th>${newSpecial.place}</th>
        <td>
          <form  action="${baseUrl}/special-tariffs/${newSpecial.id}" method="post" >
              <input type="hidden" name="_token" value="${CSRF_TOKEN}" />
              <input type="hidden" name="_method" value="DELETE" />
              <input type="hidden" name="user_id" value="${user_id}">
            <a href="javascript:void(0)" class="deleteSpecialTariff text-danger btn-sm" name="button">
              <i class="far fa-trash-alt crud-icon"></i>
            </a>
          </form>
        </td>
      </tr>
        `;

        //update tarrif count
        
        //Deleting special tariffs for users via ajax
        $('.deleteSpecialTariff').on('click',function(event){
            event.preventDefault();
            $(this).html('<i class="fas fa-spinner"></i>');
            $(this).attr('disabled','disabled');
            var form = $(this).parent('form');
            var actionUrl = form.attr('action');
            var CSRF_TOKEN = form.find('input[name="_token"]').val();
            var user_id = form.find('input[name="user_id"]').val();
            var _method = form.find('input[name="_method"]').val();
            $.ajax({
                url:actionUrl,
                type:'post',
                data:{
                    _token:CSRF_TOKEN,
                    _method:_method,
                },
                success:function(response){
                    // getSpecialTariff(user_id,CSRF_TOKEN);
                    form.parents('tr').remove();
                    $(this).attr('disabled',false);
                }
            });
            var special_type_counter_id = '#specialCounter'+user_id;
            console.log($(this).parents('table').find('tr'));
            $(special_type_counter_id).html($(this).parents('table').find('tr').length-2);
            });
    };
    //Getting special tariff table data
    var getSpecialTariff = function(user_id,CSRF_TOKEN,product_name){
        $.ajax({
            url:baseUrl+'/special-tariffs-index/'+ user_id,
            type:'Get',
            success:function(response){
                updateSpecialTariff(response,user_id,CSRF_TOKEN,product_name);
            }
        });
    }
    //Storing special tariffs for users via ajax
    $('.storeSTariffForm').submit(function(event){
        event.preventDefault();
        var self = $(this);
        $('input.comma').each(function(index,item){
            item.value = parseInt(item.value.replace(/\,/g,'',10));
        });
        $(this).find('button[type="submit"]').html('<i class="fas fa-spinner"></i>');
        $(this).find('button[type="submit"]').attr('disabled','disabled');
        var actionUrl = $(this).attr('action');
        var CSRF_TOKEN = $(this).find('input[name="_token"]').val();
        var user_id = $(this).find('input[name="user_id"]').val();
        var product_id = $(this).find('select[name="product_id"]').val();
        var product_name = $(this).find('select[name="product_id"] option:selected').html();
        var tariff_place = $(this).find('select[name="tariff_place"]').val();
        var tariff_price = $(this).find('input[name="tariff_price"]').val();
        console.log(tariff_price);
        $(this).trigger('reset');
        $.ajax({
            url:actionUrl,
            type:'post',
            data:{
                _token:CSRF_TOKEN,
                user_id:user_id,
                product_id:product_id,
                place:tariff_place,
                price:tariff_price
            },
            success:function(response){
                if(response.status == 1){
                    toastr["info"](response.message);
                    getSpecialTariff(user_id,CSRF_TOKEN,product_name);
                    self.find('button[type="submit"]').html('ذخیره');
                    self.find('button[type="submit"]').attr('disabled',false);
                   
                }else{
                    toastr["info"](response.message);
                    self.find('button[type="submit"]').html('ذخیره');
                    self.find('button[type="submit"]').attr('disabled',false);
                }
                
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
        var user_id = form.find('input[name="user_id"]').val();
        var _method = form.find('input[name="_method"]').val();
        $.ajax({
            url:actionUrl,
            type:'post',
            data:{
                _token:CSRF_TOKEN,
                _method:_method,
            },
            success:function(response){
                // getSpecialTariff(user_id,CSRF_TOKEN);
                form.parents('tr').remove();
            }
        });
        var special_type_counter_id = '#specialCounter'+user_id;
        console.log($(this).parents('table').find('tr'));
        $(special_type_counter_id).html($(this).parents('table').find('tr').length-2);

    });
   

    
    function configureChart(chartData,element_id){
        var chartData = chartData;
        var dates = [];
        var suspended = [];
        var collected = [];
        var cancelled = [];
        chartData.forEach(function(element){
            var gregorianDate = element.Date.replace(/\-/g,' ').split(' ');
            var jalaliDate = gregorian_to_jalali(parseInt(gregorianDate[0]),parseInt(gregorianDate[1]),parseInt(gregorianDate[2]));
            dates.push(jalaliDate);
        });
        chartData.forEach(function(element){
            suspended.push(element.subsended);
        });
        chartData.forEach(function(element){
            collected.push(element.collected);
        });
        chartData.forEach(function(element){
            cancelled.push(element.cancelled);
        });
        console.log(dates,suspended,collected,cancelled);
        var config = {
            type: 'line',
            data: {
                labels: dates.reverse(),
                datasets: [{
                    label: 'سفارشات وصولی',
                    backgroundColor: '#17a2b8',
                    borderColor: '#17a2b8',
                    data: collected.reverse(),
                    fill: false,
                }, 
                {
                    label: 'سفارشات کنسلی',
                    fill: false,
                    backgroundColor: '#dc3545',
                    borderColor: '#dc3545',
                    data: cancelled.reverse(),
                },
                {
                    label: 'سفارشات در انتظار و معلق',
                    fill: false,
                    backgroundColor: '#ffc107',
                    borderColor: '#ffc107',
                    data: suspended.reverse(),
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: false,
                    text: 'Chart.js Line Chart'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'تاریخ'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'تعداد'
                        }
                    }]
                }
            }
        };
    
        var ctx = document.getElementById(element_id).getContext('2d');
        window.myLine = new Chart(ctx, config);
    }
    if(document.querySelector('#agent_sell_chart')){
        var element_id = 'agent_sell_chart'; 
        var userId = $('#userId').val();
        $.ajax({
            url:baseUrl+'/users/Agent-Dashboard-Chart-API/' + userId,
            type:'Get',
            success:function(response){ 
                configureChart(response[0],element_id);
            }
        });
    };
    //Sell and orders Chart Setup for admin
    if(document.querySelector('#admin_sell_chart')){
        var element_id = 'admin_sell_chart';
        $.ajax({
            url:baseUrl+'/users/Admin-Dashboard-Chart-API',
            type:'Get',
            success:function(response){ 
                configureChart(response[0],element_id);
            }
        });
    };


    var productList;
    var orderListTable = document.querySelector('.orderList');
    //Setup for order page
    var addOrderTable = function(){
        var div = document.createElement('div');
        div.classList.add('row');
        div.innerHTML =  `
            <div class="col-sm-3">
             
              <select class="productSelect form-control bg-sec" name="product_name" required>
                <option value="">محصول را انتخاب کنید</option>
              </select>
            </div>
            <div class="col-sm-1">
              
              <input class="countField form-control bg-sec" type="number" name="count" value="1" required>
            </div>
            <div class="col-sm-2">
             
              <input class="priceField form-control bg-sec" type="text" placeholder="" name="price" value=""  disabled required>
            </div>
            <div class="col-sm-2">
             
              <input class="offField form-control bg-sec" type="number" placeholder="" name="off" value="0" required>
            </div>
            <div class="col-sm-3 mt-1">
            
              <select class="typeSelect form-control bg-sec"  name="productType">
                
              </select>
            </div>
            <div class="col-sm-1 mt-1 text-center mt-2 " >
                <strong>
                <a class="removeProduct text-danger" href="#">
                   <i class="far fa-trash-alt text-danger crud-icon"></i>
                </a>
                </strong>
            </div>
        `;
        orderListTable.appendChild(div);
        var productSelectList = document.querySelectorAll('.productSelect');
        var productSelect = productSelectList[productSelectList.length-1];
        productList.forEach(function(item) {
            productSelect.innerHTML += `
                <option value="${item.id}">${item.name}</option>
            `;
        });
    };
    if(document.querySelector('#orderForm')){
        // Getting product list for seller order table 
        $.ajax({
            url:baseUrl+'/admin/orders/ProductList',
            type:'GET',
            success:function(response){
                productList = response;
                console.log(response);
                if($('.orderEditForm').length){
                    getOrderList();
                    
                }else{
                    addOrderTable();
                }
                
            }
        });
    }
    //Order list type and price updating when product selected
    $('.orderList').on('click',function(event){
        event.preventDefault();
        if(event.target.classList.contains('productSelect') && event.target.value){
            var row = event.target.parentElement.parentElement;
            var productPriceInput = row.querySelector('.priceField');
            var typeSelect = row.querySelector('.typeSelect');
            var productPrice;
            productList.forEach(function(item){
                if(item.id == event.target.value){
                    productPrice = item.price;
                    typeSelect.innerHTML = '';
                    item.types.forEach(function(value){
                        typeSelect.innerHTML +=`
                            <option value="${value.id}">${value.name}</option>
                        `;
                    });
                }
            });
            productPriceInput.value = numberWithCommas(productPrice);

        }else if(event.target.classList.contains('fa-trash-alt')){
            // event.target.parentElement.parentElement.parentElement.parentElement.remove();
            event.target.closest(".row").remove();

        }
    });
    $('.addProduct').on('click',function(event){
        event.preventDefault();
        addOrderTable();
    });
    $('#orderForm').submit(function(event){
        event.preventDefault();
        var form = $(this);
        form.find('button[type="submit"]').html('<i class="fas fa-spinner"></i>')
        var orderArray = [];
        var product_id_array =[];
        // form.find('input[name="HBD_Date"]').val(isoDate);
        $('.orderList .row').each(function(index,value){
            var orderObject = {};
            orderObject.product_id = value.querySelector('.productSelect').value;
            orderObject.count = value.querySelector('input[name="count"]').value;
            orderObject.off = value.querySelector('input[name="off"]').value;
            orderObject.type = value.querySelector('.typeSelect').value;
            orderArray.push(orderObject);
            if(!product_id_array.includes(value.querySelector('.productSelect').value)){
                product_id_array.push(value.querySelector('.productSelect').value);
            }
        });
        var actionUrl = form.attr('action');
        var CSRF_TOKEN = form.find('input[name="_token"]').val();
        var mobile = form.find('input[name="mobile"]').val();
        var telephone = form.find('input[name="telephone"]').val();
        var state_id = form.find('select[name="state"]').val();
        var city_id = form.find('select[name="city"]').val();
        var fullName = form.find('input[name="fullName"]').val();
        var postalCode = form.find('input[name="postalCode"]').val();
        var HBD_Date = form.find('input[name="HBD_Date"]').val();;
        var address = form.find('textarea[name="address"]').val();
        var paymentMethod = form.find('input[name="paymentMethod"]').val();
        var shippingCost = form.find('input[name="shippingCost"]').val().replace(/\,/g,'',10);
        var cashPrice = form.find('input[name="cashPrice"]').val().replace(/\,/g,'',10);
        var prePayment = form.find('input[name="prePayment"]').val().replace(/\,/g,'',10);
        var chequePrice = form.find('input[name="chequePrice"]').val().replace(/\,/g,'',10);
        var instant = form.find('input[name="instant"]').val();
        var sellerDescription = form.find('textarea[name="sellerDescription"]').val();
        var deliverDescription = form.find('textarea[name="deliverDescription"]').val();
        var agentStatue = form.find('#agentStatue').val();
        m = moment(HBD_Date, 'jYYYY/jM/jD');
        var formData = {
            _token:CSRF_TOKEN,
            mobile:mobile,
            telephone:telephone,
            state_id:state_id,
            city_id:city_id,
            agentStatue:agentStatue,
            fullName:fullName,
            postalCode:postalCode,
            HBD_Date:HBD_Date,
            address:address,
            paymentMethod:paymentMethod,
            shippingCost:shippingCost,
            cashPrice:cashPrice,
            prePayment:prePayment,
            chequePrice:chequePrice,
            instant:instant,
            sellerDescription:sellerDescription,
            deliverDescription:deliverDescription,
            orderArray:orderArray,
            product_id_array:product_id_array

        }
        $.ajax({
            url:actionUrl,
            type:'POST',
            data:formData,
            success:function(response){
                form.find('button[type="submit"]').html('ثبت سفارش');
                
                toastr["success"](response);
                $('#orderForm').trigger('reset');
                $('#cityAgent').html('');
            }
        });

    });
    // Calculating order overall price
    function setOverAllPrice(){
        var overallPrice = null;
        console.log($('.orderList .row'));
        $('.orderList .row').each(function(index,value){
            var rowPrice = null;
            var count = value.querySelector('input[name="count"]').value;
            var off = value.querySelector('input[name="off"]').value;
            var price = value.querySelector('input[name="price"]').value.replace(/\,/g,'',10);
            rowPrice = (count*price) - off;
            overallPrice += rowPrice;
        });
        console.log('overall',overallPrice);
        $('#overallPrice').html(numberWithCommas(overallPrice));
        var deliveryPrice = $('#orderForm input[name="shippingCost"]').val().replace(/\,/g,'',10);
        $('#orderForm input[name="cashPrice"]').val(numberWithCommas(parseInt(overallPrice) + parseInt(deliveryPrice)));
    }
    $('#orderForm .orderList').on('change click keyup load', setOverAllPrice);
    $('#orderForm input[name="shippingCost"]').on('change keyup',function(){
        var deliveryPrice = $('#orderForm input[name="shippingCost"]').val().replace(/\,/g,'',10);
        var productsPrice = $('#overallPrice').html().replace(/\,/g,'',10);
        console.log('sum',productsPrice+deliveryPrice);
        $('#orderForm input[name="cashPrice"]').val(numberWithCommas(parseInt(productsPrice) + parseInt(deliveryPrice)));
    });

    //Checking if city has agent exist when seller gives order
    $('#orderForm #city').on('click',function(){
        $('#cityAgent').html('');
        var city = document.querySelector('#city');
        if(city.value){
            var cityName = city.selectedOptions[0].innerText;
            $.ajax({
                url:baseUrl+'/admin/orders/AgentExistInState/' + cityName,
                type:'Get',
                success:function(response){
                    $('#agentStatue').val(response.state);
                    if(response.state == 2){
                        $('#cityAgent').html('<span class="text-success">'+ response.message +'</span>');
                    }else if(response.state == 1){
                        $('#cityAgent').html('<span class="text-secondary">'+ response.message +'</span>');
                    }else{
                        $('#cityAgent').html('<span class="text-danger">'+ response.message +'</span>');
                    }
                }
            });
        }
    });

    // Confirm before delete for all delete buttons in all pages
    $('.deleteConfirm').submit(function (event) {
        if(confirm('آیا از حذف این آیتم مطمئن هستید؟')){
            // do nothing and submit
        }else{
            // prevent submit
            event.preventDefault();
        }
    });
    // Add comma to numbers
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    //Overall value for store room table 
    if($('#storeRoomTable').length){
        var rowSum = $('#storeRoomTable .rowSum');
        var overallSum = 0;
        rowSum.each(function(index,value){
            overallSum += parseInt(value.innerText.replace(/\,/g,''));
        });
        $('#overAllSum').html(numberWithCommas(overallSum));
    }
    // Add comma to numeric inputs
    $('input.comma').keyup(function(event) {

        // skip for arrow keys
        if(event.which >= 37 && event.which <= 40) return;
        // format number
        $(this).val(function(index, value) {
            return value
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    });
   
    // var isoDate;
    // Setup persian datepicker for date inputs
    var isoDate;
    $(".persianDatePicker").pDatepicker({
        calendar:{
            persian: {
                locale: 'en'
            }
        },
        format : 'YYYY-MM-DD',
        initialValue : false,
        onSelect: function(unix){
            var date = new Date(unix);
            var year = date.getFullYear();
            var month = date.getMonth();
            var day = date.getDate();
            isoDate = year + '-' + month + '-' + day;
        }

    });
    $(".persianDateTimepicker").pDatepicker({
        calendar:{
            persian: {
                locale: 'en'
            }
        },
        format:'YYYY-MM-DDTHH:mm:ss',
        initialValue : false,
        onSelect: function(unix){
            var date = new Date(unix);
            var year = date.getFullYear();
            var month = date.getMonth();
            var day = date.getDate();
            isoDate = year + '-' + month + '-' + day;
        },
        timePicker: {
            enabled: true,
            meridiem: {
                enabled: true
            }
        }
    });
    //Add zero to hours,minutes and seconds for clock
    function addZero(i) {
        if (i < 10) {
          i = "0" + i;
        }
        return i;
    }
    //Turn timestamp js date object
    function convertTimeStampToJalali(timestamp){
        var date = new Date(timestamp);
        if(!date)
            return false;
            return ( gregorian_to_jalali(date.getFullYear(),(date.getMonth()+1),date.getDate(),date.getHours(),date.getMinutes(),date.getSeconds()) );
    }
    // Turn js date object to jalali date
    function gregorian_to_jalali(gy,gm,gd,h,m,s){
        var result = '';
        g_d_m=[0,31,59,90,120,151,181,212,243,273,304,334];
        if(gy > 1600){
            jy=979;
            gy-=1600;
        }else{
            jy=0;
            gy-=621;
        }
        gy2=(gm > 2)?(gy+1):gy;
        days=(365*gy) +(parseInt((gy2+3)/4)) -(parseInt((gy2+99)/100)) +(parseInt((gy2+399)/400)) -80 +gd +g_d_m[gm-1];
        jy+=33*(parseInt(days/12053)); 
        days%=12053;
        jy+=4*(parseInt(days/1461));
        days%=1461;
        if(days > 365){
            jy+=parseInt((days-1)/365);
            days=(days-1)%365;
        }
        jm=(days < 186)?1+parseInt(days/31):7+parseInt((days-186)/30);
        jd=1+((days < 186)?(days%31):((days-186)%30));
        result = jy +'-' + jm + '-' + jd;

        if(h && m && s){
            var hours = addZero(h);
            var minutes = addZero(m);
            var seconds = addZero(s);
            result += ' ' + hours + ":" + minutes + ":" + seconds;
        }
        return result;
    }
    $('.timestamp').each(function(index,value){
        var jalaliTime = convertTimeStampToJalali(value.innerHTML)
        value.innerHTML = (jalaliTime);
    });
    $('.paginate_button').on('click',function(){
        $('.timestamp').each(function(index,value){
            var jalaliTime = convertTimeStampToJalali(value.innerHTML)
            value.innerHTML = (jalaliTime);
        });
        $('.justDate').each(function(index,value){
            if(value.innerHTML){
                var dateArray = value.innerHTML.replace(/\-/g,' ').split(' ');
                var jalaliDate = gregorian_to_jalali(parseInt(dateArray[0]),parseInt(dateArray[1]),parseInt(dateArray[2]));
                value.innerHTML = jalaliDate;
            }
    
        });
    });
    $('.justDate').each(function(index,value){
        if(value.innerHTML){
            var dateArray = value.innerHTML.replace(/\-/g,' ').split(' ');
            var jalaliDate = gregorian_to_jalali(parseInt(dateArray[0]),parseInt(dateArray[1]),parseInt(dateArray[2]));
            value.innerHTML = jalaliDate;
        }

    });
    $('.inputDateToJalali').each(function(index,value){
        if(value.value){
            var dateArray = value.value.replace(/\-/g,' ').split(' ');
            var jalaliDate = gregorian_to_jalali(parseInt(dateArray[0]),parseInt(dateArray[1]),parseInt(dateArray[2]));
            value.value = jalaliDate;
        }

    });
    
    // Calculating sent cargo to agent from tankhah warehouse in agentExchangeForm page
    function getProductPrice(products,product_id){
        var price = 0;
        $.each(products,function(index,value){
            if(value.id == product_id){
               price = value.price;
            }
        });
        return price;
    }
    function calculateCargoValue(){
        var self = $(this);
        $(this).find('.cargoValue').html('<i class="fas fa-spinner"></i>');
        var product_id = $(this).find('select[name="product"]').val();
        if(product_id){
            $.ajax({
                url:baseUrl+'/admin/orders/ProductList',
                type:'GET',
                success:function(response){
                    var price = parseInt(getProductPrice(response,product_id));
                    var number = parseInt(self.find('input[name="number"]').val());
                    number = number || 0;
                    self.find('.cargoValue').html(numberWithCommas(price*number));
                }
            });
        }
    }
    $('#sendToAgentForm').on('change', calculateCargoValue);
    $('#storeToStoreAgents').on('change', calculateCargoValue);
    $('#productReceive').on('change', calculateCargoValue);
    $('#productExit').on('change', calculateCargoValue);
    $('#warehouseToTankhah').on('change', calculateCargoValue);
    $('#tankhahExit').on('change', calculateCargoValue);
    $('#returnToFund').on('change', calculateCargoValue);


    // $('#searchForm').submit(function(event){
    //     event.preventDefault();
    //     $('.persianDatePicker').each(function(index,item){
    //         var jalali_date = $(this).val();
    //         if(jalali_date){
    //             m = moment(jalali_date, 'jYYYY/jM/jD');
    //             $(this).siblings('.georgian_date').val(m._i.slice(0, -1));
    //         }
    //     });
    //     $(this)[0].submit();
    // });
    $('#costReportForm,#paymentReportForm,#reportOrderForm,#sendToAgentForm,#storeToStoreAgents,#tankhahExit,#returnToFund,#costForm,#searchForm,#payOrderList').submit(function(event){
        event.preventDefault();
        $('.persianDatePicker').each(function(index,item){
            var jalali_date = $(this).val();
            if(jalali_date){
                m = moment(jalali_date, 'jYYYY/jM/jD');
                $(this).siblings('.georgian_date').val(m._i.slice(0, -1));
            }
        });
       $(this)[0].submit();
    });
    // $('#storeToStoreAgents').submit(function(event){
    //     event.preventDefault();
    //     $(this).find('input[name="date"]').val(isoDate);
    //     $(this)[0].submit();
    // });
    // $('#tankhahExit').submit(function(event){
    //     event.preventDefault();
    //     $(this).find('input[name="date"]').val(isoDate);
    //     $(this)[0].submit();
    // });
    // $('#returnToFund').submit(function(event){
    //     event.preventDefault();
    //     $(this).find('input[name="date"]').val(isoDate);
    //     $(this)[0].submit();
    // });
    // $('#costForm').submit(function(event){
    //     event.preventDefault();
    //     $(this).find('input[name="date"]').val(isoDate);
    //     $(this)[0].submit();
    //  });
    
    //Get State and cities array via ajax for user_create and user_edit 
    var statesCityArray;
    if($('#createUserForm').length || $('#editUserForm').length || $('#searchForm').length || $('#warehouseForm')){
        $.ajax({
            url:baseUrl+'/states/AllStatesAndCitiesName',
            type:'Get',
            success:function(response){
                statesCityArray = response;
            }
        });
        //City dependency to states in forms
        $('#state').on('change',function(){
            var null_value = null;
            var form = $(this).parents('form');
            var city = form.find('#city')[0];
            city.innerHTML = '';
            if($('#searchForm').length){
                city.innerHTML += `<option value="${null_value}">همه</option>`;
            }
            var stateName = form.find('#state option:selected').html();
            $.each(statesCityArray,function(index,value){
                if(value.name == stateName){
                    $.each(value.cities,function(index,value){
                        city.innerHTML += `<option value="${value.id}">${value.name}</option>`;
                    });
                }
            });
        });
    }
    if($('#orderForm').length){
        $.ajax({
            url:baseUrl+'/states/AllStatesAndCitiesName',
            type:'Get',
            success:function(response){
                console.log(response);
                statesCityArray = response;
            }
        });
        //City dependency to states in forms
        $('#state').on('change click',function(){
            $('#cityAgent').html('');
            var form = $(this).parents('form');
            var city = form.find('#city')[0];
            city.innerHTML = '';
            city.innerHTML += `<option value="">شهر را انتخاب کنید</option>`;
            var stateName = form.find('#state option:selected').html();
            $.each(statesCityArray,function(index,value){
                if(value.name == stateName){
                    $.each(value.cities,function(index,value){
                        city.innerHTML += `<option value="${value.id}">${value.name}</option>`;
                    });
                }
            });
        });
    }
    //Change order condition fields depending on radio button in AgentOrderLists page
    $('.conditionAssignForm input[name="condition"]:radio').change(function(e) {
        var value = e.target.value.trim();
        var form = $(this).parents('form');
        var waitingDelivery = form.find('.waitingDeliveryField');
        var suspend = form.find('.suspendField');
        var cancelField = form.find('.cancelField');
        waitingDelivery.addClass('d-none');
        suspend.addClass('d-none');
        cancelField.addClass('d-none');
     
    
        switch (value) {
          case '7':
            waitingDelivery.removeClass('d-none');
            break;
          case '14':
            suspend.removeClass('d-none');
            break;
          case '13':
            cancelField.removeClass('d-none');
            break;
          default:
            break;
        }
    });
    $('.conditionAssignForm input[name="cancel"]:radio').change(function(e) {
        var value = e.target.value.trim()
        var form = $(this).parents('form');
        var cancelDescField = form.find('.cancelDescField');
        if(value == 'cancelDesc'){
            cancelDescField.removeClass('d-none');
        }else{
            cancelDescField.addClass('d-none');
        }
    });
    $('.conditionAssignForm input[name="suspend"]:radio').change(function(e) {
        var value = e.target.value.trim()
        var form = $(this).parents('form');
        var dueDateFuild = form.find('.dueDateFuild');
        if(value == 'dueDate'){
            dueDateFuild.removeClass('d-none');
        }else{
            dueDateFuild.addClass('d-none');
        }
    });
    $('#conditionForm button').on('click',function(event){
        event.preventDefault();
        var tableData = orderTable.rows({ selected: true }).data().toArray();
        var orderNumbers = [];
        var form = $(this).parents('form');
        var actionUrl = form.attr('action');
        var CSRF_TOKEN = form.find('input[name="_token"]').val();
        var condition = form.find('select').val();
        $.each(tableData,function(index,value){
            var orderId = {'id': parseInt(value[1]),'statue': condition};
            orderNumbers.push(orderId);
        });
        if(!orderNumbers.length){
            alert('سفارشی انتخاب نشده است');
        }else if(!condition){
            alert('گزینه ای انتخاب نشده است');
        }else{
            form.find('button').html('<strong class="h6"><i class="fas fa-spinner"></i></strong>');
            form.find('button').attr('disabled','disabled');
            // var formData = [];
            // formData.status = condition;
            // formData.orders = orderNumbers;
            console.log(orderNumbers);
            $.ajax({
                url:actionUrl,
                type:'get',
                data:{
                    _token:CSRF_TOKEN,
                    orderNumbers:orderNumbers
                },
                success:function(response){
                    console.log(response);
                    form.find('button').html('<strong class="h6">ذخیره</strong>');
                    form.find('button').attr('disabled',false);
                    if(response.status == 1){
                        orderTable.rows('.selected').remove().draw( false );
                        toastr["success"](response.message);
                        
                        
                    }else{
                        toastr["error"](response.message);
                    }
                   
                }
            });
        }
        
    });
    $('#toFollowManagerForm button').on('click',function(event){
        event.preventDefault();
        var tableData = orderTable.rows({ selected: true }).data().toArray();
        var orderNumbers = [];
        var form = $(this).parents('form');
        var actionUrl = form.attr('action');
        var CSRF_TOKEN = form.find('input[name="_token"]').val();
        var status = form.find('input[name="status"]').val();
        $.each(tableData,function(index,value){
            var orderId = {'id': parseInt(value[1]),'statue': status};
            orderNumbers.push(orderId);
        });
        console.log(orderNumbers);
        if(!orderNumbers.length){
            alert('سفارشی انتخاب نشده است');
        }else{
            form.find('button').html('<strong class="h6"><i class="fas fa-spinner"></i></strong>');
            form.find('button').attr('disabled','disabled');
            $.ajax({
                url:actionUrl,
                type:'get',
                data:{
                    _token:CSRF_TOKEN,
                    orderNumbers:orderNumbers,
                },
                success:function(response){
                    form.find('button').html('<strong class="h6">ذخیره</strong>');
                    form.find('button').attr('disabled',false);
                    if(response.status == 1){
                        orderTable.rows('.selected').remove().draw( false );
                        toastr["info"](response.message);
                    }else{
                        toastr["danger"](response.message);
                    }
                    
                    console.log(response);
                }
            });
        }
        
    });
    $('#chooseAgentForm button').on('click',function(event){
        event.preventDefault();
        var tableData = unverifiedOrdersTable.rows({ selected: true }).data().toArray();
        var orderNumbers = [];
        var form = $(this).parents('form');
        var actionUrl = form.attr('action');
        var CSRF_TOKEN = form.find('input[name="_token"]').val();
        var agent_id = form.find('select[name="agent"]').val();
        $.each(tableData,function(index,value){
            var orderId = {'id': parseInt(value[1]),'agent_id': agent_id};
            orderNumbers.push(orderId);
        });
        console.log(orderNumbers);
        if(!orderNumbers.length){
            alert('سفارشی انتخاب نشده است');
        }else if(!agent_id){
            alert('گزینه ای انتخاب نشده است');
        }else{
            form.find('button').html('<strong class="h6"><i class="fas fa-spinner"></i></strong>');
            form.find('button').attr('disabled','disabled');
            $.ajax({
                url:actionUrl,
                type:'get',
                data:{
                    _token:CSRF_TOKEN,
                    orderNumbers:orderNumbers,
                },
                success:function(response){
                    form.find('button').html('<strong class="h6">ذخیره</strong>');
                    form.find('button').attr('disabled',false);
                    if(response.status == 1){
                        unverifiedOrdersTable.rows('.selected').remove().draw( false );
                        toastr["info"](response.message);
                    }else{
                        toastr["danger"](response.message);
                    }
                    
                    console.log(response);
                }
            });
        }
        
    });
    $('#backToSellerForm button').on('click',function(event){
        event.preventDefault();
        var tableData = unverifiedOrdersTable.rows({ selected: true }).data().toArray();
        var orderNumbers = [];
        var form = $(this).parents('form');
        var actionUrl = form.attr('action');
        var CSRF_TOKEN = form.find('input[name="_token"]').val();
        var statue = form.find('input[name="status"]').val();
        $.each(tableData,function(index,value){
            var orderId = {'id': parseInt(value[1]),'statue': statue};
            orderNumbers.push(orderId);
        });
        console.log(orderNumbers);
        if(false){
            alert('سفارشی انتخاب نشده است');
        }else{
            form.find('button').html('<strong class="h6"><i class="fas fa-spinner"></i></strong>');
            form.find('button').attr('disabled','disabled');
            $.ajax({
                url:actionUrl,
                type:'get',
                data:{
                    _token:CSRF_TOKEN,
                    orderNumbers:orderNumbers
                },
                success:function(response){
                    form.find('button').html('<strong class="h6">برگشت به فروشنده</strong>');
                    form.find('button').attr('disabled',false);
                    if(response.status == 1){
                        unverifiedOrdersTable.rows('.selected').remove().draw( false );
                        toastr["info"](response.message);
                    }else{
                        toastr["danger"](response.message);
                    }
                    
                    console.log(response);
                }
            });
        }
        
    });
    $('#notAbleToSendForm button').on('click',function(event){
        event.preventDefault();
        var tableData = unverifiedOrdersTable.rows({ selected: true }).data().toArray();
        var orderNumbers = [];
        var form = $(this).parents('form');
        var actionUrl = form.attr('action');
        var CSRF_TOKEN = form.find('input[name="_token"]').val();
        var statue = form.find('input[name="status"]').val();
        $.each(tableData,function(index,value){
            var orderId = {'id': parseInt(value[1]),'statue': statue};
            orderNumbers.push(orderId);
        });
        console.log(orderNumbers);
        if(false){
            alert('سفارشی انتخاب نشده است');
        }else{
            form.find('button').html('<strong class="h6"><i class="fas fa-spinner"></i></strong>');
            form.find('button').attr('disabled','disabled');
            $.ajax({
                url:actionUrl,
                type:'get',
                data:{
                    _token:CSRF_TOKEN,
                    orderNumbers:orderNumbers
                },
                success:function(response){
                    form.find('button').html('<strong class="h6">غیر قابل ارسال</strong>');
                    form.find('button').attr('disabled',false);
                    if(response.status == 1){
                        unverifiedOrdersTable.rows('.selected').remove().draw( false );
                        toastr["info"](response.message);
                    }else{
                        toastr["danger"](response.message);
                    }
                    
                    console.log(response);
                }
            });
        }
        
    });
    $('#toFollowManager button').on('click',function(event){
        event.preventDefault();
        var tableData = sellerNoActionTable.rows({ selected: true }).data().toArray();
        var orderNumbers = [];
        var form = $(this).parents('form');
        var actionUrl = form.attr('action');
        var CSRF_TOKEN = form.find('input[name="_token"]').val();
        var statue = form.find('input[name="status"]').val();
        $.each(tableData,function(index,value){
            var orderId = {'id': parseInt(value[1]),'statue': statue};
            orderNumbers.push(orderId);
        });
        console.log(orderNumbers);
        if(false){
            alert('سفارشی انتخاب نشده است');
        }else{
            form.find('button').html('<strong class="h6"><i class="fas fa-spinner"></i></strong>');
            form.find('button').attr('disabled','disabled');
            $.ajax({
                url:actionUrl,
                type:'get',
                data:{
                    _token:CSRF_TOKEN,
                    orderNumbers:orderNumbers
                },
                success:function(response){
                    form.find('button').html('<strong class="h6">غیر قابل ارسال</strong>');
                    form.find('button').attr('disabled',false);
                    if(response.status == 1){
                        sellerNoActionTable.rows('.selected').remove().draw( false );
                        toastr["info"](response.message);
                    }else{
                        toastr["danger"](response.message);
                    }
                    
                    console.log(response);
                }
            });
        }
        
    });
    
    
    //Handling cash and cheque in order_create page
    // $('#orderForm input[name="paymentMethod"]').on('change',function(){
    //     var form = $(this).parents('form');
    //     var cashPrice = form.find('input[name="cashPrice"]');
    //     var prePayment = form.find('input[name="prePayment"]')
    //     var chequePrice = form.find('input[name="chequePrice"]');
    //     var overallPrice = parseInt(form.find('#overallPrice').html().replace(/\,/g,'',10));
    //     var paymentMethod = $(this).val();
    //     if(paymentMethod === 'cash'){
    //         cashPrice.attr('disabled',false);
    //         prePayment.attr('disabled','disabled');
    //         chequePrice.attr('disabled','disabled');
    //         cashPrice.val(numberWithCommas(overallPrice));
    //         chequePrice.val(0);
    //         prePayment.val(0);
           
    //     }else{
    //         cashPrice.attr('disabled','disabled');
    //         prePayment.attr('disabled', false);
    //         chequePrice.attr('disabled', false);
    //         chequePrice.val(numberWithCommas(overallPrice));
    //         prePayment.val(0);
    //         cashPrice.val(0);
    //     }
    // });
    // $('input[name="prePayment"]').on('keyup',function(){
    //     var form = $(this).parents('form');
    //     var prePayment = parseInt($(this).val().replace(/\,/g,'',10))
    //     var overallPrice = parseInt(form.find('#overallPrice').html().replace(/\,/g,'',10));
    //     if(prePayment){
    //         form.find('input[name="chequePrice"]').val(numberWithCommas(overallPrice - prePayment) );
    //     }else{
    //         form.find('input[name="chequePrice"]').val(numberWithCommas(overallPrice));
    //     }
    // });
    
    // Condition assign per order in modal 
    $('.conditionAssignForm button').on('click',function(event){
        event.preventDefault();
        var form = $(this).parents('form');
        form.find('button').html('<strong class="h6"><i class="fas fa-spinner"></i></strong>');
        form.find('button').attr('disabled','disabled');
        var actionUrl = form.attr('action');
        var CSRF_TOKEN = form.find('input[name="_token"]').val();
        var condition = form.find('input[name="condition"]').val();
        var waitingDeliveryDesc = form.find('textarea[name="waitingDeliveryDesc"]').val();
        var suspend = form.find('input[name="suspend"]').val();
        var dueDate = form.find('input[name="dueDate"]').val();
        var cancel = form.find('input[name="cancel"]').val();
        var cancelDesc = form.find('textarea[name="cancelDesc"]').val();
        console.log(actionUrl,CSRF_TOKEN,condition,waitingDeliveryDesc,suspend,dueDate,cancel,cancelDesc);
        $.ajax({
            url:actionUrl,
            type:'get',
            data:{
                _token:CSRF_TOKEN,
                status:condition,
                waitDesc:waitingDeliveryDesc,
                suspend:suspend,
                dueDate:dueDate,
                cancel:cancel,
                cancelDesc:cancelDesc,
            },
            success:function(response){
                form.find('button').html('<strong class="h6">ذخیره</strong>');
                form.find('button').attr('disabled',false);
                console.log(response);
            }
        });
    });
    // Invoice calculation in agent page
    if($('.invoice_details').length){
        var total_without_off = null;
        var post_price = parseInt($('.post_price').html().replace(/\,/g,'',10));
        var pre_payment = parseInt($('.pre_payment').html().replace(/\,/g,'',10));
        post_price = post_price || 0;
        pre_payment = pre_payment || 0;
        $('.row_total').each(function(index,value){
            total_without_off += parseInt(value.innerHTML);
        });
        console.log(total_without_off,post_price,pre_payment);
        
        $('.total').html( total_without_off + post_price - pre_payment);
        
    }
    // Order_details modal calculation for agent,seller,etc..
    if($('.orderDetail').length){
        $('.orderDetail').each(function(index,value){
            var total_without_off = null;
            var post_price = parseInt($(this).find('.post_price').html().replace(/\,/g,'',10));
            var pre_payment = parseInt($(this).find('.pre_payment').html().replace(/\,/g,'',10));
            post_price = post_price || 0;
            pre_payment = pre_payment || 0;
            $(this).find('.row_total').each(function(index,value){
                total_without_off += parseInt(value.innerHTML);
            });
            $(this).find('.total').html( total_without_off + post_price - pre_payment);
        });
     
    }
    // Togge allowNewOrder in callcenter users list
    $('#callcenterTable input[name="allowNewOrder"]').on('change',function(){
        var allowNewOrder = $(this). is(":checked");
        if(allowNewOrder == true){
            allowNewOrder =  'on';
        }else{
            allowNewOrder = null;
        }
        var user_id = $('#user_id').val();
        $.ajax({
            url:baseUrl+'/users/callCenterAddNewOrderChange/'+ user_id,
            type:'get',
            data: {
                allowNewOrder: allowNewOrder
            },
            success:function(response){
                toastr["success"](response);
            }
        });
    });
    // Before submitting search form
    // $('#searchForm').submit(function(event){
    //     event.preventDefault();

    // });
 
    $('.persianDatePicker').on('change paste keyup select',function(){
        console.log($(this).val());
        // $(this).siblings('.georgian_date').val()
    });
    // $('#searchForm').submit(function(event){
    //     event.preventDefault();
    //     $('.persianDatePicker').each(function(index,item){
    //         var jalali_date = $(this).val();
    //         if(jalali_date){
    //             m = moment(jalali_date, 'jYYYY/jM/jD');
    //             $(this).siblings('.georgian_date').val(m._i.slice(0, -1));
    //         }
    //     });
    //     $(this)[0].submit();
    // });
    // $('#agent_report_form').submit(function(event){
    //     event.preventDefault();
    //     $('.persianDatePicker').each(function(index,item){
    //         var jalali_date = $(this).val();
    //         if(jalali_date){
    //             m = moment(jalali_date, 'jYYYY/jM/jD');
    //             $(this).siblings('.georgian_date').val(m._i.slice(0, -1));
    //         }
    //     });
    //     $(this)[0].submit();
    // });
    //Adding comma to numbers in tables 
    $.fn.digits = function(){ 
        return this.each(function(){ 
            $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") ); 
        })
    }
    $(".number").digits();

    // AgentPaymentList page turn jalali to georgian
    // $('#payOrderList').submit(function(event){
    //     event.preventDefault();
    //     $(this).find('input[name="date"]').val(isoDate);
    //     $(this)[0].submit();
    //  });
     //Order edit page, get order products
    function getOrderList(){
        
        var order_id = $('input[name="order_id"]').val();
        $.ajax({
            url:baseUrl+'/admin/orders/OrdersProductForEditPage/'+ order_id,
            type:'get',
            success:function(response){
                console.log('edit',response);
                setOrderList(response);
            }
        });
    }
        
    function setOrderList(orderList){
        var orderListTable = document.querySelector('.orderList');
        orderList.forEach(function(item){
            if(!item.type){
                item.type = '';
            };
            if(!item.product_type){
                item.product_type = '';
            }
            var div = document.createElement('div');
            div.classList.add('row');
            div.innerHTML =  `
                <div class="col-sm-3">
                    
                    <select class="productSelect form-control bg-sec" name="product_name" required disabled>
                    <option value="${item.product_id}" checked>${item.product}</option>
                    </select>
                </div>
                <div class="col-sm-1">
                    
                    <input class="countField form-control bg-sec" type="number" name="count" value="${item.count}" required disabled>
                </div>
                <div class="col-sm-2">
                    
                    <input class="priceField form-control bg-sec" type="text" placeholder="" name="price" value="${item.price}"  disabled required>
                </div>
                <div class="col-sm-2">
                    
                    <input class="offField form-control bg-sec" type="number" placeholder="" name="off" value="${item.off}" required disabled>
                </div>
                <div class="col-sm-3 mt-1">
                
                    <select class="typeSelect form-control bg-sec"  name="productType" disabled>
                    <option value="${item.product_type}" checked>${item.type}</option>
                    </select>
                </div>
                <div class="col-sm-1 mt-1 text-center mt-2 " >
                    <strong>
                    <a class="removeProduct text-danger" href="#">
                        <i class="far fa-trash-alt text-danger crud-icon"></i>
                    </a>
                    </strong>
                </div>
            `;
            orderListTable.appendChild(div);
        });
        setOverAllPrice();
    }
    //Setup current bill table for agents in current-bills page
    if($('#current_bill_form').length){
        var user_id = $('input[name="user_id"]').val();
        var debts = [];
        var credits = [];
        var all = [];
        
        //Get credits and debts array
        $.ajax({
            url: baseUrl + '/user-inventory/currentBillsCreditor/' + user_id,
            type:'get',
            dataType:'json',
            success:function(response){
                console.log(response);
                credits = response[0].map(function(value){
                    var element = {}
                    element.id = value.id;
                    element.title = value.status_id;
                    element.date = moment(value.billDate, 'YYYY-MM-DD').locale('fa').format('YYYY-MM-DD');
                    element.debt = 0;
                    element.credit = value.bill;
                    element.contribute = 0;
                    return element;
                });
                console.log(credits);
                $.ajax({
                    url: baseUrl + '/user-inventory/currentBillsDebtor/' + user_id,
                    type:'get',
                    success:function(response){
                        console.log(response);
                        debts = response[0].map(function(value){
                            var element = {}
                            element.id = value.id;
                            element.title = 'فاکتور فروش' + value.id;
                            element.date = moment(value.collected_Date, 'YYYY-MM-DD').locale('fa').format('YYYY-MM-DD');
                            element.debt = value.cashPrice;
                            element.credit = 0;
                            element.contribute = 0;
                            value.money_circulations.forEach(function(item){
                                element.contribute += item.sharedSpecialAmount;
                            })
                            // element.contribute = value.money_circulations[0].sharedSpecialAmount;
                            return element;
                        });
                        all = [...debts,...credits];
                        console.log('all',all);
                        $('#current_bill_form').DataTable({
                            "paging":   false,
                            'searching':false,
                            'info':false,
                            'ordering':false,
                            data:all,
                            columns:[
                                {'data':'date'},
                                {'data':'title','render':function(data,row){
                                    if(data == 2){
                                        title =  'واریز نقدی';
                                    }else if(data == 5){
                                        title = 'ثبت هزینه';
                                    }else{
                                        title = data;
                                    }
                                    return title;
                                }},
                                {
                                    'data':'debt',
                                    'render':$.fn.dataTable.render.number( ',', '.')
                                },
                                {
                                    'data':'credit',
                                    'render':$.fn.dataTable.render.number( ',', '.')
                                },
                                {
                                    'data':'contribute',
                                    'render':$.fn.dataTable.render.number( ',', '.')
                                },
                                {
                                    'data':null,
                                    'render':function(data,type,row){
                                        return row.debt - row.credit - row.contribute;
                                    },
                                    'className':'remain'
                                }
                            ],
                            "order": [[ 0, "desc" ]]
                        });
                        calculateRemain();
                    }
                });
            }
        });
    }
     
    
    
    function calculateRemain(){
        var sum_remain = 0;
        $('.remain').each(function(index,item){
            if(index != 0){
                sum_remain = parseInt(item.innerText) + sum_remain;
                item.innerText = sum_remain;
            }
        });
        $('.remain').each(function(index,item){
            if(index != 0){
                item.innerText = numberWithCommas(parseInt(item.innerText));
            }
            
        })
    }

    //In Report agent page change persian to georgian date before submit
    // $('#agent_report_form').submit(function(event){
    //     event.preventDefault();
    //     $('.persianDatePicker').each(function(index,item){
    //         var jalali_date = $(this).val();
    //         if(jalali_date){
    //             m = moment(jalali_date, 'jYYYY/jM/jD');
    //             $(this).siblings('.georgian_date').val(m._i.slice(0, -1));
    //         }
    //     });
    //     $(this)[0].submit();
    // });
});

