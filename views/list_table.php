<h2>My List Table Test</h2>

<?php $myListTable->prepare_items(); ?>

<form method="POST">
    <input type="hidden" name="page" value="ttest_list_table" />
    <button class="btn btn-inverse" onclick="return( addBook( jQuery( this ) ) )">Add</button>
    <?php $myListTable->search_box( 'search', 'search_id' ); ?>

    <?php $myListTable->display(); ?>
</form>

<div class="content-form" style="display: none;">
    
    <form>
        <h2>Book</h2>
        <div>
            <label for="book_title"><?php _e( 'Title Book', 'myplugin' ); ?></label>
            <input type="text" id="book_title" name="book_title" />
        </div>
        <div>
            <label for="book_author"><?php _e( 'Author', 'myplugin' ); ?></label>
            <input type="text" id="book_author" name="book_author" />
        </div>
        <div>
            <label for="book_isbn"><?php _e( 'ISBN', 'myplugin' ); ?></label>
            <input type="text" id="book_isbn" name="book_isbn" />
        </div>
        <div class="actions">
            <input type="submit" onclick="return( addNewBook( jQuery( this ) ) )" class="btn btn-info" value="<?php _e( 'Save', 'myplugin' ); ?>" />
            <input type="reset" value="<?php _e( 'Reset', 'myplugin' ); ?>" class="btn btn-reset" />
            <button type="none" class="btn btn-inverse" onclick="return( closeForm( jQuery( this ) ) );"><?php _e( 'Back', 'myplugin' ); ?></button>
        </div>
    </form>

</div>