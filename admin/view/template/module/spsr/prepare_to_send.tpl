<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>" ><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_prepare_orders; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_send; ?></a></div>
        </div>
        <div class="content">
            <input type="checkbox" name="toggle_ind" id="toggle_ind" />
            <label for="toggle_ind">Индвидуальные настройки доставки</label>

            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <div id="vtabs" class="vtabs">
                    <?php foreach ($orders as $order) { ?>
                    <a href="#order-<?php echo $order['order_id']; ?>">#<?php echo $order['order_id']; ?></a>
                    <?php } ?>
                </div>

                <div id="orders">
                    <?php foreach ($orders as $order) { ?>
                    <div class="vtabs-content" id="order-<?php echo $order['order_id']; ?>" data-order="<?php echo $order['order_id']; ?>">
                        <div id="htabs" class="htabs">
                            <a href="#order-<?php echo $order['order_id']; ?>-general"><?php echo $tab_order_general; ?></a>
                            <a href="#order-<?php echo $order['order_id']; ?>-shipping"><?php echo $tab_order_shipping; ?></a>
                            <a href="#order-<?php echo $order['order_id']; ?>-products"><?php echo $tab_order_products; ?></a>
                            <a href="#order-<?php echo $order['order_id']; ?>-options" id="href-<?php echo $order['order_id']; ?>-options"><?php echo $tab_order_options; ?></a>
                        </div>

                        <div id="order-<?php echo $order['order_id']; ?>-general">
                            <table class="form">
                                <tr>
                                    <td><?php echo $entry_order_id; ?></td>
                                    <td>
                                        <input type="hidden" name="order[<?php echo $order['order_id']; ?>][order_id]" value="<?php echo $order['order_id']; ?>" />
                                        #<?php echo $order['order_id']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $entry_create_type; ?></td>
                                    <td>
                                        <select name="order[<?php echo $order['order_id']; ?>][action]">
                                            <option value="N" selected="selected"><?php echo $ct_new; ?></option>
                                            <option value="U"><?php echo $ct_update; ?></option>
                                        </select>
                                        <input type="hidden" name="order[<?php echo $order['order_id']; ?>][pickup_type]" value="W" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo $entry_tariff; ?></td>
                                    <td>
                                        <select name="order[<?php echo $order['order_id']; ?>][tariff]">
                                            <option value="ZebOn"><?php echo $t_zebon; ?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo $entry_paid; ?></td>
                                    <td>
                                        <select name="order-paid-<?php echo $order['order_id']; ?>" onchange="paidChange(<?php echo $order['order_id']; ?>,1);">
                                            <?php if ($order['paid']) { ?>
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
                                    <td><?php echo $entry_cod; ?></td>
                                    <td>
                                        <select name="order[<?php echo $order['order_id']; ?>][cod]" onchange="paidChange(<?php echo $order['order_id']; ?>,2);">
                                            <?php if ($order['paid']) { ?>
                                            <option value="1"><?php echo $text_yes; ?></option>
                                            <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                            <?php } else { ?>
                                            <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                            <option value="0"><?php echo $text_no; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo $entry_total; ?></td>
                                    <td>
                                        <input type="hidden" name="order[<?php echo $order['order_id']; ?>][weight]" value="<?php echo $order['weight']; ?>" />
                                        <input type="hidden" name="order[<?php echo $order['order_id']; ?>][order_total]" value="<?php echo $order['total']; ?>" />
                                        <?php echo $order['total']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo $entry_products_cost; ?></td>
                                    <td><input type="text" name="order[<?php echo $order['order_id']; ?>][products_cost]" value="<?php echo $order['products_cost']; ?>" /></td>
                                </tr>
                                <tr>
                                    <td><?php echo $entry_shipping_cost; ?></td>
                                    <td><input type="text" name="order[<?php echo $order['order_id']; ?>][shipping_cost]" value="<?php echo $order['shipping_cost']; ?>" /></td>
                                </tr>
                            </table>
                        </div>

                        <div id="order-<?php echo $order['order_id']; ?>-shipping">
                            <table class="form">
                                <?php if (!empty($order['spsr_office_id'])) { ?>
                                <tr>
                                    <td colspan="2">
                                        <?php echo $text_shipping_to_pvz; ?>
                                        <?php echo $help_shipping_to_pvz; ?>
                                    </td>
                                </tr>
                                <?php } elseif (!empty($order['spsr_postamat_id'])) { ?>
                                <tr>
                                    <td colspan="2">
                                        <?php echo $text_shipping_to_postamat; ?>
                                        <?php echo $help_shipping_to_postamat; ?>
                                        <?php $postamat_address = explode(',',$order['spsr_postamat_address']); ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                <input type="hidden" name="order[<?php echo $order['order_id']; ?>][shipping_code]" value="<?php echo $order['shipping_code']; ?>" />
                                <input type="hidden" name="order[<?php echo $order['order_id']; ?>][spsr_office_id]" value="<?php echo $order['spsr_office_id']; ?>" />
                                <input type="hidden" name="order[<?php echo $order['order_id']; ?>][spsr_postamat_id]" value="<?php echo $order['spsr_postamat_id']; ?>" />
                                <tr>
                                    <td><?php echo $entry_customer; ?></td>
                                    <td><input type="text" name="order[<?php echo $order['order_id']; ?>][shipping_customer]" value="<?php echo $order['shipping_customer']; ?>" size="50" /></td>
                                </tr>
                                <tr>
                                    <td><?php echo $entry_smstoreceiver; ?></td>
                                    <td>
                                        <select name="order[<?php echo $order['order_id']; ?>][smstoreceiver]">
                                            <?php if ($spsr_intgr_smstoreceiver) { ?>
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
                                    <td><?php echo $entry_telephone; ?></td>
                                    <td><input type="text" name="order[<?php echo $order['order_id']; ?>][telephone]" value="<?php echo $order['telephone']; ?>" /></td>
                                </tr>
                                <tr>
                                    <td><?php echo $entry_email; ?></td>
                                    <td><input type="text" name="order[<?php echo $order['order_id']; ?>][email]" value="<?php echo $order['email']; ?>" size="50" /></td>
                                </tr>
                                <tr>
                                    <td><?php echo $entry_postcode; ?></td>
                                    <td>
                                        <?php if ($order['spsr_type_id'] == 3) { ?>
                                        <input type="text" name="order[<?php echo $order['order_id']; ?>][shipping_postcode]" value="<?php echo $postamat_address[0]; ?>" />
                                        <?php } else { ?>
                                        <input type="text" name="order[<?php echo $order['order_id']; ?>][shipping_postcode]" value="<?php echo $order['shipping_postcode']; ?>" />
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo $entry_country; ?></td>
                                    <td>
                                        <input type="text" name="order[<?php echo $order['order_id']; ?>][shipping_country]" value="<?php echo $order['shipping_country']; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo $entry_zone; ?></td>
                                    <td>
                                        <?php if ($order['spsr_type_id'] == 2) { ?>
                                        <input type="text" name="order[<?php echo $order['order_id']; ?>][shipping_zone]" value="<?php echo $order['spsr_office_region']; ?>" />
                                        <?php } elseif ($order['spsr_type_id'] == 3) { ?>
                                        <input type="text" name="order[<?php echo $order['order_id']; ?>][shipping_zone]" value="<?php echo preg_replace('/^\s+|\s+$/','',$postamat_address[1]); ?>" />
                                        <?php } else { ?>
                                        <input type="text" name="order[<?php echo $order['order_id']; ?>][shipping_zone]" value="<?php echo $order['shipping_zone']; ?>" />
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo $entry_city; ?></td>
                                    <td>
                                        <?php if ($order['spsr_type_id'] == 2) { ?>
                                        <input type="text" name="order[<?php echo $order['order_id']; ?>][shipping_city]" value="<?php echo $order['spsr_office_city']; ?>" />
                                        <?php } elseif ($order['spsr_type_id'] == 3) { ?>
                                        <input type="text" name="order[<?php echo $order['order_id']; ?>][shipping_city]" value="<?php echo preg_replace('/^\s+|\s+$/','',$postamat_address[2]); ?>" />
                                        <?php } else { ?>
                                        <input type="text" name="order[<?php echo $order['order_id']; ?>][shipping_city]" value="<?php echo $order['shipping_city']; ?>" />
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo $entry_address; ?></td>
                                    <td>
                                        <?php if ($order['spsr_type_id'] == 2) { ?>
                                        <input type="text" name="order[<?php echo $order['order_id']; ?>][shipping_address]" value="<?php echo $order['spsr_office_address']; ?>" size="50" />
                                        <?php } elseif ($order['spsr_type_id'] == 3) { ?>
                                        <input type="text" name="order[<?php echo $order['order_id']; ?>][shipping_address]" value="<?php echo preg_replace('/^\s+|\s+$/','',$postamat_address[3]) . ',' . $postamat_address[4]; ?>" size="50" />
                                        <?php } else { ?>
                                        <input type="text" name="order[<?php echo $order['order_id']; ?>][shipping_address]" value="<?php echo $order['shipping_address']; ?>" size="50" />
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo $entry_comment; ?></td>
                                    <td>
                                        <textarea name="order[<?php echo $order['order_id']; ?>][comment]" cols="100" rows="7"><?php echo ($order['spsr_type_id'] == 3) ? $order['spsr_postamat_id'] : $order['comment']; ?></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div id="order-<?php echo $order['order_id']; ?>-products">
                            <table class="form">
                                <tr>
                                    <td><?php echo $entry_product_type; ?></td>
                                    <td>
                                        <select name="order[<?php echo $order['order_id']; ?>][products_type]">
                                            <?php foreach ($spsr_product_types as $product_type) { ?>
                                            <?php if ($order['products_type'] == $product_type['spsr_product_type_id']) { ?>
                                            <option value="<?php echo $product_type['spsr_product_type_id']; ?>" selected="selected"><?php echo $product_type['name']; ?></option>
                                            <?php } else { ?>
                                            <option value="<?php echo $product_type['spsr_product_type_id']; ?>"><?php echo $product_type['name']; ?></option>
                                            <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>

                            <table class="list">
                                <thead>
                                <tr>
                                    <td class="left"><?php echo $column_product; ?></td>
                                    <td class="right"><?php echo $column_price; ?></td>
                                    <td class="right"><?php echo $column_quantity; ?></td>
                                    <td class="right"><?php echo $column_total; ?></td>
                                </tr>
                                </thead>
                                <?php foreach ($order['products'] as $product) { ?>
                                <tbody id="product-<?php echo $product['order_product_id']; ?>">
                                <tr>
                                    <td class="left">
                                        <input type="hidden" name="order[<?php echo $order['order_id']; ?>][products][<?php echo $product['order_product_id']; ?>][order_product_id]" value="<?php echo $product['order_product_id']; ?>" />
                                        <input type="hidden" name="order[<?php echo $order['order_id']; ?>][products][<?php echo $product['order_product_id']; ?>][name]" value="<?php echo $product['name']; ?><?php echo $product['option']['to_req']; ?>" />
                                        <?php echo $product['name']; ?>
                                        <?php echo $product['option']['to_html']; ?>
                                    </td>
                                    <td class="right">
                                        <input type="hidden" name="order[<?php echo $order['order_id']; ?>][products][<?php echo $product['order_product_id']; ?>][price]" value="<?php echo $product['price']; ?>" />
                                        <?php echo $product['price']; ?>
                                    </td>
                                    <td class="right">
                                        <input type="hidden" name="order[<?php echo $order['order_id']; ?>][products][<?php echo $product['order_product_id']; ?>][quantity]" value="<?php echo $product['quantity']; ?>" />
                                        <?php echo $product['quantity']; ?>
                                    </td>
                                    <td class="right">
                                        <input type="hidden" name="order[<?php echo $order['order_id']; ?>][products][<?php echo $product['order_product_id']; ?>][total]" value="<?php echo $product['total']; ?>" />
                                        <?php echo $product['total']; ?>
                                    </td>
                                </tr>
                                </tbody>
                                <?php } ?>
                                <tfoot>
                                <tr>
                                    <td colspan="2" class="right"><?php echo $text_total; ?></td>
                                    <td class="right"><?php echo array_sum(array_column($order['products'], 'quantity')); ?></td>
                                    <td class="right"><?php echo array_sum(array_column($order['products'], 'total')); ?></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div id="order-<?php echo $order['order_id']; ?>-options">
                            <table class="form">
                                <tr>
                                    <td><?php echo $entry_partdelivery; ?></td>
                                    <td>
                                        <select name="order[<?php echo $order['order_id']; ?>][partdelivery]">
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
                                        <select name="order[<?php echo $order['order_id']; ?>][returndoc]">
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
                                        <select name="order[<?php echo $order['order_id']; ?>][returndoctype]">
                                            <?php if ($spsr_intgr_returndoctype == 0) { ?>
                                            <option value="0" selected="selected"><?php echo $vsd_standart; ?></option>
                                            <option value="1"><?php echo $vsd_priority; ?></option>
                                            <option value="2"><?php echo $vsd_checkdoc; ?></option>
                                            <?php } elseif ($rspsr_intgr_eturndoctype == 1) { ?>
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
                                        <select name="order[<?php echo $order['order_id']; ?>][checkcontents]">
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
                                        <select name="order[<?php echo $order['order_id']; ?>][verify]">
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
                                        <select name="order[<?php echo $order['order_id']; ?>][tryon]">
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
                                        <select name="order[<?php echo $order['order_id']; ?>][byhand]">
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
                                        <select name="order[<?php echo $order['order_id']; ?>][paidbyreceiver]">
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
                                        <select name="order[<?php echo $order['order_id']; ?>][agreeddelivery]">
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
                                        <select name="order[<?php echo $order['order_id']; ?>][idc]">
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
                                        <select name="order[<?php echo $order['order_id']; ?>][eveningdelivery]">
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
                                        <select name="order[<?php echo $order['order_id']; ?>][saturdaydelivery]">
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
                                        <select name="order[<?php echo $order['order_id']; ?>][plandeliverydate]">
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
                                        <select name="order[<?php echo $order['order_id']; ?>][russianpost]">
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
                    </div>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
    $('#vtabs a').tabs();
    <?php foreach ($orders as $row => $order) { ?>
        $("#order-<?php echo $order['order_id']; ?> a").tabs();
        //$("#vtabs-order-<?php echo $order['order_id']; ?>-package a").tabs();
    <?php } ?>

    $('#toggle_ind').change(function() {
        var hide = $('#toggle_ind').prop('checked');
        if (hide == false) {
            $('a[id ^= href][id $= options]').hide();
        } else {
            $('a[id ^= href][id $= options]').show();
        }
    });

    $(document).ready(function() {
        var hide = $('#toggle_ind').prop('checked');
        if (hide == false) {
            $('a[id ^= href][id $= options]').hide();
        } else {
            $('a[id ^= href][id $= options]').show();
        }
    });
    //--></script>
<script type="text/javascript"><!--
    function paidChange(id,sel) {
        var paid = $('select[name=\'order-paid-'+id+'\']').val();
        var cod = $('select[name=\'order['+id+'][cod]\']').val();

        if (sel == 1) {
            if (paid == 1) {
                $('select[name=\'order[' + id + '][cod]\']').val(0);
            } else {
                $('select[name=\'order[' + id + '][cod]\']').val(1);
            }
        } else {
            if (cod == 1) {
                $('select[name=\'order-paid-'+id+'\']').val(0);
            } else {
                $('select[name=\'order-paid-'+id+'\']').val(1);
            }
        }
    }

    function countryChange(order_id) {
        var country_id = $('select[name=\'order['+id+'][shipping_country_id]\']').val();
        var countries = '<?php echo json_encode($countries); ?>';
        console.log(countries);
    }
    //--></script>
<?php echo $footer; ?>