<?php

/**
 *
 * CSFramework Sidebars API
 *
 * @since 1.0.0
 * @version 1.0.1
 */
class CSFramework_Sidebars_API {

    public function __construct() {
        $this->register_default_sidebars();
        if (class_exists('buddypress') && (!articlemag_is_active_plugin('youzer/youzer.php'))) {
            $this->register_buddypress_sidebars();
        }
        $this->register_footer_sidebars();
        $this->register_custom_sidebars();
    }

    /**
     *
     * Register Default Sidebars
     *
     * @since 1.0.0
     * @version 1.0.0
     */
    public function register_default_sidebars() {

        $defaults = array(
            'sidebar-1' => 'Primary Sidebar',
            'sidebar-2' => 'Secondary Sidebar',
        );

        foreach ($defaults as $key => $name) {
            register_sidebar(
                    array(
                        'id' => $key,
                        'name' => $name,
                        'description' => 'Drag widgets for all of pages sidebar',
                        'before_widget' => '<div class="articlemag_widget %2$s">',
                        'after_widget' => '<div class="clear"></div></div>',
                        'before_title' => '<div class="widget-title"><h4>',
                        'after_title' => '</h4></div>',
                    )
            );
        }
    }

    /**
     *
     * Register BuddyPress Sidebars
     *
     * @since 1.5.0
     * @version 1.5.0
     */
    public function register_buddypress_sidebars() {

        register_sidebar(
                array(
                    'id' => 'activity_directory',
                    'name' => 'Activity &rarr; Directory',
                    'description' => 'Drag widgets for activity directory sidebar',
                    'before_widget' => '<div class="articlemag_widget %2$s">',
                    'after_widget' => '<div class="clear"></div></div>',
                    'before_title' => '<div class="widget-title"><h4>',
                    'after_title' => '</h4></div>',
                )
        );

        register_sidebar(
                array(
                    'id' => 'members_directory',
                    'name' => 'Members &rarr; Directory',
                    'description' => 'Drag widgets for members directory sidebar',
                    'before_widget' => '<div class="articlemag_widget %2$s">',
                    'after_widget' => '<div class="clear"></div></div>',
                    'before_title' => '<div class="widget-title"><h4>',
                    'after_title' => '</h4></div>',
                )
        );

        register_sidebar(
                array(
                    'id' => 'groups_directory',
                    'name' => 'Groups &rarr; Directory',
                    'description' => 'Drag widgets for groups directory sidebar',
                    'before_widget' => '<div class="articlemag_widget %2$s">',
                    'after_widget' => '<div class="clear"></div></div>',
                    'before_title' => '<div class="widget-title"><h4>',
                    'after_title' => '</h4></div>',
                )
        );
        
        register_sidebar(
                array(
                    'id' => 'member_single',
                    'name' => 'Members &rarr; Single Member',
                    'description' => 'Drag widgets for member single sidebar',
                    'before_widget' => '<div class="articlemag_widget %2$s">',
                    'after_widget' => '<div class="clear"></div></div>',
                    'before_title' => '<div class="widget-title"><h4>',
                    'after_title' => '</h4></div>',
                )
        );
        
        register_sidebar(
                array(
                    'id' => 'groups_single',
                    'name' => 'Groups &rarr; Single Group',
                    'description' => 'Drag widgets for groups single sidebar',
                    'before_widget' => '<div class="articlemag_widget %2$s">',
                    'after_widget' => '<div class="clear"></div></div>',
                    'before_title' => '<div class="widget-title"><h4>',
                    'after_title' => '</h4></div>',
                )
        );
    }

    /**
     *
     * Register Custom Sidebars
     *
     * @since 1.0.0
     * @version 1.0.0
     */
    public function register_custom_sidebars() {

        $get_custom_sidebars = cs_get_option('sidebars');

        if ($get_custom_sidebars) {

            foreach ($get_custom_sidebars as $key => $sidebar) {

                $sidebar_name = $sidebar['sidebar_name'];
                register_sidebar(
                        array(
                            'id' => sanitize_title($sidebar_name),
                            'name' => $sidebar_name,
                            'description' => 'Drag widgets for all of pages sidebar',
                            'before_widget' => '<div class="articlemag_widget %2$s">',
                            'after_widget' => '<div class="clear"></div></div>',
                            'before_title' => '<div class="widget-title"><h4>',
                            'after_title' => '</h4></div>',
                        )
                );
            }
        }
    }

