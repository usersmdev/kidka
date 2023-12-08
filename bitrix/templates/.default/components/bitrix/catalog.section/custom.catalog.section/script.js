(function() {
	'use strict';

	if (!!window.JCCatalogSectionComponent)
		return;

	window.JCCatalogSectionComponent = function(params) {
		this.formPosting = false;
		this.siteId = params.siteId || '';
		this.ajaxId = params.ajaxId || '';
		this.template = params.template || '';
		this.componentPath = params.componentPath || '';
		this.parameters = params.parameters || '';

		if (params.navParams)
		{
			this.navParams = {
				NavNum: params.navParams.NavNum || 1,
				NavPageNomer: parseInt(params.navParams.NavPageNomer) || 1,
				NavPageCount: parseInt(params.navParams.NavPageCount) || 1
			};
		}

		this.bigData = params.bigData || {enabled: false};
		this.container = document.querySelector('[data-entity="' + params.container + '"]');
		this.showMoreButton = null;
		this.showMoreButtonMessage = null;

		if (this.bigData.enabled && BX.util.object_keys(this.bigData.rows).length > 0)
		{
			BX.cookie_prefix = this.bigData.js.cookiePrefix || '';
			BX.cookie_domain = this.bigData.js.cookieDomain || '';
			BX.current_server_time = this.bigData.js.serverTime;

			BX.ready(BX.delegate(this.bigDataLoad, this));
		}

		if (params.initiallyShowHeader)
		{
			BX.ready(BX.delegate(this.showHeader, this));
		}

		if (params.deferredLoad)
		{
			BX.ready(BX.delegate(this.deferredLoad, this));
		}
		this.YandexMAp();

		if (params.lazyLoad)
		{
			this.showMoreButton = document.querySelector('[data-use="show-more-' + this.navParams.NavNum + '"]');
			this.showMoreButtonMessage = this.showMoreButton.innerHTML;
			BX.bind(this.showMoreButton, 'click', BX.proxy(this.showMore, this));
		}

		if (params.loadOnScroll)
		{
			BX.bind(window, 'scroll', BX.proxy(this.loadOnScroll, this));
		}


	};

	window.JCCatalogSectionComponent.prototype =
	{

		checkButton: function()
		{
			if (this.showMoreButton)
			{
				if (this.navParams.NavPageNomer == this.navParams.NavPageCount)
				{
					BX.remove(this.showMoreButton);
				}
				else
				{
					this.container.appendChild(this.showMoreButton);
				}
			}
		},

		enableButton: function()
		{
			if (this.showMoreButton)
			{
				BX.removeClass(this.showMoreButton, 'disabled');
				this.showMoreButton.innerHTML = this.showMoreButtonMessage;
			}
		},

		disableButton: function()
		{
			if (this.showMoreButton)
			{
				BX.addClass(this.showMoreButton, 'disabled');
				this.showMoreButton.innerHTML = BX.message('BTN_MESSAGE_LAZY_LOAD_WAITER');
			}
		},

		loadOnScroll: function()
		{
			var scrollTop = BX.GetWindowScrollPos().scrollTop,
				containerBottom = BX.pos(this.container).bottom;

			if (scrollTop + window.innerHeight > containerBottom)
			{
				this.showMore();
			}
		},

		showMore: function()
		{
			if (this.navParams.NavPageNomer < this.navParams.NavPageCount)
			{
				var data = {};
				data['action'] = 'showMore';
				data['PAGEN_' + this.navParams.NavNum] = this.navParams.NavPageNomer + 1;

				if (!this.formPosting)
				{
					this.formPosting = true;
					this.disableButton();
					this.sendRequest(data);
				}
			}
		},

		bigDataLoad: function()
		{
			var url = 'https://analytics.bitrix.info/crecoms/v1_0/recoms.php',
				data = BX.ajax.prepareData(this.bigData.params);

			if (data)
			{
				url += (url.indexOf('?') !== -1 ? '&' : '?') + data;
			}

			var onReady = BX.delegate(function(result){
				this.sendRequest({
					action: 'deferredLoad',
					bigData: 'Y',
					items: result && result.items || [],
					rid: result && result.id,
					count: this.bigData.count,
					rowsRange: this.bigData.rowsRange,
					shownIds: this.bigData.shownIds
				});
			}, this);

			BX.ajax({
				method: 'GET',
				dataType: 'json',
				url: url,
				timeout: 3,
				onsuccess: onReady,
				onfailure: onReady
			});
		},

		deferredLoad: function()
		{
			this.sendRequest({action: 'deferredLoad'});
		},

		sendRequest: function(data)
		{
			var defaultData = {
				siteId: this.siteId,
				template: this.template,
				parameters: this.parameters
			};

			if (this.ajaxId)
			{
				defaultData.AJAX_ID = this.ajaxId;
			}

			BX.ajax({
				url: this.componentPath + '/ajax.php' + (document.location.href.indexOf('clear_cache=Y') !== -1 ? '?clear_cache=Y' : ''),
				method: 'POST',
				dataType: 'json',
				timeout: 60,
				data: BX.merge(defaultData, data),
				onsuccess: BX.delegate(function(result){
					if (!result || !result.JS)
						return;

					BX.ajax.processScripts(
						BX.processHTML(result.JS).SCRIPT,
						false,
						BX.delegate(function(){this.showAction(result, data);}, this)
					);
				}, this)
			});






		},

		showAction: function(result, data)
		{
			if (!data)
				return;

			switch (data.action)
			{
				case 'showMore':
					this.processShowMoreAction(result);
					break;
				case 'deferredLoad':
					this.processDeferredLoadAction(result, data.bigData === 'Y');
					break;
			}
		},

		processShowMoreAction: function(result)
		{
			this.formPosting = false;
			this.enableButton();

			if (result)
			{
				this.navParams.NavPageNomer++;
				this.processItems(result.items);
				this.processPagination(result.pagination);
				this.processEpilogue(result.epilogue);
				this.checkButton();
			}
		},

		processDeferredLoadAction: function(result, bigData)
		{
			if (!result)
				return;

			var position = bigData ? this.bigData.rows : {};

			this.processItems(result.items, BX.util.array_keys(position));
		},

		processItems: function(itemsHtml, position)
		{
			if (!itemsHtml)
				return;

			var processed = BX.processHTML(itemsHtml, false),
				temporaryNode = BX.create('DIV');

			var items, k, origRows;

			temporaryNode.innerHTML = processed.HTML;
			items = temporaryNode.querySelectorAll('[data-entity="items-row"]');

			if (items.length)
			{
				this.showHeader(true);

				for (k in items)
				{
					if (items.hasOwnProperty(k))
					{
						origRows = position ? this.container.querySelectorAll('[data-entity="items-row"]') : false;
						items[k].style.opacity = 0;

						if (origRows && BX.type.isDomNode(origRows[position[k]]))
						{
							origRows[position[k]].parentNode.insertBefore(items[k], origRows[position[k]]);
						}
						else
						{
							this.container.appendChild(items[k]);
						}
					}
				}

				new BX.easing({
					duration: 2000,
					start: {opacity: 0},
					finish: {opacity: 100},
					transition: BX.easing.makeEaseOut(BX.easing.transitions.quad),
					step: function(state){
						for (var k in items)
						{
							if (items.hasOwnProperty(k))
							{
								items[k].style.opacity = state.opacity / 100;
							}
						}
					},
					complete: function(){
						for (var k in items)
						{
							if (items.hasOwnProperty(k))
							{
								items[k].removeAttribute('style');
							}
						}
					}
				}).animate();
			}

			BX.ajax.processScripts(processed.SCRIPT);
		},

		processPagination: function(paginationHtml)
		{
			if (!paginationHtml)
				return;

			var pagination = document.querySelectorAll('[data-pagination-num="' + this.navParams.NavNum + '"]');
			for (var k in pagination)
			{
				if (pagination.hasOwnProperty(k))
				{
					pagination[k].innerHTML = paginationHtml;
				}
			}
		},

		processEpilogue: function(epilogueHtml)
		{
			if (!epilogueHtml)
				return;

			var processed = BX.processHTML(epilogueHtml, false);
			BX.ajax.processScripts(processed.SCRIPT);
		},

		YandexMAp: function (){
			$('#view_map').on('click', function (){
				$('#myModal').modal('show');
				ymaps.load(init);
			})


			function init() {
				let result = [];

				$('.catalog-row .news-item').each(function () {
					let ItemObject = new Object();
					let arr_pointr = [];
					let arr_address = [];
					let point;
					let address;
					console.log($(this).find('.map_point'))
					$(this).find('.map_point').each(function () {
						point = $(this).val().split(',');
						arr_pointr.push(point);
					});
					$(this).find('.address').each(function () {
						address = $(this).val();
						arr_address.push(address);
					});
					ItemObject['title'] = $(this).find('.title').text();
					ItemObject['point'] = arr_pointr;
					ItemObject['address'] = arr_address;
					ItemObject['link'] = $(this).find('a.about').attr('href');
					result.push(ItemObject);
				});
				console.log(result)
				//arr_point = ['55.775870837802','37.659226074219'];
				var myMap = new ymaps.Map("mapYa", {
					// Координаты центра карты.
					// Порядок по умолчнию: «широта, долгота».
					center: result[0].point[0],
					// Уровень масштабирования. Допустимые значения:
					// от 0 (весь мир) до 19.
					zoom: 10,
					// Элементы управления
					// https://tech.yandex.ru/maps/doc/jsapi/2.1/dg/concepts/controls/standard-docpage/
					controls: [

						'zoomControl', // Ползунок масштаба
						'rulerControl', // Линейка
						'routeButtonControl', // Панель маршрутизации
						'trafficControl', // Пробки
						'typeSelector', // Переключатель слоев карты
						'fullscreenControl', // Полноэкранный режим

						// Поисковая строка
						new ymaps.control.SearchControl({
							options: {
								// вид - поисковая строка
								size: 'large',
								// Включим возможность искать не только топонимы, но и организации.
								provider: 'yandex#search'
							}
						})

					]
				});
				for (var i = 0; i < result.length; i++) {
					//console.log(result[i].point)
					let balun_title = result[i].title;
					let arr_point_obj = result[i].point;
					let balun_address = result[i].address;
					let balun_link = result[i].link;
					//console.log(result[i].title)
					for (var l = 0; l < arr_point_obj.length; l++) {
						//console.log(result[i].title)
						//console.log(arr_point_obj[l]);
						myMap.geoObjects.add( new ymaps.Placemark(arr_point_obj[l], {
							balloonContent: '<h3>'+result[i].title+'</h3><strong>'+balun_address[l]+'</strong><br><a href="'+balun_link+'">Подробнее</a>'
						}));
					}
				};
				//центровка карты по всем точкам
				//myMap.setBounds(myMap.geoObjects.getBounds(),{checkZoomRange:true, zoomMargin:9});
				$('#myModal').on('hidden.bs.modal', function (e) {
					myMap.destroy();
				})

			}
		},

		showHeader: function(animate)
		{
			var parentNode = BX.findParent(this.container, {attr: {'data-entity': 'parent-container'}}),
				header;

			if (parentNode && BX.type.isDomNode(parentNode))
			{
				header = parentNode.querySelector('[data-entity="header"]');

				if (header && header.getAttribute('data-showed') != 'true')
				{
					header.style.display = '';

					if (animate)
					{
						new BX.easing({
							duration: 2000,
							start: {opacity: 0},
							finish: {opacity: 100},
							transition: BX.easing.makeEaseOut(BX.easing.transitions.quad),
							step: function(state){
								header.style.opacity = state.opacity / 100;
							},
							complete: function(){
								header.removeAttribute('style');
								header.setAttribute('data-showed', 'true');
							}
						}).animate();
					}
					else
					{
						header.style.opacity = 100;
					}
				}
			}
			class Rating {
				constructor(dom) {
					dom.innerHTML = '<svg width="110" height="20"></svg>';
					this.svg = dom.querySelector('svg');
					for(var i = 0; i < 5; i++)
						this.svg.innerHTML += `<polygon data-value="${i+1}"
           transform="translate(${i*22},0)" 
           points="10,1 4,19.8 19,7.8 1,7.8 16,19.8">`;
					this.svg.onclick = e => this.change(e);

					this.render();
				}

				change(e) {
					let value = e.target.dataset.value;
					value && (this.svg.parentNode.dataset.value = value);
					this.render();
				}
				render() {
					this.svg.querySelectorAll('polygon').forEach(star => {
						//let pointer = this.svg.parentNode.style.cssText = "pointer-events:none";
						let on = +this.svg.parentNode.dataset.value >= +star.dataset.value;
						star.classList.toggle('active', on);


					});
				}
			}
			document.querySelectorAll('.rating').forEach(dom => new Rating(dom));
			$('#productType').change(function(){
				//url = BX.util.htmlspecialcharsback(result.FILTER_AJAX_URL);
				let ID = $('#AJAX_ID').data("id");
				console.log(ID)
				BX.ajax.insertToNode($(this).val()+'&bxajaxid='+ID, 'comp_'+ID);

				// var xmlHttp = new XMLHttpRequest();
				// xmlHttp.open( "GET", $(this).val(), false ); // false for synchronous request
				// xmlHttp.send( null );

			});

				$().fancybox({
					selector: '.gal_image',
					backFocus: false
				});
			$('.favor').on('click', function (e) {
				var favorID = $(this).attr('data-item');
				if ($(this).hasClass('active_ds')) {
					var doAction = 'delete';
					//$('.fav_page').find('.favor[data-item="' + favorID + '"]').parents('.cat_list').remove(); // Моментальное удаление, если мы на странице избранного
				} else {
					var doAction = 'add';
					addFavorite(favorID, doAction);
				}
			});
			/* Favorites */
			$('.favor').on('click', function (e) {
				if ($(this).hasClass('active_d')) {
					$(this).removeClass('active_d')
				} else {
					$(this).addClass('active_d')
				}

			});

			/* Избранное */

			function addFavorite(id, action) {
				var param = 'id=' + id + "&action=" + action;
				$.ajax({
					url: '/local/components/smdev/favorite.elements/ajax.php', // URL отправки запроса
					type: "GET",
					dataType: "html",
					data: param,
					timeout: 3000,
					beforeSend: function () {
						$('.preloader').addClass('loaded_hiding');
					},
					error: function (request, error) {
						if (error == "timeout") {
							alert('timeout');
						} else {
							alert('Error! Please try again!');
						}
						console.log('Error: ' + errorThrown);
					},
					success: function (response) {
						var result = response;
						//$('.favor').text(response)
						if (result == 1) { // Если всё хорошо, то выполняем действия, которые показывают, что данные отправлены
							$('.favor[data-item="' + id + '"]').addClass('active_d');
							var wishCount = parseInt($('#want .col').html()) + 1;
							$('#want .col').html(wishCount); // Визуально меняем количество у иконки
						}
						if (result == 2) {
							$('.favor[data-item="' + id + '"]').removeClass('active_d');
							var wishCount = parseInt($('#want .col').html()) - 1;
							$('#want .col').html(wishCount); // Визуально меняем количество у иконки
						}
					}
				});
			}
			$( "#productitem select" ).change(function () {
				var str = "";
				let select = $(this);
				$(this).find( "option:selected" ).each(function() {
					str = $( this ).val();
					let productid = str;
					$.ajax({
						type: "POST",
						url: '/local/components/smdev/service.price.block/ajax/getPrice.php',
						data: {productid: productid},
						timeout: 3000,
						beforeSend: function () {
							$('.preloader').addClass('loaded_hiding');
						},
						error: function (request, error) {
							if (error == "timeout") {
								alert('timeout');
							} else {
								alert('Error! Please try again!');
							}
						},
						success: function (data) {
							select.parents('#productitem').find('.blockoffer').html(data);
						}
					});

				});
				$( "div.text" ).text( str );
			})



		}

	};

})();
