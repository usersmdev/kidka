$(document).ready(function(){
	// var dataText = $('.landings-list__item--js-more > span').text(),
	var lastVisible = $('.landings-list__item.last');
	$('.landings-list__item--js-more').on('click', function(){
		var $this = $(this),
			block = $this.find('> span'),
			dataOpened = $this.data('opened'),
			thisText = block.text()
			dataText = block.data('text'),
			item = $this.closest('.landings-list__info').find('.landings-list__item-more');

		item.removeClass('hidden');

		if(dataOpened != 'Y'){
			item.velocity('stop').velocity({
				'opacity': 1,
			}, {
				'display': 'inline',
				'duration': 200,
				begin: function(){
					lastVisible.toggleClass('last');
				}
			});
			$this.addClass('opened').data('opened', 'Y');
		}
		else{
			item.velocity('stop').velocity({
				'opacity': 0,
			}, {
				'display': 'none',
				'duration': 100,
				complete: function(){
					lastVisible.toggleClass('last');
				}
			});
			$this.removeClass('opened').data('opened', 'N');
		}
		
		block.data('text', thisText).text(dataText);
	});
});