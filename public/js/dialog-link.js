let dialogContent = "";

function openDialogWithDynamicContent(id, link, title){
    dialogContent = "";
    $('#file-manager-file-content-grep').val("");
    $.ajax({
        type: "GET",
        url: link,
        async: true,
        success: function(msg) {
            dialogContent = msg;
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

    $('#file-manager-file-content-grep').keypress(function (e) {
        if (e.which == 13) {
            let match = $('#file-manager-file-content-grep').val();
            console.log(match);
            if (match==='') {
                $('#dialog-simple-content').text(dialogContent);
                return;
            }
            let t = [...dialogContent.matchAll(RegExp('.*'+match+'.*','ig'))].join(["\n"]);
            console.log(t);
            $('#dialog-simple-content').text(
                t
            );
        }
    });

});