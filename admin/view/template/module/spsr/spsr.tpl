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
            <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons">
                <a href="<?php echo $prepare_orders; ?>" class="button"><?php echo $button_prepare_orders; ?></a>
                <a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
                <a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a>
            </div>
        </div>

        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <div id="htabs" class="htabs">
                    <a href="#options"><?php echo $tab_options; ?></a>
                    <a href="#sms"><?php echo $tab_sms; ?></a>
                    <a href="#auth"><?php echo $tab_auth; ?></a>
                    <a href="#setting"><?php echo $tab_setting; ?></a>
                    <a href="#shipper"><?php echo $tab_shipper; ?></a>
                    <a href="#status-rules"><?php echo $tab_status_rules; ?></a>
                </div>

                <div id="options">
                    <table class="form">
                        <tr>
                            <td><?php echo $entry_product_type; ?></td>
                            <td>
                                <select name="spsr_intgr_product_type">
                                    <?php foreach ($spsr_product_types as $product_type) { ?>
                                    <?php if ($spsr_intgr_product_type == $product_type['spsr_product_type_id']) { ?>
                                    <option value="<?php echo $product_type['spsr_product_type_id']; ?>" selected="selected"><?php echo $product_type['name']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $product_type['spsr_product_type_id']; ?>"><?php echo $product_type['name']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_partdelivery; ?></td>
                            <td>
                                <select name="spsr_intgr_partdelivery">
                                    <?php if ($spsr_intgr_partdelivery == 1) { ?>
                                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                    <option value="0"><?php echo $text_no; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_yes; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_returndoc; ?></td>
                            <td>
                                <select name="spsr_intgr_returndoc">
                                    <?php if ($spsr_intgr_returndoc == 1) { ?>
                                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                    <option value="0"><?php echo $text_no; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_yes; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_returndoctype; ?></td>
                            <td>
                                <select name="spsr_intgr_returndoctype">
                                    <?php if ($spsr_intgr_returndoctype == 0) { ?>
                                    <option value="0" selected="selected"><?php echo $vsd_standart; ?></option>
                                    <option value="1"><?php echo $vsd_priority; ?></option>
                                    <option value="2"><?php echo $vsd_checkdoc; ?></option>
                                    <?php } elseif ($spsr_intgr_returndoctype == 1) { ?>
                                    <option value="0"><?php echo $vsd_standart; ?></option>
                                    <option value="1" selected="selected"><?php echo $vsd_priority; ?></option>
                                    <option value="2"><?php echo $vsd_checkdoc; ?></option>
                                    <?php } else { ?>
                                    <option value="0"><?php echo $vsd_standart; ?></option>
                                    <option value="1"><?php echo $vsd_priority; ?></option>
                                    <option value="2" selected="selected"><?php echo $vsd_checkdoc; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_checkcontents; ?></td>
                            <td>
                                <select name="spsr_intgr_checkcontents">
                                    <?php if ($spsr_intgr_checkcontents == 1) { ?>
                                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                    <option value="0"><?php echo $text_no; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_yes; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_verify; ?></td>
                            <td>
                                <select name="spsr_intgr_verify">
                                    <?php if ($spsr_intgr_verify == 1) { ?>
                                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                    <option value="0"><?php echo $text_no; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_yes; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_tryon; ?></td>
                            <td>
                                <select name="spsr_intgr_tryon">
                                    <?php if ($spsr_intgr_tryon == 1) { ?>
                                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                    <option value="0"><?php echo $text_no; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_yes; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_byhand; ?></td>
                            <td>
                                <select name="spsr_intgr_byhand">
                                    <?php if ($spsr_intgr_byhand == 1) { ?>
                                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                    <option value="0"><?php echo $text_no; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_yes; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_paidbyreceiver; ?></td>
                            <td>
                                <select name="spsr_intgr_paidbyreceiver">
                                    <?php if ($spsr_intgr_paidbyreceiver == 1) { ?>
                                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                    <option value="0"><?php echo $text_no; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_yes; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_agreeddelivery; ?></td>
                            <td>
                                <select name="spsr_intgr_agreeddelivery">
                                    <?php if ($spsr_intgr_agreeddelivery == 1) { ?>
                                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                    <option value="0"><?php echo $text_no; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_yes; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_idc; ?></td>
                            <td>
                                <select name="spsr_intgr_idc">
                                    <?php if ($spsr_intgr_idc == 1) { ?>
                                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                    <option value="0"><?php echo $text_no; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_yes; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_eveningdelivery; ?></td>
                            <td>
                                <select name="spsr_intgr_eveningdelivery">
                                    <?php if ($spsr_intgr_eveningdelivery == 1) { ?>
                                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                    <option value="0"><?php echo $text_no; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_yes; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_saturdaydelivery; ?></td>
                            <td>
                                <select name="spsr_intgr_saturdaydelivery">
                                    <?php if ($spsr_intgr_saturdaydelivery == 1) { ?>
                                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                    <option value="0"><?php echo $text_no; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_yes; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_plandeliverydate; ?></td>
                            <td>
                                <select name="spsr_intgr_plandeliverydate">
                                    <?php if ($spsr_intgr_plandeliverydate == 1) { ?>
                                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                    <option value="0"><?php echo $text_no; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_yes; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_russianpost; ?></td>
                            <td>
                                <select name="spsr_intgr_russianpost">
                                    <?php if ($spsr_intgr_russianpost == 1) { ?>
                                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                    <option value="0"><?php echo $text_no; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_yes; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="sms">
                    <table class="form">
                        <tr>
                            <td><?php echo $entry_smstoshipper; ?></td>
                            <td>
                                <select name="spsr_intgr_smstoshipper">
                                    <?php if ($spsr_intgr_smstoshipper == 1) { ?>
                                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                    <option value="0"><?php echo $text_no; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_yes; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_smsnumbershipper; ?></td>
                            <td><input type="text" name="spsr_intgr_smsnumbershipper" value="<?php echo $spsr_intgr_smsnumbershipper; ?>" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_smstoreceiver; ?></td>
                            <td>
                                <select name="spsr_intgr_smstoreceiver">
                                    <?php if ($spsr_intgr_smstoreceiver == 1) { ?>
                                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                    <option value="0"><?php echo $text_no; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_yes; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="auth">
                    <table class="form">
                        <tr>
                            <td><?php echo $entry_spsr_server; ?></td>
                            <td>
                                <select name="spsr_intgr_server">
                                    <?php foreach ($spsr_servers as $index => $srv) { ?>
                                    <?php if ((int)$spsr_intgr_server === $index) { ?>
                                    <option value="<?php echo $index; ?>" selected="selected"><?php echo $srv; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $index; ?>"><?php echo $srv; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_login; ?></td>
                            <td><input type="text" name="spsr_intgr_login" value="<?php echo $spsr_intgr_login; ?>" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_passwd; ?></td>
                            <td><input type="text" name="spsr_intgr_passwd" value="<?php echo $spsr_intgr_passwd; ?>" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_company; ?></td>
                            <td><input type="text" name="spsr_intgr_company" value="<?php echo $spsr_intgr_company; ?>" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_ikn; ?></td>
                            <td><input type="text" name="spsr_intgr_ikn" value="<?php echo $spsr_intgr_ikn; ?>" /></td>
                        </tr>
                    </table>
                </div>

                <div id="setting">
                    <table class="form">
                        <tr>
                            <td><?php echo $entry_paid_status; ?></td>
                            <td>
                                <select name="spsr_intgr_paid_order_status">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $spsr_intgr_paid_order_status) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_upload_status; ?></td>
                            <td>
                                <select name="spsr_intgr_upload_order_status">
                                    <?php foreach ($order_statuses as $order_status) { ?>
                                    <?php if ($order_status['order_status_id'] == $spsr_intgr_upload_order_status) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <div><a href="<?php echo $load_spsr_cities; ?>" class="button" style="margin-bottom: 5px; margin-right: 10px;"><?php echo $button_load_cities;?></a>&nbsp;<?php echo $text_updated; ?> <?php echo $spsr_intgr_cities_upd; ?></div>
                    <div><a href="<?php echo $load_spsr_offices; ?>" class="button" style="margin-bottom: 5px; margin-right: 10px;"><?php echo $button_load_offices; ?></a>&nbsp;<?php echo $text_updated; ?> <?php echo $spsr_intgr_offices_upd; ?><br /><?php echo $text_office_upd_alert; ?></div>
                </div>

                <div id="shipper">
                    <table class="form">
                        <tr>
                            <td><?php echo $entry_postcode; ?></td>
                            <td><input type="text" name="spsr_intgr_shipper_info[postcode]" value="<?php echo $spsr_intgr_shipper_info['postcode']; ?>" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_city; ?></td>
                            <td><input type="text" name="spsr_intgr_shipper_info[city]" value="<?php echo $spsr_intgr_shipper_info['city']; ?>" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_address; ?></td>
                            <td><input type="text" name="spsr_intgr_shipper_info[address]" value="<?php echo $spsr_intgr_shipper_info['address']; ?>" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_contact; ?></td>
                            <td><input type="text" name="spsr_intgr_shipper_info[contact]" value="<?php echo $spsr_intgr_shipper_info['contact']; ?>" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_telephone; ?></td>
                            <td><input type="text" name="spsr_intgr_shipper_info[telephone]" value="<?php echo $spsr_intgr_shipper_info['telephone']; ?>" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_email; ?></td>
                            <td><input type="text" name="spsr_intgr_shipper_info[email]" value="<?php echo $spsr_intgr_shipper_info['email']; ?>" /></td>
                        </tr>
                    </table>
                </div>

                <div id="status-rules">
                    <table class="list" id="spsr-status-rules">
                        <thead>
                        <tr>
                            <td class="left"><?php echo $column_spsr_status; ?></td>
                            <td class="left"><?php echo $column_order_status; ?></td>
                            <td class="left"><?php echo $column_notify; ?></td>
                            <td class="left"><?php echo $column_comment; ?></td>
                            <td class="left"><?php echo $column_action; ?></td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $row = 1; ?>
                        <?php if (!empty($spsr_intgr_order_rules)) { ?>
                        <?php foreach ($spsr_intgr_order_rules as $rule) { ?>
                        <tr rel="<?php echo $row; ?>">
                            <td class="left">
                                <select name="spsr_intgr_order_rules[<?php echo $row; ?>][spsr_status_id]" style="max-width:150px;">
                                    <?php foreach ($spsr_statuses as $spsr_status) { ?>
                                    <?php if ($rule['spsr_status_id'] == $spsr_status['event_id']) { ?>
                                    <option value="<?php echo $spsr_status['event_id']; ?>" selected="selected"><?php echo $spsr_status['name']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $spsr_status['event_id']; ?>"><?php echo $spsr_status['name']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="left">
                                <select name="spsr_intgr_order_rules[<?php echo $row; ?>][order_status_id]">
                                    <?php foreach ($order_statuses as $order_status) { ?>
                                    <?php if ($rule['order_status_id'] == $order_status['order_status_id']) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="left">
                                <select name="spsr_intgr_order_rules[<?php echo $row; ?>][notify]">
                                    <?php if ($rule['notify'] == 1) { ?>
                                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                    <option value="0"><?php echo $text_no; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_yes; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="left">
                                <textarea name="spsr_intgr_order_rules[<?php echo $row; ?>][comment]" cols="70" rows="3"><?php echo $rule['comment']; ?></textarea>
                            </td>
                            <td class="left">
                                <a class="button" onclick="$(this).closest('tr').remove();"><?php echo $button_delete; ?></a>
                            </td>
                        </tr>
                        <?php $row++; ?>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                    <a class="button" onclick="addRule();"><?php echo $button_add_rule; ?></a>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
    function addRule() {
        var row = <?php echo $row; ?>;

        $('table#spsr-status-rules tr[rel]').each(function(){
            var rel = $(this).attr('rel');
            if (rel > row) {
                row = rel;
            }
        });
        row++;

        html = '<tr rel="' + row + '">';
        html += '<td class="left">';
        html += '<select name="spsr_intgr_order_rules['+row+'][spsr_status_id]" style="max-width:150px;">';
    <?php foreach ($spsr_statuses as $spsr_status) { ?>
            html += '<option value="<?php echo $spsr_status["event_id"]; ?>"><?php echo $spsr_status["name"]; ?></option>';
        <?php } ?>
        html += '</select>';
        html += '</td>';
        html += '<td class="left">';
        html += '<select name="spsr_intgr_order_rules['+row+'][order_status_id]">';
    <?php foreach ($order_statuses as $order_status) { ?>
            html += '<option value="<?php echo $order_status["order_status_id"]; ?>"><?php echo $order_status["name"]; ?></option>';
        <?php } ?>
        html += '</td>';
        html += '<td class="left">';
        html += '<select name="spsr_intgr_order_rules['+row+'][notify]">';
        html += '<option value="1"><?php echo $text_yes; ?></option>';
        html += '<option value="0" selected="selected"><?php echo $text_no; ?></option>';
        html += '</select>';
        html += '</td>';
        html += '<td class="left"><textarea name="spsr_intgr_order_rules['+row+'][comment]" cols="70" rows="3"></textarea></td>';
        html += '<td class="left"><a class="button" onclick="$(this).closest(\'tr\').remove();"><?php echo $button_delete; ?></a></td>';
        html += '</tr>';

        $("table#spsr-status-rules tbody:last").append(html);
    }
    //--></script>
<script type="text/javascript"><!--
    $('#htabs a').tabs();
    //--></script>
<?php echo $footer; ?>