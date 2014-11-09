<?php

if(!function_exists('mydump')) {
	function mydump($var) {
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}
}

if(!class_exists('NKMImageField')) {
	class NKMImageField {
		var $fields = array();
		var $controller = NULL;
		var $current_field;
		var $field_base = 'nkmfield_';
		
		function NKMImageField(&$controller) {
			$this->controller = &$controller;
		}
		
		
		
		
		function init($post_ID) {
			global $wpdb;
			
			if(count($this->fields)) { return; }
			
			$ft = $this->controller->field_table_name;
			$vt = $this->controller->value_table_name;
			$sql = $wpdb->prepare("SELECT f.field_id as field_id, f.field_description as field_desc, f.field_name as name, v.value as value
																		FROM $ft f
																		LEFT JOIN $vt v
																		ON f.field_id=v.field_id AND v.post_id = %d
																		WHERE 1", intval($post_ID));
			$fields = $wpdb->get_results($sql, ARRAY_A);
			if($fields && count($fields)) {
				$this->fields = $fields;
			}
		}
		
		
		
		function field_hook_page() {
			return $this->field_hook('page');
		}
		
		
		
		
		function field_hook_post() {
			return $this->field_hook('post');
		}
		
		
		
		
		function field_hook($type) {
			global $post_ID;
			$this->init($post_ID);
			foreach($this->fields as $field) {
				$this->current_field = &$field;
				add_meta_box('nkm-imagefielddiv-'.$field['field_id'], 'Select an Image for Field "' . $field['name'] . '"', array(&$this, 'print_field'), $type, 'normal', 'high');
			}
		}
		
		
		
		function nkm_field_js() { ?>
			<script type="text/javascript">
			/* <![CDATA[ */
			function send_to_field(fieldname, the_html) {
				//alert(the_html);
				var the_field = document.getElementById(fieldname);
				the_field.value = the_html;
				tb_remove();
			}
			/* ]]> */
			</script>
		
		<?php 
		}
		
		
		
		
		function save_for_publication($post_id) {
			$post_id = (int) $post_id;
			if(!get_post($post_id)) { return; } // if post has yet to be saved we don't want to block image attachment.
			update_option('nkm_is_future_' . $post_id, 'TRUE');
		}
		
		
		
		
		function save_custom($post_ID, $post=null) {
			global $wpdb;
			$post_id = (int) $post_ID;
			if( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) { return; }
			// if we're publishing a scheduled post, don't update b/c we'll only delete the fields accidentally
			if(get_option('nkm_is_future_' . $post_id) === 'TRUE' 
				&& (get_post_field('post_status', $post_id) == 'publish')) { 
					delete_option('nkm_is_future_' . $post_id, FALSE);
					return;
			}
			
			$this->init($post_id);
			$vt = $this->controller->value_table_name;
			
			$fields = &$this->fields;
			$vals = $_POST[$this->field_base];
			foreach($fields as $field) {
				$field_id = $field['field_id'];
				$value = stripslashes( (trim( $vals[$field['field_id']] ) ) );
				$value = $wpdb->escape(  maybe_serialize($value) );
				$sql = "REPLACE INTO $vt (post_id, field_id, value) VALUES (%d, %d, '%s')";
				$result = $wpdb->query($wpdb->prepare($sql, $post_id, $field_id, $value));
			} // end foreach $fields
		}




		function print_field($object, $box) { 
			global $post_ID, $temp_ID;
			$val = '';
						
			$field_id = str_replace('nkm-imagefielddiv-', '', $box['id']);
			
			$name = htmlspecialchars($this->field_base . '[' . $field_id . ']');
			foreach($this->fields as $field) {
				if($field['field_id'] == $field_id) {
					$val = htmlspecialchars($field['value']);
					break;
				}
			}
			
			$uploading_iframe_ID = (int) (0 == $post_ID ? $temp_ID : $post_ID);
			$media_upload_iframe_src = "media-upload.php?post_id=$uploading_iframe_ID";
			$image_upload_iframe_src = apply_filters('image_upload_iframe_src', "$media_upload_iframe_src" . "&amp;type=nkmimage&amp;nkmfield=$field_id&amp;flash=0");
			$image_title = 'Insert image into field "' . $field['name'] . '"';
		?>
			<p><input name="<?php echo $name; ?>" type="text" id="<?php echo $name; ?>" value="<?php echo $val; ?>" />
			<a href="<?php echo $image_upload_iframe_src; ?>&amp;TB_iframe=true" id="add_image" class="thickbox" title='<?php echo $image_title; ?>'><img src='images/media-button-image.gif' alt='<?php echo $image_title; ?>' /></a></p>
			<p><?php echo htmlspecialchars($field['field_desc']); ?></p>
<?php
			}
		
		
		
	
		function get_imagefields($post_id) {
			$this->init($post_id);
			return $this->fields;			
		}





		function media_upload_nkmmedia($type) {
			if(ob_start()) { /*echo 'yay'; mydump($_POST); } else { echo 'boo'; */ }
			add_filter('media_upload_tabs', 'nkm_media_upload_tabs');
			call_user_func('media_upload_' . $type);
			$ret = ob_get_clean();
			ob_end_flush();
			if (isset($_POST['nkmsend'])) {
				return $this->nkmmedia_insert_handler();
			}
			
			$field_id = urlencode(stripslashes($_GET['nkmfield']));
			$ret = str_replace('tab=gallery', 'tab=nkmgallery', $ret);
			$ret = str_replace('tab=library', 'tab=nkmlibrary', $ret);
			$ret = str_replace('tab=type', 'tab=nkmimage', $ret);
			$ret = str_replace('&#038;', '&amp;', $ret);
			$ret = preg_replace("/(nkmfield=$field_id(\&(amp;)?)?)/", '', $ret);
			$ret = str_replace('upload.php?', "upload.php?nkmfield=$field_id&", $ret);
/*			$ret = str_replace('onclick="addExtImage.insert()"', "onclick=\"win.send_to_field('$field_id', '<?php echo addslashes($html); ?>');\"", $ret);*/
			$ret = str_replace('name=\'send[', 'name=\'nkmsend[', $ret);
			echo $ret;
			//echo htmlspecialchars($ret);
			//flush();
		}
		
		
		
		function media_upload_nkmimage() {
			$this->media_upload_nkmmedia('image');
		}
		
		
		
		function media_upload_nkmgallery() {
			$this->media_upload_nkmmedia('gallery');
		}
		
		
		
		function media_upload_nkmlibrary() {
			$this->media_upload_nkmmedia('library');
		}
		
		
		
		
		function nkmmedia_insert_handler() {
			$field_name = $this->field_base . '[' . intval($_GET['nkmfield']) . ']';
			$keys = array_keys($_POST['nkmsend']);
			$send_id = (int) array_shift($keys);
//			$attachment = stripslashes_deep( $_POST['attachments'][$send_id] );
			list($html) = image_downsize($send_id, 'full');
			nkm_media_send_to_field($field_name, $html);
		}

	} // endif class does not exist
} // end class NKMImageField



function nkm_prep_imagefield($post_id=null) {
	global $post, $nkm_controller;
	if(!$post_id) { 
		$post_id = $post->ID;  
	}
	if(!$post_id) { return null; }
	$the_field = new NKMImageField($nkm_controller);
	$the_field->init($post_id);
	return $the_field;
}


function get_nkm_imagefields($post_id=null) {
	$field = nkm_prep_imagefield($post_id);
	if(!$field) { return array(); }
	return $field->fields;
}




function get_nkm_imagefield($fieldname, $post_id=null) {
	$nkm_field = nkm_prep_imagefield($post_id);
	if(!$nkm_field) { return array(); }
	foreach($nkm_field->fields as $field) {
		if($field['name'] == $fieldname) {
			return $field;
		}
	}
	return NULL;
}




function get_nkm_imageurl($fieldname, $post_id=null) {
	$nkm_field = nkm_prep_imagefield($post_id);
	if(!$nkm_field) { return ''; }
	foreach($nkm_field->fields as $field) {
		if($field['name'] == $fieldname) {
			return $field['value'];
		}
	}
	return '';
}




function nkm_media_upload_tabs() {
	return array(
		'type' => __('Choose File'), // handler action suffix => tab text
		'nkmgallery' => __('Gallery'),
		'nkmlibrary' => __('Media Library'),
	);
}




function nkm_media_send_to_field($field_name, $html) {	?>
	<script type="text/javascript">
	/* <![CDATA[ */
	
	var win = window.dialogArguments || opener || parent || top;
	//alert('hi');
	win.send_to_field('<?php echo $field_name; ?>', '<?php echo addslashes($html); ?>');
	/* ]]> */
	</script>
<?php
	exit;
}

?>