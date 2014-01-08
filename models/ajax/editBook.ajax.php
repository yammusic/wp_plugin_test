<?php

    switch ( $_POST[ 'sub-action' ] ) {

        case 'getBook':
            $json[ 'book' ] = $GLOBALS[ 'Book' ]->find( $_POST[ 'id' ] );
            $json[ 'info' ] = 'success';
        break;

        case 'saveBook':
            foreach ($_POST as $key => $value) {
                if ( preg_match( '/book_/i', $key ) ) {
                    $toSave[ $key ] = $value;
                }
            }

            if ( $GLOBALS[ 'Book' ]->update( $toSave, $_POST[ 'id' ] ) ) {
                $json = array(
                    'info' => 'success',
                    'msg' => 'The Book was updated successfully'
                );
            } else {
                $json = array(
                    'info' => 'error',
                    'msg' => 'An error has occurred and the Book could not be saved'
                );
            }
        break;

    }

    echo json_encode( $json );

?>