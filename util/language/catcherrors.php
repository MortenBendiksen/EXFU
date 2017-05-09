<?php

$before = "[$lang]:";
$after = "!";

$var = [
    "SETTING_BTN",
    "SETTING_LIGHT",
    "SETTING_LOGOUT",
    "ERROR_NOT_LOGGED_IN",
    "MENU_START_GAME",
    'MENU_HOME',
    'MENU_BATTLE_SKIP_ANIMATION',
    'SIGN_UP_DISPLAY_NAME',
    'SIGN_UP_EMAIL',
    'SIGN_UP_PASSWORD',
    'SIGN_UP_RETYPE_PASSWORD',
    'SIGN_UP_SECURITY_LEVEL',
    'SIGN_UP_SECURITY_LEVEL_1',
    'SIGN_UP_SECURITY_LEVEL_2',
    'SIGN_UP_SECURITY_LEVEL_3',
    'SIGN_UP_LANGUAGE',
    "SIGN_UP_TEXT",
    "LOGIN_TEXT",
    "LOGOUT_TEXT",
    "GAME_NAME",
    "CREATE_NEW_GROUP",
    "CREATE_GROUP_SELECT_ROLE",
    "CREATE_GROUP_SELECT_POWERSET",
    "CREATE_GROUP_CONTINUE",
    "CREATE_GROUP_TANK_DESC",
    "CREATE_GROUP_SUPPORT_DESC",
    "CREATE_GROUP_HEAL_DESC",
    "CREATE_GROUP_CONTROL_DESC",
    "CREATE_GROUP_DAMAGE_DESC",
    'GLOBAL_TANK_LONG',
    'GLOBAL_SUPPORT_LONG',
    'GLOBAL_HEAL_LONG',
    'GLOBAL_CONTROL_LONG',
    'GLOBAL_DAMAGE_LONG',
    'GLOBAL_TANK_SHORT',
    'GLOBAL_SUPPORT_SHORT',
    'GLOBAL_HEAL_SHORT',
    'GLOBAL_CONTROL_SHORT',
    'GLOBAL_DAMAGE_SHORT',
    "CREATE_GROUP_CHOOSE_CHARACTER_NAME",
    "CREATE_GROUP_SELECT_MAIN_POWERSET",
    "CREATE_GROUP_SELECT_SECONDARY_POWERSET",
    "CREATE_GROUP_CHANGE_POWERSETS",
    "GAME_SELECT_GROUP",
    "USER_NOT_FOUND",
    "MENU_MAP"
];
foreach ($var as $v) {
    if (!defined($v)) {
        define($v, "$before $v $after");
    }
}