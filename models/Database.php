<?php

    /**
    * 
    */
    interface iDatabase {
        static public function find_all( $SQL, $link );
        static public function insert_row( $table, $data, $link );
        static public function find_one( $SQL, $link );
    }

    abstract class Database implements iDatabase {
        
        static public function find_all( $SQL, $link ) {
            if ( MY_Plugin::existsTable() ) {
                if ( $content = $link->get_results( $SQL ) ) {
                    foreach ( $content as $value ) {
                        $result[] = get_object_vars( $value );
                    }
                    return( $result );
                } else {
                    return( false );
                }
            } else { return( false ); }
        }

        static public function insert_row( $table, $data, $link ) {
            if ( MY_Plugin::existsTable() ) {
                if ( $link->insert( $table, $data ) ) {
                    return( true );
                } else {
                    return( false );
                }
            } else { return( false ); }
        }

        static public function find_one( $SQL, $link ) {
            if ( MY_Plugin::existsTable() ) {
                return( $link->get_row( $SQL, ARRAY_A ) );
            } else { return( false ); }
        }

        static public function update_row( $table, $data, $id, $link ) {
            if ( MY_Plugin::existsTable() ) {
                return( $link->update( $table, $data, $id ) );
            } else { return( false ); }
        }

        static public function delete_row( $table, $id, $format, $link ) {
            if ( MY_Plugin::existsTable() ) {
                return( $link->delete( $table, $id, $format ) );
            } else { return( false ); }
        }
    }

?>