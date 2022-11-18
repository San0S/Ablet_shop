<?php

// Connexion avec le serveur de l'IUT (Brice)

// $db_config['SGBD'] = 'mysql';
// $db_config['HOST'] = 'devbdd.iutmetz.univ-lorraine.fr';
// $db_config['DB_NAME'] = 'dellaera2u_testDB';
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

// Connexion avec le serveur de l'IUT (Matteo)

$db_config['SGBD'] = 'mysql';
$db_config['HOST'] = 'devbdd.iutmetz.univ-lorraine.fr';
$db_config['DB_NAME'] = 'vella7u_tpweb_devweb';
$db_config['USER'] = 'vella7u_appli';
$db_config['PASSWORD'] = '32105498';

try {
    $db = new PDO(
        $db_config['SGBD'] . ':host=' . $db_config['HOST'] . ';dbname=' . $db_config['DB_NAME'],
        $db_config['USER'],
        $db_config['PASSWORD'],
        array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
    );
    unset($db_config);
} catch (Exception $exception) {
    die($exception->getMessage());
}



// Connexion avec le serveur LAMP (Brice)

// $db_config['SGBD'] = 'mysql';
// $db_config['HOST'] = 'localhost';
// $db_config['DB_NAME'] = 'tpweb_devweb';
// $db_config['USER'] = 'root';
// $db_config['PASSWORD'] = 'root';

// try {
//     $db = new PDO($db_config['SGBD'].$db_config['SGBD'] = 'mysql';
// $db_config['HOST'] = 'localhost';
// $db_config['DB_NAME'] = 'tpweb_devweb';
// $db_config['USER'] = 'root';
// $db_config['PASSWORD'] = '';

// try {
//     $db = new PDO($db_config['SGBD'].':host='.$db_config['HOST'].';dbname='.$db_config['DB_NAME'], $db_config['USER'], $db_config['PASSWORD'], 
//     array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

//     unset($db_config);
// } catch (Exception $exception) {
//     die($exception->getMessage());
// }//     unset($db_config);
// } catch (Exception $exception) {
//     die($exception->getMessage());
// }


// Connexion avec le serveur WAMP (Matteo)

// $db_config['SGBD'] = 'mysql';
// $db_config['HOST'] = 'localhost';
// $db_config['DB_NAME'] = 'tpweb_devweb';
// $db_config['USER'] = 'root';
// $db_config['PASSWORD'] = '';

// try {
//     $db = new PDO($db_config['SGBD'].':host='.$db_config['HOST'].';dbname='.$db_config['DB_NAME'], $db_config['USER'], $db_config['PASSWORD'], 
//     array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

//     unset($db_config);
// } catch (Exception $exception) {
//     die($exception->getMessage());
// }
?>