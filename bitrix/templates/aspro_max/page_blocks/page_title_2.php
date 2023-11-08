<div class="top-block-wrapper grey_block">
	<section class="page-top maxwidth-theme <?CMax::ShowPageProps('TITLE_CLASS');?>">
		<div id="navigation">
			<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "main", array(
				"START_FROM" => "0",
				"PATH" => "",
				"SITE_ID" => SITE_ID,
				"SHOW_SUBSECTIONS" => "N"
				),
				false
			);?>
		</div>
		<?$APPLICATION->ShowViewContent('section_bnr_h1_content');?>
		<div class="topic">
			<div class="topic__inner">
				<?=$APPLICATION->ShowViewContent('product_share')?>
				<h1 class="topic__heading" id="pagetitle"><?$APPLICATION->ShowTitle(false)?><?$APPLICATION->ShowViewContent('more_text_title');?></h1>
			</div>
		</div>
	</section>
</div>