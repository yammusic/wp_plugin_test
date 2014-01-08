<?php

    /**
    * 
    */
    class MY_Plugin {

        public $tableName;
        private $wpdb;
        public $switchTable;
        static private $WPDB;
        static private $table;
        
        public function __construct( $wpdb ) {
            $this->tableName = 'myplugin_books';
            self::$table = $this->tableName;
            $this->wpdb = $wpdb;
            self::setWPDB( $wpdb );
            $this->initPlugin();
        }

        public function initPlugin() {
            if ( !self::existsTable() ) {
                $this->switchTable = true;
                return( false );
            } else {
                $this->switchTable = false;
                return( true );
            }
        }

        public function createTable() {
            $SQL = "CREATE TABLE IF NOT EXISTS ". $this->tableName ." ( book_id INT NOT NULL AUTO_INCREMENT, book_title VARCHAR(255) NOT NULL, book_author VARCHAR(255) NOT NULL, book_isbn VARCHAR(255) NOT NULL, PRIMARY KEY ( book_id ) )";
            return( $this->wpdb->query( $SQL ) );
        }

        static public function existsTable() {
            $tables = self::WPDB()->get_col( "SHOW TABLES" );
            return( in_array( self::$table, $tables ) );
        }

        static private function setWPDB( $wpdb ) {
            self::$WPDB = $wpdb;
        }

        static public function WPDB() {
            return( self::$WPDB );
        }

        public function __destruct() {
            $this->wpdb = 0;
        }

    }

?>