function setNewHeader(){
	var ratingHtml = priceHtml = imgHtml = skuHtml = buttonHtml = '';

	if(arMaxOptions['THEME']['SHOW_HEADER_GOODS'] != 'Y')
		return;

	/*if($('.logo-row.wproducts').length)
		return;*/

	if($('.product-info-headnote .rating').length) //show rating
	{
		ratingHtml = '<div class="votes_block nstar'+(arAsproOptions['THEME']['REVIEWS_VIEW'] == 'EXTENDED' ? ' pointer' : '')+'"><div class="ratings"><div class="inner_rating"';
		var inner =  $('.product-info-headnote .rating .inner_rating');
		if(inner.length && inner.attr('title') !== undefined) {
			ratingHtml += 'title="'+inner.attr('title');
		} 
		ratingHtml += '">';

		$('.product-info-headnote .rating .inner_rating > div').each(function(index){
			var index_title = index+1;
			ratingHtml += '<div class="item-rating '+($(this).hasClass('filed') ? 'filed' : '');
			if(inner.attr('title') === undefined) {
				ratingHtml += '" title="'+index_title;
			}
			ratingHtml += '">'+$(this).html()+'</div>';
		});

		ratingHtml += '</div></div></div>';

		if($('.product-info-headnote .rating span').length) {
			ratingHtml += $('.product-info-headnote .rating span')[0].outerHTML;
		}
	}
	if($('div *[itemprop="offers"]').length) //show price
	{
		/*if($('.cost.detail .js_price_wrapper').length)
		{
			priceHtml = $('.cost.detail .js_price_wrapper .price_matrix_wrapper').html();
		}
		else
		{
			if($('.cost.detail .price_group.min').length)
				priceHtml = $('.cost.detail .price_group.min').html();
			else if($('.cost.detail .price_matrix_wrapper').length)
				priceHtml = $('.cost.detail .price_matrix_wrapper').html();
		}*/
		priceHtml = $('.cost.detail').html();
	}

	if($('#photo-sku').length) //show img
	{
		imgSrc = ($('#photo-sku .product-detail-gallery__picture.one').attr('src') ? $('#photo-sku .product-detail-gallery__picture.one').attr('src') : $('#photo-sku .product-detail-gallery__picture').data('src') ? $('#photo-sku .product-detail-gallery__picture').data('src') : $('#photo-sku .product-detail-gallery__picture').attr('src'));
	}
	else if($('.product-detail-gallery__slider #photo-0').length)
	{
		imgSrc = ($('.product-detail-gallery__slider #photo-0 .product-detail-gallery__picture').data('src') ? $('.product-detail-gallery__slider #photo-0 .product-detail-gallery__picture').data('src') : $('.product-detail-gallery__slider #photo-0 .product-detail-gallery__picture').attr('src'));
	}

	if($('.slide_offer').length) //show button
		buttonHtml = '<span class="buy_block"><span class="btn btn-default btn-sm slide_offer type_block">'+($('.product-container .buy_block .offer_buy_block .in-cart').is(':visible') ? $('.product-container .buy_block .offer_buy_block .in-cart').html() : BX.message('MORE_INFO_SKU'))+'</span></span>';
	else if($('.buy_block .sku_props').length)
		buttonHtml = '<span class="buy_block"><span class="btn btn-default btn-sm more type_block">'+($('.product-container .buy_block .offer_buy_block .in-cart').is(':visible') ? $('.product-container .buy_block .offer_buy_block .in-cart').html() : BX.message('MORE_INFO_SKU'))+'</span></span>';
	else if($('.buy_block .button_block').length)
		buttonHtml = $('.buy_block .button_block').html().replace(/btn-lg/g, 'btn-sm');

	if($('.sku_props .bx_catalog_item_scu > div').length)
	{
		var skuHtmlTmp = '';
		$('.product-container .sku_props .bx_catalog_item_scu > div').each(function(){
			var _this = $(this),
				li_block = _this.find('li.active'),
				select_block = _this.find('select');
			if(li_block.length)
			{
				skuHtmlTmp += '<div class="bx_catalog_item_scu"><div class="bx_scu"><div class="'+_this.attr('class')+'"><ul><li class="active" title="'+li_block.attr('title')+'">'+li_block.html()+'</li></ul></div></div></div>';
			}
			else if(select_block.length)
			{
				if(select_block.find('option:selected').data('img_src') !== undefined)
				{
					skuHtmlTmp += '<div class="bx_catalog_item_scu"><div class="bx_scu"><div class="bx_item_detail_scu"><ul><li class="active" title="'+select_block.val()+'"><span class="cnt1"><span class="cnt_item" style="background-image:url('+select_block.find('option:selected').data('img_src')+')"></span></span></li></ul></div></div></div>';
				}
				else
				{
					skuHtmlTmp += '<div class="bx_catalog_item_scu"><div class="bx_scu"><div class="'+_this.attr('class')+'"><ul><li class="active"><span class="cnt">'+select_block.val()+'</span></li></ul></div></div></div>';
				}
			}
		})
		skuHtml = skuHtmlTmp;
	}

	$('#headerfixed .logo-row').html(
	'<div class="ajax_load">'+
		'<div class="table-view flexbox flexbox--row">'+
			'<div class="table-view__item item main_item_wrapper">'+
				'<div class="table-view__item-wrapper item_info catalog-adaptive flexbox flexbox--row">'+
					'<div class="item-foto">'+
						'<div class="item-foto__picture">'+
							'<img src="'+imgSrc+'" />'+
						'</div>'+
					'</div>'+
					'<div class="item-info">'+
						'<div class="item-title">'+
							'<span>'+$('#pagetitle').text()+'</span>'+
						'</div>'+
						'<div class="wrapp_stockers sa_block">'+
							'<div class="rating sm-stars">'+ratingHtml+'</div>'+
							($('.quantity_block_wrapper .item-stock').length ? '<div class="item-stock">'+$('.quantity_block_wrapper .item-stock').html()+'</div>' : '')+
						'</div>'+
					'</div>'+
					'<div class="item-actions flexbox flexbox--row">'+
						'<div class="item-price">'+
							'<div class="cost prices">'+priceHtml+'</div>'+
						'</div>'+
						'<div class="item-sku">'+
							'<div class="but-cell flexbox flexbox--row sku_props">'+skuHtml+'</div>'+
						'</div>'+
						'<div class="item-buttons">'+
							'<div class="but-cell">'+buttonHtml+'</div>'+
						'</div>'+
						($('.product-info .like_icons').length ? '<div class="item-icons s_'+$('.product-info .like_icons').data('size')+'"><div class="like_icons list static icons long">'+$('.product-info .like_icons').html()+'</div></div>' : '')+
					'</div>'+
				'</div>'+
			'</div>'+
		'</div>'+
	'</div>');

	InitLazyLoad();
}

