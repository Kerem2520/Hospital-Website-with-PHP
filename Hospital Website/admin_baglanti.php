<?php

try
{

   $dbConnection = new mysqli("localhost", "root", "12345678", "hastane");
}
catch (Exception $e)
{
    $dbConnection = null;   
}



?>






