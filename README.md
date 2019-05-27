# Код вызова компонента:

$APPLICATION->IncludeComponent(
    "flxmd:registration.user",
    "registration",
    array(
        "EMAIL_TO" => "test@flex.media",
        "EVENT_MESSAGE_ID" => "1", // NEW_USER
        "COMPONENT_TEMPLATE" => "registration",
    ),
    false
);

