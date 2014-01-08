<?php

    /**
    * 
    */
    class Book extends Database implements iDatabase {

        public $tableName;
        public $singularTableName;
        public $wpdb;
        
        public function __construct( $wpdb ) {
            $this->tableName = 'myplugin_books';
            $this->singularTableName = 'book';
            $this->wpdb = $wpdb;
        }

        public function insert( $data ) {
            return( Database::insert_row( $this->tableName, $data, $this->wpdb ) );
        }

        public function all() {
            $SQL = "SELECT * FROM ". $this->tableName ." ORDER BY ". $this->singularTableName ."_id ASC";
            return( Database::find_all( $SQL, $this->wpdb ) );
        }

        public function find( $id ) {
            $SQL = "SELECT * FROM ". $this->tableName ." WHERE ". $this->singularTableName ."_id=". $id ." LIMIT 1";
            return( Database::find_one( $SQL, $this->wpdb ) );
        }

        public function update( $data, $id ) {
            return( Database::update_row( $this->tableName, $data, array( $this->singularTableName .'_id' => $id ), $this->wpdb ) );
        }

        public function delete( $id ) {
            return( Database::delete_row( $this->tableName, array( $this->singularTableName .'_id' => $id ), array( '%d' ), $this->wpdb ) );
        }
    }

?>