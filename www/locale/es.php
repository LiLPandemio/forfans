<?php
//Aqui se almacenan las claves con las cadenas de texto para el idioma ESPAÑOL

$lang['welcome_to'] 
    = "Bienvenido a {sitename}!";

$lang['login'] 
    = "Iniciar sesion";

$lang['register'] 
    = "Registrarse";

$lang['join_site'] 
    = "Unirme a {sitename}";

var_dump($lang);

//Procesar placeholders
  for ($i=0; $i < count($lang); $i++) { 
      //Reemplazar phs
      echo $lang[$i];
  }



//   function lang($phrase){
//     static $lang = array(
//         'NO_PHOTO' => 'No photo\'s available',
//         'NEW_MEMBER' => 'This user is new'
//     );
//     return $lang[$phrase];
// }
