<?php

/**
 * Custom Walker to extract current sub-menu
 */

class Custom_Walker_Nav_Sub_Menu extends Walker_Nav_Menu {

  var $found_parents = array();

  function start_el(&$output, $item, $depth, $args) {
    global $wp_query;
	//echo "<pre>";print_r($item);
      $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

      $class_names = $value = '';

      $classes = empty( $item->classes ) ? array() : (array) $item->classes;

      $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
      $class_names = ' class="' . esc_attr( $class_names ) . '"';

      // Checks if the current element is in the current selection
		 if (strpos($class_names, 'current-menu-item')
		    || strpos($class_names, 'current-menu-parent')
		    || strpos($class_names, 'current-menu-ancestor')
		    || (is_array($this->found_parents) && in_array( $item->menu_item_parent, $this->found_parents )) ) {

        // Keep track of all selected parents
        $this->found_parents[] = $item->ID;

        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
      //}
      $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
  }

	function end_el(&$output, $item, $depth) {
	  // Closes only the opened li
	  if ( is_array($this->found_parents) && in_array( $item->ID, $this->found_parents ) ) {
	      $output .= "</li>\n";
    }
  }

  function end_lvl(&$output, $depth) {
    $indent = str_repeat("\t", $depth);
    // If the sub-menu is empty, strip the opening tag, else closes it
    if (substr($output, -22)=="<ul class=\"sub-menu\">\n") {
      $output = substr($output, 0, strlen($output)-23);
    } else {
      $output .= "$indent</ul>\n";
    }
  }
}

/**
 * Custom Walker to omit current sub-menu
 */

class Custom_Walker_Nav_Main_Menu extends Walker_Nav_Menu {

  var $found_parents = array();

  function start_el(&$output, $item, $depth, $args) {
    global $wp_query;

      $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

      $class_names = $value = '';

      $classes = empty( $item->classes ) ? array() : (array) $item->classes;

      $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
      $class_names = ' class="' . esc_attr( $class_names ) . '"';

      // Checks if the current element is NOT  in the current selection
      if(
      strpos($class_names, 'ancestor') !== FALSE
      ||
      strpos($class_names, 'parent') !== FALSE
      ||
      strpos($class_names, 'current-menu-item') !== FALSE
      )	 $this->found_parents[] = $item->ID;

      if($depth == 0 || (!in_array($item->ID, $this->found_parents) && !in_array($item->menu_item_parent, $this->found_parents) ) )
      {
        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
      //}
      $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
  }

	function end_el(&$output, $item, $depth) {
	  // Closes only the opened li
	  if ( is_array($this->found_parents) && in_array( $item->ID, $this->found_parents ) ) {
	      $output .= "</li>\n";
    }
  }

  function end_lvl(&$output, $depth) {
    $indent = str_repeat("\t", $depth);
    // If the sub-menu is empty, strip the opening tag, else closes it
    if (substr($output, -22)=="<ul class=\"sub-menu\">\n") {
      $output = substr($output, 0, strlen($output)-23);
    } else {
      $output .= "$indent</ul>\n";
    }
  }
}