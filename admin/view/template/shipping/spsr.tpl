<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>

    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>

    <div class="box">
        <div class="heading">
            <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons">
                <a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
                <a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a>
            </div>
        </div>

        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <div id="htabs" class="htabs">
                    <a href="#tab-general"><?php echo $tab_general; ?></a>
                    <a href="#tab-discounts"><?php echo $tab_discounts; ?></a>
                    <a href="#tab-tariff"><?php echo $tab_tariff; ?></a>
                </div>

                <div id="tab-general">
                    <table class="form">
                        <tbody>
                        <tr>
                            <td><?php echo $entry_status; ?></td>
                            <td>
                                <select name="spsr_status">
                                    <?php if ($spsr_status) { ?>
                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    <option value="0"><?php echo $text_disabled; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_enabled; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_sort_order; ?></td>
                            <td><input name="spsr_sort_order" value="<?php echo $spsr_sort_order; ?>" size="2" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_city; ?></td>
                            <td>
                                <input type="hidden" name="spsr_shipping_city_id" value="<?php echo $spsr_shipping_city_id; ?>" />
                                <input type="hidden" name="spsr_shipping_city_owner_id" value="<?php echo $spsr_shipping_city_owner_id; ?>" />
                                <input type="text" name="spsr_shipping_city" value="<?php echo $spsr_shipping_city; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_shipping_types; ?></td>
                            <td>
                                <input type="checkbox" name="spsr_shipping_courier" id="courier" <?php if ($spsr_shipping_courier == "on") { echo "checked"; } ?>/>
                                <label for="courier"><?php echo $checkbox_courier; ?></label>
                                <br />
                                <input type="checkbox" name="spsr_shipping_pvz" id="pvz" <?php if ($spsr_shipping_pvz == "on") { echo "checked"; } ?>/>
                                <label for="pvz"><?php echo $checkbox_pvz; ?></label>
                                <br />
                                <input type="checkbox" name="spsr_shipping_postomat" id="postomat" <?php if ($spsr_shipping_postomat == "on") { echo "checked"; } ?>/>
                                <label for="postomat"><?php echo $checkbox_postomat; ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_debug; ?></td>
                            <td>
                                <select name="spsr_shipping_debug">
                                    <?php if ($spsr_shipping_debug) { ?>
                                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                    <option value="0"><?php echo $text_no; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_yes; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                    </table>
                </div>

                <div id="tab-discounts">
                    <table class="list" id="table-discounts">
                        <thead>
                        <tr>
                            <td class="left"><?php echo $column_sum; ?></td>
                            <td class="left"><?php echo $column_tariff; ?></td>
                            <td class="left"><?php echo $column_geo_zone; ?></td>
                            <td class="left"><?php echo $column_value; ?></td>
                            <td class="left"><?php echo $column_sort_order; ?></td>
                            <td class="left"></td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $row = 1; ?>
                        <?php foreach ($spsr_shipping_discount as $discount) { ?>
                        <tr rel="<?php echo $row; ?>">
                            <td class="left">
                                <input type="text" name="spsr_shipping_discount[<?php echo $row; ?>][sum]" value="<?php echo $discount['sum']; ?>" size="5" />
                            </td>
                            <td class="left">
                                <select name="spsr_shipping_discount[<?php echo $row; ?>][tariff]">
                                    <?php foreach ($tariffs as $key => $tariff) { ?>
                                    <?php if ($discount['tariff'] == $key) { ?>
                                    <option value="<?php echo $key; ?>" selected="selected"><?php echo $tariff; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $key; ?>"><?php echo $tariff; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="left">
                                <select name="spsr_shipping_discount[<?php echo $row; ?>][geo_zone]">
                                    <option value="0"><?php echo $text_all_zones; ?></option>
                                    <?php foreach ($geo_zones as $geo_zone) { ?>
                                    <?php if ($geo_zone['geo_zone_id'] == $discount['geo_zone']) { ?>
                                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="left">
                                <select name="spsr_shipping_discount[<?php echo $row; ?>][prefix]">
                                    <?php foreach (['-','+'] as $prefix) { ?>
                                    <?php if ($discount['prefix'] == $prefix) { ?>
                                    <option value="<?php echo $prefix; ?>" selected="selected"><?php echo $prefix; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $prefix; ?>"><?php echo $prefix; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                                <input type="text" name="spsr_shipping_discount[<?php echo $row; ?>][discount]" value="<?php echo $discount['discount']; ?>" size="5" />
                            </td>
                            <td class="left">
                                <input type="text" name="spsr_shipping_discount[<?php echo $row; ?>][sort_order]" value="<?php echo $discount['sort_order']; ?>" size="2" />
                            </td>
                            <td class="left">
                                <a onclick="$('tr[rel=<?php echo $row; ?>]').remove();" class="button"><?php echo $button_delete; ?></a>
                            </td>
                        </tr>
                        <?php $row++; ?>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div><a class="button" onclick="addDiscount();"><?php echo $button_add_discount; ?></a></div>
                </div>
            </form>

            <div id="tab-tariff">
                <form action="<?php echo $upload_action; ?>" method="post" enctype="multipart/form-data" id="tariff-form">
                    <table class="form">
                        <tr>
                            <td><?php echo $entry_select_tariff; ?></td>
                            <td>
                                <select name="tariff">
                                    <option value="zebon"><?php echo $t_zebon; ?></option>
                                    <option value="gepon"><?php echo $t_gepon; ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_select_tariff_type; ?></td>
                            <td>
                                <select name="tariff-type">
                                    <option value="1"><?php echo $checkbox_courier; ?></option>
                                    <option value="2"><?php echo $checkbox_pvz; ?></option>
                                    <option value="3"><?php echo $checkbox_postomat; ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_select_upload_file; ?></td>
                            <td><input type="file" name="tariff-file" accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" /></td>
                        </tr>
                        <tr>
                            <td colspan="2"><a onclick="$('#tariff-form').submit();" class="button"><?php echo $button_upload; ?></a></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
    $('input[name=\'spsr_shipping_city\']').autocomplete({
        delay: 500,
        minLength: 3,
        source: function(request, response) {
            $.ajax({
                url: 'index.php?route=shipping/spsr/getspsrcitiesautocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
                dataType: 'json',
                success: function(json) {
                    response($.map(json, function(item) {
                        return {
                            label: item['city_name'],
                            city_name: item['city_name'],
                            city_id: item['city_id'],
                            city_owner_id: item['city_owner_id']
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
            $('input[name=\'spsr_shipping_city\']').attr('value', ui.item['city_name']);
            $('input[name=\'spsr_shipping_city_id\']').attr('value', ui.item['city_id']);
            $('input[name=\'spsr_shipping_city_owner_id\']').attr('value', ui.item['city_owner_id']);
            return false;
        },
        focus: function(event, ui) {
            return false;
        }
    });

    $('#htabs a').tabs();
//--></script>
<script type="text/javascript"><!--
    function addDiscount() {
        var row = '<?php echo $row; ?>';
        html = '<tr rel="'+row+'">';
        html += '<td class="left">';
        html += '<input type="text" name="spsr_shipping_discount['+row+'][sum]" size="5" />';
        html += '</td>';
        html += '<td class="left">';
        html += '<select name="spsr_shipping_discount['+row+'][tariff]">';
        html += '<option value="zebon"><?php echo $t_zebon; ?></option>';
        html += '<option value="gepon"><?php echo $t_gepon; ?></option>';
        html += '</select>';
        html += '</td>';
        html += '<td class="left">';
        html += '<select name="spsr_shipping_discount['+row+'][geo_zone]">';
        html += '<option value="0"><?php echo $text_all_zones; ?></option>';
        <?php foreach ($geo_zones as $geo_zone) { ?>
            html += '<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>';
        <?php } ?>
        html += '</select>';
        html += '</td>';
        html += '<td class="left">';
        html += '<select name="spsr_shipping_discount['+row+'][prefix]">';
        html += '<option value="-">-</option>';
        html += '<option value="+">+</option>';
        html += '</select>';
        html += '<input type="text" name="spsr_shipping_discount['+row+'][discount]" size="5" />';
        html += '</td>';
        html += '<td class="left">';
        html += '<input type="text" name="spsr_shipping_discount['+row+'][sort_order]" size="2" />';
        html += '</td>';
        html += '<td class="left">';
        html += '<a class="button"><?php echo $button_delete; ?></a>'
        html += '</td>';
        html += '</tr>';
        <?php $row++; ?>

        $('table#table-discounts tbody').append(html);
    }
//--></script>
<?php echo $footer; ?>