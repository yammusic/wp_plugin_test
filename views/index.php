<div class="wrap">
    <?php
        if ( $GLOBALS[ 'MyPlugin' ]->initPlugin() ) {
            include_once( plugin_dir_path( __FILE__ ) . 'list_table.php' );
        } else {
            include_once( plugin_dir_path( __FILE__ ) . 'confirmation.php' );            
        }
    ?>
</div>