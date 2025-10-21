<?php
namespace SMMCARE;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Plugin {
    public function run() {
        add_action( 'admin_menu', [ $this, 'register_admin_menu' ] );
        add_action( 'rest_api_init', [ $this, 'register_rest_routes' ] );

        // load textdomain for translations
        add_action( 'init', [ $this, 'load_textdomain' ] );
    }

    public function load_textdomain() {
        load_plugin_textdomain( 'smmcare', false, dirname( plugin_basename( SMMCARE_PLUGIN_FILE ) ) . '/languages' );
    }

    public function register_admin_menu() {
        add_menu_page(
            __( 'SMMCARE', 'smmcare' ),
            __( 'SMMCARE', 'smmcare' ),
            'manage_options',
            'smmcare',
            [ $this, 'render_admin_page' ],
            'dashicons-admin-generic'
        );
    }

    public function render_admin_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // Simple nonce usage for form actions
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'SMMCARE Settings', 'smmcare' ); ?></h1>
            <form method="post">
                <?php wp_nonce_field( 'smmcare_save_settings', 'smmcare_nonce' ); ?>
                <table class="form-table">
                    <tr>
                        <th><label for="smmcare_api_key"><?php esc_html_e( 'API Key', 'smmcare' ); ?></label></th>
                        <td><input id="smmcare_api_key" name="smmcare_api_key" type="text" value="<?php echo esc_attr( get_option( 'smmcare_api_key', '' ) ); ?>" class="regular-text" /></td>
                    </tr>
                </table>
                <?php submit_button( __( 'Save Settings', 'smmcare' ) ); ?>
            </form>
        </div>
        <?php
    }

    public function register_rest_routes() {
        register_rest_route( 'smmcare/v1', '/onboard', [
            'methods' => 'POST',
            'callback' => [ $this, 'handle_onboard' ],
            'permission_callback' => function ( $request ) {
                return current_user_can( 'edit_posts' );
            },
            'args' => [
                'company_name' => [
                    'required' => true,
                    'sanitize_callback' => 'sanitize_text_field',
                ],
            ],
        ] );
    }

    public function handle_onboard( \WP_REST_Request $request ) {
        $company_name = $request->get_param( 'company_name' );

        // Example: store as option for now. Replace with proper meta or custom table.
        update_option( 'smmcare_company_name', sanitize_text_field( $company_name ) );

        return rest_ensure_response( [
            'success' => true,
            'message' => __( 'Onboarding saved.', 'smmcare' ),
        ] );
    }
}