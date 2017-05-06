$('#search').on('keyup', function () {
    $('#lupa').removeClass('glyphicon-refresh glyphicon-refresh-animate').addClass('glyphicon-search');

    if ($('#search').val().length >= 2) {
        $('#lupa').removeClass('glyphicon-search').addClass('glyphicon-refresh glyphicon-refresh-animate');
    }

    $('#search').autocomplete({
        source: function( request, response ) {
            $.ajax({
                method: 'get',
                url: '/posts/search-ajax',
                data: {
                    q: $('#search').val()
                },
                success: function (data, status, event) {
                    $('#lupa').removeClass('glyphicon-refresh glyphicon-refresh-animate').addClass('glyphicon-search');
                    var d = JSON.parse(data);
                    response(d);
                }
            });
        },
        minLength: 2,
        delay: 800,
        select: function( event, ui ) {
            $('#search').parent().submit();
        },
        response: function(event, ui) {
            $('#lupa').removeClass('glyphicon-refresh glyphicon-refresh-animate').addClass('glyphicon-search');
        }
    }).data("ui-autocomplete")._renderItem = function( ul, item ) {
        return $( "<li>" )
        .attr( "data-value", item.value )
        .append( $( "<a>" ).html( item.label.replace(new RegExp('^' + this.term, 'gi'),"<strong>$&</strong>") + '...' ) )
        .appendTo( ul );
    }

});
