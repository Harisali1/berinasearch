<script src="{{asset('assets/frontend/js/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery-ui.js')}}"></script>
<script src="{{asset('assets/frontend/js/rangeSlider.js')}}"></script>
<script src="{{asset('assets/frontend/js/range-slider.js')}}"></script>
<script src="{{asset('assets/frontend/js/tether.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/popper.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/popup.js')}}"></script>
<script src="{{asset('assets/frontend/js/moment.js')}}"></script>
<script src="{{asset('assets/frontend/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/mmenu.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/mmenu.js')}}"></script>
<script src="{{asset('assets/frontend/js/aos.js')}}"></script>
<script src="{{asset('assets/frontend/js/aos2.js')}}"></script>
<script src="{{asset('assets/frontend/js/slick.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/slick4.js')}}"></script>
<script src="{{asset('assets/frontend/js/fitvids.js')}}"></script>
<script src="{{asset('assets/frontend/')}}"></script>
<script src="{{asset('assets/frontend/js/typed.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery.counterup.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/smooth-scroll.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/lightcase.js')}}"></script>
<script src="{{asset('assets/frontend/js/search.js')}}"></script>
<script src="{{asset('assets/frontend/js/owl.carousel.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/ajaxchimp.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/newsletter.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery.form.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/searched.js')}}"></script>
<script src="{{asset('assets/frontend/js/forms-2.js')}}"></script>
<script src="{{asset('assets/frontend/js/leaflet.js')}}"></script>
<script src="{{asset('assets/frontend/js/leaflet-gesture-handling.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/leaflet-providers.js')}}"></script>
<script src="{{asset('assets/frontend/js/leaflet.markercluster.js')}}"></script>
<script src="{{asset('assets/frontend/js/map-style2.js')}}"></script>
<script src="{{asset('assets/frontend/js/range.js')}}"></script>
<script src="{{asset('assets/frontendn/js/map-single.js')}}"></script>
<script src="{{asset('assets/frontend/js/timedropper.js')}}"></script>
<script src="{{asset('assets/frontend/js/datedropper.js')}}"></script>
<script src="{{asset('assets/frontend/js/color-switcher.js')}}"></script>
<script src="{{asset('assets/frontend/js/inner.js')}}"></script>

<script>
    $(window).on('scroll load', function () {
        $("#header.cloned #logo img").attr("src", $('#header #logo img').attr('data-sticky-logo'));
    });

</script>

<!-- Slider Revolution scripts -->
<script src="{{asset('assets/frontend/revolution/js/jquery.themepunch.tools.min.js')}}"></script>
<script src="{{asset('assets/frontend/revolution/js/jquery.themepunch.revolution.min.js')}}"></script>
<script src="{{asset('assets/frontend/revolution/js/extensions/revolution.extension.actions.min.js')}}"></script>
<script src="{{asset('assets/frontend/revolution/js/extensions/revolution.extension.carousel.min.js')}}"></script>
<script src="{{asset('assets/frontend/revolution/js/extensions/revolution.extension.kenburn.min.js')}}"></script>
<script src="{{asset('assets/frontend/revolution/js/extensions/revolution.extension.layeranimation.min.js')}}"></script>
<script src="{{asset('assets/frontend/revolution/js/extensions/revolution.extension.migration.min.js')}}"></script>
<script src="{{asset('assets/frontend/revolution/js/extensions/revolution.extension.navigation.min.js')}}"></script>
<script src="{{asset('assets/frontend/revolution/js/extensions/revolution.extension.parallax.min.js')}}"></script>
<script src="{{asset('assets/frontend/revolution/js/extensions/revolution.extension.slideanims.min.js')}}"></script>
<script src="{{asset('assets/frontend/revolution/js/extensions/revolution.extension.video.min.js')}}"></script>
<script>
    var typed = new Typed('.typed', {
        strings: ["House ^2000", "Apartment ^2000", "Plaza ^4000"],
        smartBackspace: false,
        loop: true,
        showCursor: true,
        cursorChar: "|",
        typeSpeed: 50,
        backSpeed: 30,
        startDelay: 800
    });

</script>

<script>
    $('.slick-lancers').slick({
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
        adaptiveHeight: true,
        responsive: [{
            breakpoint: 1292,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                dots: true,
                arrows: false
            }
        }, {
            breakpoint: 993,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                dots: true,
                arrows: false
            }
        }, {
            breakpoint: 769,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true,
                arrows: false
            }
        }]
    });

</script>

<script>
    $(".dropdown-filter").on('click', function () {

        $(".explore__form-checkbox-list").toggleClass("filter-block");

    });

</script>
<script>
    $('#reservation-date').dateDropper();

</script>
<!-- Time Dropper Script-->
<script>
    this.$('#reservation-time').timeDropper({
        setCurrentTime: false,
        meridians: true,
        primaryColor: "#e8212a",
        borderColor: "#e8212a",
        minutesInterval: '15'
    });

</script>

<script>
    $(document).ready(function () {
        $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false
        });
    });

</script>

<script>
    $('.slick-carousel').each(function () {
        var slider = $(this);
        $(this).slick({
            infinite: true,
            dots: false,
            arrows: false,
            centerMode: true,
            centerPadding: '0'
        });

        $(this).closest('.slick-slider-area').find('.slick-prev').on("click", function () {
            slider.slick('slickPrev');
        });
        $(this).closest('.slick-slider-area').find('.slick-next').on("click", function () {
            slider.slick('slickNext');
        });
    });

</script>

<!-- MAIN JS -->
<script src="{{asset('assets/frontend/js/script.js')}}"></script>

