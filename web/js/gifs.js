jQuery(document).ready(function () {
    $('.viewport:not(:in-viewport(0))').each(function(index) {
        $(this).next().find('video').addClass('video-paused').get(0).pause();
        $(this).next().find('ins').show();
    });

    if ($( '.viewport' ).isInViewport({ tolerance: 0 }).length !== 0) {
        $('.viewport').isInViewport({ tolerance: 0 }).each(function() {
            $( this ).next().find('video').removeClass('video-paused').get(0).play();
            $(this).next().find('ins').hide();
        });
    }

    $('video').on('click', function() {
        if ($(this).get(0).paused) {
            $(this).get(0).play();
            $(this).next().hide();
        } else {
            $(this).addClass('video-paused').get(0).pause();
            $(this).next().show();
        }
    });

    $(window).scroll(function() {
        $('.viewport:not(:in-viewport(0))').each(function(index) {
            $(this).next().find('video').addClass('video-paused').get(0).pause();
            $(this).next().find('ins').show();
        });

        if ($( '.viewport' ).isInViewport({ tolerance: 0 }).length !== 0) {
            $('.viewport').isInViewport({ tolerance: 0 }).each(function() {
                var video = $( this ).next().find('video').removeClass('video-paused').get(0);
                if (video.paused) {
                    video.play();
                    $(this).next().find('ins').hide();
                }
            });
        }
    });
});
