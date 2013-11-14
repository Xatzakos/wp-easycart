
<div class="ec_account_order_details_item_display" id="ec_account_order_details_item_display_<?php $order_item->display_order_item_id(); ?>">
  <?php $order_item->display_download_error( ); ?>
  <div class="ec_account_order_details_item_display_column1">
    <?php $order_item->display_image( "small" ); ?>
  </div>
  <div class="ec_account_order_details_item_display_column2">
    <div class="ec_account_order_details_item_display_title">
      <?php $order_item->display_title(); ?>
    </div>
    <?php if( $order_item->has_option1( ) ){ ?>
    <div class="ec_account_order_details_item_display_option">
      <?php $order_item->display_option1_label( ); ?>
      :
      <?php $order_item->display_option1( ); ?>
    </div>
    <?php }?>
    <?php if( $order_item->has_option2( ) ){ ?>
    <div class="ec_account_order_details_item_display_option">
      <?php $order_item->display_option2_label( ); ?>
      :
      <?php $order_item->display_option2( ); ?>
    </div>
    <?php }?>
    <?php if( $order_item->has_option3( ) ){ ?>
    <div class="ec_account_order_details_item_display_option">
      <?php $order_item->display_option3_label( ); ?>
      :
      <?php $order_item->display_option3( ); ?>
    </div>
    <?php }?>
    <?php if( $order_item->has_option4( ) ){ ?>
    <div class="ec_account_order_details_item_display_option">
      <?php $order_item->display_option4_label( ); ?>
      :
      <?php $order_item->display_option4( ); ?>
    </div>
    <?php }?>
    <?php if( $order_item->has_option5( ) ){ ?>
    <div class="ec_account_order_details_item_display_option">
      <?php $order_item->display_option5_label( ); ?>
      :
      <?php $order_item->display_option5( ); ?>
    </div>
    <?php }?>
    <?php if( $order_item->has_gift_card_message( ) ){ ?>
    <div class="ec_account_order_details_item_display_option">
      <?php $order_item->display_gift_card_message( $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_gift_message' ) ); ?>
    </div>
    <?php }?>
    <?php if( $order_item->has_gift_card_from_name( ) ){ ?>
    <div class="ec_account_order_details_item_display_option">
      <?php $order_item->display_gift_card_from_name( $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_gift_from' ) ); ?>
    </div>
    <?php }?>
    <?php if( $order_item->has_gift_card_to_name( ) ){ ?>
    <div class="ec_account_order_details_item_display_option">
      <?php $order_item->display_gift_card_to_name( $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_gift_to' ) ); ?>
    </div>
    <?php }?>
    <?php if( $order_item->has_print_gift_card_link( ) && $this->is_approved ){ ?>
    <div class="ec_account_order_details_item_display_option">
      <?php $order_item->display_print_online_link( $GLOBALS['language']->get_text( "account_order_details", "account_orders_details_print_online" ) ); ?>
    </div>
    <?php }?>
    <?php if( $order_item->has_download_link( ) && $this->is_approved ){ ?>
    <div class="ec_account_order_details_item_display_option">
      <?php $order_item->display_download_link( $GLOBALS['language']->get_text( 'account_order_details', 'account_orders_details_download' ) ); ?>
    </div>
    <?php }?>
  </div>
  <div class="ec_account_order_details_item_display_column3">
    <div class="ec_account_order_details_item_display_unit_price">
      <?php $order_item->display_unit_price(); ?>
    </div>
  </div>
  <div class="ec_account_order_details_item_display_column4">
    <div class="ec_account_order_details_item_display_quantity">
      <?php $order_item->display_quantity(); ?>
    </div>
  </div>
  <div class="ec_account_order_details_item_display_column5">
    <div class="ec_account_order_details_item_display_total_price">
      <?php $order_item->display_item_total(); ?>
    </div>
  </div>
</div>