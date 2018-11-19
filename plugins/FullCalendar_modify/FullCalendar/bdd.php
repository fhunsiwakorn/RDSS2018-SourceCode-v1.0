<?php
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=calendar;charset=utf8', 'root', 'siw@k0rn');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
