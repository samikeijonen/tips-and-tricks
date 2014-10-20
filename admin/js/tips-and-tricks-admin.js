/* ==========================================================
 * This js file is basically from Soliloquy Plugin.
 *
 * @package    Tips_And_Tricks
 * @subpackage admin/js
 * @since      1.0.0
 *
 * @link       http://soliloquywp.com/
 * @author     Thomas Griffin
 * @copyright  Copyright (c) 2013, Thomas Griffin
 *
 *
 * Licensed under the GPL License, Version 2.0 or later (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */

;(function($){
    $(function(){
        // Close the modal window on user action.
        var tips_and_tricks_trigger_target  = tips_and_tricks_editor_frame = false;
        var tips_and_tricks_append_and_hide = function(e){
            e.preventDefault();
            $('.tips-and-tricks-default-ui .selected').removeClass('details selected');
            $('.tips-and-tricks-default-ui').appendTo('.tips-and-tricks-default-ui-wrapper').hide();
            tips_and_tricks_trigger_target = tips_and_tricks_editor_frame = false;
			/* display welcome on close: not sure. */
			$( '#tips-and-tricks-welcome' ).show();
			$( '#tips-and-tricks-welcome' ).siblings('.tips-and-tricks-section').hide();
			/* remove active tab */
			$( '#tips-and-tricks-terms a' ).removeClass('active');
        };

        $(document).on('click', '.tips-and-tricks-show-tip, .tips-and-tricks-modal-trigger', function(e){
            e.preventDefault();

            // Store the trigger target.
            tips_and_tricks_trigger_target = e.target;

            // Show the modal.
            tips_and_tricks_editor_frame = true;
            $('.tips-and-tricks-default-ui').appendTo('body').show();
			
			// Close the modal.
            $(document).on('click', '.media-modal-close, .media-modal-backdrop, .tips-and-tricks-close-modal', tips_and_tricks_append_and_hide);
            $(document).on('keydown', function(e){
                if ( 27 == e.keyCode && tips_and_tricks_editor_frame ) {
                    tips_and_tricks_append_and_hide(e);
                }
            });
        });
		/**
		 * This to create the tabs
		 * maybe need fixing, just a quick cowboy coding
		 */
        $(document).on('click', '#tips-and-tricks-terms a', function(e){
			e.preventDefault();
			/* make tab */
			$(this).addClass('active');
			$(this).siblings("a").removeClass('active');

			/* grab the target id */
			var target_div = $(this).attr("href");

			/* Only if it's not loaded yet. */
			if ( ! $(target_div).hasClass('loaded') ) {

				/* Loading status. */
				$( '#tips-and-tricks-loading' ).show();

				$.ajax( {
					type: "POST",
					url: tips_and_tricks_ajax_data.ajaxurl, // From localized script.
					data:
					{
						action                      : 'tips_and_tricks_click_term_link',                    // Inject data to hook "wp_ajax_*" => "wp_ajax_tips_and_tricks_click_term_link" (hook).
						tips_and_tricks_ajax_nonce  : tips_and_tricks_ajax_data.tips_and_tricks_ajax_nonce, // From localize script.
						tips_and_tricks_ajax_termid : $(this).data('tip-id'),                               // From data-termid in add module link.
					},
					success: function( data ){
						$( target_div ).html( data ); // Add the data on success.
						$( target_div ).addClass( 'loaded' );
						$( '#tips-and-tricks-loading' ).hide();
					}
				} );

			} //end if

			/* Display it. */
			$(target_div).show();
			/* Hide others. */
			$(target_div).siblings( '.tips-and-tricks-section' ).hide();

        });
    });
}(jQuery));
