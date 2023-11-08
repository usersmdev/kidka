<?
$userPhone = '';
$login = $USER->GetLogin();
if (preg_match('#^\d{11}$#', $login)) {
	$userPhone = $login;
}
elseif ($USER->GetID()) {
	if (!$_SESSION['ONE_CLICK_USER_DATA'] || ($_SESSION['ONE_CLICK_USER_DATA']['ID'] != $USER->GetID())) {
		$r  = \CUser::GetByID($USER->GetID())->GetNext();
		$_SESSION['ONE_CLICK_USER_DATA']['ID'] = $USER->GetID();
		$_SESSION['ONE_CLICK_USER_DATA']['UF_BXMAKER_AUPHONE'] = '';
		if ($r) {
			$_SESSION['ONE_CLICK_USER_DATA']['UF_BXMAKER_AUPHONE'] = $r['UF_BXMAKER_AUPHONE'];
		}
		unset($r);
	}
	if ($_SESSION['ONE_CLICK_USER_DATA']['UF_BXMAKER_AUPHONE'] && preg_match('#^\d{11}$#', $_SESSION['ONE_CLICK_USER_DATA']['UF_BXMAKER_AUPHONE'])) {
		$userPhone = $_SESSION['ONE_CLICK_USER_DATA']['UF_BXMAKER_AUPHONE'];
	}
}
?>
<!-- new_one_click -->
<? if ($USER->IsAuthorized()):?>
	<div id="buy_one_click">
		<form action="/ajax/order_make_one_click.php" method="GET">
			<h2>Купить в 1 клик</h2>
			<p>ФИО <font color="red">*</font></p>
			<input name="fio" class="input-text" type="text" required /><br>
			<p>Телефон <font color="red">*</font></p>
			<input name="phone" data-phone class="input-text" type="text" required value="<?= $userPhone ?>"/><br>
			<p>E-mail</p>
			<input name="email" class="input-text" type="email" /><br>
			<input type="hidden" name="pid" value="<?=$arParams["ELEMENT_ID"]?>" />
			<input class="dm_button red" type="submit" value="Оформить" style="float:none">
		</form>
		<div style="clear:both"></div>
	</div>
<? else:?>
	<div id="buy_one_click">
		<h2>Для покупки в 1 клик требуется подтверждение телефона</h2>
		<?$APPLICATION->IncludeComponent(
			"bxmaker:authuserphone.login",
			"",
			Array()
		);?>
	</div>
<? endif; ?>