<?php
 
/**
*
* Plugin Name: WP My Plugin
* Plugin URI: http://embat.es
* Description: [TESTING] A plugin that allow you to put a banner (skin, with an image and a link) behind the #wraper in your home page
* Version: 1.0
* Author: Joan Ballester
* Author URI: http://embat.es
*
**/

    ///////////////////////////////
    /// LOAD FILES
    //////////////////////////////

    if( !class_exists( 'Database' ) ) {
        require_once( plugin_dir_path( __FILE__ ) . 'models/Database.php' );
        require_once( plugin_dir_path( __FILE__ ) . 'models/Book.php' );
    }

    if( !class_exists( 'MY_Plugin' ) ) {
        require_once( plugin_dir_path( __FILE__ ) . 'core/MY_Plugin.php' );
    }

    if( !class_exists( 'MY_List_Table' ) ) {
        require_once( plugin_dir_path( __FILE__ ) . 'core/MY_List_Table.php' );
    }

    $MyPlugin = new MY_Plugin( $wpdb );
    $Book = new Book( $wpdb );

    global $MyPlugin, $Book;



    /////////////////////////////
    /// ADD ITEM MENU LIST
    ////////////////////////////

    function my_add_menu_items() {
        global $hookMenu;
        $hookMenu = add_menu_page( 'My Plugin List Table', 'My List Table Example', 'activate_plugins', 'myplugin', 'my_render_list_page' );
        add_action( "load-$hookMenu", 'add_options' );
    }

    function add_options() {
        global $myListTable;
        $option = 'per_page';
        $args = array(
            'label' => 'Books per page',
            'default' => 10,
            'option' => 'books_per_page'
        );
        add_screen_option( $option, $args );
        $myListTable = new MY_List_Table( $GLOBALS[ 'Book' ]->all() );
    }

    add_action( 'admin_menu', 'my_add_menu_items' );


    /////////////////////////////
    /// DISPLAY PLUGIN
    ////////////////////////////

    function my_render_list_page() {
        $myListTable = new MY_List_Table( $GLOBALS[ 'Book' ]->all() );
        include_once( plugin_dir_path( __FILE__ ) . 'views/index.php' );
    }


    /////////////////////////////
    /// VALUE OPTIONS TABLE
    ////////////////////////////

    function test_table_set_option( $status, $option, $value ) {
      return $value;
    }

    add_filter( 'set-screen-option', 'test_table_set_option', 10, 3 );


    ///////////////////////////////////
    /// LOAD SCRIPTS AND STYLESHEETS
    //////////////////////////////////

    function load_scripts( $hook ) {
        global $hookMenu;

        if( $hook != $hookMenu ) return;

        wp_enqueue_script( 'main-js', plugin_dir_url( __FILE__ ) . 'assets/js/main.js', array( 'jquery' ) );
    }

    function load_stylesheets( $hook ) {
        global $hookMenu;

        if( $hook != $hookMenu ) return;

        // Load Bootstrap Css
        wp_register_style( 'myplugin-admin-bootstrap', plugin_dir_url( __FILE__ ) .'assets/css/bootstrap.css' );
        wp_enqueue_style( 'myplugin-admin-bootstrap' );

        // Load Default Style Css
        wp_register_style( 'myplugin-admin-css', plugin_dir_url( __FILE__ ) .'assets/css/style.css' );
        wp_enqueue_style( 'myplugin-admin-css' );
    }

    add_action( 'admin_enqueue_scripts', 'load_scripts' );
    add_action( 'admin_enqueue_scripts', 'load_stylesheets' );


    ////////////////////////////
    /// AJAX FUNCTIONS
    ///////////////////////////

    function ajax_create_table() {
        include_once( plugin_dir_path( __FILE__ ) . 'models/ajax/confirmationTable.ajax.php' );

        die();
    }

    add_action( 'wp_ajax_myplugin_create_table', 'ajax_create_table' );

    function ajax_create_book() {
        include_once( plugin_dir_path( __FILE__ ) . 'models/ajax/createBook.ajax.php' );

        die();
    }

    add_action( 'wp_ajax_myplugin_create_book', 'ajax_create_book' );

    function ajax_edit_book() {
        include_once( plugin_dir_path( __FILE__ ) . 'models/ajax/editBook.ajax.php' );

        die();
    }

    add_action( 'wp_ajax_myplugin_edit_book', 'ajax_edit_book' );

    function ajax_delete_book() {
        include_once( plugin_dir_path( __FILE__ ) . 'models/ajax/deleteBook.ajax.php' );

        die();
    }

    add_action( 'wp_ajax_myplugin_delete_book', 'ajax_delete_book' );


    //////////////////////////////
    /// SHORTCODES 
    /////////////////////////////

    function stylesheet_book_shortcode() {
        wp_register_style( 'singleBookStyle', plugin_dir_url( __FILE__ ) . 'assets/css/shortcode_book.css' );
        wp_enqueue_style( 'singleBookStyle' );
    }

    add_action( 'wp_enqueue_scripts' , 'stylesheet_book_shortcode' );

    function shortcode_single_book( $atts ) {
        extract( shortcode_atts( array( 'id' => NULL ), $atts ) );
        if ( is_null( $id ) ) return 'invalid id for book, please add an id valid in the shortcode [book id="my-id" /]';

        extract( $GLOBALS[ 'Book' ]->find( $id ) );
        // do_action( 'single_book_action', $id, $book_title, $book_author, $book_isbn );
        ob_start();
        include_once( plugin_dir_path( __FILE__ ) . 'views/shortcodes/singleBook.php' );
        $singleBook = apply_filters( 'single_book_filter', ob_get_clean(), $id, $book_title, $book_author, $book_isbn );
        
        return( $singleBook );
    }

    add_shortcode( 'book', 'shortcode_single_book' );

    function shortcode_list_books( $atts ) {
        extract( shortcode_atts( array(), $atts ) );
        $allBooks = $GLOBALS[ 'Book' ]->all();
        ob_start();
        require_once( plugin_dir_path( __FILE__ ) . 'views/shortcodes/showBooks.php' );
        $showBooks = apply_filters( 'show_books_filter', ob_get_clean(), $allBooks );
        // print_r( $showBooks );
        return( $showBooks );
    }

    add_shortcode( 'books', 'shortcode_list_books' );

/*function the_action( &$id, $book_title, $book_author, $book_isbn ) {
  echo 'Hola Mundo';
}
function the_filter( $singleBook, $id, $book_title, $book_author, $book_isbn ) {
    //$x = 3;
    //$book_title = call_user_func( 'the_action', $x, 'dfg', 'dfg', 324 );
    //empty( $book_title );
    return( $singleBook );
}
$x = 20;
function yeison( &$x ) {
    $x = $x * 2;
  echo 'X Func = ' . $x;
}
yeison( $x );
echo 'X Out Func = ' . $x;
add_action( 'single_book_action', 'the_action', 10, 4 );
add_filter( 'single_book_filter', 'the_filter', 10, 5 );*/
