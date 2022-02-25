<?php
//! This file customizes how the theme looks - //!Use with caution!!!

// Enable pre custom css themes (Can be dynamicly overriden)
$useCyborgTheme = false;    //WARNING: MUST BE true OR false
$useDarklyTheme = false;     //WARNING: MUST BE true OR false
$useLiteraTheme = false;    //WARNING: MUST BE true OR false
$useMintyXTheme = false;    //WARNING: MUST BE true OR false
$useQuartzTheme = false;    //WARNING: MUST BE true OR false
$useMorphTheme = false;
$useVaporTheme = false;
//Allow users to override the variable b4 version?
$user_override_killswitch = true;

//Aplicando las configuraciones.
//Override by user
if ($user_override_killswitch) {
    require_once(ROOT . "/functions/authEngine.php");
    require_once(ROOT . "/functions/userEngine.php");

    if (isWebLoggedIn($_COOKIE)) {
        $user = whoami();
        $userdata = getUserData($user);
        $overrider = $userdata["default_theme_variable"];
        if ($overrider !== NULL and $overrider !== "") {
            switch ($overrider) {
                case 'cyborg':
                    $useCyborgTheme = true;    //WARNING: MUST BE true OR false
                    break;
                case 'darkly':
                    $useDarklyTheme = true;     //WARNING: MUST BE true OR false
                    break;
                case 'litera':
                    $useLiteraTheme = true;    //WARNING: MUST BE true OR false
                    break;
                case 'minty':
                    $useMintyXTheme = true;    //WARNING: MUST BE true OR false
                    break;
                case 'quartz':
                    $useQuartzTheme = true;    //WARNING: MUST BE true OR false
                    break;
                case 'morph':
                    $useMorphTheme = true;    //WARNING: MUST BE true OR false
                    break;
                case 'vapor':
                    $useVaporTheme = true;    //WARNING: MUST BE true OR false
                    break;
                default:
                    // Don't override nothing
                    break;
            }
        }
    }
}
