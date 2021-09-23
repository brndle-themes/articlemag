<?php
/**
 * Search
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<div class="cs-search-form">
<form role="search" method="get" id="bbp-search-form" action="<?php bbp_search_url(); ?>">
	<input type="hidden" name="action" value="bbp-search-request" />
	<input placeholder="<?php esc_attr_e( 'Search', 'articlemag' ); ?>" tabindex="<?php bbp_tab_index(); ?>" type="text" value="<?php echo esc_attr( bbp_get_search_terms() ); ?>" name="bbp_search" id="bbp_search" class="cs-search"/>
	<button tabindex="<?php bbp_tab_index(); ?>" type="submit" id="bbp_search_submit" class="fa fa-search"></button>
</form>
</div>