    /**
     *
     * Register Footer Sidebars
     *
     * @since 1.0.0
     * @version 1.0.1
     */
    public function register_footer_sidebars() {

        if (cs_get_option('footer_block_before')) {
            register_sidebar(
                    array(
                        'id' => 'footer-block-before',
                        'name' => 'Footer Block Before',
                        'description' => 'Drag widgets for all of pages sidebar',
                        'before_widget' => '<div class="articlemag_widget %2$s">',
                        'after_widget' => '<div class="clear"></div></div>',
                        'before_title' => '<div class="widget-title"><h4>',
                        'after_title' => '</h4></div>',
                    )
            );
        }

        if (cs_get_option('footer_before')) {
            register_sidebar(
                    array(
                        'id' => 'footer-before',
                        'name' => 'Footer Widgets Before',
                        'description' => 'Drag widgets for all of pages sidebar',
                        'before_widget' => '<div class="articlemag_widget %2$s">',
                        'after_widget' => '<div class="clear"></div></div>',
                        'before_title' => '<div class="widget-title"><h4>',
                        'after_title' => '</h4></div>',
                    )
            );
        }

        $sidebars = cs_get_option('footer_widgets');

        if ($sidebars) {

            switch ($sidebars) {
                case 5:
                    $length = 6;
                    break;

                case 6:
                case 7:
                case 8:
                    $length = 3;
                    break;

                case 9:
                case 10:
                    $length = 4;
                    break;

                default:
                    $length = $sidebars;
                    break;
            }

            for ($i = 0; $i < $length; $i++) {

                $num = ( $i + 1 );

                register_sidebar(
                        array(
                            'id' => 'footer-' . $num,
                            'name' => 'Footer Widget ' . $num,
                            'description' => 'Appears in the footer section of the site',
                            'before_widget' => '<div class="articlemag_widget %2$s">',
                            'after_widget' => '<div class="clear"></div></div>',
                            'before_title' => '<div class="widget-title"><h4>',
                            'after_title' => '</h4></div>',
                        )
                );
            }
        }

        if (cs_get_option('footer_after')) {
            register_sidebar(
                    array(
                        'id' => 'footer-after',
                        'name' => 'Footer Widgets After',
                        'description' => 'Drag widgets for all of pages sidebar',
                        'before_widget' => '<div class="articlemag_widget %2$s">',
                        'after_widget' => '<div class="clear"></div></div>',
                        'before_title' => '<div class="widget-title"><h4>',
                        'after_title' => '</h4></div>',
                    )
            );
        }

        if (cs_get_option('footer_block_after')) {
            register_sidebar(
                    array(
                        'id' => 'footer-block-after',
                        'name' => 'Footer Block After',
                        'description' => 'Drag widgets for all of pages sidebar',
                        'before_widget' => '<div class="articlemag_widget %2$s">',
                        'after_widget' => '<div class="clear"></div></div>',
                        'before_title' => '<div class="widget-title"><h4>',
                        'after_title' => '</h4></div>',
                    )
            );
        }

        $header_style = cs_get_option('header_style');
        if ($header_style == 'left') {
            register_sidebar(
                    array(
                        'id' => 'cs-logo-right',
                        'name' => 'Logo Right Area',
                        'description' => 'Drag widgets for logo right content',
                        'before_widget' => '<div class="%2$s">',
                        'after_widget' => '<div class="clear"></div></div>',
                        'before_title' => '<div class="widget-title"><h4>',
                        'after_title' => '</h4></div>',
                    )
            );
        }

        if (class_exists('bbPress')) {
            register_sidebar(
                    array(
                        'id' => 'bbpress-forum',
                        'name' => 'bbPress Forum',
                        'description' => 'Drag widgets for bbpress forum sidebar',
                        'before_widget' => '<div class="articlemag_widget %2$s">',
                        'after_widget' => '<div class="clear"></div></div>',
                        'before_title' => '<div class="widget-title"><h4>',
                        'after_title' => '</h4></div>',
                    )
            );
        }
    }

}

new CSFramework_Sidebars_API();
