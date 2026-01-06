
        $(document).ready(function() {
            // Optional: Add smooth scrolling for anchor links
            $('a[href*="#"]').on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: $($(this).attr('href')).offset().top
                }, 500);
            });

            // Optional: Add hover effect for buttons
            $('.btn').hover(
                function() { $(this).addClass('shadow'); },
                function() { $(this).removeClass('shadow'); }
            );
        });
    