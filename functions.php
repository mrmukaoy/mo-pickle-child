<?php

function mopickle_child_setup() {
	// Enqueue the editor styles.
	wp_enqueue_style( 'mopickle-editor-styles', get_theme_file_uri( '_assets/css/editor-style.css' ), array() );

}
add_action( 'enqueue_block_editor_assets', 'mopickle_child_setup', 1, 1 );


function mopickle_child_enqueue_style() {
	$this_theme = wp_get_theme();
	$this_version = $this_theme->get( 'Version' );

	wp_enqueue_style( 'childstyle', get_stylesheet_directory_uri() . '/style.css', array(), $this_version );
}
add_action( 'wp_enqueue_scripts', 'mopickle_child_enqueue_style', 11);


/* Disable 'full screen' editing as the default */
if ( is_admin() ) {
	function amm_disable_editor_fullscreen_as_default() {
		$script = "window.onload = function() {
			const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' );
			if ( isFullscreenMode ) {
				wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' );
			}
		}";
		wp_add_inline_script( 'wp-blocks', $script );
	}
	add_action( 'enqueue_block_editor_assets', 'amm_disable_editor_fullscreen_as_default' );
}
