$(function() {
    var meetApp = {};

    meetApp.manageEvent = {

        init: function () {
            $('.event-add').click(function (e){
                meetApp.manageEvent.crud('PUT', $(this).attr('data-path'))
            });
            $('event-del').click(function(e){
                meetApp.manageEvent.crud('DELETE', $(this).attr('data-path'))
            });
        },

        crud: function (type, path) {
            jQuery.ajax({
                type: type,
                url: path
            }).done(function(response){
                console.log(response);
            })
        }

    };
    window.meetApp = meetApp;
});