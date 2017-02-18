<?php
/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
class Wpsp_Admin {
    /**
     * Option key, and option page slug
     * @var string
     */
    private $key = 'wpsp_options';
    /**
     * Options page metabox id
     * @var string
     */
    private $metabox_id = 'wpsp_option_metabox';
    /**
     * Options Page title
     * @var string
     */
    protected $title = '<b><span class="dashicons dashicons-lock"></span>WP Secure</b><p style="font-size: 10px;"> Settings';
    /**
     * Options Page hook
     * @var string
     */
    protected $options_page = '';
    /**
     * Holds an instance of the object
     *
     * @var wpsp_Admin
     **/
    private static $instance = null;
    /**
     * Constructor
     * @since 0.1.0
     */
    private function __construct() {
        // Set our title
        $this->title = __( '<b>WP Secure</b><br><font style="font-size: 12px;">Settings<font>', 'wpsp' );
    }
    /**
     * Returns the running object
     *
     * @return wpsp_Admin
     **/
    public static function get_instance() {
        if( is_null( self::$instance ) ) {
            self::$instance = new wpsp_Admin();
            self::$instance->hooks();
        }
        return self::$instance;
    }
    /**
     * Initiate our hooks
     * @since 0.1.0
     */
    public function hooks() {
        add_action( 'admin_init', array( $this, 'init' ) );
        add_action( 'admin_menu', array( $this, 'add_options_page' ) );
        add_action( 'cmb2_admin_init', array( $this, 'add_options_page_metabox' ) );
    }
    /**
     * Register our setting to WP
     * @since  0.1.0
     */
    public function init() {
        register_setting( $this->key, $this->key );
    }
    /**
     * Add menu options page
     * @since 0.1.0
     */
    public function add_options_page() {

        $icon_url =  plugins_url( 'img/icon.png', dirname(__FILE__) );  // 'dashicons-lock'

        $this->options_page = add_menu_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) , $icon_url  );
        // Include CMB CSS in the head to avoid FOUC
        add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
    }
    /**
     * Admin page markup. Mostly handled by CMB2
     * @since  0.1.0
     */
    public function admin_page_display() {
        ?>

        <div class="wpsp_options_page wrap cmb2-options-page <?php echo $this->key; ?>">
            <h2><b><?php _e('WP Secure','wpsp') ?></b></h2><span style="font-size: 15px;"><?php _e('Settings','wpsp'); ?><span>
            <?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
        </div>
    <?php
    }
    /**
     * Add the options metabox to the array of metaboxes
     * @since  0.1.0
     */
    function add_options_page_metabox() {

        // hook in our save notices
        add_action( "cmb2_save_options-page_fields_{$this->metabox_id}", array( $this, 'settings_notices' ), 10, 2 );
        $wpsp_options = new_cmb2_box( array(
            'id'         => $this->metabox_id,
            'hookup'     => false,
            'cmb_styles' => false,
            'show_on'    => array(
                // These are important, don't remove
                'key'   => 'options-page',
                'value' => array( $this->key, )
            ),
        ) );

        // to Set our Settings fields

        // to add logo
        $wpsp_options->add_field( array(
            'name'    => __('Your Logo  (optional)', 'wpsp'),
            'desc'    => __('Upload an image for your logo', 'wpsp'),
            'id'      => 'logo_image',
            'type'    => 'file',
            // Optional:
            'options' => array(
                'url' => false, // Hide the text input for the url
                'add_upload_file_text' => 'Add Logo' // Change upload button text. Default: "Add or Upload File"
            ),
        ) );

        $wpsp_options->add_field( array(
            'name' => __('Enable WP Secure Lock','wpsp'),
            'desc' => __('Check this to enable WP Secure\'s PIN lock on your whole site','wpsp'),
            'id'   => 'enable',
            'type' => 'checkbox'
        ) );

        // set logo height
        $wpsp_options->add_field( array(
            'name'    => __('Logo Height (optional)', 'wpsp'),
            'desc'    => __('Here you can set logo height in px.', 'wpsp'),
            'default' => '100',
            'id'      => 'logo_height',
            'type'    => 'text_small'
        ) );

        // set logo widht
        $wpsp_options->add_field( array(
            'name'    => __('Logo Width (optional)', 'wpsp'),
            'desc'    => __('Here you can set logo widht in px. <br><b>Note: keep both height and width same for neat look.<b>', 'wpsp'),
            'default' => '100',
            'id'      => 'logo_width',
            'type'    => 'text_small'
        ) );

        // set password
        $wpsp_options->add_field( array(
            'name'    => __('Password', 'wpsp'),
            'desc'    => __('Set Password to protect your site', 'wpsp'),
            'default' => '',
            'id'      => 'pin',
            'type'    => 'text'
        ) );

        // Submit button text
        $wpsp_options->add_field( array(
            'name'    => __('Label for submit button (optional)', 'wpsp'),
            'desc'    => __('From here you can set label for submit button', 'wpsp'),
            'default' => 'Submit',
            'id'      => 'submit_label',
            'type'    => 'text',
        ) );

        // Placeholder text
        $wpsp_options->add_field( array(
            'name'    => __('Place holder text (optional)', 'wpsp'),
            'desc'    => __('From here you can set Place holder for PIN field', 'wpsp'),
            'default' => 'ENTER YOUR PIN',
            'id'      => 'pin_placeholder',
            'type'    => 'text',
        ) );

        // Error text
        $wpsp_options->add_field( array(
            'name'    => __('Error Text (optional)', 'wpsp'),
            'desc'    => __('Text to be displayed if wrong PIN entered', 'wpsp'),
            'default' => 'Please Try Again',
            'id'      => 'try_again_error',
            'type'    => 'text',
        ) );

    }
    /**
     * Register settings notices for display
     *
     * @since  0.1.0
     * @param  int   $object_id Option key
     * @param  array $updated   Array of updated fields
     * @return void
     */
    public function settings_notices( $object_id, $updated ) {
        if ( $object_id !== $this->key || empty( $updated ) ) {
            return;
        }
        add_settings_error( $this->key . '-notices', '', __( 'Settings updated.', 'wpsp' ), 'updated' );
        settings_errors( $this->key . '-notices' );
    }
    /**
     * Public getter method for retrieving protected/private variables
     * @since  0.1.0
     * @param  string  $field Field to retrieve
     * @return mixed          Field value or exception is thrown
     */
    public function __get( $field ) {
        // Allowed fields to retrieve
        if ( in_array( $field, array( 'key', 'metabox_id', 'title', 'options_page' ), true ) ) {
            return $this->{$field};
        }
        throw new Exception( 'Invalid property: ' . $field );
    }
}
/**
 * Helper function to get/return the wpsp_Admin object
 * @since  0.1.0
 * @return wpsp_Admin object
 */
function wpsp_admin() {
    return Wpsp_Admin::get_instance();
}
/**
 * @author Mohammad Mursaleen
 * @since  0.1.0
 * @param  string  $key Options array key
 * @return mixed        Option value
 */
function wpsp_get_option( $key = '' ) {

    $wpsp_options  = get_option(wpsp_admin()->key);

    if ( $key == '' )
        return $wpsp_options;

    $wpsp_defaults = array(
        // TODO define array for default values...
    );

    return isset($wpsp_options[$key]) ? $wpsp_options[$key] : false;

}
// Get it started
wpsp_admin();