<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
?>

<form class="form entry__form signup js-validate" id="signup-form" action="<?=POST_FORM_ACTION_URI;?>" method="post" autocomplete="off">

	<div class="form__message js-error-container"></div>

	<?=bitrix_sessid_post();?>

	<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>" />
	<input type="hidden" name="FLXMD_AJAX" value="Y" />
	<input type="hidden" name="CHECK_EMPTY" value="" />

	<div class="form__row">

		<div class="form__item" id="signup-name-item">
			<label class="form__label" for="signup-name">
				<?= Loc::getMessage('REGISTRATION_USER_NAME'); ?>*
			</label>
			<input
				class="input"
				id="signup-name"
				type="text"
				name="reg-name"
				required
				placeholder="<?= Loc::getMessage('REGISTRATION_USER_NAME_PLACEHOLDER'); ?>"
				data-required-message="<?= Loc::getMessage('REGISTRATION_USER_REQUIRED_FIELD'); ?>"
				data-error-message="<?= Loc::getMessage('REGISTRATION_USER_NAME_ERROR'); ?>"
				data-error-target="#signup-name-item"
			/>
		</div>

		<div class="form__item" id="signup-surname-item">
			<label class="form__label" for="signup-surname">
				<?= Loc::getMessage('REGISTRATION_USER_SURNAME'); ?>*
			</label>
			<input
				class="input"
				id="signup-surname"
				type="text"
				name="reg-surname"
				required
				placeholder="<?= Loc::getMessage('REGISTRATION_USER_SURNAME_PLACEHOLDER'); ?>"
				data-required-message="<?= Loc::getMessage('REGISTRATION_USER_REQUIRED_FIELD'); ?>"
				data-error-message="<?= Loc::getMessage('REGISTRATION_USER_SURNAME_ERROR'); ?>"
				data-error-target="#signup-surname-item"
			/>
		</div>

	</div>

	<div class="form__row">

		<div class="form__item" id="signup-company-item">
			<label class="form__label" for="signup-company">
				<?= Loc::getMessage('REGISTRATION_USER_COMPANY'); ?>
			</label>
			<input
				class="input"
				id="signup-company"
				type="text"
				name="reg-company"
				placeholder="<?= Loc::getMessage('REGISTRATION_USER_COMPANY_PLACEHOLDER'); ?>"
			/>
		</div>

		<div class="form__item" id="signup-position-item">
			<label class="form__label" for="signup-position">
				<?= Loc::getMessage('REGISTRATION_USER_POSITION'); ?>
			</label>
			<input
				class="input"
				id="signup-position"
				type="text"
				name="reg-position"
				placeholder="<?= Loc::getMessage('REGISTRATION_USER_POSITION_PLACEHOLDER'); ?>"
			/>
		</div>

	</div>

	<div class="form__row">

		<div class="form__item" id="signup-email-item">
			<label class="form__label" for="signup-email">
				<?= Loc::getMessage('REGISTRATION_USER_EMAIL'); ?>*
			</label>
			<input
				class="input"
				id="signup-email"
				type="email"
				name="reg-email"
				required
				placeholder="<?= Loc::getMessage('REGISTRATION_USER_EMAIL_PLACEHOLDER'); ?>"
				data-required-message="<?= Loc::getMessage('REGISTRATION_USER_REQUIRED_FIELD'); ?>"
				data-error-message="<?= Loc::getMessage('REGISTRATION_USER_EMAIL_ERROR'); ?>"
				data-error-target="#signup-email-item"
			/>
		</div>

		<div class="form__item form__item--short" id="signup-tel-item">
			<label class="form__label" for="signup-tel">
				<?= Loc::getMessage('REGISTRATION_USER_PHONE'); ?>*
			</label>
			<input
				class="input"
				id="signup-tel"
				type="tel"
				name="reg-tel"
				required
				placeholder="+"
				data-required-message="<?= Loc::getMessage('REGISTRATION_USER_REQUIRED_FIELD'); ?>"
				data-error-message="<?= Loc::getMessage('REGISTRATION_USER_PHONE_ERROR'); ?>"
				data-error-target="#signup-tel-item"
			/>
		</div>

	</div>

	<div class="form__row">

		<div class="form__item" id="signup-password-item">
			<label class="form__label" for="signup-password">
				<?= Loc::getMessage('REGISTRATION_USER_PASSWORD'); ?>*
			</label>
			<input
				class="input"
				id="signup-password"
				type="password"
				name="reg-password"
				required
				placeholder="<?= Loc::getMessage('REGISTRATION_USER_PASSWORD_PLACEHOLDER'); ?>"
				data-required-message="<?= Loc::getMessage('REGISTRATION_USER_REQUIRED_FIELD'); ?>"
				data-error-message="<?= Loc::getMessage('REGISTRATION_USER_PASSWORD_ERROR'); ?>"
				data-error-target="#signup-password-item"
			/>
		</div>

		<div class="form__item" id="signup-password-repeat-item">
			<label class="form__label" for="signup-password-repeat">
				<?= Loc::getMessage('REGISTRATION_USER_PASSWORD_REPEAT'); ?>*
			</label>
			<input
				class="input"
				id="signup-password-repeat"
				type="password"
				name="reg-password-repeat"
				required
				placeholder="<?= Loc::getMessage('REGISTRATION_USER_PASSWORD_REPEAT_PLACEHOLDER'); ?>"
				data-required-message="<?= Loc::getMessage('REGISTRATION_USER_REQUIRED_FIELD'); ?>"
				data-error-target="#signup-password-repeat-item"
				data-target-match="#signup-password"
				data-mismatch-message="<?= Loc::getMessage('REGISTRATION_USER_PASSWORD_NOT_MATCH'); ?>"
			/>
		</div>

	</div>

	<div class="form__footer signup__footer">
		<p class="form__footer-text">* <?= Loc::getMessage('REGISTRATION_USER_REQUIRED_FIELDS'); ?></p>
		<button class="btn btn--big signup__btn" type="submit">
			<?= Loc::getMessage('REGISTRATION_USER_SEND'); ?>
		</button>
	</div>

	<div class="form__item signup__agreement" id="signup-agreement-item">
		<input
			class="input-checkbox"
			type="checkbox"
			id="signup-agreement"
			name="reg-agreement"
			required
			data-error-target="#signup-agreement-item"
			data-required-message="<?= Loc::getMessage('REGISTRATION_USER_REQUIRED_FIELD'); ?>"
		/>
		<label for="signup-agreement"><?= Loc::getMessage('REGISTRATION_USER_AGREE'); ?> <a class="signup__link" href="<?=SITE_DIR;?>personal-data/"><?= Loc::getMessage('REGISTRATION_USER_PERSONAL_DATA'); ?></a>*</label>
	</div>

</form>
