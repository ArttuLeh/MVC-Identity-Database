<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


spl_autoload_register(
        function ($class)
        {
            if (file_exists("Controllers/$class.php"))
            include "Controllers/$class.php";
        });
spl_autoload_register(
        function ($class)
        {
            if (file_exists("Classes/$class.php"))
            include "Classes/$class.php";
        });
spl_autoload_register(
        function ($class)
        {
            if (file_exists("Models/$class.php"))
            include "Models/$class.php";
        });

// luodaan ja kutsutaan controlleria
$cont = new MVCIdentityDatabaseController();

// kutsutaan view sivua
include "Views/MVCIdentityDatabaseView.php";




