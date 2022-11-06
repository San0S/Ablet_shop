<?php

// Connexion avec le serveur de l'IUT

// $db_config['SGBD'] = 'mysql';
// $db_config['HOST'] = 'devbdd.iutmetz.univ-lorraine.fr';
// $db_config['DB_NAME'] = 'dellaera2u_tpwebdevweb';
// $db_config['USER'] = 'dellaera2u_appli';
// $db_config['PASSWORD'] = '32002011';

// try {
//     $db = new PDO(
//         $db_config['SGBD'] . ':host=' . $db_config['HOST'] . ';dbname=' . $db_config['DB_NAME'],
//         $db_config['USER'],
//         $db_config['PASSWORD'],
//         array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
//     );
//     unset($db_config);
// } catch (Exception $exception) {
//     die($exception->getMessage());
// }




// Connexion avec le serveur WAMP

$db_config['SGBD'] = 'mysql';
$db_config['HOST'] = 'localhost';
$db_config['DB_NAME'] = 'tpweb_devweb';
$db_config['USER'] = 'root';
$db_config['PASSWORD'] = '';

try {
    $db = new PDO($db_config['SGBD'].':host='.$db_config['HOST'].';dbname='.$db_config['DB_NAME'], $db_config['USER'], $db_config['PASSWORD'], 
    array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

    unset($db_config);
} catch (Exception $exception) {
    die($exception->getMessage());
}

?>