<div id="header-logo">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div id="header-logo-wrap">
          <?php echo cs_site_logo(); ?><!-- /site-logo -->
          <?php if ( is_active_sidebar('cs-logo-right') ) { ?><div id="site-logo-right"><div id="site-logo-right-content"><?php dynamic_sidebar( 'cs-logo-right' )?></div></div><!-- /site-logo-right --><?php } ?>
          <?php echo cs_mobile_icon(); ?><!-- /mobile-icon -->
        </div>
      </div>
    </div>
  </div>
</div><!-- /header-logo -->

<header id="masthead" role="banner">
      <div class="container">
        <div class="cs-inner">
          <?php echo cs_site_menu(); ?><!-- /site-nav -->
        </div>
      </div>
  <div id="site-header-shadow"></div>
</header><!-- /header -->