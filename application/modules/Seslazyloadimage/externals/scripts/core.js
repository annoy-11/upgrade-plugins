//https://github.com/verlok/lazyload
//LazyLoad is a fast, lightweight and flexible script that speeds up your web application by loading images as they enter the viewport. It's written in plain "vanilla" JavaScript, uses IntersectionObserver, and supports responsive images. It's also SEO-friendly and it has some other notable features. https://www.andreaverlicchi.eu/lazyload/

en4.core.runonce.add(function() {

    var lazyloading = function() {
        //console.log('4545');
        var images = document.body.getElementsByClassName("_lazyload");
        var imagesLength = images.length;
        if(!imagesLength) return;

        if(lazyLoadInstance) {
            lazyLoadInstance.update();
        } else {
            var lazyLoadInstance = new LazyLoad({
                elements_selector: "._lazyload",
                //threshold: 300,
            });
        }
    };
    setTimeout(lazyloading, 1000);
});
