<?php
public function get_themes() {
	$files = (array) $this->_scandir( plugin_dir_path( __FILE__ ) . 'reveal.js/css/theme' );

	if ( file_exists( get_stylesheet_directory() . '/presenter' ) ) {
		$files += (array) $this->_scandir( get_stylesheet_directory() . '/presenter' );
	}
	if ( is_child_theme() && file_exists( get_template_directory() . '/presenter' ) ) {
		$files += (array) $this->_scandir( get_template_directory() . '/presenter' );
	}

	$presenter_themes = $this->_cache_get( 'themes' );

	if ( ! is_array( $presenter_themes ) ) {

		foreach ( $files as $file => $full_path ) {
			// Handles the distributed themes...even though it's a lame way to do it
			if ( ! preg_match( '|([^\*]*)theme for reveal.js|mi', file_get_contents( $full_path ), $header ) ) {
				// Better way, using WordPress style headers
				if ( ! preg_match( '|Template Name:(.*)$|mi', file_get_contents( $full_path ), $header ) ) {
					continue;
				}
			} else {
				// The distributed files don't all have unique names, so add the filename
				$header[1] = _cleanup_header_comment( $header[1] ) . ' (' . basename( $full_path ) . ')';
			}

			$presenter_themes[ str_replace( WP_CONTENT_DIR, '', $full_path ) ] = _cleanup_header_comment( $header[1] );
		}

		$this->_cache_add( 'themes', $presenter_themes );
	}

	/**
	 * Filter list of Presenter themes.
	 *
	 * This filter does not currently allow for themes to be added.
	 *
	 * @param array    $presenter_themes Array of themes. Keys are filenames relative to WP_CONTENT_DIR, values are translated names.
	 * @param WP_Theme $this             The Presenter object.
	 */
	$return = apply_filters( 'presenter-themes', $presenter_themes, $this );

	$presenter_themes = array_intersect_assoc( $return, $presenter_themes );

	return $presenter_themes;
}

public function get_default_theme() {
	return apply_filters( 'presenter-default-theme', str_replace( WP_CONTENT_DIR, '', plugin_dir_path( __FILE__ ) . 'reveal.js/css/theme/league.css' ) );
}

private function _presenter_themes_dropdown_options( $selected_theme = '' ) {
	$themes = $this->get_themes();
	asort( $themes );

	foreach ( $themes as $theme => $name ) {
		$selected = selected( $selected_theme, $theme, false );
		printf( '<option value="%1$s"%2$s>%3$s</option>', esc_attr( $theme ), $selected, esc_html( $name ) );
	}
}

	/**
	 * Adds theme data to cache.
	 *
	 * @access private
	 *
	 * @param string $key Name of data to store
	 * @param string $data Data to store
	 * @return bool Return value from wp_cache_add()
	 */
private function _cache_add( $key, $data ) {
	return wp_cache_add( 'presenter-' . $key, $data, 'presenter', 1800 );
}

	/**
	 * Gets data from cache.
	 *
	 * @access private
	 *
	 * @param string $key Name of data to retrieve
	 * @return mixed Retrieved data
	 */
private function _cache_get( $key ) {
	return wp_cache_get( 'presenter-' . $key, 'presenter' );
}

	/**
	 * Scans a directory for files of a certain extension.
	 *
	 * @access private
	 *
	 * @param string                                                                                       $path Absolute path to search.
	 * @param mixed  Array of extensions to find, string of a single extension, or null for all extensions.
	 * @param int                                                                                          $depth How deep to search for files. Optional, defaults to 1 (specified directory and all directories in it). 0 depth is a flat scan. -1 depth is infinite.
	 * @param string                                                                                       $relative_path The basename of the absolute path. Used to control the returned path
	 *                                                                                        for the found files, particularly when this function recurses to lower depths.
	 */
private function _scandir( $path, $extensions = 'css', $depth = 1, $relative_path = '' ) {
	if ( ! is_dir( $path ) ) {
		return false;
	}

	if ( $extensions ) {
		$extensions = (array) $extensions;
		$_extensions = implode( '|', $extensions );
	}

	$relative_path = trailingslashit( $relative_path );
	if ( '/' == $relative_path ) {
		$relative_path = '';
	}

	$results = scandir( $path );
	$files = array();

	foreach ( $results as $result ) {
		if ( '.' == $result[0] ) {
			continue;
		}
		if ( is_dir( $path . '/' . $result ) ) {
			if ( ! $depth || 'CVS' == $result ) {
				continue;
			}
			$found = $this->_scandir( $path . '/' . $result, $extensions, $depth - 1, $relative_path . $result );
			$files = array_merge_recursive( $files, $found );
		} elseif ( ! $extensions || preg_match( '~\.(' . $_extensions . ')$~', $result ) ) {
			$files[ $relative_path . $result ] = $path . '/' . $result;
		}
	}

	return $files;
}

	/**
	 * Function to instantiate our class and make it a singleton
	 */
public static function get_instance() {
	if ( ! self::$instance ) {
		self::$instance = new self();
	}
	return self::$instance;
}

public function single_template( $template ) {
	if ( is_singular( 'slideshow' ) ) {
		$template = plugin_dir_path( __FILE__ ) . 'templates/index.php';

		wp_register_style( 'presenter', plugins_url( 'css/presenter.css', __FILE__ ) );
		wp_register_style( 'reveal', plugins_url( 'reveal.js/css/reveal.css', __FILE__ ), array(), '3.5.0' );
		$theme = get_post_meta( get_the_ID(), '_presenter-theme', true );
		if ( empty( $theme ) ) {
			$theme = $this->get_default_theme();
		}
		wp_register_style( 'reveal-theme', content_url( $theme ) );
		wp_register_style( 'reveal-lib-zenburn', plugins_url( 'reveal.js/lib/css/zenburn.css', __FILE__ ), array(), '3.5.0' );

		wp_register_script( 'html5shiv', plugins_url( 'reveal.js/lib/js/html5shiv.js', __FILE__ ) );
		global $wp_scripts;
		$wp_scripts->add_data( 'html5shiv', 'conditional', 'lt IE 9' );

		wp_register_script( 'reveal-head', plugins_url( 'reveal.js/lib/js/head.min.js', __FILE__ ), array(), '3.5.0', true );
		wp_register_script( 'reveal', plugins_url( 'reveal.js/js/reveal.js', __FILE__ ), array( 'reveal-head' ), '3.5.0', true );
	}
	return $template;
}
