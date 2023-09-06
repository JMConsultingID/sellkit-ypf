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
            jQuery(".woocommerce-checkout").on( 'click', 'a.woocommerce-terms-and-conditions-link', function(event) {
                event.stopPropagation();
                let TermsPageLink = jQuery('a.woocommerce-terms-and-conditions-link').attr('href');
                window.open(TermsPageLink, '_blank');
                return false;
            });
        </script> 
        <?php
    }  
}
add_action('wp_footer', 'sellkit_ypf_add_terms_and_conditions_checkbox');

function sellkit_ypf_enqueue_frontend_scripts() {
    // Cek apakah plugin diaktifkan
    if (get_option('sellkit_ypf_enable_plugin') !== 'enable') {
        return;
    }

    if (strpos($_SERVER['REQUEST_URI'], '/sellkit_step/') === false) {
        return;
    }

    // Jika CSS Editor diaktifkan, tambahkan CSS ke frontend
    if (get_option('sellkit_ypf_enable_css_editor') === 'enable') {
        $custom_css = get_option('sellkit_ypf_custom_css');
        if (!empty($custom_css)) {
            wp_add_inline_style('wp-block-library', $custom_css); // 'wp-block-library' adalah handle untuk salah satu stylesheets inti WordPress. Anda bisa menggantinya dengan handle stylesheet lain jika diperlukan.
        }

        $custom_js = get_option('sellkit_ypf_custom_js');
        if (!empty($custom_js)) {
            wp_add_inline_script('jquery-core', $custom_js); // 'jquery-core' adalah handle untuk jQuery, yang merupakan salah satu skrip inti WordPress. Anda bisa menggantinya dengan handle skrip lain jika diperlukan.
        }
    }

    // Jika Anda juga ingin menambahkan JS Editor di masa depan, Anda bisa menambahkannya di sini dengan cara yang serupa.
}
add_action('wp_enqueue_scripts', 'sellkit_ypf_enqueue_frontend_scripts', 100); // Prioritas 100 untuk memastikan ini dijalankan setelah stylesheet lainnya.

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
