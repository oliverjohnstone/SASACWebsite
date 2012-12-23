define(['jquery'],
	function($) {
		var currentPage = null;
		var body = $('.page-content');
		var title = $('.page-title h1');
		return {
			exceptions: {
				"Forum": "http://sasac.co.uk/forum"
			},
			map: {
				Home: [ 'home.html', 'Welcome to St Albans Sub Aqua Club' ],
				// TryDive: [ 'trydive.html', 'Come down to SASAC for a Try Dive'],
				LearnToDive: [ 'learntodive.html', 'Learn to dive with SASAC' ],
				AlreadyADiver: [ 'alreadyadiver.html', 'Continue diving with SASAC' ],
				Snorkelling: [ 'snorkelling.html', 'Learn to snorkel with SASAC' ],
				UnderwaterHockey: [ 'underwaterhockey.html', 'Play underwater hockey with SASAC' ],
				Social: [ 'social.html', 'SASAC has a social side' ],
				TheInstructors: [ 'theinstructors.html', 'Meet the instructors' ],
				Calendar: [ 'calendar.html', 'SASAC\'s calendar' ],
				PhotoCompetition: [ 'photocompetition.html', 'SASAC\'s photo competition winners'  ],
				Forum: [ 'forum.html', 'SASAC\'s Forum' ],
				RestorationGrant: [ 'restoration.html', 'SASAC\'s Restoration grant' ],
				Downloads: ['downloads.html', 'SASAC downloads'],
			},
			navigate: function(location) {
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