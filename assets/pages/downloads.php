<div>
	<div class="loading"></div>
	<p>The following downloads are all the important club documents and useful
		information regarding St Albans Sub Aqua Club.</p>
	<div class="home" onclick="parseDirectory(); return false;"></div>
	<label class="location">/</label>
	<ul class="downloads_list">
	</ul>
</div>
<script type="text/javascript">
	parseDirectory();
	function parseDirectory(path) {
		$('.downloads_list').hide()
		$('.loading').show()
		if (typeof path === 'undefined') {
			path = ""
		}
		var $ul = $(".downloads_list")
		$.ajax({
			url: "assets/php/downloads.php?folder=" + path,
			success: function(result) {
				$ul.empty()
				if (result.parent !== false) {
					$ul.append("<li class='li_dir'><a href='#' onclick='parseDirectory(\"" + 
					result.parent + "\"); return false;'>..</a></li>")
					$(".home").css("background-position", "left bottom")
					$(".home").css("cursor", "pointer");
				} else {
					$(".home").css("background-position", "left top")
					$(".home").css("cursor", "default");
				}
				if (result.directory.length > 0) {
					for(var file in result.directory) {
						if (result.directory[file].isFile) {
							$ul.append("<li class='li_file'><a href='assets/php/downloads.php?folder=" + path + "&file=" + 
							result.directory[file].name + "' target='_blank'>" + 
							result.directory[file].name + "</a></li>")
						} else {
							$ul.append("<li class='li_dir'><a href='#' onclick='parseDirectory(\"" + 
							result.path + "/" + result.directory[file].name + "\"); return false;'>" + 
							result.directory[file].name + "</a></li>")
						}
					}
				} else if (result.parent === false) {
					$ul.append("<li>Sorry, no downloads available at the moment.</li>")
				}
				$('.location').text("/" + result.path);
				$('.loading').hide()
				$ul.show()
			},
			error: function(e) {
				$ul.append("<li><font color='red'>Sorry, an error occurred while listing the directory.</font></li>")
				$('.loading').hide()
				$ul.show()
			}
		})
		return false;
	}
</script>