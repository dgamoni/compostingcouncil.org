<?php
/*
 add extra fields while writing your post content - with inputs, textareas, etc
*/

add_action('init', 'publications_init');

function publications_init()
{

    $args = array(
        'label' => __('Publications'),
        'labels' => array(
            'edit_item' => __('Edit Publications'),
            'add_new_item' => __('Add New'),
            'view_item' => __('View Publications'),

            'search_items' => __('Search Publications'),
            'not_found' => __('No Publications found'),
            'not_found_in_trash' => __('No Publications found in Trash'),
            'parent' => __('Parent Publications'),

        ),
        'singular_label' => __('Publications'),
        'public' => true,
        'show_ui' => true, // show in admin
        '_builtin' => false,
        '_edit_link' => 'post.php?post=%d',
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array("slug" => "publications"), // links
        'supports' => array('thumbnail')
    );

    register_post_type('publications', $args);

    register_taxonomy(
        'publications_category',
        'publications',
        array('hierarchical' => false, 'label' => __('Categories'),
             'singular_label' => __('Categories'))
    );
}

add_action("admin_init", 'publications_admin_init');

function publications_admin_init()
{
    remove_meta_box('submitdiv', 'publications', 'normal');
    remove_meta_box('tagsdiv-publications_category', 'publications', 'normal');
}

add_action('add_meta_boxes_publications', 'publications_boxes_setup');

function publications_boxes_setup()
{
    wp_enqueue_script('editor');
    wp_enqueue_script('datepicker', get_bloginfo('template_directory') . '/js/ui.datepicker.min.js', array('jquery-ui-core'), '1.7.3');
    wp_enqueue_style('jquery-ui-lightness', get_bloginfo('template_directory') . '/js/' . JQUERY_UI_THEME . '/jquery-ui-1.7.3.custom.css');
    add_action('edit_form_advanced', 'publications_form', 1);
    add_action('post_edit_form_tag', 'publications_form_enctype');
}

function publications_form_enctype()
{
    echo ' enctype="multipart/form-data" ';
}


