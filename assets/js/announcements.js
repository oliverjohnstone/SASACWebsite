var currentItem = 1

$(function(){
	setInterval(function() {
		if (parseInt(currentItem) == 5) {
			change(1)
		} else {
			change(parseInt(currentItem) + 1)
		}
	}, 10000)
	$('.pagination-item').click(function(e){
		id = $(e.target).attr('id').substring(4)
		change(id)
		return false
	})
})

function change(id) {
	$('.pagination-item').removeClass('active')
	$('.announce-item').removeClass('active')
	$('#item' + currentItem).fadeOut(400, function() {
		currentItem = id
		$('#item' + currentItem).slideDown()
		$('#page' + currentItem).toggleClass('active')
		$('#item' + currentItem).toggleClass('active')
	})
}