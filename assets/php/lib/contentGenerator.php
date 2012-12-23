<?php
	class ContentGenerator {
		protected $user = null;
		protected $page = null;
		protected $auth = null;
		protected $sessionPage = false;

		public function __construct($user, $auth) {
			$this->user = $user;
			$this->auth = $auth;
			if (isset($_GET['page'])) {
				$this->page = $_GET['page'];
				$auth->setSessionVariable("forum_page", $this->page);
			} else if ($auth->getSessionVariable("forum_page")) {
				$this->sessionPage = true;
				$this->page = $auth->getSessionVariable("forum_page");
			}
		}

		public function buildContent() {
			$content = "";
			if (!$this->page || ($this->page && $this->sessionPage)) {
				$content = $this->getHeadContent();
			}
			$content .= $this->getBodyContent();
			if (!$this->page || ($this->page && $this->sessionPage)) {
				$content .= $this->getFooterContent();
			}
			return $content;
		}

		protected function getHeadContent() {
			$head = <<< HTML
	<div class="forum">
		<h1>SASAC Forum</h1>
		<div class="forum_menu">
			<ul class="forum_menu_list">
				<li><a href='#' class='forumMenuClick' id='home'>Home</a></li>
				<li><a href='#' class='forumMenuClick' id='forums'>Forums</a></li>
				<li><a href='#' class='forumMenuClick' id='settings'>Settings</a></li>
			</ul> <!-- /forum_menu_list  -->
		</div>
		<div class='forum_body'>
HTML;
			return $head;
		}

		protected function getBodyContent() {
			$method = "generate" . ucfirst($this->page) . "Content";
			if (method_exists($this, $method)) {
				return $this->$method;
			} else {
				return "<h2>Sorry, page not found.</h2>";
			}
		}

		protected function getFooterContent() {
			$footer = <<< HTML
		</div> <!-- /forum_body -->
	</div> <!-- /forum -->
	<script type="text/javascript">
		$('.forumMenuClick').click(function(e) {
			$.ajax({
				url: 'assets/php/forum.php?page=' + e.target.id,
				success: function(data) {
					$('.forumMenuClick').removeClass('selected');
					$('#' + e.target.id).addClass('selected');
					$('.forum_body').html(data.body);
				},
				error: function(data) {
					alert("Sorry, an error occurred.");
				}
			});
			return false;
		});
	</script>
HTML;
			return $footer;
		}

		protected function generateHomeContent() {
			return "";
		}
	}