function publications_form()
{
    global $post;

    echo __("<p>Please fill out the form below to add a new item. Mandatory fields are marked (<span class='file-error'>*</span>)</p>");

    $post_type_object = get_post_type_object($post->post_type);

    $member = get_post_meta($post->ID, 'member', true);
    $non_member = get_post_meta($post->ID, 'non_member', true);
    $no_shipping = get_post_meta($post->ID, 'no_shipping', true);

    $purchase_receipt=get_post_meta($post->ID, 'purchase_receipt',true);

    //    print_r($post);
    //    echo $no_shipping;
    //    echo 'ssssssssssssssssssssssssssssssssssssssssssssss';

    $cats = get_terms('publications_category', 'hide_empty=0');
    $post_cats = wp_get_object_terms($post->ID, 'publications_category');
    $post_cats_id = array();
    if (!empty($post_cats)) {
        foreach ($post_cats as $c) $post_cats_id[$c->term_id] = true;
    }

    ?>
<div id="submitdiv"></div><!-- need for JS on posts data and submit -->
<table class="form-table">
    <tr>
        <td>&nbsp;
            <label for="post_status">
                <span>Display</span>
            </label>
        </td>
        <td>
            <select name='post_status' id='post_status' tabindex='4'>
                <option<?php selected($post->post_status, 'publish'); ?>
                        value='publish'><?php _e('Published') ?></option>
                <?php if ('private' == $post->post_status) : ?>
                <option<?php selected($post->post_status, 'private'); ?>
                        value='publish'><?php _e('Privately Published') ?></option>
                <?php elseif ('future' == $post->post_status) : ?>
                <option<?php selected($post->post_status, 'future'); ?> value='future'><?php _e('Scheduled') ?></option>
                <?php endif; ?>
                <option<?php selected($post->post_status, 'pending'); ?>
                        value='pending'><?php _e('Pending Review') ?></option>
                <?php if ('auto-draft' == $post->post_status) : ?>
                <option<?php selected($post->post_status, 'auto-draft'); ?> value='draft'><?php _e('Draft') ?></option>
                <?php else : ?>
                <option<?php selected($post->post_status, 'draft'); ?> value='draft'><?php _e('Draft') ?></option>
                <?php endif; ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><span class='file-error'>*</span>
            <label for="category">
                <span>Category</span>
            </label>
        </td>
        <td>
            <select name="category" id="category">
                <?php
                                foreach ($cats as $c) {
                echo "<option id='{$c->name}'" . selected(isset($post_cats_id[$c->term_id]), true, false) . " >{$c->name}</option>";
            }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><span class='file-error'>*</span>
            <label for="title">
                <span>Title</span>
            </label>
        </td>
        <td>
            <input type="text" name="post_title" size="80" tabindex="1"
                   value="<?php echo esc_attr(htmlspecialchars($post->post_title)); ?>" id="title" autocomplete="off"/>
        </td>
    </tr>
    <tr>
        <td><span class='file-error'>*</span>
            <label for="content">
                <span>Summary</span>
            </label>
        </td>
        <td>
            <?php the_editor($post->post_content, 'content', 'title', false);  ?>
        </td>
    </tr>
    <tr>
        <td><span class='file-error'>*</span>
            <label for="member">
                <span>Member Price</span>
            </label>
        </td>
        <td>$
            <input type="text" name="member" size="20" tabindex="1"
                   value="<?php echo esc_attr(htmlspecialchars($member)); ?>" id="member" autocomplete="off"/>
        </td>
    </tr>
    <tr>
        <td><span class='file-error'>*</span>
            <label for="non_member">
                <span>Non-Member Price</span>
            </label>
        </td>
        <td>$
            <input type="text" name="non_member" size="20" tabindex="1"
                   value="<?php echo esc_attr(htmlspecialchars($non_member)); ?>" id="non_member" autocomplete="off"/>
        </td>
    </tr>

    <tr>
		<td><span class='file-error'>*</span>
			<label for="non_member">
				<span>Purchase Receipt</span>
			</label>
		</td>
		<td>
            <textarea style="width: 300px; height: 200px;" rows="" cols="" name="purchase_receipt"><?php echo esc_attr( htmlspecialchars( $purchase_receipt ) ); ?></textarea>
		</td>
	</tr>

    <tr>
        <td>
            <input id='add_form_no_shipping' type='checkbox' name='no_shipping'
                   value='yes' <?php echo (($no_shipping == 1) ? 'checked="checked"' : '');?> />&nbsp;<label
                for='add_form_no_shipping'>Disregard Shipping for this product</label>
        </td>
    </tr>




                <?php

    $args = array(
        'post_type' => 'attachment',
        'numberposts' => -1,
        'post_status' => null,
        'post_parent' => $post->ID
    );
    $attachments = get_posts($args);
    if ($attachments) {
        echo "<tr><td></td><td>";
        foreach ($attachments as $attachment) {
            echo "<div class='alignleft' style='margin:10px'><div class='alignleft'>";
            the_attachment_link($attachment->ID, false);
            echo "</div><span class='clear alignleft'>{$attachment->post_content}</span>";
            echo "<a href='" . wp_nonce_url("post.php?action=delete&amp;post={$attachment->ID}", 'delete-attachment_' . $attachment->ID) . "' id='delete-{$attachment->ID}' class='delbutton clear alignleft button'>" . __('Delete') . "</a>";
            echo "</div>";
        }
        echo "</td></tr>";
        ?>
        <script type="text/javascript">
            //<![CDATA[
            (function($) {
                $(document).ready(function() {
                    $('.delbutton').click(function() {
                        $.post($(this).attr('href'));
                        $(this).parent().hide();
                        return false;
                    })

                });
            })(jQuery);

            //]]>
        </script>

        <?php

    }

    ?>
    <tr>
        <td>
            <label for="userfile">
                <span>File Upload</span>
            </label>
        </td>
        <td>
            <input type="file" name="userfile" size="80" id="userfile"/>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <?php if (!in_array($post->post_status, array('publish', 'future', 'private')) || 0 == $post->ID) : ?>
            <input type="submit" name="save" id="save-post" class="button-primary" tabindex="5" accesskey="p"
                   value="<?php esc_attr_e('Add Item') ?>"/>
            <?php else: ?>
            <input type="submit" name="save" id="save-post" class="button-primary" tabindex="5" accesskey="p"
                   value="<?php esc_attr_e('Update Item') ?>"/>
            <?php endif; ?>

            <a href="/admin/wp-content/plugins/as-pdf/generate.php?post=<?php echo $post->ID; ?>" target="_blank">
                <img src="/admin/wp-content/themes/composting/images/icons/print.png"/>
            </a>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>

                <?php


}

