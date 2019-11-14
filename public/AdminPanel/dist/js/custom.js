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
});

