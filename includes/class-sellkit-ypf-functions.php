<?php
// Add menu item
function sellkit_ypf_add_admin_menu() {
    add_submenu_page(
        'sellkit',
        'YPF SellKit',
        'YPF SellKit',
        'manage_options',
        'sellkit-ypf',
        'sellkit_ypf_settings_page'
    );
}
add_action('admin_menu', 'sellkit_ypf_add_admin_menu');

// Settings page
function sellkit_ypf_settings_page() {
    ?>
    <div class="wrap">
        <h2>SellKit YPF Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('sellkit_ypf_settings_group'); ?>
            <?php do_settings_sections('sellkit-ypf'); ?>
            <?php submit_button(); ?>
        </form>
        <hr>
        <div class="sellkit-ypf-export" style="width:50%;float:left;">
        <h3>Export Settings</h3>
        <p>
            <button type="button" class="button" id="sellkit-ypf-export">Export Settings</button>
        </p>
        </div>
        <div class="sellkit-ypf-import" style="width:50%;float:left;">
        <h3>Import Settings</h3>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="sellkit_ypf_import_file" accept=".json">
            <button type="submit" class="button" name="sellkit_ypf_import">Import Settings</button>
        </form>
        </div>
    </div>
    <?php
}

// Register settings
function sellkit_ypf_register_settings() {
    register_setting('sellkit_ypf_settings_group', 'sellkit_ypf_enable_plugin');
    register_setting('sellkit_ypf_settings_group', 'sellkit_ypf_enable_badges_payment');
    register_setting('sellkit_ypf_settings_group', 'sellkit_ypf_badges_images_payment');
    register_setting('sellkit_ypf_settings_group', 'sellkit_ypf_enable_terms_conditions');
    register_setting('sellkit_ypf_settings_group', 'sellkit_ypf_enable_css_editor');
    register_setting('sellkit_ypf_settings_group', 'sellkit_ypf_custom_css');
    register_setting('sellkit_ypf_settings_group', 'sellkit_ypf_custom_js');

    add_settings_section('sellkit_ypf_general_settings', 'General Settings', null, 'sellkit-ypf');

    add_settings_section('sellkit_ypf_general_settings', 'General Settings', 'sellkit_ypf_general_settings_callback', 'sellkit-ypf');

    add_settings_field('sellkit_ypf_enable_plugin', 'Enable Plugin', 'sellkit_ypf_enable_plugin_callback', 'sellkit-ypf', 'sellkit_ypf_general_settings');
    add_settings_field('sellkit_ypf_enable_badges_payment', 'Enable Badges Payment', 'sellkit_ypf_enable_badges_payment_callback', 'sellkit-ypf', 'sellkit_ypf_general_settings');
    add_settings_field('sellkit_ypf_badges_images_payment', 'Badge Pictures', 'sellkit_ypf_badges_images_payment_callback', 'sellkit-ypf', 'sellkit_ypf_general_settings');
    add_settings_field('sellkit_ypf_enable_terms_conditions', 'Enable Terms and Conditions', 'sellkit_ypf_enable_terms_conditions_callback', 'sellkit-ypf', 'sellkit_ypf_general_settings');
    add_settings_field('sellkit_ypf_enable_css_editor', 'Enable CSS/JS Editor', 'sellkit_ypf_enable_css_editor_callback', 'sellkit-ypf', 'sellkit_ypf_general_settings');
    add_settings_field('sellkit_ypf_custom_css', 'Custom CSS', 'sellkit_ypf_custom_css_callback', 'sellkit-ypf', 'sellkit_ypf_general_settings');
    add_settings_field('sellkit_ypf_custom_js', 'Custom JS', 'sellkit_ypf_custom_js_callback', 'sellkit-ypf', 'sellkit_ypf_general_settings');
}
add_action('admin_init', 'sellkit_ypf_register_settings');

