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
    });
}(jQuery));
