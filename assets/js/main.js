jQuery( function( $ ) {

    var contentForm = $( 'div.content-form' );
    var form = contentForm.children();

    form.css( { 'margin-top' : '-'+ ( form.height() / 2 ) +'px' } );

} );

function addBook( that ) {
    var contentForm = jQuery( 'div.content-form' );
    var form = contentForm.find( 'form' );
    form.attr( { 'data-action' : 'newBook' } );
    form.find( 'input[ type="submit" ]' ).attr( {
        'value' : 'Add',
        'onclick' : 'return( addNewBook( jQuery( this ) ) )',
        'data-action' : 'newBook'
    } );
    contentForm.show( 'fast' );
    return( false );
}

function closeForm( that ) {
    form = that.parent().parent();
    form.parent().hide( 'fast' );
    form.removeAttr( 'data-action' );
    form.find( 'input[ type="text" ]' ).val( '' );
    form.find( 'input[ type="submit" ]' ).attr( {
        'value' : '',
        'onclick' : 'return( false )',
        'data-action' : ''
    } );
    return( false );
}

function confirmationTable( that ) {
    data = {
        action : 'myplugin_create_table'
    };

    jQuery.ajax( {
        cache : false,
        type : "POST",
        dataType : 'json',
        data : data,
        url : ajaxurl,
        success: function( response ) {
            if ( response.info == 'success' ) {
                alert( response.msg );
                location.href = document.URL;
            } else {
                alert( response.msg );
            }
        }
    } );

    return( false );
}

function addNewBook( that ) {
    src = that.parent().parent().serializeArray();

    data = '{ "action" : "myplugin_create_book"';

    jQuery.each( src, function( key, val ) {
        data += ', "'+ val.name +'" : "'+ val.value +'"';
    });

    data += ' }';
    data = JSON.parse( data );

    jQuery.ajax( {
        cache : false,
        type : "POST",
        dataType : 'json',
        data : data,
        url : ajaxurl,
        success : function( response ) {
            if ( response.info == 'success' ) {
                alert( response.msg );
                location.href = document.URL;
            } else {
                alert( response.msg );
            }
        }
    } );

    return( false );
}

function editBook( that, id ) {
    var contentForm = jQuery( 'div.content-form' );
    var form = contentForm.find( 'form' );
    form.attr( { 'data-action' : 'editBook' } );
    form.find( 'input[ type="submit" ]' ).attr( {
        'value' : 'Edit',
        'onclick' : 'return( editBook( jQuery( this ), '+ id +' ) )',
        'data-action' : 'editBook'
    } );

    get = '{ "action" : "myplugin_edit_book", "id" : "'+ id +'", ';

    switch ( that.data( 'action' ) ) {

        case 'activeAction':
            get += '"sub-action" : "getBook" }';
            get = JSON.parse( get );
            jQuery.ajax( {
                cache : false,
                type : "POST",
                dataType : 'json',
                data : get,
                url : ajaxurl,
                success : function( response ) {
                    if ( response.info == 'success' ) {
                        jQuery.extend( get, response );

                        jQuery.each( get.book, function( index, val ) {
                            jQuery( 'input#' + index ).val( val );
                        } );

                        contentForm.show( 'fast' );
                    } else { alert( 'Error getting data from the Book' ); }
                }
            } );
        break;

        case 'editBook':
            get += '"sub-action" : "saveBook"';
            data = that.parent().parent().serializeArray();
            jQuery.each( data, function( index, value ) {
                get += ', "'+ value.name +'" : "'+ value.value +'"';
            } );
            get += ' }';
            get = JSON.parse( get );

            jQuery.ajax( {
                cache : false,
                type : "POST",
                dataType : 'json',
                data : get,
                url : ajaxurl,
                success : function( response ) {
                    if ( response.info == 'success' ) {
                        alert( response.msg );
                        location.href = document.URL;
                    } else { alert( msg ); }
                }
            } );
        break;

    }
    
    return( false );
}

function deleteBook( that, id ) {
    r = confirm( 'Are you sure want to delete this Book?' );

    if ( !r ) {
        return( false )
    } else {
        data = {
            action : 'myplugin_delete_book',
            id : id
        };
        jQuery.ajax( {
            cache : false,
            type : "POST",
            dataType : 'json',
            data : data,
            url : ajaxurl,
            success : function( response ) {
                if ( response.info == 'success' ) {
                    alert( response.msg );
                    location.href = document.URL;
                } else {
                    alert( response.msg );
                }
            }
        } );
    }

    return( false );
}