// Callback function for the "General Settings" section
function sellkit_ypf_general_settings_callback() {
    echo '<p>These are the general settings for the SellKit YPF plugin. Please feel free to customize them according to your needs.</br>After making changes in the SellKit YPF plugin, Please Refresh your website and clear cache of your browser.</br> If you have any questions, please send an email to <a href="mailto:ardi@jm-consulting.id">ardi@jm-consulting.id</a>.</br>Enjoy Using this Plugin.</p>';
}

// Callback functions for settings fields
function sellkit_ypf_enable_plugin_callback() {
    $value = get_option('sellkit_ypf_enable_plugin', 'disable');
    echo '<select name="sellkit_ypf_enable_plugin"><option value="enable"' . selected($value, 'enable', false) . '>Enable</option><option value="disable"' . selected($value, 'disable', false) . '>Disable</option></select>';
}

function sellkit_ypf_enable_badges_payment_callback() {
    $value = get_option('sellkit_ypf_enable_badges_payment', 'disable');
    echo '<select name="sellkit_ypf_enable_badges_payment"><option value="enable"' . selected($value, 'enable', false) . '>Enable</option><option value="disable"' . selected($value, 'disable', false) . '>Disable</option></select>';
}

function sellkit_ypf_badges_images_payment_callback() {
    $badges = get_option('sellkit_ypf_badges_images_payment', array());

    // Pastikan $badges adalah array
    if (!is_array($badges)) {
        $badges = array();
    }

    echo '<div class="sellkit-ypf-badges-wrapper">';
    foreach ($badges as $badge) {
        echo '<div class="sellkit-ypf-badge">';
        echo '<input type="hidden" name="sellkit_ypf_badges_images_payment[]" value="' . esc_attr($badge) . '" />';
        echo '<div class="sellkit-ypf-badge-wrap-images">';
        echo '<img src="' . esc_url($badge) . '" style="max-width:100px; display:block;" />';
        echo '</div>';
        echo '<button type="button" class="button sellkit-ypf-remove-badge-button">Remove</button>';
        echo '</div>';
    }
    echo '</div>';

    echo '<button type="button" id="sellkit-ypf-add-badge-button" class="button">Add Badge</button>';
}


function sellkit_ypf_enable_terms_conditions_callback() {
    $value = get_option('sellkit_ypf_enable_terms_conditions', 'disable');
    echo '<select name="sellkit_ypf_enable_terms_conditions"><option value="enable"' . selected($value, 'enable', false) . '>Enable</option><option value="disable"' . selected($value, 'disable', false) . '>Disable</option></select>';
}

function sellkit_ypf_enable_css_editor_callback() {
    $value = get_option('sellkit_ypf_enable_css_editor', 'disable');
    echo '<select name="sellkit_ypf_enable_css_editor"><option value="enable"' . selected($value, 'enable', false) . '>Enable</option><option value="disable"' . selected($value, 'disable', false) . '>Disable</option></select>';
}


function sellkit_ypf_custom_css_callback() {
    $value = get_option('sellkit_ypf_custom_css', '');
    echo '<textarea id="sellkit-ypf-css-editor" name="sellkit_ypf_custom_css" rows="10" cols="50">' . esc_textarea($value) . '</textarea>';
}

function sellkit_ypf_custom_js_callback() {
    $value = get_option('sellkit_ypf_custom_js', '');
    echo '<textarea id="sellkit-ypf-js-editor" name="sellkit_ypf_custom_js" rows="10" cols="50">' . esc_textarea($value) . '</textarea>';
}

function sellkit_ypf_enqueue_scripts($hook) {
    if ($hook != 'toplevel_page_sellkit-ypf') {
        return;
    }

    // Enqueue CodeMirror scripts and styles
    wp_enqueue_style('wp-codemirror');
    wp_enqueue_script('wp-codemirror');
    wp_enqueue_script('css-codemirror', plugins_url('../public/js/css-codemirror.js', __FILE__), array('wp-codemirror'), '1.0.0', true);

    // Enqueue the codemirror settings from WordPress
    wp_enqueue_code_editor(array('type' => 'text/css'));
    wp_enqueue_code_editor(array('type' => 'text/javascript'));
}
add_action('admin_enqueue_scripts', 'sellkit_ypf_enqueue_scripts');


