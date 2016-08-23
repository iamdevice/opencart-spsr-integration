function pickpoint_choose(result) {
    var postamat_id = result['id'];
    var postamat_addr = result['name'] + '<br />' + result['address'];
    var type_id = $('#address').parent().attr('for');
    var input = $('input[name=\'shipping_method\'][value^=\'spsr.'+type_id+'\']');

    $('#pickpoint_id').val(postamat_id);
    $('#pickpoint_address').val(result['address']);
    $('#pickpoint_name').val(result['name']);
    $('#address').html(postamat_addr);
}