define(['jquery', 'Router'],
	function($, Router) {
		return {
			onHover: function(e) {
				if (!$(e.target).hasClass('selected')) {
					$('.hover').removeClass('hover');
					$(e.target).addClass('hover');
				}
			},
			onLeave: function(e) {
				$('.hover').removeClass('hover');
			},
			onClick: function(e) {
				$(window).css('cursor', 'progress');
				$('.hover').removeClass('hover');
				var result = Router.navigate(e.target.id.substring(0, e.target.id.length - 1));
				if (result) {
					$('.selected').removeClass('selected');
					$(e.target).addClass('selected');
				}
				$(window).css('cursor', '');
				return false;
			}
		};
	});