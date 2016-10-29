<?php
function apr_swipebox_options_page() {
  ?>
		<div class="wrap">
			<?php screen_icon(); ?>
			<h2><?php _e( 'APR Swipebox Plugin', 'apr-swipebox' ); ?></h2>
			<p><?php _e( 'Settings page for the plugin', 'apr-swipebox' ); ?></p>
			<form method="POST" action="options.php">
				<?php
					settings_fields( 'apr_swipebox_settings' );
				?>
				<table class="form-table">
					<tbody>
						<?php apr_swipebox_do_options(); ?>
					</tbody>
				</table>
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'apr-swipebox' ); ?>" />
				<input type="hidden" name="apr-swipebox-submit" value="Y" />
			</form>
		</div>
<?php
}

function apr_swipebox_menu() {
	add_submenu_page( 'options-general.php', __( 'APR Swipebox', 'apr-swipebox' ), __( 'APR Swipebox Settings', 'apr-swipebox' ), 
		'administrator', 'apr_swipebox', 'apr_swipebox_options_page');
}
add_action( 'admin_menu', 'apr_swipebox_menu' );

function apr_swipebox_init(){
	register_setting( 'apr_swipebox_settings', 'apr_swipebox', 'apr_validate_input');
	  
}
add_action('admin_init', 'apr_swipebox_init');


function apr_swipebox_do_options() {
	
	$options = get_option('apr_swipebox');
	
	if (gettype($options)!='array'){
		$options=array();
	}
	
	?>
		<tr valign="top"><th scope="row"><?php _e( 'Delay before hiding bars on desktop (ms)', 'apr-swipebox' ); ?></th>
			<td>
				<?php
					if (!array_key_exists('delay_time', $options) || !isset($options['delay_time'])){
						$options['delay_time'] = 0; // will keep the bars all the time
					}
				?>
				<input type="number" id="delay_time" name="apr_swipebox[delay_time]" width="30" value="<?php echo esc_html($options['delay_time']); ?>" /><br />
				<label class="description" for="apr_swipebox[delay_time]"><?php _e( 'Note: 0 delay will keep the bars permanently', 'apr-swipebox' ); ?></label>
			</td>
		</tr>
		<tr valign="top"><th scope="row"><?php _e( 'Video max width (px)', 'apr-swipebox' ); ?></th>
			<td>
				<?php
					if (!array_key_exists('video_max_width', $options) || !isset($options['video_max_width'])){
						$options['video_max_width'] = 1140;
					}
				?>
				<input type="number" id="video_max_width" name="apr_swipebox[video_max_width]" width="30" value="<?php echo esc_html($options['video_max_width']); ?>" /><br />

			</td>
		</tr>
		<tr valign="top"><th scope="row"><?php _e('Hide "Close" button on mobile?', 'apr-swipebox');?></th>
			<td>
				<?php
					if (!array_key_exists('hide_close', $options) && !isset($options['hide_close'])){
						$options['hide_close'] = 'false';
					}
				?>
				<select name ="apr_swipebox[hide_close]">
					<option value="false" <?php echo ($options['hide_close']=='false')? 'selected':''; ?> ><?php _e('No','apr-swipebox'); ?></option>
					<option value="true" <?php echo ($options['hide_close']=='true')? 'selected':''; ?> ><?php _e('Yes','apr-swipebox'); ?></option>
				</select>
			</td>
		</tr>
		<tr valign="top"><th scope="row"><?php _e('Show top bar on mobile devices?', 'apr-swipebox');?></th>
			<td>
				<?php
					if (!array_key_exists('top_bar', $options) && !isset($options['top_bar'])){
						$options['top_bar'] = 'true';
					}
				?>
				<select name ="apr_swipebox[top_bar]">
					<option value="true" <?php echo ($options['top_bar']=='true')? 'selected':''; ?> ><?php _e('No','apr-swipebox'); ?></option>
					<option value="false" <?php echo ($options['top_bar']=='false')? 'selected':''; ?> ><?php _e('Yes','apr-swipebox'); ?></option>
				</select>
			</td>
		</tr>
<?php
}

function apr_validate_input($input){
	ob_start();
	$input['delay_time'] = (int)$input['delay_time'];
	$input['video_max_width'] = (int)$input['video_max_width'];

	$type = 'error';
    $error_message_delay = __( 'Delay before hiding bars should be greater or equal to 0', 'apr-swipebox' );
    $error_message_video = __( 'Video max width should be greater than 0', 'apr-swipebox' );

    $options = get_option('apr_swipebox');
    if (gettype($options)!='array'){
		$options=array(
			'delay_time' => 0,
			'video_max_width' => 1140
			);

	}

	if ($input['delay_time'] < 0){
		
		add_settings_error(
        'delay_error',
        esc_attr( 'settings_updated' ),
        $error_message_delay,
        $type
    );
		$input['delay_time'] = $options['delay_time'];
	}

	if ($input['video_max_width'] < 0){
		add_settings_error(
        'video_max_width_error',
        esc_attr( 'settings_updated' ),
        $error_message_video,
        $type
    );
		$input['video_max_width'] = $options['video_max_width'];
		
	}

	return $input;
	ob_end_flush();

}

