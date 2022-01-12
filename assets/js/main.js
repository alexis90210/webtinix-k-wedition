// sticking navbar + changing states
(function() {
    $(document).ready(function() {

        $(window).scroll(function() {
            if(isScrolledAfterElement('#hideTopNav')) {
                $('#topNav').addClass('hidden md:flex');
                $('#fixedBtn').removeClass('hidden md:flex');
            } else {
               $('#topNav').removeClass('hidden md:flex');
               $('#fixedBtn').addClass('hidden md:flex');;
            }
        })

        function isScrolledAfterElement(elem) {
            const $elem = $(elem);
            const $window = $(window);

            const docViewTop = $window.scrollTop();
            const docViewBottom = docViewTop + $window.height();

            const elemTop = $elem.offset().top;

            return elemTop <= docViewBottom;
        }
    });
})();