$(document).on('click', ".item-stock .store_view", function(){
	scroll_block($('.js-store-scroll'), $('a[href=#stores]'));
});

$(document).on('click', '.blog-info__rating--top-info, #headerfixed .wproducts .wrapp_stockers .rating .votes_block', function() {
	var reviews = $('.reviews.EXTENDED');
	if(reviews.length) {
		scroll_block(reviews, $('.ordered-block .nav-tabs a[href="#reviews"]'));
	}
});

$(document).on('click', ".table-view__item--has-stores .item-stock .value", function(){
	$(this).closest('.table-view__item-wrapper').find('.stores-icons .btn').trigger('click');
});

$(document).on('click', '#headerfixed .item-buttons .more', function(){
	if($('.product-container .buy_block .offer_buy_block .to-cart').is(':visible'))
		$('.product-container .buy_block .offer_buy_block .to-cart').trigger('click');
	else
		location.href = arAsproOptions['PAGES']['BASKET_PAGE_URL'];
})

$(document).on('click', '#headerfixed .item-actions .bx_catalog_item_scu', function(){
	var offset = 0;
	offset = $('.product-container .sku_props .bx_catalog_item_scu').offset().top;
		
	$('body, html').animate({scrollTop: offset-150}, 500);
})

$(document).on('click', ".stores-title .stores-title__list", function(){
	var _this = $(this);
	_this.siblings().removeClass('stores-title--active');
	_this.addClass('stores-title--active');

	$('.stores_block_wrap .stores-amount-list').hide(100).removeClass('stores-amount-list--active');
	$('.stores_block_wrap .stores-amount-list:eq('+_this.index()+')').show(100, function(){
		if(_this.hasClass('stores-title--map'))
		{
			if(typeof map !== 'undefined')
			{
				map.container.fitToViewport();
				if(typeof clusterer !== 'undefined' && !$(this).find('.detail_items').is(':visible'))
				{
					map.setBounds(clusterer.getBounds(), {
						zoomMargin: 40,
						// checkZoomRange: true
					});
				}
			}
		}
	}).addClass('stores-amount-list--active');

})

$(document).on('click', ".info_ext_block .title", function(){
	var _this = $(this);
	_this.toggleClass('opened');
	_this.next().slideToggle();
})

$(document).on('click', ".stores-icons .btn", function(){
	var _this = $(this),
		block = _this.closest('.table-view__item-wrapper').next(),
		bVisibleblock = (block.is(':visible')),
		animate = (bVisibleblock ? 'slideUp' : 'slideDown');

	if(!_this.hasClass('clicked'))
	{
		_this.addClass('clicked');

		block.velocity('stop').velocity(animate, {
			duration: 400,
			// delay: 250,
			begin: function(){
				_this.toggleClass('closed');
			},
			complete: function(){
				_this.removeClass('clicked');
				// InitLazyLoad();
			}
		});
	}
});