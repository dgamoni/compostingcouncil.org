<?php
/*
 add extra fields while writing your post content - with inputs, textareas, etc
*/


$key = "key";
$meta_boxes = array(
	"input" => array(
	  "name" => "input", 
	  "title" => "Input Field",  
	  "description" => "This is an example for a regular input field.",
	  "type" => "text",
	  "class" => "text",
	  "rows" => "",
	  "width" => "100%",
	  "options" => ""
	), 	  
	"textarea" => array(
	  "name" => "textarea", 
	  "title" => "Textarea Field",  
	  "description" => "This is an example for a textarea field.",
	  "type" => "textarea",
	  "class" => "textarea",
	  "rows" => "6",
	  "width" => "100%",
	  "options" => ""
	),	  
	"checkbox" => array(
	  "name" => "checkbox", 
	  "title" => "Checkbox Field", 
	  "description" => "This is an example of a checkbox field.",
	  "type" => "checkbox",
	  "class" => "checkbox",
	  "rows" => "",
	  "width" => "",
	  "options" => array("1" => "checkbox 1", 
	  					 "2" => "checkbox 2", 
	  					 "3" => "checkbox 3", 
	  					 "4" => "checkbox 4", 
	  					 "5" => "checkbox 5", 
	  					 "6" => "checkbox 6")
	),	  
	"radio" => array(
	  "name" => "radio",  
	  "title" => "Radio Field",  
	  "description" => "This is an example of a radio field.",
	  "type" => "radio",
	  "class" => "radio",
	  "rows" => "",
	  "width" => "",
	  "options" => array("1" => "radio 1", 
	  					 "2" => "radio 2", 
	  					 "3" => "radio 3", 
	  					 "4" => "radio 4")
	),	  
	"dropdown" => array(
	  "name" => "dropdown",   
	  "title" => "Dropdown Selection",  
	  "description" => "This is an example of a dropdown field.",
	  "type" => "dropdown",
	  "class" => "dropdown",
	  "rows" => "",
	  "width" => "",
	  "options" => array("1" => "option 1", 
	  					 "2" => "option 2", 
	  					 "3" => "option 3")
	),  
	"checkbox2" => array(
	  "name" => "checkbox2", 
	  "title" => "Checkbox Field",  
	  "description" => "This is an example of a secondary checkbox field.",
	  "type" => "checkbox",
	  "class" => "checkbox",
	  "rows" => "",
	  "width" => "",
	  "options" => array("1" => "yes")
	)
);

function create_meta_box() {
global $key;

if( function_exists( 'add_meta_box' ) ) {
add_meta_box( 'new-meta-boxes', ucfirst( $key ) . ' Custom Post Options', 'display_meta_box', 'news', 'normal', 'high' );
}
}

function display_meta_box() {
global $post, $meta_boxes, $key;
?>

<div class="form-wrap">

<?php
wp_nonce_field( plugin_basename( __FILE__ ), $key . '_wpnonce', false, true );

$output = '';
foreach($meta_boxes as $meta_box) { 
    $data = get_post_meta($post->ID, $key, true);     
	 
	$output .= '<p style="font-size:1.1em; font-style:normal;">' . $meta_box['title'] . '<br />' . "\n"; 
	$output .= $meta_box['description'] . '<br />' . "\n";

	if($meta_box['type'] == 'text') { // plain text input 
  	  $output .= '<input type="text" name="' . $meta_box['name'] . '" value="' . $data[$meta_box['name']] . '" style="width:' . $meta_box['width'] . ';" />';     
	} 
	
	else if($meta_box['type'] == 'textarea') { // textarea box
  	  $output .= '<textarea name="' . $meta_box['name'] . '" style="width:' . $meta_box['width'] . '; height:100px;">' . $data[$meta_box['name']] . '</textarea>'; 
  	} 
	
	else if(($meta_box['type'] == 'checkbox') && (!empty($meta_box['options']))) { // checkboxes
		  foreach($meta_box['options'] as $checkbox_value) { 
		     if($data[$meta_box['name']] != "") { // if array is empty, warnings will be issued, this circumvents it  
	    		$output .= '<input type="checkbox" name="' . $meta_box['name'] . '[]" value="' . $checkbox_value . '" ' . (isset($data[$meta_box['name']]) && (in_array($checkbox_value, $data[$meta_box['name']])) ? ' checked="checked"' : '') . '/> ' . $checkbox_value . ' &nbsp; ' . "\n";	
		     } else {  
	    		$output .= '<input type="checkbox" name="' . $meta_box['name'] . '[]" value="' . $checkbox_value . '"/> ' . $checkbox_value . ' &nbsp; ' . "\n";	
		     }
		  }		  			
	} 
	
	else if(($meta_box['type'] == 'radio') && (!empty($meta_box['options']))) { // radio buttons
				
		  foreach($meta_box['options'] as $radio_value) {
	    		$output .= '<input type="radio" name="' . $meta_box['name'] . '" value="' . $radio_value . '" ' . (isset($data[$meta_box['name']]) && ($data[$meta_box['name']] == $radio_value) ? ' checked="checked"' : '') . '/> ' . $radio_value . ' &nbsp; ' . "\n";	
		  }		  	
	} 
	
	else if(($meta_box['type'] == 'dropdown') && (!empty($meta_box['options']))) { // dropdown lists
			
		$output .= '<select name="' . $meta_box['name'] . '">' . "\n";
		if (isset($data[$meta_box['name']])) {
		  	$output .= '<option selected>'. $data[$meta_box['name']] .'</option>' . "\n";	
		}
			
		$output .= '<option value="">----------------</option>' . "\n";		
		foreach($meta_box['options'] as $dropdown_key => $dropdown_value) {
	    	$output .= '<option value="' . $dropdown_value . '">' . $dropdown_value . '</option>' . "\n";
		}
		  	
		$output .= '</select>' . "\n";		  	
	}
	
	$output .= "</p>\n\n";
  } 
  
  echo '<div>' . "\n" . $output . "\n" . '</div>' . "\n\n";

}

function save_meta_box( $post_id ) {
global $post, $meta_boxes, $key;

foreach( $meta_boxes as $meta_box ) {
$data[ $meta_box[ 'name' ] ] = $_POST[ $meta_box[ 'name' ] ];
}

if ( !wp_verify_nonce( $_POST[ $key . '_wpnonce' ], plugin_basename(__FILE__) ) )
return $post_id;

if ( !current_user_can( 'edit_post', $post_id ))
return $post_id;

update_post_meta( $post_id, $key, $data );
}

add_action( 'admin_menu', 'create_meta_box' );
add_action( 'save_post', 'save_meta_box' );