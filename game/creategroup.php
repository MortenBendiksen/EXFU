<?php

include_once '../util/Db.php';
include_once '../model/Battlegroup.php';
include_once '../model/BattleCharacter.php';
include_once '../model/Powerset.php';
include_once '../model/Power.php';

if (!isset($_SESSION)) {
    session_start();
}
include '../util/gametop.php';
if (isset($_SESSION['player'])) {
    if (isset($_GET['role'])) {
        $print = '<div id="powerset">
                <h1 id="powersetheader">' . CREATE_GROUP_SELECT_POWERSET . ':</h1>
                <h1 id="charnameheader">' . CREATE_GROUP_CHOOSE_CHARACTER_NAME . ':</h1>
                <input type="hidden" name="role" id="role_selected" value="' . $_GET['role'] . '"/>
                <input type="hidden" name="name" id="char_name"/>
                <input type="hidden" name="main" id="main_powerset"/>
                <input type="hidden" name="secondary" id="secondary_powerset"/>
                <button disabled="1">' . CREATE_GROUP_CONTINUE . '</button>';
        $tankSet = '<div id="power">' . GLOBAL_TANK_SHORT . '-set:</div><div id="power" element="fire" name="magm">MAGMA</div><div id="power" element="water" name="aqua">AQUATIC</div><div id="power" element="light" name="infu">INFUSION</div><div id="power" element="earth" name="ston">STONE</div><div id="power" element="mental" name="psy">PSY-SHIELD</div><div id="power" element="ice" name="free">FREEZING</div>';
        $suppSet = '<div id="power">' . GLOBAL_SUPPORT_SHORT . '-set:</div><div id="power" element="fire" name="igni">IGNITING</div><div id="power" element="water" name="bubb">BUBBLE FIELD</div><div id="power" element="light" name="refl">REFLECTIVE</div><div id="power" element="earth" name="crys">CRYSTAL</div><div id="power" element="mental" name="alte">ALTERATION</div><div id="power" element="ice" name="arct">ARCTIC</div>';
        $healSet = '<div id="power">' . GLOBAL_HEAL_SHORT . '-set:</div><div id="power" element="fire" name="warm">WARMTH</div><div id="power" element="water" name="pure">PURE WATER</div><div id="power" element="light" name="ange">ANGEL</div><div id="power" element="earth" name="bloo">BLOOD</div><div id="power" element="mental" name="mind">MIND CURE</div><div id="power" element="ice" name="cold">COLD</div>';
        $contSet = '<div id="power">' . GLOBAL_CONTROL_SHORT . '-set:</div><div id="power" element="fire" name="chao">CHAOS</div><div id="power" element="water" name="dark">DARK WATERS</div><div id="power" element="light" name="soli">SOLIDIFY</div><div id="power" element="earth" name="plan">PLANT</div><div id="power" element="mental" name="illu">ILLUSION</div><div id="power" element="ice" name="stor">STORM</div>';
        $damaSet = '<div id="power">' . GLOBAL_DAMAGE_SHORT . '-set:</div><div id="power" element="fire" name="sola">SOLAR</div><div id="power" element="water" name="pres">PRESSURE</div><div id="power" element="light" name="ener">ENERGY</div><div id="power" element="earth" name="elem">ELEMENTAL</div><div id="power" element="mental" name="shad">SHADOW</div><div id="power" element="ice" name="cryo">CRYO</div>';
        switch ($_GET['role']) {
            case 'role_tank':
                $print .= '<input type="text" value="' . GLOBAL_TANK_LONG . '" id="role_tank" class="active selected" disabled />';
                $firstSecondary = $damaSet;
                $main = $tankSet;
                $secondSecondary = $suppSet;
                break;
            case 'role_supp':
                $print .= '<input type="text" value="' . GLOBAL_SUPPORT_LONG . '" id="role_supp" class="active selected" disabled />';
                $firstSecondary = $tankSet;
                $main = $suppSet;
                $secondSecondary = $healSet;
                break;
            case 'role_heal':
                $print .= '<input type="text" value="' . GLOBAL_HEAL_LONG . '" id="role_heal" class="active selected" disabled />';
                $firstSecondary = $suppSet;
                $main = $healSet;
                $secondSecondary = $contSet;
                break;
            case 'role_cont':
                $print .= '<input type="text" value="' . GLOBAL_CONTROL_LONG . '" id="role_cont" class="active selected" disabled />';
                $firstSecondary = $healSet;
                $main = $contSet;
                $secondSecondary = $damaSet;
                break;
            case 'role_dama':
                $print .= '<input type="text" value="' . GLOBAL_DAMAGE_LONG . '" id="role_dama" class="active selected" disabled />';
                $firstSecondary = $contSet;
                $main = $damaSet;
                $secondSecondary = $tankSet;
                break;
        }
        $print .= '<div class="c"></div>
            <h3 id="mainpowersetheader">' . CREATE_GROUP_SELECT_MAIN_POWERSET . ':</h3>
            <h3 id="secondarypowersetheader">' . CREATE_GROUP_SELECT_SECONDARY_POWERSET . ':</h3>
            <h3 id="changepowersetheader">' . CREATE_GROUP_CHANGE_POWERSETS . ':</h3>
            <div id="powersets">'
                . "<span class='secondary'>" . $firstSecondary . "</span>\n<span class='main'>" . $main . "</span>" . "<span class='secondary'>" . $secondSecondary . "</span>"
                . '<div class="c"></div>
            </div>
            </div>';
    } else {
        $print = '<div id="role">
    <h1>' . CREATE_GROUP_SELECT_ROLE . ':</h1>
    <input type="hidden" name="role" id="selected_role" />
    <button disabled="1">' . CREATE_GROUP_CONTINUE . '</button>
    <div id="role_tank">' . GLOBAL_TANK_LONG . '</div>
    <div id="role_supp">' . GLOBAL_SUPPORT_LONG . '</div>
    <div id="role_heal">' . GLOBAL_HEAL_LONG . '</div>
    <div id="role_cont">' . GLOBAL_CONTROL_LONG . '</div>
    <div id="role_dama">' . GLOBAL_DAMAGE_LONG . '</div>
    <div class="c"></div>
    <div id="desc">
        
        <div class="role_tank">' . CREATE_GROUP_TANK_DESC . '</div>
        <div class="role_supp">' . CREATE_GROUP_SUPPORT_DESC . '</div>
        <div class="role_heal">' . CREATE_GROUP_HEAL_DESC . '</div>
        <div class="role_cont">' . CREATE_GROUP_CONTROL_DESC . '</div>
        <div class="role_dama">' . CREATE_GROUP_DAMAGE_DESC . '</div>
    </div>
</div>';
    }
} else {
    header('location:/?not_logged_in=1');
}
echo $print;
?>
<?php

include '../util/gamebottom.php';
?>