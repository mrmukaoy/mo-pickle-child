<?php

function mopickle_child_setup() {
	// Disable Custom Colors
	// add_theme_support( 'disable-custom-colors' );
	add_theme_support( 'disable-custom-gradients' );

	// Editor Color Palette
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => __( 'Blue', 'mopickle' ),
			'slug'  => 'mopickle-blue',
			'color' => '#143079',
		),
		array(
			'name'  => __( 'Light Blue', 'mopickle' ),
			'slug'  => 'mopickle-lightblue',
			'color' => '#0181ec',
		),
		array(
			'name'  => __( 'Dark Blue', 'mopickle' ),
			'slug'  => 'mopickle-darkblue',
			'color' => '#112a49',
		),
		array(
			'name'  => __( 'Green', 'mopickle' ),
			'slug'  => 'mopickle-green',
			'color' => '#007a4b',
		),
		array(
			'name'  => __( 'Lime', 'mopickle' ),
			'slug'  => 'mopickle-lime',
			'color' => '#d0f102',
		),
		array(
			'name'  => __( 'Orange', 'mopickle' ),
			'slug'  => 'mopickle-orange',
			'color' => '#ff730a',
		),
	) );
}
add_action( 'after_setup_theme', 'mopickle_child_setup' );


function mopickle_child_editor_setup() {
	// Enqueue the editor styles.
	wp_enqueue_style( 'mopickle-editor-styles', get_theme_file_uri( '_assets/css/editor-style.css' ), array() );
}
// add_action( 'enqueue_block_editor_assets', 'mopickle_child_editor_setup', 1, 1 );


function mopickle_child_enqueue_style() {
	$this_theme = wp_get_theme();
	$this_version = $this_theme->get( 'Version' );

	wp_enqueue_style( 'childstyle', get_stylesheet_directory_uri() . '/style.css', array(), $this_version );
}
add_action( 'wp_enqueue_scripts', 'mopickle_child_enqueue_style', 11);


/* Extra widgets */
function mopickle_sidebar_registration() {

	// Arguments used in all register_sidebar() calls.
	$shared_args = array(
		'before_title'  => '<h2 class="widget-title subheading heading-size-3">',
		'after_title'   => '</h2>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div></div>',
	);

	// Footer Centered.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Footer Center', 'mopickle' ),
				'id'          => 'sidebar-center',
				'description' => __( 'Widgets in this area will be displayed in the center column in the footer. <strong>Only if no widgets exist in sidebars 1 & 2.</strong>', 'mopickle' ),
			)
		)
	);

	// Footer Sub-footer.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Sub-Footer', 'mopickle' ),
				'id'          => 'sidebar-subfoot',
				'description' => __( 'Widgets in this area will be displayed in the bottom section of the footer.', 'mopickle' ),
			)
		)
	);

}
add_action( 'widgets_init', 'mopickle_sidebar_registration' );

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
