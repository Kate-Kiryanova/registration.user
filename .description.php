<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();


use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = array(
	"NAME" =>  Loc::getMessage("FLXMD_REGISTRATION_USER_COMPONENT_NAME"),
	"DESCRIPTION" =>  Loc::getMessage("FLXMD_REGISTRATION_USER_COMPONENT_DESCR"),
	"PATH" => array(
		"ID" => "FLXMD",
		"NAME" => Loc::getMessage('FLXMD_REGISTRATION_USER_COMPONENT_PATH'),
	),
);
?>
