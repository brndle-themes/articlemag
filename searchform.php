<?php
/**
 *
 * Search form.
 * @since 1.0.0
 * @version 1.0.0
 *
 */
?>
<div class="cs-search-form">
  <button id="nav-search" class="cs-link cs-sticky-item cs-open-modal"><span class="fa fa-times-circle"></span></button>	
  <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
    <input type="text" placeholder="<?php _e( 'Type to search', 'articlemag' ); ?>" name="s" class="cs-search" />
    <button type="submit" class="fa fa-search"></button>
    <?php do_action( 'cs_search_hidden_fields' ); ?>
  </form>
</div>