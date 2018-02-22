<?php
/**
 * CMB2 Theme Options
 * @version 0.1.0
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {
    $icon_url =  plugins_url( 'img/icon.png', dirname(__FILE__) );
    $default_value = 327;

    Container::make( 'theme_options', 'WP Secure Settings' )
        ->set_icon($icon_url)
        ->add_tab(__('WP Secure Settings','wp_secure'), array(
            Field::make('image', 'logo_image', __("Add logo")),
            Field::make("checkbox", "enable",__( "Enable WP Secure Lock"))
                ->set_option_value('on'),
            Field::make('text', 'logo_height', __("logo height","wp_secure"))->set_default_value( 100 ),
            Field::make('text', 'logo_width', __("logo Width","wp_secure"))->set_default_value( 100 ),
            Field::make('text', 'pin', __("Password"))->set_required( true ),
            Field::make('text', 'submit_label', __("Label For Submit Button (optional)")),
            Field::make('text', 'pin_placeholder', __("Place Holder Text(optional)")),
            Field::make('text', 'try_again_error', __("Error Text(optional)")),
            Field::make( 'color', 'crb_background',__ ("Background")),
            //->set_palette( array( '#FF0000', '#00FF00', '#0000FF' )),
        ));
}
/*use Carbon_Fields\Container;
use Carbon_Fields\Field;
 $icon_url =  plugins_url( 'img/icon.png', dirname(__FILE__) );
 $default_value = 327;

Container::make( 'theme_options', 'WP Secure Settings' )
       ->set_icon($icon_url)
       ->add_tab(__('WP Secure Settings','wp_secure'), array(
        Field::make('image', 'logo_image', __("Add logo")),
        Field::make("checkbox", "enable",__( "Enable WP Secure Lock"))
            ->set_option_value('on'),
        Field::make('text', 'logo_height', __("logo height","wp_secure"))->set_default_value( 100 ),
		Field::make('text', 'logo_width', __("logo Width","wp_secure"))->set_default_value( 100 ),
		Field::make('text', 'pin', __("Password"))->set_required( true ),
		Field::make('text', 'submit_label', __("Label For Submit Button (optional)")),
		Field::make('text', 'pin_placeholder', __("Place Holder Text(optional)")),
		Field::make('text', 'try_again_error', __("Error Text(optional)")),
		Field::make( 'color', 'crb_background',__ ("Background")),
        //->set_palette( array( '#FF0000', '#00FF00', '#0000FF' )),
			));*/