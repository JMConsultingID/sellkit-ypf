<?php
function replace_sellkit_action() {
    // Cek apakah class Multi_Step tersedia
    if ( class_exists( '\Sellkit\Elementor\Modules\Checkout\Classes\Multi_Step' ) ) {
        // Menghapus action asli
        $settings = array(
            'show_preview_box' => 'no', // contoh pengaturan
            'show_breadcrumb' => 'no',   // contoh pengaturan lainnya,
            'show_shipping_method' => 'no',
            'show_sticky_cart_details' => 'no'
        );        
        $multi_step_instance = new \Sellkit\Elementor\Modules\Checkout\Classes\Multi_Step( $settings );

        // Pastikan instance telah dibuat dan method 'first_step_begin' ada
        if ( isset( $multi_step_instance ) && method_exists( $multi_step_instance, 'first_step_begin' ) ) {
               
        } 
    }
}

function sellkit_ypf_add_terms_and_conditions_checkbox() {
    $value = get_option('sellkit_ypf_enable_terms_conditions');
    // Cek apakah plugin diaktifkan
    if (get_option('sellkit_ypf_enable_plugin') !== 'enable') {
        return;
    }

    if (strpos($_SERVER['REQUEST_URI'], '/sellkit_step/') === false) {
        return;
    }


    // Cek apakah opsi "term and condition" diaktifkan
    if (get_option('sellkit_ypf_enable_terms_conditions') !== 'enable') {
        ?>
         <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                var termsWrapper = document.querySelector('.woocommerce-terms-and-conditions-wrapper.sellkit-checkout-terms');
                if (termsWrapper) {
                    termsWrapper.style.display = 'none';
                }
            });            
        </script> 
        <?php
    }  
}
add_action('wp_footer', 'sellkit_ypf_add_terms_and_conditions_checkbox');

function sellkit_ypf_enqueue_frontend_scripts() {
    if (get_option('sellkit_ypf_enable_plugin') !== 'enable') {
        return;
    }

    if (get_option('sellkit_ypf_enable_css_editor') === 'enable') {
        $custom_js = get_option('sellkit_ypf_custom_js');
        if (!empty($custom_js)) {
            // Enqueue your main script and place it in the footer
            wp_enqueue_script( 'sellkit-ypf-inline-js', plugins_url( '../public/js/sellkit-ypf-inline-js.js', __FILE__ ), array('jquery'), '1.0.0', true );
            wp_add_inline_script('sellkit-ypf-inline-js', $custom_js);
        }
    }
}
add_action('wp_enqueue_scripts', 'sellkit_ypf_enqueue_frontend_scripts', 200);

function sellkit_ypf_add_footer_styles() {
    if (get_option('sellkit_ypf_enable_plugin') !== 'enable') {
        return;
    }

    if (get_option('sellkit_ypf_enable_css_editor') === 'enable') {
        $custom_css = get_option('sellkit_ypf_custom_css');
        if (!empty($custom_css)) {
            // Enqueue your main stylesheet
            wp_enqueue_style('sellkit-ypf-inline-css', plugins_url( '../public/css/sellkit-ypf-inline-css.css', __FILE__ ) );
            wp_add_inline_style('sellkit-ypf-inline-css', $custom_css);
        }
    }
};
add_action( 'wp_footer', 'sellkit_ypf_add_footer_styles', 100 );

function sellkit_ypf_get_badges_html() {
    $badges = get_option('sellkit_ypf_badges_images_payment', array());

    // Jika tidak ada badges, kembalikan string kosong atau pesan default
    if (empty($badges)) {
        return '<div class="trustbadges items-center py-7 trustbadges-desktop">
                <div class="trustbadges-item">
                    <img data-src="https://fundyourfx.com/wp-content/uploads/2022/12/norton.png" class="lazyloaded" src="https://fundyourfx.com/wp-content/uploads/2022/12/norton.png">
                </div>
                <div class="trustbadges-item">
                    <img data-src="https://fundyourfx.com/wp-content/uploads/2022/12/mcfee.png" class="lazyloaded" src="https://fundyourfx.com/wp-content/uploads/2022/12/mcfee.png">
                </div>
                <div class="trustbadges-item">
                    <img data-src="https://fundyourfx.com/wp-content/uploads/2022/12/visever.png" class="lazyloaded" src="https://fundyourfx.com/wp-content/uploads/2022/12/visever.png">
                </div>
                <div class="trustbadges-item">
                    <img data-src="https://fundyourfx.com/wp-content/uploads/2022/12/truste.png" class="lazyloaded" src="https://fundyourfx.com/wp-content/uploads/2022/12/truste.png">
                </div>
            </div>'; // atau return 'No badges uploaded.';
    }

    $output = '<div class="trustbadges items-center py-7 trustbadges-desktop">';

    foreach ($badges as $badge) {
        $output .= '<div class="trustbadges-item">';
        $output .= '<img data-src="' . esc_url($badge) . '" class="lazyloaded" src="' . esc_url($badge) . '">';
        $output .= '</div>';
    }

    $output .= '</div>';

    return $output;
}


function sellkit_ypf_insert_badges_js() {
    // Cek apakah plugin diaktifkan
    if (get_option('sellkit_ypf_enable_plugin') !== 'enable') {
        return;
    }

    if (strpos($_SERVER['REQUEST_URI'], '/sellkit_step/') === false) {
        return;
    }

    // Cek apakah badges diaktifkan
    if (get_option('sellkit_ypf_enable_badges_payment') !== 'enable') {
        return;
    }

    // Sisipkan JavaScript
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            var completeOrderButton = document.querySelector('.sellkit-one-page-checkout-place-order');
            if (completeOrderButton) {
                var badgesHTML = <?php echo json_encode(sellkit_ypf_get_badges_html()); ?>;
                completeOrderButton.insertAdjacentHTML('afterend', badgesHTML);
            }
        });
    </script>
    <?php
}
add_action('wp_footer', 'sellkit_ypf_insert_badges_js');
