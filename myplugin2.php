<?php
 
/**
*
* Plugin Name: WP Skin @ Home
* Plugin URI: http://embat.es
* Description: [TESTING] A plugin that allow you to put a banner (skin, with an image and a link) behind the #wraper in your home page
* Version: 1.0
* Author: Joan Ballester
* Author URI: http://embat.es
*
**/

    $dbh = new wpdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST );
     
    global $table_prefix;
    $table = $table_prefix.'options';
     
    $query_link = "SELECT option_value FROM $table WHERE option_name = 'wp_skin_link'";
    $res_link = $dbh->get_results( $query_link );
     
    add_action( 'admin_menu', 'wp_skinhome' );
    add_action( 'shutdown', 'wp_skinhome_home' );

    function wp_skinhome_home() {
        if ( is_home() ) {
            echo '<a href="./about-us/"><img src="https://www.google.com.co/images/srpr/logo11w.png" alt="Google"></a>';
        }
    }

    function wp_skinhome() {
        add_options_page( 'Opciones WP Skin @ Home', 'Wp Skin @ Home', 'manage_options', 'wp_skinhome', 'wp_skinhome_options' );
    }

    function wp_skinhome_options() {
 
        if (!current_user_can('manage_options')){
            wp_die( __('Pequeño padawan... debes utilizar la fuerza para entrar aquí.') );
        }
     
        $opt_name = 'wp_skin_image';
        $hidden_field_name = 'wp_skin_image_hidden';
        $data_field_name = 'wp_skin_image';
        $opt_val = get_option( $opt_name );
     
        if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'ruta_hidden') {
            $opt_val = $_POST[ $data_field_name ];
            update_option( $opt_name, $opt_val );
            ?>
                <div class="updated"><p><strong><?php _e('settings saved.', 'wp_skinhome_menu' ); ?></strong></p></div>
            <?php
            }
     
            echo '<div class="wrap">';
                echo "<h2>" . __( 'WP Skin @ Home', 'wp_skinhome_menu' ) . "</h2>";
     
            ?>
     
            <form name="form1" method="post" action="">
                <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="ruta_hidden">
                <p>
                    <?php _e('Ruta del skin: ', 'wp_skinhome_menu' ); ?>
                    <input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" size="60" />
                </p>
                <p class="submit">
                    <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
                </p>
            </form>
        </div>
     
    <?php
     
    }