define(['jquery'],
	function($) {
		var currentPage = null;
		var body = $('.page-content');
		var title = $('.page-title h1');
		return {
			'exceptions': {
				'Forum': 'http://sasac.co.uk/forum'
			},
			'map': {
				'Home': [ 'home.html', 'Welcome to St Albans Sub Aqua Club', 'Home'],
				'LearnToDive': [ 'learntodive.html', 'Learn to dive with SASAC', 'Learn To Dive'],
				'AlreadyADiver': [ 'alreadyadiver.html', 'Continue diving with SASAC', 'Continue Diving'],
				'Snorkelling': [ 'snorkelling.html', 'Learn to snorkel with SASAC', 'Snorkelling'],
				'UnderwaterHockey': [ 'underwaterhockey.html', 'Play underwater hockey with SASAC', 'Underwater Hockey'],
				'Social': [ 'social.html', 'SASAC has a social side', 'Social'],
				'TheInstructors': [ 'theinstructors.html', 'Meet the instructors', 'Instructors'],
				'Calendar': [ 'calendar.html', 'SASAC\'s calendar', 'Calendar'],
				'PhotoCompetition': [ 'photocompetition.html', 'SASAC\'s photo competition winners', 'Photo Competition'],
				'Forum': [ 'forum.html', 'SASAC\'s Forum', 'Forum'],
				'RestorationGrant': [ 'restoration.html', 'SASAC\'s Restoration grant', 'Restoration Grant'],
				'Downloads': ['downloads.html', 'SASAC downloads', 'Downloads']
			},
			'navigate': function(location) {
				if (typeof this.exceptions[location] !== 'undefined') {
					window.open(this.exceptions[location], "_blank");
					return false;
				}
				if (typeof this.map[location] !== 'undefined') {
					var me = this;
					if (location === 'Forum' && window.logged_in()) {
						jQuery.ajax({
							async: false,
							url: 'assets/php/forum.php',
							success: function(data) {
								// data = JSON.parse(data);
								$('.header').hide();
								body.html(data.body);
								document.title = me.map[location][2] + " | St Albans Sub Aqua Club";
								window.location.hash = '#' + location;
							}, 
							error: function(jqXHR) {
								title.html('Page Not Found');
								body.html('Sorry, the page you are looking for could not be found.');
								window.location.hash = '#PageNotFound';
							}
						});
					} else {
						jQuery.ajax({
							async: false,
							url: 'assets/pages/' + this.map[location][0],
							success: function(data) {
								title.html(me.map[location][1]);
								document.title = me.map[location][2] + " | St Albans Sub Aqua Club";
								body.html(data);
								$('.header').show();
								window.location.hash = '#' + location;
							},
							error: function(jqXHR) {
								title.html('Page Not Found');
								body.html('Sorry, the page you are looking for could not be found.');
								window.location.hash = '#PageNotFound';
							}
						});
					}
				} else {
					title.html('Page Not Found');
					body.html('Sorry, the page you are looking for could not be found.');
					window.location.hash = '#PageNotFound';
				}
				return true;
			}
		};
	});