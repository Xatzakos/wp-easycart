<div class="ec_cart_shipping_method_holder">
  <div class="ec_cart_shipping_method_title"><?php echo $GLOBALS['language']->get_text( 'cart_shipping_method', 'cart_shipping_method_title' )?></div>
  <div id="ec_cart_shipping_methods">
  <?php $this->ec_cart_display_shipping_methods( $GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_standard' ),$GLOBALS['language']->get_text( 'cart_estimate_shipping', 'cart_estimate_shipping_express' ), "RADIO" ); ?>
  </div>
  <?php $this->display_estimate_shipping_loader(); ?>
</div>