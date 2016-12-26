<?php
add_action( 'add_tag_form_fields', 'tag_form_custom_field_add', 10 );
add_action( 'edit_tag_form_fields', 'tag_form_custom_field_edit', 10, 2 );
add_action( 'created_tag', 'tag_form_custom_field_save', 10, 2 );    
add_action( 'edited_tag', 'tag_form_custom_field_save', 10, 2 );

function tag_form_custom_field_add( $taxonomy ) {
?>
<div class="form-field">
  <label for="tag_custom_noautokey">不要用作自動關鍵字</label>
  <input name="tag_custom_noautokey" id="tag_custom_noautokey" type="checkbox" value="1" />
  <p class="description">選取者將不會用作自動關鍵字</p>
</div>
<?php
}
 
function tag_form_custom_field_edit( $tag, $taxonomy ) {
    $option_name = 'tag_custom_noautokey_' . $tag->term_id;
    $tag_custom_noautokey = get_option( $option_name );
?>
<tr class="form-field">
  <th scope="row" valign="top"><label for="tag_custom_noautokey">不要用作自動關鍵字</label></th>
  <td>
    <input type="checkbox" name="tag_custom_noautokey" id="tag_custom_noautokey" value="1"<?php if($tag_custom_noautokey){ ?> checked<?php } ?> />
    <p class="description">選取者將不會用作自動關鍵字</p>
  </td>
</tr>
<?php
}
 
function tag_form_custom_field_save( $term_id, $tt_id ) {
    if ( isset( $_POST['tag_custom_noautokey'] ) ) {            
        $option_name = 'tag_custom_noautokey_' . $term_id;
        update_option( $option_name, $_POST['tag_custom_noautokey'] ? 1 : 0 );
    }
}
?>