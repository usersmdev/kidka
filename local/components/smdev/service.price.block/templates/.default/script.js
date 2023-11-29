$( document ).ready(function() {
    $( "select" )
        .change(function () {
            var str = "";
            $( "select option:selected" ).each(function() {
                str += $( this ).val() + " ";


            });
            $( "div.text" ).text( str );
        })
});