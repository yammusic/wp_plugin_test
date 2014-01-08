<?php

    if ( $GLOBALS[ 'Book' ]->delete( $_POST[ 'id' ] ) ) {
        $json = array(
            'info' => 'success',
            'msg' => 'The Book was deleted successfully'
        );
    } else {
        $json = array(
            'info' => 'error',
            'msg' => 'An error occurred and the book cannot be deleted'
        );
    }

    echo json_encode( $json );

?>