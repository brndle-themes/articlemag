<?php
$homepage_image       = cs_multilang_value( cs_get_option( 'homepage_cover' ) );
$homepage_title       = cs_multilang_value( cs_get_option( 'homepage_title' ) );
$homepage_subtitle    = cs_multilang_value( cs_get_option( 'homepage_default_subtitle' ) );
$homepage_action      = cs_multilang_value( cs_get_option( 'homepage_action_button' ) );
$homepage_action_link = cs_get_option( 'homepage_action_button_link' );

if ( is_home() ) {
?>
<section class="header-hero">
    <div class="header-hero-img" style="background:url( '<?php echo $homepage_image; ?>' );"></div>
    <div class="header-hero-content">
        <h1 class="hero-title"><?php echo esc_html( $homepage_title ); ?></h1>
        <p class="hero-description"><?php echo esc_html( $homepage_subtitle ); ?></p>
        <a href="<?php echo esc_url( $homepage_action_link ); ?>" class="hero-button"><?php echo esc_html( $homepage_action ); ?></a>
    </div>
</section>
<?php } 