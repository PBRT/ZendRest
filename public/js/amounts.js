// /public/js/custom.js

jQuery(function($) {
    $("#create").on('click', function(event){
        event.preventDefault();
        var $amount = $(this);
        $.post("amounts/add", null,
            function(data){
                if(data.response == true){
                    $amount.before("<div class=\"sticky-note\"><textarea id=\"stickynote-"+data.new_note_id+"\"></textarea><a href=\"#\" id=\"remove-"+data.new_note_id+"\"class=\"delete-sticky\">X</a></div>");
                    // print success message
                } else {
                    // print error message
                    console.log('could not add');
                }
            }, 'json');
    });

    $('#sticky-notes').on('click', 'a.delete-sticky',function(event){
        event.preventDefault();
        var $amount = $(this);
        var remove_id = $(this).attr('id');
        remove_id = remove_id.replace("remove-","");

        $.post("amounts/remove", {
                id: remove_id
            },
            function(data){
                if(data.response == true)
                    $amount.parent().remove();
                else{
                    // print error message
                    console.log('could not remove ');
                }
            }, 'json');
    });

    $('#sticky-notes').on('keyup', 'textarea', function(event){
        var $amount = $(this);
        var update_id = $amount.attr('id'),
            update_content = $amount.val();
        update_id = update_id.replace("stickynote-","");

        $.post("amounts/update", {
            id: update_id,
            content: update_content
        },function(data){
            if(data.response == false){
                // print error message
                console.log('could not update');
            }
        }, 'json');

    });
});