function publications_print_html($post)
{

    ob_start();

    $post_type_object = get_post_type_object($post->post_type);

    $member = get_post_meta($post->ID, 'member', true);
    $non_member = get_post_meta($post->ID, 'non_member', true);

    $cats = get_terms('publications_category', 'hide_empty=0');
    $post_cats = wp_get_object_terms($post->ID, 'publications_category');
    $post_cats_id = array();
    if (!empty($post_cats)) {
        foreach ($post_cats as $c) $post_cats_id[$c->term_id] = true;
    }

    ?><br/>
<span>Category:</span> <?php
                foreach ($cats as $c) {
    echo $c->name;
}
    ?><br/>
<span>Title:</span> <?php echo esc_attr(htmlspecialchars($post->post_title)); ?><br/>
<span>Summary:</span> <br/><?php echo esc_attr(htmlspecialchars($post->post_content)); ?><br/>
<span>Member Price:</span> <?php echo esc_attr(htmlspecialchars($member)); ?><br/>
<span>Non-Member Price:</span> <?php echo esc_attr(htmlspecialchars($non_member)); ?><br/>
                       <?php

    $args = array(
        'post_type' => 'attachment',
        'numberposts' => -1,
        'post_status' => null,
        'post_parent' => $post->ID
    );
    $attachments = get_posts($args);
    if ($attachments) {
        foreach ($attachments as $attachment) {
            the_attachment_link($attachment->ID, false);
            echo "<span class='clear alignleft'>{$attachment->post_content}</span><br/>";
        }
    }

    $ret = ob_get_contents();
    ob_end_clean();

    return $ret;
}

add_action('save_post', 'publications_save', 1);

function publications_save()
{
    global $post;

    if ($post->post_type != 'publications') return;

    if (isset($_POST['member'])) {
        update_post_meta($post->ID, 'member', esc_attr($_POST['member']));
    }

    if (isset($_POST['non_member'])) {
        update_post_meta($post->ID, 'non_member', esc_attr($_POST['non_member']));
    }

     if (isset($_POST['purchase_receipt'])) {
        update_post_meta($post->ID, 'purchase_receipt', esc_attr($_POST['purchase_receipt']));
    }

    if (isset($_POST['category'])) {
        wp_set_object_terms($post->ID, esc_attr($_POST['category']), 'publications_category');
    }


    if (!empty($_FILES)) {
        // add_filter('wp_read_image_metadata','publications_save_file_description');
        // Upload File button was clicked
        $id = media_handle_upload('userfile', $post->ID);
        //unset($_FILES);
        if (is_wp_error($id)) {
            $errors['upload_error'] = $id;
            $id = false;
        }
    }

    // WP e-Commerce integration
    if (function_exists('wpsc_insert_product')) {

        //        print_r($_POST);
        //        die;
        $no_shipping = 0;
        if (isset($_POST['no_shipping']) && $_POST['no_shipping'] == 'yes') {
            $no_shipping = 1;
        }
        update_post_meta($post->ID, 'no_shipping', $no_shipping);

        //        echo  $no_shipping;
        //        die;

        $post_data = array(
            'name' => $post->post_title,
            'description' => $post->post_content,


            'notax' => 1,
            'publish' => 1,
            'active' => 1,
            'no_shipping' => $no_shipping,


        );


        if (isset($_POST['member'])) {
            $post_data['price'] = (float)get_post_meta($post->ID, 'member', true);
            if ($product_id = get_post_meta($post->ID, 'memeber_product_id', true)) {
                $post_data['product_id'] = $product_id;
            }
            update_post_meta($post->ID, 'memeber_product_id', wpsc_insert_product($post_data));
        }

        if (isset($_POST['non_member'])) {
            $post_data['price'] = (float)get_post_meta($post->ID, 'non_member', true);
            if ($product_id = get_post_meta($post->ID, 'non_memeber_product_id', true)) {
                $post_data['product_id'] = $product_id;
            }
            update_post_meta($post->ID, 'non_memeber_product_id', wpsc_insert_product($post_data));
        }
    }
}

add_filter('manage_edit-publications_columns', 'manage_edit_publications_columns');

function manage_edit_publications_columns($headers)
{

    unset($headers['date']);
    unset($headers['author']);
    $headers['title'] = 'Title';
    $headers['role'] = 'Member';
    $headers['response'] = 'Non-Member';
    $headers['rel'] = 'Category';
    return $headers;
}

add_action('manage_posts_custom_column', 'manage_posts_publications_column', 1);

function manage_posts_publications_column($cname)
{
    global $post;

    if ($post->post_type != 'publications') return;

    switch ($cname) {
        case 'rel':
            $tags = get_the_terms($id, 'publications_category');
            if (!empty($tags)) {
                $out = array();
                foreach ($tags as $c)
                    $out[] = esc_html(sanitize_term_field('name', $c->name, $c->term_id, 'publications_category', 'display'));
                echo join(', ', $out);
            } else {
                _e('No Tags');
            }
            break;
        case 'role':
            $type = get_post_meta($post->ID, 'member', true);
            echo '$' . $type;
            break;
        case 'response':
            $type = get_post_meta($post->ID, 'non_member', true);
            echo '$' . $type;
            break;

    }
}
