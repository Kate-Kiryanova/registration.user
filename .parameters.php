<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/** @var array $arCurrentValues */

global $USER_FIELD_MANAGER;

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$site = ($_REQUEST["site"] <> ''? $_REQUEST["site"] : ($_REQUEST["src_site"] <> ''? $_REQUEST["src_site"] : false));
$arFilter = Array("TYPE_ID" => "FEEDBACK_FORM", "ACTIVE" => "Y");
if($site !== false)
	$arFilter["LID"] = $site;

$arEvent = Array();
$dbType = CEventMessage::GetList($by="ID", $order="DESC", $arFilter);
while($arType = $dbType->GetNext())
	$arEvent[$arType["ID"]] = "[".$arType["ID"]."] ".$arType["SUBJECT"];

if(!\Bitrix\Main\Loader::includeModule("iblock"))
	return;

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock = array();
$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while ( $arr = $rsIBlock->Fetch() ) {
	$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];
}

$arComponentParameters = array(
	"PARAMETERS" => array(
		"EMAIL_TO" => Array(
			"NAME" =>  Loc::getMessage("FLXMD_REGISTRATION_USER_EMAIL_TO"),
			"TYPE" => "STRING",
			"DEFAULT" => '',
			"PARENT" => "BASE",
		),
		"EVENT_MESSAGE_ID" => Array(
			"NAME" =>  Loc::getMessage("FLXMD_REGISTRATION_USER_EMAIL_TEMPLATES"),
			"TYPE"=>"LIST",
			"VALUES" => $arEvent,
			"DEFAULT"=>"",
			"MULTIPLE"=>"N",
			"COLS"=>25,
			"PARENT" => "BASE",
		),
	)
);
?>
