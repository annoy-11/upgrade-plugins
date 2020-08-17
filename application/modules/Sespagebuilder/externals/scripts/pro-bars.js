//	ProBars v1.0, Copyright 2014, Joe Mottershaw, https://github.com/joemottershaw/
//	===============================================================================

	function animateProgressBar() {
		sesTree ('.pro-bar').each(function(i, elem) {
			var	elem = sesTree(this),
				percent = elem.attr('data-pro-bar-percent'),
				delay = elem.attr('data-pro-bar-delay');

			if (!elem.hasClass('animated'))
				elem.css({ 'width' : '0%' });

			if (elem.visible(true)) {
				setTimeout(function() {
					elem.animate({ 'width' : percent + '%' }, 2000, 'easeInOutExpo').addClass('animated');
				}, delay);
			} 
		});
	}

	sesTree (document).ready(function() {
		animateProgressBar();
	});

	sesTree (window).resize(function() {
		animateProgressBar();
	});

	sesTree (window).scroll(function() {
		animateProgressBar();

		if (sesTree(window).scrollTop() + sesTree(window).height() == sesTree(document).height())
			animateProgressBar();
	});