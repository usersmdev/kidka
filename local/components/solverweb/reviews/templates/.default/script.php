<script type="text/javascript">
	function DefaultReview(object)
	{
		this.element = object['ELEMENT'];
		this.object = object;
		this.sended = false;
		
		this.constructor.prototype.formShow = function (callback) {
			$(this.element).find('#form').show();
			
			if (callback !== undefined) {
				callback();
			}
		}
		
		this.constructor.prototype.formHide = function (callback) {
			$(this.element).append('<div class="success" style="padding: 10px;font-size: 16px;color: green;">Ваш отзыв отправлен. Благодарим Вас!</div>');
			$(this.element).find('#form').hide();
			if (callback !== undefined) {
				callback();
			}
		}
		
		if (this.object['PARAMETERS']['FILTER_FIELDS'] == true)
		{
		
			$(this.element).find('#name').focusout(function(){
				var ret = /^([a-zA-Zа-яА-ЯёЁ -]*)$/; // валидация имени
					console.log(ret.test($(this).val()));
				if ($(this).val().length == 0 || !ret.test($(this).val())) {
					$(this).addClass('error');
				} else {
					$(this).removeClass('error');
				}
			});
			$(this.element).find('#description').focusout(function(){
				if ($(this).val().length == 0) {
					$(this).addClass('error');
				} else {
					$(this).removeClass('error');
				}
			});
			$('input[type="radio"].rank').each(function(){
				$(this).change(function(){
					if ($('input[type="radio"].rank:checked').val() > 0) {
						$(this).parent().css('background','');
					} else {
						$(this).parent().css('background','rgba(255, 10, 10, 0.4)');
					}
				});
			});
		}
		
		this.constructor.prototype.Send = function (callback) {
			if (this.sended == false) {
				var ret = /^([a-zA-Zа-яА-ЯёЁ -]*)$/; // валидация имени
				var nameEl = $(this.element).find('#name');
				var name = nameEl.val();
				var descriptionEl = $(this.element).find('#description');
				var description = descriptionEl.val();
				var rankEl = $(this.element).find('input[type="radio"].rank');
				var rankChEl = $(this.element).find('input[type="radio"].rank:checked');
				var rank = rankChEl.val();
				
				if (nameEl.val().length == 0 || !ret.test(nameEl.val()))
					nameEl.addClass('error');
				else 
					nameEl.removeClass('error');
				
				if (descriptionEl.val().length == 0)
					descriptionEl.addClass('error');
				else
					descriptionEl.removeClass('error');
				
				if (rank > 0)
					rankEl.parent().css('background','');
				else
					rankEl.parent().css('background','rgba(255, 10, 10, 0.4)');
				
				if (name.length > 0 && description.length > 0 && rank>0) {
					var element = encodeURIComponent(this.object['PARAMETERS']['ELEMENT_ID']);
					var iblock = encodeURIComponent(this.object['PARAMETERS']['IBLOCK_ID']);
					var charset = encodeURIComponent(this.object['PARAMETERS']['CHARSET']);
					var name = encodeURIComponent(name);
					var description = encodeURIComponent(description);
					var rank = rank;
					var url = '<?=$templateFolder.'/ajax/add_review.php'?>';
					
					$.ajax({
						'url': url,
						'type': 'POST',
						'data': {
							'element':element,
							'iblock':iblock,
							'charset':charset,
							'name':name,
							'description':description,
							'rank':rank
						},
						'success': function(){
							if (callback !== undefined) {
								callback();
							}
							
							this.sended = true;
						}
					});
				}
			}
		}
	}
</script>