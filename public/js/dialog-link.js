function openDialogWithDynamicContent(id, link, title){
    $.ajax({
        type: "GET",
        url: link,
        async: true,
        success: function(msg) {
            $('#'+id+'-content').text(msg);
            $('#'+id).dialog('open');
            $('#'+id).dialog( "option", "title", title );
        },
        error: function() {
            // błąd
            alert ('ERROR');
        }
    });
}

$(document).ready(function(){

    /* uruchamia dialog */
    $(document).on("click", "a.link-dialog" , function() {
        var link = $(this).attr('href');
        var title = $(this).attr('title');
        if(title == ''){
            title = $(this).attr('data-original-title');
        }
        openDialogWithDynamicContent('dialog-simple',link, title);
        return false;
    });

});