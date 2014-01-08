<table class="show-books">
    <thead>
        <tr>
            <th><?php _e( 'ID', 'myplugin' ) ?></th>
            <th><?php _e( 'Title', 'myplugin' ) ?></th>
            <th><?php _e( 'Author', 'myplugin' ) ?></th>
            <th><?php _e( 'ISBN', 'myplugin' ) ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ( $allBooks as $value ) {
        ?>
        <tr>
            <td><?php echo $value[ 'book_id' ] ?></td>
            <td><?php echo $value[ 'book_title' ] ?></td>
            <td><?php echo $value[ 'book_author' ] ?></td>
            <td><?php echo $value[ 'book_isbn' ] ?></td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>