<?php


    if ( !$GLOBALS[ 'MyPlugin' ]->switchTable ) {
        $json = array(
            'info' => 'token',
            'msg' => __( 'The table already exists in your database', 'myplugin' )
        );
    } else {

        if ( $GLOBALS[ 'MyPlugin' ]->createTable() ) {
            $json = array(
                'info' => 'success',
                'msg' => __( 'The table was created successfully', 'myplugin' )
            );
        } else {
            $json = array(
                'info' => 'error',
                'msg' => __( 'Error creating the table', 'myplugin' )
            );
        }
    }

    echo json_encode( $json );

?>