function sellkit_ypf_export_settings() {
    if (!isset($_GET['sellkit_ypf_export'])) {
        return;
    }

    $settings = array(
        'sellkit_ypf_enable_plugin' => get_option('sellkit_ypf_enable_plugin'),
        'sellkit_ypf_enable_badges_payment' => get_option('sellkit_ypf_enable_badges_payment'),
        'sellkit_ypf_badges_images_payment' => get_option('sellkit_ypf_badges_images_payment'),
        'sellkit_ypf_enable_terms_conditions' => get_option('sellkit_ypf_enable_terms_conditions'),
        'sellkit_ypf_enable_css_editor' => get_option('sellkit_ypf_enable_css_editor'),
        'sellkit_ypf_custom_css' => get_option('sellkit_ypf_custom_css'),
        'sellkit_ypf_custom_js'  => get_option('sellkit_ypf_custom_js'),
        // Tambahkan pengaturan lainnya jika diperlukan
    );
    $current_date_time = date('Y-m-d_H-i-s');
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="sellkit-ypf-settings_' . $current_date_time . '.json"');
    echo json_encode($settings);
    exit;
}
add_action('admin_init', 'sellkit_ypf_export_settings');

function sellkit_ypf_import_settings() {
    if (!isset($_FILES['sellkit_ypf_import_file'])) {
        return;
    }

    $file = $_FILES['sellkit_ypf_import_file'];
    if ($file['type'] !== 'application/json') {
        wp_die('Invalid file type.');
    }

    $settings = json_decode(file_get_contents($file['tmp_name']), true);
    if (!$settings) {
        wp_die('Invalid file content.');
    }

    foreach ($settings as $key => $value) {
        update_option($key, $value);
    }

    wp_redirect(add_query_arg('settings-imported', 'true', admin_url('admin.php?page=sellkit-ypf')));
    exit;
}
add_action('admin_init', 'sellkit_ypf_import_settings');

function sellkit_ypf_admin_scripts() {
    ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var exportButton = document.getElementById('sellkit-ypf-export');
            if (exportButton) {
                exportButton.addEventListener('click', function() {
                    window.location.href = '<?php echo admin_url('admin.php?page=sellkit-ypf&sellkit_ypf_export=true'); ?>';
                });
            }
        });
    </script>
    <?php
}
add_action('admin_footer', 'sellkit_ypf_admin_scripts');


function sellkit_ypf_enqueue_admin_scripts($hook) {
    wp_enqueue_media();  // Pastikan baris ini ada

    wp_enqueue_script('sellkit-ypf-admin', plugin_dir_url( __FILE__ ) . '../admin/js/sellkit-ypf-main.js', array('jquery'), '1.0.0', true);
}
add_action('admin_enqueue_scripts', 'sellkit_ypf_enqueue_admin_scripts');




//------------------- Start Front End Functions --------------------------------

// Check if the plugin is enabled and if the current request URI matches the given pattern
function sellkit_ypf_check_request_uri() {
    if (get_option('sellkit_ypf_enable_plugin') == 'enable') {
        if (strpos($_SERVER['REQUEST_URI'], '/sellkit_step/') !== false) {
            add_action('init', 'replace_sellkit_action', 9999);
        }
    }
}
add_action('init', 'sellkit_ypf_check_request_uri', 1); // Run this early on the 'init' hook

add_filter( 'woocommerce_default_address_fields', 'sellkit_ypf_custom_override_default_checkout_fields', 10, 1 );
function sellkit_ypf_custom_override_default_checkout_fields( $address_fields ) {
    $address_fields['address_1']['placeholder'] = __( 'Address *', 'woocommerce' );

    return $address_fields;
}
add_filter( 'woocommerce_ship_to_different_address_checked', '_return_true' );