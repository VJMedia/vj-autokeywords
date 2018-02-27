<?php
/*
Plugin Name: VJMedia: AutoKeywords
Description: Auto Convert existing Tags to post Keywords
Version: 1.0
Author: <a href="http://www.vjmedia.com.hk">Technical Team</a>
GitHub Plugin URI: https://github.com/VJMedia/vj-autokeywords
*/

require_once("tagaction.inc.php");

function vjautokey_metabox_add() { 
	$screens = array( 'post' );
	foreach ( $screens as $screen ) {
		add_meta_box("vjautokey","AutoKeywords Preview",'vjautokey_metabox_render',$screen);
	}
}
add_action( 'add_meta_boxes', 'vjautokey_metabox_add' );

function vjautokey_getalltag(){
	if(! function_exists("sortbylen")){
		function sortbylen($a,$b){
			return strlen($b)-strlen($a);
		}
	}
	$alltag=get_terms("post_tag",array( 'fields'=> 'names','hide_empty'=>false));
	usort($alltag,'sortbylen');
	return $alltag;
}

function vjautokey_metabox_render( $post ) {
	if(! $post->post_content && ! $post->post_title){ echo "Save the post first"; return; }
	
	echo "<style>#vjautokey b{ color: red;}</style>";
	$alltag=vjautokey_getalltag();
	$preview=strip_tags($post->post_title." ".$post->post_content);
	foreach($alltag as $tag){
		$preview=str_replace($tag,"<b>{$tag}</b>",$preview);
	}
	echo $preview;
}


function vjautokey_update( $post_id ) { 
	$alltag=vjautokey_getalltag();
	$content_post = get_post($post_id);
	$post_content = strip_tags($content_post->post_title." ".$content_post->post_content);
	$keywords=array(); foreach($alltag as $tag){
		if(mb_strpos($post_content,$tag) !== false){
			$keywords[]=$tag;
		}
	}
	update_post_meta($post_id,"_aioseop_keywords",implode(",",$keywords));

}
add_action( 'save_post', 'vjautokey_update',99);
