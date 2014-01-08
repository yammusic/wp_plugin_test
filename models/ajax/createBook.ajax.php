<?php

    $data = array();

    foreach ($_POST as $key => $value) {
        if ( preg_match( '/book_/i', $key ) ) {
            $data[ $key ] = $value ;
        }
    }

    if ( $GLOBALS[ 'Book' ]->insert( $data ) ) {
        $json = array(
            'info' => 'success',
            'msg' => 'The Book was added successfully'
        );
    } else {
        $json = array(
            'info' => 'error',
            'msg' => 'Error, the Book couldn\'t be added'
        );
    }

    echo json_encode( $json );

?>