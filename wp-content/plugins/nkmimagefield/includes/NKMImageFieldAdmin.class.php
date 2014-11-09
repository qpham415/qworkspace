<?php

class NKMImageFieldAdmin {
	var $version = '0.6';
	var $fields = array();
	var $field_table_name;
	var $value_table_name;
	var $messages = array();
	var $edit_error;
	var $other_error;
	
	
	
	function NKMImageFieldAdmin() {
		global $wpdb;
		$this->field_table_name = $wpdb->prefix . 'nkm_imagefields';
		$this->value_table_name = $wpdb->prefix . 'nkm_imagevals';
		register_activation_hook(dirname(dirname(__FILE__)) . '/nkm-imagefield.php', array(&$this, 'activate_me'));
	}
	
	
	
	function add_admin_page() {
		wp_enqueue_script('admin-forms');
		add_options_page('Custom Image Fields', 'Custom Image Fields', 'manage_options', __FILE__, array(&$this, 'display_options_page'));
	}
	
	
	
	public function activate_me() {
		global $wpdb;
				
		if($wpdb->get_var("SHOW TABLES LIKE '$this->field_table_name'") != $this->field_table_name) {
			$sql = "CREATE TABLE $this->field_table_name (
							field_id INT NOT NULL AUTO_INCREMENT  PRIMARY KEY ,
							field_name VARCHAR( 32 ) NOT NULL ,
							field_description VARCHAR( 255 ) NOT NULL ,
							KEY ( field_name )
							);";
			$wpdb->query($sql);
		}
		if($wpdb->get_var("SHOW TABLES LIKE '$this->value_table_name'") != $this->value_table_name) {
			$sql = "CREATE TABLE $this->value_table_name (
							field_id INT NOT NULL ,
							post_id INT NOT NULL ,
							value VARCHAR( 255 ) NOT NULL ,
							UNIQUE KEY ( field_id , post_id )
							);";
			$wpdb->query($sql);
		}
		update_option('nkm_imagefield_version', $this->version);
	}



	function process_edit_field_form() {
		$id = intval($_POST['nkmfield']);		
		return $this->process_new_field_form($id); 
		
	}



	function process_new_field_form($id = NULL) {
		global $wpdb;
		
		$name = remove_accents(trim(stripslashes($_POST['new_field_name'])));
		if(strlen(preg_replace('/[a-zA-Z0-9_\-]/', '', $name))) {
			$this->messages[] = 'Error: Name may include only alphanumeric characters, dashes, and underscores.';
			$this->edit_error = TRUE;
			return;
		}
		$name = preg_replace('/[^a-zA-Z0-9_\-]/', '-', $name);
		if(!strlen(preg_replace('/[^a-zA-Z0-9]/', '', $name))) {
			$this->messages[] = 'Error: Name must include at least one alphanumeric character.';
			$this->edit_error = TRUE;
			return;
		}
		$description = trim(stripslashes($_POST['new_field_desc']));
		
		$dupes = $wpdb->get_results($wpdb->prepare("SELECT * FROM  $this->field_table_name WHERE field_name='%s' AND field_id != %d", $name, intval($id)));
		if(count($dupes)) {
			$this->messages[] = 'Cannot create duplicate field name';
			$this->edit_error = TRUE;		
			return;
		}
		
		if(!$id) {
			$sql = $wpdb->prepare("INSERT INTO $this->field_table_name (field_name, field_description) VALUES ('%s', '%s')", $name, $description);
			if($wpdb->query($sql)) {
				$this->messages[] = 'New field added successfully.';
				return;
			}
		}
		else {
			if($wpdb->query($wpdb->prepare("REPLACE INTO $this->field_table_name (field_id, field_name, field_description) VALUES (%d, '%s', '%s')", $id, $name, $description))) {
				$this->messages[] =  'Field updated successfully.';
				return;
			}			
		}
		$this->messages[] = 'Unknown error adding or editing field.';
		$this->edit_error = TRUE;
	}	
	
	
	
	function process_delete_fields() {
		global $wpdb;
		
		$to_delete = $_POST['delete_nkmfield'];
		$ids = array();
		foreach($to_delete as $id) {
			$ids[] = intval($id);
		}
		$has_fields = $wpdb->get_var("SELECT count(*) FROM $this->field_table_name WHERE field_id IN (" . join(', ', $ids) . ")");
		$has_vals = $wpdb->get_var("SELECT count(*) FROM $this->vals_table_name WHERE field_id IN (" . join(', ', $ids) . ")");
		
		if($has_fields) {
			$result = $wpdb->query("DELETE FROM $this->field_table_name WHERE field_id IN (" . join(', ', $ids) . ")");
			if(!$result) {
				$this->messages[] = 'Unknown error deleting fields';
				$this->other_error = TRUE;				
				return;
			}
					
			if($has_vals) {
				$result = $wpdb->query("DELETE FROM $this->vals_table_name WHERE field_id IN (" . join(', ', $ids) . ")");			
				if(!$result) {
					$this->messages[] = 'Fields deleted successfully, but could not delete field values from posts.';
					$this->other_error = TRUE;
					return;
				}
			} // end if has_vals
			$this->messages[] = 'Fields deleted successfully.';
		} // end if has_fields
	}
	
	
	
	function load_fields() {
		global $wpdb;
		if(count($this->fields)) { return; }
		$fields = $wpdb->get_results($wpdb->prepare("SELECT * FROM $this->field_table_name WHERE 1"), ARRAY_A);
		$this->fields = &$fields;
	}
	
	
	
	function display_options_page() { 
		$messages = array();
		$editing = FALSE;
		$field_id = NULL;
		$this->edit_error = FALSE;
		$this->other_error = FALSE;
		
		if(isset($_POST['add_field_button'])) {
			$this->process_new_field_form();
		}
		else if(isset($_POST['edit_field_button'])) {
			$this->process_edit_field_form();
			if($this->edit_error) { 
				$editing = TRUE; 
				$field_id = intval($_POST['nkmfield']);
			}
		}
		else if(isset($_POST['delete_selected'])) {
			$this->process_delete_fields();
		}
		else if($_GET['mode'] == 'edit') {
			$field_id = intval($_GET['nkmfield']);
			$editing = TRUE;
		}
		
		?>
		<div class="wrap">
			<?php if(count($this->messages)) { ?>
				<br class="clear" />
				<div class="<?php if($this->edit_error || $this->other_error) { echo ' error'; } else { echo 'updated fade'; } ?>" id="message">
					<?php foreach($this->messages as $message) { ?><p><?php echo $message; ?></p><?php } ?>
				</div>
			<?php }
						if(!$editing && !$this->edit_error) {  $this->admin_field_list();	} // endif 
						$this->edit_field_form($editing, $this->edit_error, $field_id); 
			?></div><?php 	
	} // end display_options_page
	
	
	
	
	
	function admin_field_list() { 
		global $wpdb;
		
		$this->load_fields();
		if(count($this->fields)) {
	?>	
			<h2>Manage Custom Image Fields (<a href="#add">add new</a>)</h2>
			<form action="" method="post">
				<div class="tablenav">
					<div class="alignleft">
						<input class="button-secondary delete" type="submit" name="delete_selected" value="Delete" />
					</div>
					<br class="clear" />
				</div>
				<br class="clear" />
				<table class="widefat">
					<thead>
						<tr>
							<th scope="col" class="check-column"><input type="checkbox" /></th>
							<th scope="col">ID</th>
							<th scope="col">Field Name</th>
							<th scope="col">Description</th>
							<th scope="col">Edit</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($this->fields as $field) { ?>
						<tr>
							<td class="check-column"><input type="checkbox" name="delete_nkmfield[]" value="<?php echo $field['field_id']; ?>" /></td>
							<td><?php echo $field['field_id']; ?></td>
							<td><?php echo $field['field_name']; ?></td>
							<td><?php echo $field['field_description']; ?></td>
							<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>&mode=edit&amp;nkmfield=<?php echo $field['field_id']; ?>">Edit</a></td>
						</tr>
					<?php	} // endfor ?>
					</tbody>
				</table>
				<p><strong>Note:</strong><br />Deleting a field will also delete values for that field for all posts and pages.</p>
			</form><?php	
		} // endif
	} // end admin_field_list()
	
	
	
	
	function edit_field_form($editing = FALSE, $is_error = FALSE, $field_id = NULL) {		
		$name = NULL;
		$desc = NULL;
		$field = NULL;
		$loaded = FALSE;
		
		if($editing && $field_id && !$is_error) {
			$this->load_fields();
			foreach($this->fields as $afield) {
				if($afield['field_id'] == $field_id) {
					$field = &$afield;
					break;
				}
			}
			if(is_array($field)) {
				$name = htmlspecialchars($field['field_name']);
				$desc = htmlspecialchars($field['field_description']);
				$loaded = TRUE;
			}
		}
		if($is_error || (!$loaded && $editing)) {
			$name = htmlspecialchars(stripslashes($_POST['new_field_name']));
			$desc = htmlspecialchars(stripslashes($_POST['new_field_desc']));
		}
		$this->field_form($name, $desc, $field_id);
	}
	
	
	
	
	function field_form($name, $desc, $id = NULL) {
		$mode = 'add'; 
		$title = 'Add a New Custom Image Field';
		$button = 'Add Field';
		
		if($id) {
			$mode = 'edit';
			$title = 'Edit Custom Image Field';
			$button = 'Save Changes';
		}
		?>
			<h2><a name="add"></a><?php echo $title; ?></h2>
			<form action="?page=<?php echo $_GET['page']; ?>" method="post">
				<input type="hidden" name="mode" value="<?php echo $mode; ?>" />
				<?php if($id) { ?><input type="hidden" name="nkmfield" value="<?php echo $id; ?>" /><?php } ?>
				<table class="form-table">
					<tr>
						<th scope="row"><label for="new_field_name">Field Name</label></th>
						<td>
							<input type="text" id="new_field_name" name="new_field_name" size="20" value="<?php echo $name; ?>" /><br />
							Use only alphanumeric characters, dashes, and underscores.  Name must be unique.
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="new_field_desc">Field Description (optional)</label></th>
						<td>
							<textarea type="text" id="new_field_desc" name="new_field_desc" rows="3" cols="50"><?php echo $desc; ?></textarea>					
						</td>
					</tr>
				</table>
				<p class="submit">
					<input name="<?php echo $mode; ?>_field_button" value="<?php echo $button; ?>" type="submit">
				</p>
			</form><?php
	}
	
} // end class
	
	
	
?>