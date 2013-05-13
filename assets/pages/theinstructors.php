<div>
	<p>This is a list of the currently active instructors at St Albans Sub Aqua Club.</p>
<?php
	$instructors = array(
		"Carl Graham" => array(
			"grade" => "Dive Leader",
			"instructor" => "Open Water Instructor",
			"description" => "Carl enjoys diving because it means he can leave work behind and relax with friends."
		),
		"Steve Kennedy" => array(
			"grade" => "BSAC Dive Leader",
			"instructor" => "BSAC Open Water Instructor",
			"description" => "Trained with PADI in 2005 in Spain and joined SASAC in 2006. Steve likes the 'feeling of flying' you get from diving and being able to get up close to sea life. 'On land you see something 20 yards away - in the sea it's so close.'"
		),
		"Sarah Kennedy" => array(
			"grade" => "BSAC Dive Leader",
			"instructor" => "BSAC Open Water Instructor",
			"description" => "Trained with PADI in 2005 in Spain and joined SASAC in 2006. Sarah likes the tranquillity of diving and prefers the sea life of scenic diving to exploring wrecks - 'I'm not that interested in scrap metal!'"
		),
		"Paul Compton" => array(
			"grade" => "BSAC Advanced Instructor",
			"instructor" => "BSAC First Class Diver",
			"description" => "Paul has a special interest in technical diving and has taken Technical Diving International's Trimix Diver course. 'It was something I'd always wanted to do - the children had grown up and I could go diving when I liked'."
		),
		"Peter Stansfield" => array(
			"grade" => "BSAC Advanced Instructor",
			"instructor" => "BSAC First Class Diver",
			"description" => "Learnt to dive in 1976 and then joined Potters Bar Sub Aqua Club before joining SASAC in 1988. 'Diving is one of the few things that stops me worrying about work.' A keen technical diver, Peter has taken the Trimix Diver certification, and is qualified to run most of the BSAC Skill Development Courses."
		)
		// "Lisa Shafe" => array(
		// 	"grade" => "",
		// 	"instructor" => "",
		// 	"description" => ""
		// ),
		// "Jacqui Willis" => array(
		// 	"grade" => "",
		// 	"instructor" => "",
		// 	"description" => ""
		// ),
		// "Pierre Leon" => array(
		// 	"grade" => "",
		// 	"instructor" => "",
		// 	"description" => ""
		// ),
		// "Reg Ellis" => array(
		// 	"grade" => "BSAC Advanced Diver",
		// 	"instructor" => "BSAC Open Water Instructor",
		// 	"description" => "Trained with SASAC in 1984. Reg likes the adventure of UK diving over the 'pedestrian predictability' of most warm-water diving. He has a special interest in marine life - 'a lot of it tastes so good.'"
		// ),
		// "Steve Gore" => array(
		// 	"grade" => "",
		// 	"instructor" => "",
		// 	"description" => ""
		// ),
	);

	ksort($instructors);

	$i = 1;

	foreach ($instructors as $name => $attrbs) {
		$grade = $attrbs["grade"];
		$instructor = $attrbs["instructor"];
		$description = $attrbs["description"];
		$image = str_replace(" ", "", $name);
		if ($i === 1) {
?>
	<div class='image-gallery-row'>
<?php
		}
?>

		<div class='image-gallery-column'>
			<a class='image-gallery-image' href='#'>
				<span class='image-gallery-roll' instructorInfo="<h5><?php echo $name; ?>, <?php echo $grade; ?></h5><h6><?php echo $instructor; ?></h6><p><?php echo $description; ?></p>" instructorName="<?php echo $name; ?>"></span>
				<img src="assets/media/instructors/<?php echo $image; ?>.jpg" class="img-rounded">
			</a> 
			<p><?php echo $name; ?></p>
		</div>

<?php
		if ($i === 4) {
			$i = 0;
?>
	</div>
<?php
		}
		$i++;
	}
?>

<div class="modal hide fade" id="instructor-info">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 id='instructor-name'></h3>
	</div>
	<div class="modal-body">
		<img src="" class='img-rounded img-modal'>
		<div id='instructor-blurb'></div>
	</div>
</div>

<script type="text/javascript">
$(function() {
	$(".image-gallery-roll").css("opacity","0");

	$(".image-gallery-roll").hover(function () {
		$(this).stop().animate({
		opacity: .7
		}, "slow");
	},

	function () {
		$(this).stop().animate({
		opacity: 0
		}, "slow");
	});

	$('.image-gallery-roll').click(function(e) {
		$instructor = $(e.target);
		$image = $(e.target.nextElementSibling);
		$('#instructor-name').html($instructor.attr('instructorName'));
		$('.img-modal').attr('src', $image.attr('src'));
		$('#instructor-blurb').html($instructor.attr('instructorInfo'));
		$('#instructor-info').modal();
		return false;
	});
});
</script>

</div>