<?php
/**
 * Twenty Twenty-Five functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

// Adds theme support for post formats.
if ( ! function_exists( 'twentytwentyfive_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'twentytwentyfive_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_editor_style() {
		add_editor_style( get_parent_theme_file_uri( 'assets/css/editor-style.css' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_editor_style' );

// Enqueues style.css on the front.
if ( ! function_exists( 'twentytwentyfive_enqueue_styles' ) ) :
	/**
	 * Enqueues style.css on the front.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_enqueue_styles() {
		wp_enqueue_style(
			'twentytwentyfive-style',
			get_parent_theme_file_uri( 'style.css' ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'twentytwentyfive_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 'twentytwentyfive_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfive' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'twentytwentyfive_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_pattern_categories() {

		register_block_pattern_category(
			'twentytwentyfive_page',
			array(
				'label'       => __( 'Pages', 'twentytwentyfive' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfive' ),
			)
		);

		register_block_pattern_category(
			'twentytwentyfive_post-format',
			array(
				'label'       => __( 'Post formats', 'twentytwentyfive' ),
				'description' => __( 'A collection of post format patterns.', 'twentytwentyfive' ),
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'twentytwentyfive_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_register_block_bindings() {
		register_block_bindings_source(
			'twentytwentyfive/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'twentytwentyfive' ),
				'get_value_callback' => 'twentytwentyfive_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'twentytwentyfive_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function twentytwentyfive_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;

/* CPT: Custom Post Type */
$args = array(
    'labels' => array(
            'name'          => 'Books',
            'singular_name' => 'Book',
            'menu_name'     => 'Books',
            'add_new'       => 'Add New Book',
            'add_new_item'  => 'Add New Book',
            'new_item'      => 'New Book',
            'edit_item'     => 'Edit Book',
            'view_item'     => 'View Book',
            'all_items'     => 'All Books',
    ),
    'public' => true,
    'has_archive' => true,
    'show_in_rest' => true,
	'rest_base'    => 'books',
    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
);

register_post_type( 'book', $args );

add_action( 'admin_menu', 'bookstore_add_booklist_submenu');
function bookstore_add_booklist_submenu() {
    add_submenu_page(
        'edit.php?post_type=book', 
        'Book List',
        'Book List',
        'edit_posts',
        'book-list',
        'bookstore_render_booklist'
    );
}

function bookstore_render_booklist() { 

    $paged    = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $search   = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
    $author   = isset($_GET['author']) ? intval($_GET['author']) : '';

    $args = [
        'post_type'      => 'book',
        'posts_per_page' => 10,
        'paged'          => $paged,
        's'              => $search,
    ];

    if ($author) {
        $args['author'] = $author;
    }

    $books = new WP_Query($args);

    echo '<div class="wrap">';
    echo '<h1>Book List</h1>';

    // Search & Filter Form
    echo '<form method="get">';
    echo '<input type="hidden" name="post_type" value="book">';
    echo '<input type="hidden" name="page" value="book-list">';
    echo '<input type="text" name="s" value="' . esc_attr($search) . '" placeholder="Search books..." />';

    // Author Filter
    wp_dropdown_users([
        'name'              => 'author',
        'selected'          => $author,
        'show_option_all'   => 'All Authors',
        'role__in'          => ['Author', 'Editor', 'Administrator'],
    ]);

    echo '<input type="submit" class="button button-primary" value="Filter"> ';
    echo '<a href="' . admin_url('edit.php?page=book-list&post_type=book') . '" class="button">Clear</a>';

    echo '</form>';

    // Book Table
    if ($books->have_posts()) {
        echo '<table class="widefat striped">';
        echo '<thead><tr><th>Title</th><th>Author</th><th>Date</th><th>Actions</th></tr></thead><tbody>';

        while ($books->have_posts()) {
            $books->the_post();
            echo '<tr>';
            echo '<td>' . esc_html(get_the_title()) . '</td>';
            echo '<td>' . esc_html(get_the_author()) . '</td>';
            echo '<td>' . esc_html(get_the_date()) . '</td>';
            echo '<td><a href="' . esc_url(get_permalink()) . '" target="_blank">View</a> | <a href="' . esc_url(get_edit_post_link()) . '">Edit</a></td>';
            echo '</tr>';
        }

        echo '</tbody></table>';

        // Pagination
        $total_pages = $books->max_num_pages;
        if ($total_pages > 1) {
            echo '<div class="tablenav"><div class="tablenav-pages">';
            echo paginate_links([
                'base'    => add_query_arg('paged', '%#%'),
                'format'  => '',
                'current' => $paged,
                'total'   => $total_pages,
            ]);
            echo '</div></div>';
        }
    } else {
        echo '<p>No books found.</p>';
    }

    echo '</div>';
    wp_reset_postdata();
}

add_action('add_meta_boxes', 'bookstore_add_custom_meta_box');

function bookstore_add_custom_meta_box() {
    add_meta_box(
        'book_publisher',                 // Unique ID
        'Publisher Information',          // Box Title
        'bookstore_render_meta_box',      // Callback Function
        'book',                           // Post Type (CPT)
        'side',                           // Context: normal, side, advanced
        'default'                         // Priority
    );
}

function bookstore_render_meta_box($post) {
    // Get existing value
    $publisher = get_post_meta($post->ID, '_book_publisher', true);

    // Security nonce
    wp_nonce_field('bookstore_save_meta_box', 'bookstore_meta_box_nonce');

    echo '<label for="book_publisher">Publisher:</label>';
    echo '<input type="text" name="book_publisher" id="book_publisher" value="' . esc_attr($publisher) . '" />';
}

add_action('save_post', 'bookstore_save_meta_box_data');

function bookstore_save_meta_box_data($post_id) {
    // Check nonce
    if (!isset($_POST['bookstore_meta_box_nonce']) || 
        !wp_verify_nonce($_POST['bookstore_meta_box_nonce'], 'bookstore_save_meta_box')) {
        return;
    }

    // Check auto-save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) return;

    // Save value
    if (isset($_POST['book_publisher'])) {
        update_post_meta($post_id, '_book_publisher', sanitize_text_field($_POST['book_publisher']));
    }
}

function bookstore_display_publisher_shortcode() {
    if (is_singular('book')) {
        $publisher = get_post_meta(get_the_ID(), '_book_publisher', true);
        if (!empty($publisher)) {
            return '<p><strong>Publisher:</strong> ' . esc_html($publisher) . '</p>';
        }
    }
    return '';
}
add_shortcode('book_publisher', 'bookstore_display_publisher_shortcode');

//error_log ( $some_variable );

// add_filter( 'the_content', 'append_custom_text', 20 );
// function append_custom_text( $content ) {
//     return $content . '<p>Thanks for reading!</p>';
// }
