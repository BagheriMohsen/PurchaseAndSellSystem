$(document).ready(function(){
    var persianDataTable = {
        "sEmptyTable":     "هیچ داده‌ای در جدول وجود ندارد",
        "sInfo":           "نمایش _START_ تا _END_ از _TOTAL_ ردیف",
        "sInfoEmpty":      "نمایش 0 تا 0 از 0 ردیف",
        "sInfoFiltered":   "(فیلتر شده از _MAX_ ردیف)",
        "sInfoPostFix":    "",
        "sInfoThousands":  ",",
        "sLengthMenu":     "نمایش _MENU_ ردیف",
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
    //Remove comma from number inputs for product Create Form
    $('#productCreateForm').submit(function(event){
        event.preventDefault();
        $('input.comma').each(function(index,item){
            item.value = parseInt(item.value.replace(/\,/g,'',10));
        });
        $(this)[0].submit();
    });
    //Remove comma from number inputs for product Edit Form
    $('#productEditForm').submit(function(event){
        event.preventDefault();
        $('input.comma').each(function(index,item){
            item.value = parseInt(item.value.replace(/\,/g,'',10));
        });
        $(this)[0].submit();
    });
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
            $('#tariff_internal,#tariff_locally,#tariff_village').parent().removeClass('d-none');
        }else{
            $('#tariff_internal,#tariff_locally,#tariff_village').parent().addClass('d-none');
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
    };
    checkUserRole();
    $('#user_role').on('change', checkUserRole);

    // Order and Product section tables
    // $('#productTable').DataTable({
    //     buttons: [
    //        'print'
    //     ]
    // });
    var orderTable = $('#orderTable').DataTable({
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
        buttons: {
            buttons: [
              { extend: 'print', text: 'Print List' },
              { extend: 'pdf', text: 'PDF' },
              { extend: 'copy', text: 'Copy to clipboard' }
            ]
          }
    });
    //User sections tables
    $('#agentTable,#callcenterTable,#sellerTable,#usersTable').DataTable();
    //Dashboard tables
    $('#sellerInfoTable').DataTable();
    //Store room tables
    // $('#agentInTable,#agentOutTable,#agentReceiveTable,#agentIndexTable,#agentExchangeStorageTable,#fundInStorageTable,#mainReceiveTable,#fundOutStorageTable,#returnFromAgentTable,#sendToAgentTable,#mainInStorageTable,#mainOutStorageTable,#returnFromFundTable,#storageChangeTable,#storeRoomTable').DataTable();
    //Warehouse tables
    // $('#warehouseInOutTable,#warehouseIndexTable').DataTable();
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
                    <form class="pt-1" action="http://localhost:8000/types/${value.id}"  method="POST">
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
                        <form class="pt-1" action="http://localhost:8000/types/${value.id}"  method="POST">
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
        $('.deleteTypeButton').on('click',function(event){
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
        });
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
    }
    //Getting product types via ajax in product type modal in products page
    var getProductTypes = function(product_id,CSRF_TOKEN){

        $.ajax({
            url:'http://localhost:8000/types/'+ product_id,
            type:'Get',
            success:function(response){
                updateProductTypes(response,product_id,CSRF_TOKEN);
            }
        });
    }
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
                self.find('button[type="submit"]').html('<i class="far fa-plus-square crud-icon"></i>');
                self.find('button[type="submit"]').attr('disabled',false);
                getProductTypes(product_id,CSRF_TOKEN);
            }
        });
    });
    //Deleting product type via ajax
    $('.deleteTypeButton').on('click',function(event){
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
    });
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
          <form  action="http://localhost:8000/special-tariffs/${newSpecial.id}" method="post" >
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
        });
    };
    //Getting special tariff table data
    var getSpecialTariff = function(user_id,CSRF_TOKEN,product_name){
        $.ajax({
            url:'http://localhost:8000/special-tariffs-index/'+ user_id,
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
                getSpecialTariff(user_id,CSRF_TOKEN,product_name);
                self.find('button[type="submit"]').html('ذخیره');
                self.find('button[type="submit"]').attr('disabled',false);
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
    };
    var productList;
    var orderListTable = document.querySelector('.orderList');
    //Setup for order page
    var addOrderTable = function(){
        var div = document.createElement('div');
        div.classList.add('row');
        div.innerHTML =  `
            <div class="col-sm-3">
              <label for="product_name">انتخاب محصول
                <span class="text-danger">*</span>
              </label>
              <select class="productSelect form-control bg-sec" name="product_name" required>
                <option value="">محصول را انتخاب کنید</option>
              </select>
            </div>
            <div class="col-sm-1">
              <label for="count">تعداد
                <span class="text-danger">*</span>
              </label>
              <input class="countField form-control bg-sec" type="number" name="count" value="1" required>
            </div>
            <div class="col-sm-2">
              <label for="price">قیمت-تومان
                <span class="text-danger">*</span>
              </label>
              <input class="priceField form-control bg-sec" type="text" placeholder="" name="price" value=""  disabled required>
            </div>
            <div class="col-sm-2">
              <label for="off">تخفیف
                <span class="text-danger">*</span>
              </label>
              <input class="offField form-control bg-sec" type="number" placeholder="" name="off" value="0" required>
            </div>
            <div class="col-sm-3 mt-1">
              <label for="productType">مدل محصول
                <span class="text-danger">*</span>
              </label>
              <select class="typeSelect form-control bg-sec"  name="productType">
                
              </select>
            </div>
            <div class="col-sm-1 mt-1 text-center mt-5 " >
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
            url:'http://localhost:8000/admin/orders/ProductList',
            type:'GET',
            success:function(response){
                productList = response;
                console.log(response);
                addOrderTable();
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
        // var x = false;
        event.preventDefault();
        var form = $(this);
        form.find('button[type="submit"]').html('<i class="fas fa-spinner"></i>')
        var orderArray = [];
        form.find('input[name="HBD_Date"]').val(isoDate);
        $('.orderList .row').each(function(index,value){
            var orderObject = {};
            // if(!value.querySelector('.productSelect').value){
            //     x = true;
            //     return;
            // }
            orderObject.product_id = value.querySelector('.productSelect').value;
            orderObject.count = value.querySelector('input[name="count"]').value;
            orderObject.off = value.querySelector('input[name="off"]').value;
            orderObject.type = value.querySelector('.typeSelect').value;
            orderArray.push(orderObject);
        });
        // if(x == true){
        //     alert('لطفا محصول را انتخاب فرمایید');
        //     return;
        // }
        var actionUrl = form.attr('action');
        var CSRF_TOKEN = form.find('input[name="_token"]').val();
        var mobile = form.find('input[name="mobile"]').val();
        var telephone = form.find('input[name="telephone"]').val();
        var state_id = form.find('select[name="state"]').val();
        var city_id = form.find('select[name="city"]').val();
        var fullName = form.find('input[name="fullName"]').val();
        var postalCode = form.find('input[name="postalCode"]').val();
        var HBD_Date = form.find('input[name="HBD_Date"]').val();
        var address = form.find('textarea[name="address"]').val();
        var paymentMethod = form.find('input[name="paymentMethod"]').val();
        var shippingCost = form.find('input[name="shippingCost"]').val().replace(/\,/g,'',10);
        var cashPrice = form.find('input[name="cashPrice"]').val().replace(/\,/g,'',10);
        var prePayment = form.find('input[name="prePayment"]').val().replace(/\,/g,'',10);
        var chequePrice = form.find('input[name="chequePrice"]').val();
        var instant = form.find('input[name="instant"]').val();
        var sellerDescription = form.find('textarea[name="sellerDescription"]').val();
        var agentStatue = form.find('#agentStatue').val();
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
            orderArray:orderArray
        }
        console.log(formData);
        $.ajax({
            url:actionUrl,
            type:'POST',
            data:formData,
            success:function(response){
                form.find('button[type="submit"]').html('ثبت سفارش');
                
                toastr["success"](response,{
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-bottom-center",
                    "preventDuplicates": false,
                    "showDuration": "300",
                    "hideDuration": "500",
                    "timeOut": "3000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "slideIn",
                    "hideMethod": "SlideOout"
                    });
                $('#orderForm').trigger('reset');
                $('#cityAgent').html('');
            }
        });

    });
    // Calculating order overall price
    $('#orderForm').on('change click keyup',function(){
        var overallPrice = null;
        $('.orderList .row').each(function(index,value){
            var rowPrice = null;
            var count = value.querySelector('input[name="count"]').value;
            var off = value.querySelector('input[name="off"]').value;
            var price = value.querySelector('input[name="price"]').value.replace(/\,/g,'',10);
            rowPrice = (count*price) - off;
            overallPrice += rowPrice;
        });
        $('#overallPrice').html(numberWithCommas(overallPrice));
        // Cash price field updated after overallprice update
        $('#orderForm input[name="cashPrice"]').val(numberWithCommas(overallPrice));
    });
    //Checking if city has agent exist when seller gives order
    $('#orderForm #city').on('click',function(){
        $('#cityAgent').html('');
        var city = document.querySelector('#city');
        if(city.value){
            var cityName = city.selectedOptions[0].innerText;
            $.ajax({
                url:'http://localhost:8000/admin/orders/AgentExistInState/' + cityName,
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
   
    var isoDate;
    // Setup persian datepicker for date inputs
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
        result = jy +'/' + jm + '/' + jd;

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
    $('.justDate').each(function(index,value){
        if(value.innerHTML){
            var dateArray = value.innerHTML.replace(/\-/g,' ').split(' ');
            var jalaliDate = gregorian_to_jalali(parseInt(dateArray[0]),parseInt(dateArray[1]),parseInt(dateArray[2]));
            value.innerHTML = jalaliDate;
        }

    });
    // $(".waves-effect").click(function () {
    //     toastr["info"]("I was launched via jQuery!")
    // });
    // toastr.info('Are you the 6 fingered man?')
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
                url:'http://localhost:8000/admin/orders/ProductList',
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
    // $('#sendToAgentForm').on('click',function(){
    //     // $(this).val() = isoDate;
    //     console.log(isoDate);
    // })
    $('#sendToAgentForm').submit(function(event){
       event.preventDefault();
       $(this).find('input[name="date"]').val(isoDate);
       console.log($(this).find('input[name="date"]').val());
       $(this)[0].submit();
    });
    $('#storeToStoreAgents').submit(function(event){
        event.preventDefault();
        $(this).find('input[name="date"]').val(isoDate);
        $(this)[0].submit();
    });
    $('#tankhahExit').submit(function(event){
        event.preventDefault();
        $(this).find('input[name="date"]').val(isoDate);
        $(this)[0].submit();
    });
    
    //Get State and cities array via ajax for user_create and user_edit 
    var statesCityArray;
    if($('#createUserForm').length || $('#editUserForm').length){
        $.ajax({
            url:'http://localhost:8000/states/AllStatesAndCitiesName',
            type:'Get',
            success:function(response){
                statesCityArray = response;
            }
        });
        //City dependency to states in forms
        $('#state').on('change',function(){
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
    if($('#orderForm').length){
        $.ajax({
            url:'http://localhost:8000/states/AllStatesAndCitiesName',
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
    $('.conditionForm input[name="condition"]:radio').change(function(e) {
        var value = e.target.value.trim()
        var form = $(this).parents('form');
        var waitingDelivery = form.find('.waitingDeliveryField');
        var suspend = form.find('.suspendField');
        var cancelField = form.find('.cancelField');
        waitingDelivery.addClass('d-none');
        suspend.addClass('d-none');
        cancelField.addClass('d-none');
     
    
        switch (value) {
          case '1':
            waitingDelivery.removeClass('d-none');
            break;
          case '2':
            suspend.removeClass('d-none');
            break;
          case '3':
            cancelField.removeClass('d-none');
            break;
          default:
            break;
        }
    });
    $('.conditionForm input[name="cancel"]:radio').change(function(e) {
        var value = e.target.value.trim()
        var form = $(this).parents('form');
        var cancelDescField = form.find('.cancelDescField');
        if(value == '9'){
            cancelDescField.removeClass('d-none');
        }else{
            cancelDescField.addClass('d-none');
        }
    });
    $('.conditionForm input[name="suspend"]:radio').change(function(e) {
        var value = e.target.value.trim()
        var form = $(this).parents('form');
        var dueDateFuild = form.find('.dueDateFuild');
        if(value == '3'){
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
            orderNumbers.push(parseInt(value[1]));
        });
        if(!orderNumbers.length){
            alert('سفارشی انتخاب نشده است');
        }else if(!condition){
            alert('گزینه ای انتخاب نشده است');
        }else{
            form.find('button').html('<strong class="h6"><i class="fas fa-spinner"></i></strong>');
            form.find('button').attr('disabled','disabled');
            var formData = [];
            formData[0] = condition;
            formData[1] = orderNumbers;
            console.log(formData);
            // $.ajax({
            //     url:actionUrl,
            //     type:'get',
            //     data:{
            //         _token:CSRF_TOKEN,
            //         condition:condition,
            //         orderNumbers:orderNumbers
            //     },
            //     success:function(response){
            //         form.find('button').html('<strong class="h6">ذخیره</strong>');
            //         form.find('button').attr('disabled',false);
            //         console.log(response);
            //         console.log('test');
            //         orderTable.rows('.selected').remove().draw( false );
            //         toastr["success"](response,{
            //             "closeButton": true,
            //             "debug": false,
            //             "newestOnTop": false,
            //             "progressBar": true,
            //             "positionClass": "toast-bottom-center",
            //             "preventDuplicates": false,
            //             "showDuration": "300",
            //             "hideDuration": "500",
            //             "timeOut": "3000",
            //             "extendedTimeOut": "1000",
            //             "showEasing": "swing",
            //             "hideEasing": "linear",
            //             "showMethod": "slideIn",
            //             "hideMethod": "SlideOout"
            //             });
                   
            //     }
            // });
        }
        
    });
    $('#toFollowManagerForm button').on('click',function(event){
        event.preventDefault();
        var tableData = orderTable.rows({ selected: true }).data().toArray();
        var orderNumbers = [];
        var form = $(this).parents('form');
        var actionUrl = form.attr('action');
        var CSRF_TOKEN = form.find('input[name="_token"]').val();
        $.each(tableData,function(index,value){
            orderNumbers.push(parseInt(value[1]));
        });
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
                    orderNumbers:orderNumbers
                },
                success:function(response){
                    form.find('button').html('<strong class="h6">ذخیره</strong>');
                    form.find('button').attr('disabled',false);
                    orderTable.rows('.selected').remove().draw( false );
                    toastr["success"](response,{
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                      });
                    console.log(response);
                }
            });
        }
        
    });
    $('#productTable').DataTable( {
        "language": persianDataTable,
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ]
    } );
    pdfMake.fonts = {
        Arial: {
                normal: 'arial.ttf',
                bold: 'arialbd.ttf',
                italics: 'ariali.ttf',
                bolditalics: 'arialbi.ttf'
        }
    };
    //Handling cash and cheque in order_create page
    $('#orderForm input[name="paymentMethod"]').on('change',function(){
        console.log('test');
    });
   
});

