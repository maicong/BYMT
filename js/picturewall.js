/**
 *
 * @package     BYMT
 * @author      MaiCong (i@maicong.me)
 * @link        https://maicong.me/t/119
 * @version     2.1.2
 */

jQuery(document).ready(function($){
   $('#picturewall').imagesLoaded(function(){
	var handler = null,
	option = {
	  autoResize: true,
	  container: $('#picturewall'),
	  offset: 10,
	  outerOffset: 5,
	  flexibleWidth: 260
	};
	function applyLayout(){
	  $('#picturewall').imagesLoaded(function(){
		if(handler.wookmarkInstance){
		  handler.wookmarkInstance.clear();
		}
		handler = $('#picturewall #imgbox');
		handler.wookmark(option);
	  });
	}
	var sentIt = true,	nextHref = $(".page_next").attr("href");
	$(window).on("scroll", function(){
		var winHeight = window.innerHeight ? window.innerHeight : $(window).height(),
		closeToBottom = ($(window).scrollTop() + winHeight > $(document).height() - 100 && sentIt);
		if(closeToBottom){
			 if(nextHref !== undefined){
				$('.imgover').text('正在加载...').fadeIn();
				$.ajax({
					url: nextHref,
					type: "html",
					beforeSend: function(){sentIt = false;},
					success: function(data){
						nextHref = $(data).find(".page_next").attr("href");
						$(".page_next").attr("href", nextHref);
						$('#picturewall').append(data);
						$('.imgover').slideUp();
						applyLayout();
					},
					complete: function(){setTimeout(sentIt = true, 600);}
				});
			}else{
				$('.imgover').text('没有了哦！').fadeIn();
				setTimeout(function() {$('.imgover').fadeOut()},1000);
			}
		}
	});
	handler = $('#picturewall #imgbox');
	handler.wookmark(option);
  });
});
