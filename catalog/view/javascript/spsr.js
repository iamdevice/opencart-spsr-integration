function pickpoint_choose(result) {
    document.getElementById('pickpoint_id').value = result['id'];
    document.getElementById('address').innerHTML = result['name'] + '<br />' + result['address'];
    var type_id = $('#address').parent().attr('for');
    $('input[id=\''+type_id+'\']').val(type_id + '_' + result['id']);
}