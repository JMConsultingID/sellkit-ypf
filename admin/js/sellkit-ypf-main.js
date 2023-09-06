(function( $ ) {
	'use strict';

	jQuery(document).ready(function($) {
	    $('#sellkit-ypf-add-badge-button').click(function(e) {
	        e.preventDefault();

	        // Cek jumlah gambar saat ini
	        var currentBadges = $('.sellkit-ypf-badge').length;
	        if (currentBadges >= 4) {
	            alert('You can only upload a maximum of 4 badges.');
	            return;
	        }

	        var frame = wp.media({
	            title: 'Select or Upload Badge',
	            button: {
	                text: 'Use this badge'
	            },
	            multiple: false
	        });

	        frame.on('select', function() {
	            var attachment = frame.state().get('selection').first().toJSON();
	            var badgeHTML = `
	                <div class="sellkit-ypf-badge">
	                    <input type="hidden" name="sellkit_ypf_badges_images_payment[]" value="${attachment.url}" />
	                    <div class="sellkit-ypf-badge-wrap-images">
	                    <img src="${attachment.url}" style="max-width:100px; display:block;" />
	                    </div>
	                    <button type="button" class="button sellkit-ypf-remove-badge-button">Remove</button>
	                </div>
	            `;
	            $('.sellkit-ypf-badges-wrapper').append(badgeHTML);
	        });

	        frame.open();
	    });

	    $(document).on('click', '.sellkit-ypf-remove-badge-button', function() {
	        $(this).closest('.sellkit-ypf-badge').remove();
	    });
	});


})( jQuery );
