						<?CMax::checkRestartBuffer();?>
						<?IncludeTemplateLangFile(__FILE__);?>
							<?if(!$isIndex):?>
								<?if($isHideLeftBlock && !$isWidePage):?>
									</div> <?// .maxwidth-theme?>
								<?endif;?>
								</div> <?// .container?>
							<?else:?>
								<?CMax::ShowPageType('indexblocks');?>
							<?endif;?>
							<?CMax::get_banners_position('CONTENT_BOTTOM');?>
						</div>

 <?// .middle?>
					<?//if(($isIndex && $isShowIndexLeftBlock) || (!$isIndex && !$isHideLeftBlock) && !$isBlog):?>
					<?if(($isIndex && ($isShowIndexLeftBlock || $bActiveTheme)) || (!$isIndex && !$isHideLeftBlock)):?>
						</div> <?// .right_block?>
							<?if($APPLICATION->GetProperty("HIDE_LEFT_BLOCK") != "Y" && !defined("ERROR_404")):?>
								<?if(CSite::InDir("/uslugi/") || CSite::InDir("/izbrannoe-uslugi/")): ?>
								<?else:?>
								<?CMax::ShowPageType('left_block');?>
                            <?endif;?>
							<?endif;?>
							<?if($APPLICATION->GetProperty("HIDE_LEFT_BLOCK") != "Y" && !defined("ERROR_404")):?>
							<?if($APPLICATION->GetCurPage() != "/uslugi/" && $count_page < 3): ?>
                                    <?if(CSite::InDir("/izbrannoe-uslugi1/")): ?>
                                    <?else:?>
								<?CMax::ShowPageType('left_block');?>
                                <?endif;?>
							<?endif;?>
							
						<?endif;?>
					<?endif;?>
					</div> <?// .container_inner?>
				<?if($isIndex):?>
					</div>
				<?elseif(!$isWidePage):?>
					</div> <?// .wrapper_inner?>
				<?endif;?>
			</div> <?// #content?>
			<?CMax::get_banners_position('FOOTER');?>
		</div><?// .wrapper?>

		<?//FLOAT_BANNERS?>
                       
		<?if(!$isIndex):?>
			<div class="middle  ">
				<div class="container float_banners text-inside" data-class="middle_adv_drag">
					<?include(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/mainpage/components/middle_adv/type_4.php'));?>
				</div>
			</div>
		<?endif;?>

		<footer id="footer">
			<?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/footer_include/under_footer.php'));?>
			<?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/footer_include/top_footer.php'));?>
		</footer>

		<?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/footer_include/bottom_footer.php'));?>
		<?
		if ($APPLICATION->GetPageProperty('body_class')) {
			$GLOBALS['dopBodyClass'] .= ' '.$APPLICATION->GetPageProperty("body_class");;
		}
		?>

	<link href="/bitrix/templates/aspro_max/css/custom_2.css" type="text/css"  data-template-style="true"  rel="stylesheet" />

	</body>
</html>