<?php
/**
 * Plugin class
 **/
if ( ! class_exists( 'CustomFields' ) ) {

	class CustomFields {

		public function __construct() {
			//
		}

		/*
		 * Initialize the class and start calling our hooks and filters
		 * @since 1.0.0
		*/
		public function init() {
			add_action( 'category_add_form_fields', array ( $this, 'add_category_image' ), 10, 2 );
			add_action( 'created_category', array ( $this, 'save_category_image' ), 10, 2 );
			add_action( 'category_add_form_fields', array ( $this, 'add_category_video_link' ), 10, 2 );
			add_action( 'created_category', array ( $this, 'save_category_image' ), 10, 2 );
			add_action( 'category_edit_form_fields', array ( $this, 'update_category_image' ), 10, 2 );
			add_action( 'category_edit_form_fields', array ( $this, 'update_category_video_link' ), 10, 2 );
			add_action( 'edited_category', array ( $this, 'updated_category_image' ), 10, 2 );
			add_action( 'edited_category', array ( $this, 'updated_category_video_link' ), 10, 2 );
			add_action( 'admin_footer', array ( $this, 'add_script' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'load_wp_media_files' ) );
		}

		function load_wp_media_files() {
			wp_enqueue_media();
		}

		/*
		 * Add a form field in the new category page
		 * @since 1.0.0
		*/
		public function add_category_image ( $taxonomy ) { ?>
			<div class="form-field term-group">
				<label for="category-image-id"><?php _e( 'Image' ); ?></label>
				<input type="hidden" id="category-image-id" name="category-image-id" class="custom_media_url" value="">
				<div id="category-image-wrapper"></div>
				<p>
					<input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Upload Image' ); ?>" />
					<input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image' ); ?>" />
				</p>
			</div>
			<?php
		}

		/*
		 * Save the form field
		 * @since 1.0.0
		*/
		public function save_category_image ( $term_id, $tt_id ) {
			if( isset( $_POST['category-image-id'] ) && '' !== $_POST['category-image-id'] ){
				$image = $_POST['category-image-id'];
				add_term_meta( $term_id, 'category-image-id', $image, true );
			}
		}

		/*
		 * Add a form field in the new category page
		 * @since 1.0.0
		*/
		public function add_category_video_link ( $taxonomy ) { ?>
			<div class="form-field term-group">
				<label for="category-video-link"><?php _e( 'Image' ); ?></label>
				<input type="text" id="category-video-link" name="category-video-link" value="">
				<div id="category-image-wrapper"></div>
				<p>
					<input type="button" class="button button-secondary " id="category-video-link-remove" name="category-video-link-remove" value="<?php _e( 'Remove Link' ); ?>" />
				</p>
			</div>
			<?php
		}

		/*
		 * Save the form field
		 * @since 1.0.0
		*/
		public function save_category_video_link ( $term_id, $tt_id ) {
			if( isset( $_POST['category-video-link'] ) && '' !== $_POST['category-video-link'] ){
				$image = $_POST['category-video-link'];
				add_term_meta( $term_id, 'category-video-link', $image, true );
			}
		}

		/*
		 * Edit the form field
		 * @since 1.0.0
		*/
		public function update_category_image ( $term, $taxonomy ) { ?>
			<tr class="form-field term-group-wrap">
				<th scope="row">
					<label for="category-image-id"><?php _e( 'Image' ); ?></label>
				</th>
				<td>
					<?php $image_id = get_term_meta ( $term -> term_id, 'category-image-id', true ); ?>
					<input type="hidden" id="category-image-id" name="category-image-id" value="<?php echo $image_id; ?>">
					<div id="category-image-wrapper">
						<?php if ( $image_id ) { ?>
							<?php echo wp_get_attachment_image ( $image_id, 'thumbnail' ); ?>
						<?php } ?>
					</div>
					<p>
						<input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add new image' ); ?>" />
						<input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image' ); ?>" />
					</p>
				</td>
			</tr>
			<?php
		}

		/*
		 * Update the form field value
		 * @since 1.0.0
		 */
		public function updated_category_image ( $term_id, $tt_id ) {
			if( isset( $_POST['category-image-id'] ) && '' !== $_POST['category-image-id'] ){
				$image = $_POST['category-image-id'];
				update_term_meta ( $term_id, 'category-image-id', $image );
			} else {
				update_term_meta ( $term_id, 'category-image-id', '' );
			}
		}

		/*
		 * Edit the form field
		 * @since 1.0.0
		*/
		public function update_category_video_link ( $term, $taxonomy ) { ?>
			<tr class="form-field term-group-wrap">
				<th scope="row">
					<label for="category-video-link-id"><?php _e( 'Video link' ); ?></label>
				</th>
				<td>
					<?php $video_link = get_term_meta ( $term -> term_id, 'category-video-link', true ); ?>
					<input type="text" id="category-video-link" name="category-video-link" value="<?php echo $video_link; ?>">
					<div id="category-video-link-wrapper">
						<?php if ( $video_link ) { ?>
							<?php echo $this->get_video_thumbnail ( $video_link, $term ); ?>
						<?php } ?>
					</div>
					<p>
						<input type="button" class="button button-secondary " id="category-video-link-remove" name="category-video-link-remove" value="<?php _e( 'Remove Link' ); ?>" />
					</p>
				</td>
			</tr>
			<?php
		}

		/*
		 * Update the form field value
		 * @since 1.0.0
		 */
		public function updated_category_video_link ( $term_id, $tt_id ) {
			if( isset( $_POST['category-video-link'] ) && '' !== $_POST['category-video-link'] ){
				$video_link = $_POST['category-video-link'];
				update_term_meta ( $term_id, 'category-video-link', $video_link );
			} else {
				update_term_meta ( $term_id, 'category-video-link', '' );
			}
		}

		/*
		 * Add script
		 * @since 1.0.0
		 */
		public function add_script() { ?>
			<script>
                jQuery(document).ready( function($) {
                    function ct_media_upload(button_class) {
                        var _custom_media = true,
                            _orig_send_attachment = wp.media.editor.send.attachment;
                        $('body').on('click', button_class, function(e) {
                            var button_id = '#'+$(this).attr('id');
                            var send_attachment_bkp = wp.media.editor.send.attachment;
                            var button = $(button_id);
                            _custom_media = true;
                            wp.media.editor.send.attachment = function(props, attachment){
                                if ( _custom_media ) {
                                    $('#category-image-id').val(attachment.id);
                                    $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                                    $('#category-image-wrapper .custom_media_image').attr('src',attachment.sizes.thumbnail.url).css('display','block');
                                } else {
                                    return _orig_send_attachment.apply( button_id, [props, attachment] );
                                }
                            }
                            wp.media.editor.open(button);
                            return false;
                        });
                    }
                    ct_media_upload('.ct_tax_media_button.button');
                    $('body').on('click','.ct_tax_media_remove',function(){
                        $('#category-image-id').val('');
                        $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                    });

                    $('body').on('click','#category-video-link-remove',function(){
                        $('#category-video-link').val('');
                        $('#category-video-link-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                    });

                    $(document).ajaxComplete(function(event, xhr, settings) {
                        var queryStringArr = settings.data.split('&');
                        if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
                            var xml = xhr.responseXML;
                            $response = $(xml).find('term_id').text();
                            if($response!=""){
                                // Clear the thumb image
                                $('#category-image-wrapper').html('');
                            }
                        }
                    });
                });
			</script>
		<?php }

		public function get_video_thumbnail ( $video_url, $term )
		{
			if ( $video_url ) { // if there is a video URL
				$url = $video_url;
				preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
				if ( $matches[1] ) {
					$youtubeThumb = "http://img.youtube.com/vi/{$matches[1]}/mqdefault.jpg";
					echo '<img src="' . $youtubeThumb . '">';
				}
				else {
					$vimeoId = (int) substr(parse_url($url, PHP_URL_PATH), 1);
					$vimeoThumb = unserialize(file_get_contents("http://vimeo.com/api/v2/video/{$vimeoId}.php"))[0]['thumbnail_medium'];
					echo '<img src="'  . $vimeoThumb . '">';
				}
			}
		}

	}

}