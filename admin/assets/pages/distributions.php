<?php
	require_once "announcements.php";
	$newsItems = getAnnouncementItems("News");
	$divingItems = getAnnouncementItems("Diving");
	$trainingItems = getAnnouncementItems("Training");
	$socialItems = getAnnouncementItems("Social");
?>

<h2>News</h2>
	<ul class="js-News sortable">
	</ul>
	<select name="News" id="select-News">
<?php
	foreach ($newsItems as $key => $item) {
?>
		<option value="<?php echo $key; ?>"><?php echo $item["Title"]; ?></option>
<?php
	}
?>
	</select>
	<a href="#" category="News" class="btn js-select">Add</a>

<h2>Diving</h2>
	<ul class="js-Diving sortable">
	</ul>
	<select name="Diving" id="select-Diving">
<?php
	foreach ($divingItems as $key => $item) {
?>
		<option value="<?php echo $key; ?>"><?php echo $item["Title"]; ?></option>
<?php
	}
?>
	</select>
	<a href="#" category="Diving" class="btn js-select">Add</a>

<h2>Training</h2>
	<ul class="js-Training sortable">
	</ul>
	<select name="Training" id="select-Training">
<?php
	foreach ($trainingItems as $key => $item) {
?>
		<option value="<?php echo $key; ?>"><?php echo $item["Title"]; ?></option>
<?php
	}
?>
	</select>
	<a href="#" category="Training" class="btn js-select">Add</a>

<h2>Social</h2>
	<ul class="js-Social sortable">
	</ul>
	<select name="Social" id="select-Social">
<?php
	foreach ($socialItems as $key => $item) {
?>
		<option value="<?php echo $key; ?>"><?php echo $item["Title"]; ?></option>
<?php
	}
?>
	</select>
	<a href="#" category="Social" class="btn js-select">Add</a>

<script>
	$(function() {
		$( ".sortable" ).sortable({
			placeholder: "ui-state-highlight"
		})
		$( ".sortable" ).disableSelection()

		$('.js-select').click(function(){
			var category = $(this).attr('category')
			if ($('#select-' + category + ' option').length > 0) {
				var value = $('#select-' + category + ' option:selected')
				var text = value.text()
				$('.js-' + category).append('<li class="ui-state-default">' + text + '</li>')
				$('#select-' + category + ' option:selected').remove()
			}
		})
	})
</script>