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
        </div>
        <div class="content">
            <input type="checkbox" name="toggle_ind" id="toggle_ind" />
            <label for="toggle_ind">Индвидуальные настройки доставки</label>

            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <div id="vtabs" class="vtabs">
                    <?php foreach ($orders as $order) { ?>
                    <a href="#order-<?php echo $order['order_id']; ?>">#<?php echo $order['order_id']; ?></a>
                    <?php } ?>
                </div>

                <div id="orders">
                    <?php foreach ($orders as $order) { ?>
                    <div class="vtabs-content" id="order-<?php echo $order['order_id']; ?>" data-order="<?php echo $order['order_id']; ?>">
                        <div id="htabs" class="htabs">
                            <a href="#order-<?php echo $order['order_id']; ?>-shipping"><?php echo $tab_order_shipping; ?></a>
                            <a href="#order-<?php echo $order['order_id']; ?>-products"><?php echo $tab_order_products; ?></a>
                            <a href="#order-<?php echo $order['order_id']; ?>-options"><?php echo $tab_order_options; ?></a>
                        </div>

                        <div id="order-<?php echo $order['order_id']; ?>-options">

                        </div>

                        <div id="order-<?php echo $order['order_id']; ?>-shipping">

                        </div>

                        <div id="order-<?php echo $order['order_id']; ?>-products">

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
        var hide = $('#toggle_ind').attr('checked');
        if (hide == 'checked') {
            $('div[id $= options]').each(function(i) {
                $(this).style.display = 'none';
            });
        }
    });
    //--></script>
<?php echo $footer; ?>