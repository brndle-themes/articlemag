<header id="masthead" role="banner">
  <div class="container">
    <div class="cs-inner">

      <div class="cs-fancy-row">

        <div class="cs-fancy-left">
          <?php echo cs_site_menu(); ?><!-- /site-nav -->
        </div>
        <div class="cs-fancy-logo">
          <?php echo cs_site_logo(); ?><!-- /site-logo -->
        </div>
        <div class="cs-fancy-right">
          <nav id="site-nav" role="navigation">
            <?php wp_nav_menu( array( 'theme_location'  => 'right' ) ); ?>
          </nav>
        </div>

        <div class="clear"></div>
      </div>

      <?php echo cs_mobile_icon(); ?><!-- /mobile-icon -->
    </div>
  </div>
  <div id="site-header-shadow"></div>
</header><!-- /header -->