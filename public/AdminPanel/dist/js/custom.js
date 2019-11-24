$(document).ready(function(){
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
    $('#productTable,#orderTable').DataTable();
    //User sections tables
    $('#agentTable,#callcenterTable,#sellerTable,#usersTable').DataTable();
    //Dashboard tables
    $('#sellerInfoTable').DataTable();
    //Store room tables
    $('#agentInTable,#agentOutTable,#agentReceiveTable,#agentIndexTable,#agentExchangeStorageTable,#fundInStorageTable,#mainReceiveTable,#fundOutStorageTable,#returnFromAgentTable,#sendToAgentTable,#mainInStorageTable,#mainOutStorageTable,#returnFromFundTable,#storageChangeTable,#storeRoomTable').DataTable();
    //Warehouse tables
    $('#warehouseInOutTable,#warehouseIndexTable').DataTable();
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
        //Deleting product type via ajax in product type modal in products page
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
            url:'http://127.0.0.1:8000/types/'+ product_id,
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
        <th>${newSpecial.price}</th>
        <th>${newSpecial.place}</th>
        <td>
          <form  action="http://127.0.0.1:8000/special-tariffs/${newSpecial.id}" method="post" >
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
    };
    //Getting special tariff table data
    var getSpecialTariff = function(user_id,CSRF_TOKEN,product_name){
        $.ajax({
            url:'http://127.0.0.1:8000/special-tariffs-index/'+ user_id,
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
        $(this).find('button[type="submit"]').html('<i class="fas fa-spinner"></i>');
        var actionUrl = $(this).attr('action');
        var CSRF_TOKEN = $(this).find('input[name="_token"]').val();
        var user_id = $(this).find('input[name="user_id"]').val();
        var product_id = $(this).find('select[name="product_id"]').val();
        var product_name = $(this).find('select[name="product_id"] option:selected').html();
        console.log(product_name);
        var tariff_place = $(this).find('select[name="tariff_place"]').val();
        var tariff_price = $(this).find('input[name="tariff_price"]').val();
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
              <select class="productSelect form-control bg-sec" name="product_name">
                <option value="">محصول را انتخاب کنید</option>
              </select>
            </div>
            <div class="col-sm-1">
              <label for="count">تعداد
                <span class="text-danger">*</span>
              </label>
              <input class="countField form-control bg-sec" type="number" name="count" value="" >
            </div>
            <div class="col-sm-2">
              <label for="price">قیمت-تومان
                <span class="text-danger">*</span>
              </label>
              <input class="priceField form-control bg-sec" type="text" placeholder="" name="price" value=""  disabled>
            </div>
            <div class="col-sm-2">
              <label for="off">تخفیف
                <span class="text-danger">*</span>
              </label>
              <input class="offField form-control bg-sec" type="number" placeholder="" name="off" value="" >
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
            url:'http://127.0.0.1:8000/admin/orders/ProductList',
            type:'GET',
            success:function(response){
                productList = response;
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
                            <option value="${value.name}">${value.name}</option>
                        `;
                    });
                }
            });
            productPriceInput.value = productPrice;

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
        var orderArray = [];
        $('.orderList .row').each(function(index,value){
            var orderObject = {};
            orderObject.name = value.querySelector('.productSelect').value;
            orderObject.count = value.querySelector('input[name="count"]').value;
            orderObject.off = value.querySelector('input[name="off"]').value;
            orderObject.type = value.querySelector('.typeSelect').value;
            orderArray.push(orderObject);
        });
        var actionUrl = form.attr('action');
        var CSRF_TOKEN = form.find('input[name="_token"]').val();
        var mobile = form.find('input[name="mobile"]').val();
        var telephone = form.find('input[name="telephone"]').val();
        var state = form.find('input[name="state"]').val();
        var city = form.find('input[name="city"]').val();
        var fullName = form.find('input[name="fullName"]').val();
        var postalCode = form.find('input[name="postalCode"]').val();
        var HBD_Date = form.find('input[name="HBD_Date"]').val();
        var address = form.find('textarea[name="address"]').val();
        var paymentMethod = form.find('input[name="paymentMethod"]').val();
        var sendCost = form.find('input[name="sendCost"]').val();
        var cashAmount = form.find('input[name="cashAmount"]').val();
        var prePrice = form.find('input[name="prePrice"]').val();
        var checkPrice = form.find('input[name="checkPrice"]').val();
        var status = form.find('input[name="status"]').val();
        var description = form.find('textarea[name="description"]').val();
        var formData = {
            CSRF_TOKEN:CSRF_TOKEN,
            mobile:mobile,
            telephone:telephone,
            state:state,
            city:city,
            fullName:fullName,
            postalCode:postalCode,
            HBD_Date:HBD_Date,
            address:address,
            paymentMethod:paymentMethod,
            sendCost:sendCost,
            cashAmount:cashAmount,
            prePrice:prePrice,
            checkPrice:checkPrice,
            state:status,
            description:description,
            orderArray:orderArray
        }
        console.log(formData);
        $.ajax({
            url:actionUrl,
            type:'POST',
            data:formData,
            success:function(response){
                console.log(response);
            }
        });

    });
    // Calculating order overall price
    $('#orderForm').on('change click',function(){
        var overallPrice = null;
        $('.orderList .row').each(function(index,value){
            var rowPrice = null;
            var count = value.querySelector('input[name="count"]').value;
            var off = value.querySelector('input[name="off"]').value;
            var price = value.querySelector('input[name="price"]').value;
            rowPrice = (count*price) - off;
            overallPrice += rowPrice;
        });
        $('#overallPrice').html(overallPrice);
    });
    //Checking if city has agent exist when seller gives order
    $('#orderForm #city').on('click',function(event){
        event.preventDefault();
        $('#cityAgent').html('');
        var cityName = document.querySelector('#city').selectedOptions[0].innerText;
        $.ajax({
            url:'http://127.0.0.1:8000/orders/AgentExistInState/' + cityName,
            type:'Get',
            success:function(response){
                if(response.state == 2){
                    $('#cityAgent').html('<span class="text-success">'+ response.message +'</span>');
                }else if(response.state == 1){
                    $('#cityAgent').html('<span class="text-secondary">'+ response.message +'</span>');
                }else{
                    $('#cityAgent').html('<span class="text-danger">'+ response.message +'</span>');
                }
            }
        });
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
    $('input.number').keyup(function(event) {

        // skip for arrow keys
        if(event.which >= 37 && event.which <= 40) return;
        // format number
        $(this).val(function(index, value) {
            return value
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    });
    // Setup persian datepicker for date inputs
    $(".persianDatePicker").pDatepicker();

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
        var hours = addZero(h);
        var minutes = addZero(m);
        var seconds = addZero(s);
        return jy +'/' + jm + '/' + jd + ' ' + hours + ":" + minutes + ":" + seconds;
    }
    $('.timestamp').each(function(index,value){
        var jalaliTime = convertTimeStampToJalali(value.innerHTML)
        value.innerHTML = (jalaliTime);
    });
});
