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

// <!-- 	<div class="announcements">
// 		<div class="pagination">
// 			<a href="#" class="pagination-item active" id="page1"></a>
// 			<a href="#" class="pagination-item" id="page2"></a>
// 			<a href="#" class="pagination-item" id="page3"></a>
// 			<a href="#" class="pagination-item" id="page4"></a>
// 			<a href="#" class="pagination-item" id="page5"></a>
// 			<h5 class="title">What's Going On?</h5>
// 		</div>
// 		<div class="items">
// 			<div class="announce-item active" id="item1">
// 				Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a urna at dolor fermentum rhoncus. Fusce nibh massa, dictum ut egestas quis, consectetur quis arcu. Curabitur et massa quis enim dictum consequat. Praesent dignissim nibh at velit semper et interdum quam porttitor. Morbi congue dolor ut justo aliquam rutrum. Vivamus ac arcu quam. Aliquam eu neque id turpis blandit adipiscing in vitae velit. Donec facilisis sagittis dui, nec euismod sem gravida eu.
// 			</div>
// 			<div class="announce-item" id="item2">
// 				Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a urna at dolor fermentum rhoncus. Fusce nibh massa, dictum ut egestas quis, consectetur quis arcu. Curabitur et massa quis enim dictum consequat. Praesent dignissim nibh at velit semper et interdum quam porttitor. Morbi congue dolor ut justo aliquam rutrum. Vivamus ac arcu quam. Aliquam eu neque id turpis blandit adipiscing in vitae velit. Donec facilisis sagittis dui, nec euismod sem gravida eu.
// 			</div>
// 			<div class="announce-item" id="item3">
// 				Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a urna at dolor fermentum rhoncus. Fusce nibh massa, dictum ut egestas quis, consectetur quis arcu. Curabitur et massa quis enim dictum consequat. Praesent dignissim nibh at velit semper et interdum quam porttitor. Morbi congue dolor ut justo aliquam rutrum. Vivamus ac arcu quam. Aliquam eu neque id turpis blandit adipiscing in vitae velit. Donec facilisis sagittis dui, nec euismod sem gravida eu.
// 			</div>
// 			<div class="announce-item" id="item4">
// 				Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a urna at dolor fermentum rhoncus. Fusce nibh massa, dictum ut egestas quis, consectetur quis arcu. Curabitur et massa quis enim dictum consequat. Praesent dignissim nibh at velit semper et interdum quam porttitor. Morbi congue dolor ut justo aliquam rutrum. Vivamus ac arcu quam. Aliquam eu neque id turpis blandit adipiscing in vitae velit. Donec facilisis sagittis dui, nec euismod sem gravida eu.
// 			</div>
// 			<div class="announce-item" id="item5">
// 				Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a urna at dolor fermentum rhoncus. Fusce nibh massa, dictum ut egestas quis, consectetur quis arcu. Curabitur et massa quis enim dictum consequat. Praesent dignissim nibh at velit semper et interdum quam porttitor. Morbi congue dolor ut justo aliquam rutrum. Vivamus ac arcu quam. Aliquam eu neque id turpis blandit adipiscing in vitae velit. Donec facilisis sagittis dui, nec euismod sem gravida eu.
// 			</div>
// 		</div>
// 		<a class="subscribe-link" href="/announcements">Subscribe to Announcements</a>
// 	</div> -->