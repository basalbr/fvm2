<script type="text/javascript" src="{{url(public_path('vendor/js/jquery.js'))}}"></script>
<script type="text/javascript" src="{{url(public_path('vendor/js/bootstrap.min.js'))}}"></script>
<script type="text/javascript" src="{{url(public_path('vendor/js/viewport-checker.js'))}}"></script>
<script type="text/javascript">
    $(function () {

        setTimeout(function () {
            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.8";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        }, 1200);

        if ($("body").scrollTop() > 0) {
            $('#nav-menu').removeClass('transparent');
        }
        $(window).on('scroll', function () {
            if ($("body").scrollTop() == 0) {
                $('#nav-menu').addClass('transparent');
            } else {
                $('#nav-menu').removeClass('transparent');
            }
        });

        $('#mensalidade form').addClass('invisible').viewportChecker({
            classToAdd: 'slideInLeft animated', // Class to add to the elements when they are visible,
            classToAddForFullView: 'full-visible', // Class to add when an item is completely visible in the viewport
            classToRemove: 'invisible', // Class to remove before adding 'classToAdd' to the elements
            offset: ['10%'], // The offset of the elements (let them appear earlier or later). This can also be percentage based by adding a '%' at the end
            invertBottomOffset: true, // Add the offset as a negative number to the element's bottom
            repeat: false, // Add the possibility to remove the class if the elements are not visible
            scrollHorizontal: false // Set to true if your website scrolls horizontal instead of vertical.
        });

        $('section a').addClass('invisible').viewportChecker({
            classToAdd: 'zoomIn animated', // Class to add to the elements when they are visible,
            classToAddForFullView: 'full-visible', // Class to add when an item is completely visible in the viewport
            classToRemove: 'invisible', // Class to remove before adding 'classToAdd' to the elements
            offset: ['10%'], // The offset of the elements (let them appear earlier or later). This can also be percentage based by adding a '%' at the end
            invertBottomOffset: true, // Add the offset as a negative number to the element's bottom
            repeat: false, // Add the possibility to remove the class if the elements are not visible
            scrollHorizontal: false // Set to true if your website scrolls horizontal instead of vertical.
        });

        $('section h1, .banner-text').addClass('invisible').viewportChecker({
            classToAdd: 'fadeInDown animated', // Class to add to the elements when they are visible,
            classToAddForFullView: 'full-visible', // Class to add when an item is completely visible in the viewport
            classToRemove: 'invisible', // Class to remove before adding 'classToAdd' to the elements
            offset: ['5%'], // The offset of the elements (let them appear earlier or later). This can also be percentage based by adding a '%' at the end
            invertBottomOffset: true, // Add the offset as a negative number to the element's bottom
            repeat: false, // Add the possibility to remove the class if the elements are not visible
            scrollHorizontal: false // Set to true if your website scrolls horizontal instead of vertical.
        });

        $('#contato form').addClass('invisible').viewportChecker({
            classToAdd: 'slideInLeft animated', // Class to add to the elements when they are visible,
            classToAddForFullView: 'full-visible', // Class to add when an item is completely visible in the viewport
            classToRemove: 'invisible', // Class to remove before adding 'classToAdd' to the elements
            offset: ['10%'], // The offset of the elements (let them appear earlier or later). This can also be percentage based by adding a '%' at the end
            invertBottomOffset: true, // Add the offset as a negative number to the element's bottom
            repeat: false, // Add the possibility to remove the class if the elements are not visible
            scrollHorizontal: false // Set to true if your website scrolls horizontal instead of vertical.
        });

        $('#mensalidade-box').addClass('invisible').viewportChecker({
            classToAdd: 'slideInUp animated', // Class to add to the elements when they are visible,
            classToAddForFullView: 'full-visible', // Class to add when an item is completely visible in the viewport
            classToRemove: 'invisible', // Class to remove before adding 'classToAdd' to the elements
            offset: ['10%'], // The offset of the elements (let them appear earlier or later). This can also be percentage based by adding a '%' at the end
            invertBottomOffset: true, // Add the offset as a negative number to the element's bottom
            repeat: false, // Add the possibility to remove the class if the elements are not visible
            scrollHorizontal: false // Set to true if your website scrolls horizontal instead of vertical.
        });

    });
</script>
