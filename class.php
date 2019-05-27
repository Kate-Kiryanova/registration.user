<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Application,
	Bitrix\Main\Localization\Loc;

class FlxMDRegistrationUser extends CBitrixComponent
{

	private $arRequest = [];

	private $bCheckPassword = false;
	private $bCheckFields = false;
	private $isRegisterUser = false;

	private $arResponse = [];

	public function executeComponent()
	{
		Loc::loadMessages(__FILE__);

		if (!check_email($this->arParams['EMAIL_TO']) || empty($this->arParams['EVENT_MESSAGE_ID'])) {
			ShowError(Loc::getMessage("FLXMD_REGISTRATION_USER_PARAMS_NOT_CORRECT"));
			return;
		}

		$this->arResult["PARAMS_HASH"] = md5(serialize($this->arParams).$this->GetTemplateName());

		$this->arRequest = Application::getInstance()->getContext()->getRequest();

		if (
			$this->arRequest->isAjaxRequest() &&
			$this->arRequest->getPost('FLXMD_AJAX') === 'Y' &&
			$this->arRequest->getPost('PARAMS_HASH') === $this->arResult["PARAMS_HASH"]
		) {
			$this->checkPassword();

			if ($this->bCheckPassword)
				$this->checkFields();

			if ($this->bCheckFields)
				$this->isRegisterUser();

			if (!$this->isActiveUser)
				$this->doRegistration();

			if ($this->userId)
				$this->sendEmail();

			$this->sendResponseAjax();

		} else {

			$this->IncludeComponentTemplate();

		}
	}

	public function checkPassword()
	{
		if (htmlspecialchars($this->arRequest->getPost('reg-password')) == htmlspecialchars($this->arRequest->getPost('reg-password-repeat'))) {
			$this->bCheckPassword = true;
		} else {
			$this->arResponse = ['STATUS' => 'ERROR', 'MESSAGE' => Loc::getMessage("FLXMD_REGISTRATION_USER_PASSWORD_ERROR")];
			$this->bCheckPassword = false;
		}
	}

	public function checkFields()
	{
		if (
			$this->arRequest->getPost('PARAMS_HASH') === $this->arResult["PARAMS_HASH"] &&
			empty($this->arRequest->getPost('CHECK_EMPTY')) &&
			!empty($this->arRequest->getPost('reg-name')) &&
			!empty($this->arRequest->getPost('reg-surname')) &&
			!empty($this->arRequest->getPost('reg-email')) &&
			check_email($this->arRequest->getPost('reg-email')) &&
			!empty($this->arRequest->getPost('reg-tel')) &&
			!empty($this->arRequest->getPost('reg-agreement')) &&
			check_bitrix_sessid()
		) {

			$this->bCheckFields = true;

		} else {

			$this->arResponse = ['STATUS' => 'ERROR', 'MESSAGE' => Loc::getMessage("FLXMD_REGISTRATION_USER_FIELDS_ERROR")];
			$this->bCheckFields = false;

		}
	}

	public function isRegisterUser()
	{
		$this->arSearchUser = \Bitrix\Main\UserTable::GetList(array(
			'select' => array('ID', 'ACTIVE', 'LOGIN', 'EMAIL'),
			'filter' => array('LOGIN' => htmlspecialchars($this->arRequest->getPost('reg-email')))
		));

		if ( $this->arUser = $this->arSearchUser->fetch() ) {
			if ($this->arUser["ACTIVE"] == 'Y') {
				$this->isActiveUser = true;
				$this->arResponse = ['STATUS' => 'ERROR', 'MESSAGE' => Loc::getMessage("FLXMD_REGISTRATION_USER_IS_REGISTER_AND_ACTIVE")];
			} else {
				$this->arResponse = ['STATUS' => 'ERROR', 'MESSAGE' => Loc::getMessage("FLXMD_REGISTRATION_USER_IS_REGISTER_WITHOUT_ACTIVE")];
			}
		}
	}

	public function doRegistration()
	{
		$this->user = new CUser;
		$arUserFields = array(
			'LOGIN' => htmlspecialchars($this->arRequest->getPost('reg-email')),
			'NAME' =>  htmlspecialchars($this->arRequest->getPost('reg-name')),
			'LAST_NAME' =>  htmlspecialchars($this->arRequest->getPost('reg-surname')),
			'EMAIL' => htmlspecialchars($this->arRequest->getPost('reg-email')),
			'WORK_PHONE' => htmlspecialchars($this->arRequest->getPost('reg-tel')),
			'PASSWORD' => htmlspecialchars($this->arRequest->getPost('reg-password')),
			'CONFIRM_PASSWORD' => htmlspecialchars($this->arRequest->getPost('reg-password-repeat')),
			'ACTIVE' => 'N',
			'WORK_COMPANY' => htmlspecialchars($this->arRequest->getPost('reg-company')),
			'WORK_POSITION' => htmlspecialchars($this->arRequest->getPost('reg-position'))
		);
		$this->userId = $this->user->Add($arUserFields);
		if (!$this->userId) {
			$this->arResponse = ['STATUS' => 'ERROR', 'MESSAGE' => Loc::getMessage("FLXMD_REGISTRATION_USER_ERROR")];
		}
	}

	public function sendEmail()
	{
		$arFields = array(
			'ID' => $this->userId,
			'NAME' =>  htmlspecialchars($this->arRequest->getPost('reg-name')),
			'LAST_NAME' =>  htmlspecialchars($this->arRequest->getPost('reg-surname')),
			'EMAIL' => htmlspecialchars($this->arRequest->getPost('reg-email')),
			'WORK_PHONE' => htmlspecialchars($this->arRequest->getPost('reg-tel')),
			'WORK_COMPANY' => htmlspecialchars($this->arRequest->getPost('reg-company')),
			'WORK_POSITION' => htmlspecialchars($this->arRequest->getPost('reg-position')),
			'LINK_USER' => SITE_SERVER_NAME . '/bitrix/admin/user_edit.php?lang=ru&ID=' . $this->userId,
			'EMAIL_TO' => $this->arParams['EMAIL_TO'],
			'PASSWORD' => htmlspecialchars($this->arRequest->getPost('reg-password'))
		);

		if (CEvent::Send("NEW_USER", SITE_ID, $arFields, $this->arParams['EVENT_MESSAGE_ID'])) {
			$this->arResponse = ['STATUS' => 'SUCCESS'];
		} else {
			$this->arResponse = ['STATUS' => 'ERROR', 'MESSAGE' => Loc::getMessage("FLXMD_REGISTRATION_SEND_MAIL_ERROR")];
		}
	}

	public function sendResponseAjax() {

		global $APPLICATION;

		$APPLICATION->RestartBuffer();

		echo json_encode($this->arResponse);

		die();

	}

}
