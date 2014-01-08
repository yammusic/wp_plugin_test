<?php
    
    if( ! class_exists( 'WP_List_Table' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
    }

    /**
    * 
    */
    class MY_List_Table extends WP_List_Table {

        var $example_data = array();
        
        function __construct( $itemsRows ) {
            global $status, $page;

            $this->example_data = $itemsRows;

            parent::__construct( array(
                'singular' => __( 'book', 'myplugin' ),
                'plural' => __( 'books', 'myplugin' ),
                'ajax' => false
            ) );

            add_action( 'admin_head', array( &$this, 'admin_header' ) );
        }

        function get_columns() {
            $columns = array(
                // 'cb' => '<input type="checkbox" />',
                'book_id' => __( 'ID', 'myplugin' ),
                'book_title' => __( 'Title', 'myplugin' ),
                'book_author' => __( 'Author', 'myplugin' ),
                'book_isbn' => __( 'ISBN', 'myplugin' )
            );
            return $columns;
        }

        function prepare_items() {
            $columns = $this->get_columns();
            $hidden = array();
            $sortable = $this->get_sortable_columns();
            $this->_column_headers = array( $columns, $hidden, $sortable );
            if ( !empty( $this->example_data ) ) {
                usort(  $this->example_data, array( &$this, 'usort_reorder' ) );
            }

            $per_page = $this->get_items_per_page( 'books_per_page', 5 );
            $current_page = $this->get_pagenum();
            $total_items = count( $this->example_data );

            $this->found_data = ( !empty( $this->example_data ) ) ? array_slice( $this->example_data, ( ( $current_page - 1 ) * $per_page ), $per_page ) : '';

            $this->set_pagination_args( array(
                'total_items' => $total_items,
                'per_page' => $per_page
            ) );
            $this->items = $this->found_data;
        }

        function column_default( $item, $column_name ) {
            switch ( $column_name ) {
                case 'book_id':
                case 'book_title':
                case 'book_author':
                case 'book_isbn':
                    return $item[ $column_name ];
                default:
                    return print_r( $item, true );
            }
        }

        function get_sortable_columns() {
            $sortable_columns = array(
                'book_id' => array( 'book_id', false ),
                'book_title' => arraY ( 'book_title', false ),
                'book_author' => arraY ( 'book_author', false ),
                'book_isbn' => arraY ( 'book_isbn', false )
            );
            return $sortable_columns;
        }

        function usort_reorder( $a, $b ) {
            $orderby = ( !empty( $_GET[ 'orderby' ] ) ) ? $_GET[ 'orderby' ] : 'book_title';
            $order = ( !empty( $_GET[ 'order' ] ) ) ? $_GET[ 'order' ] : 'asc';
            $result = strcmp( $a[ $orderby ], $b[ $orderby ] );
            return ( $order === 'asc' ) ? $result : -$result;
        }

        function column_book_title( $item ){
            $actions = array(
                'edit' => sprintf( '<a href="" data-action="activeAction" onclick="return( editBook( jQuery( this ), %d ) )">Edit</a>', $item[ 'book_id' ] ),
                'delete' => sprintf( '<a href="" onclick="return( deleteBook( jQuery( this ), %d ) )">Delete</a>', $item[ 'book_id' ] )
            );
         
            return sprintf( '%1$s %2$s', $item[ 'book_title' ], $this->row_actions( $actions ) );
        }

        // function column_cb( $item ) {
        //     return sprintf( '<input type="checkbox" name="book[]" value="%s" />', $item[ 'book_id' ] );    
        // }

        function column_book_id( $item ) {
            return sprintf( '%s', $item[ 'book_id' ] );
        }

        // function get_bulk_actions() {
        //     $actions = array(
        //         'edit' => 'Edit',
        //         'delete' => 'Delete'
        //     );
        //     return $actions;
        // }

        function admin_header() {
            $page = ( isset( $_GET[ 'page' ] ) ) ? esc_attr( $_GET[ 'page' ] ) : false;
            if( 'myplugin' != $page ) return;

            $toEcho = '<style type="text/css">';
            $toEcho .= '.wp-list-table .column-book_id { width: 55px !important; }';
            $toEcho .= '</style>';

            echo $toEcho;
        }

        function no_items() {
          _e( 'No books found, dude.' );
        }
    }

?>