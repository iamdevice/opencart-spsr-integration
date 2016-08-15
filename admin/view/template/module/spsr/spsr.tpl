<?php echo $header; ?>
<div id="content">
    <div class="breadcrumbs">
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
            </form>
        </div>
    </div>
</div>