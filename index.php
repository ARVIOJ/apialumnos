<?php

//USO DEL FRAMEWORK FLIGHT
require 'flight/Flight.php';


Flight::register('db','PDO', array('mysql:host=localhost;dbname=api','root',''));

//Metodo GET(Mostrar todos los alumnos)
Flight::route('GET /alumnos', function () {
    
    $sentecia = Flight::db()->prepare("SELECT * FROM `alumnos`");

    $sentecia->execute();

    $datos = $sentecia->fetchAll();//PDO::FETCH_ASSOC
    Flight::json($datos);

});

//Metodo POST (Insertar un alumno)
Flight::route('POST /alumnos', function () {
    
    $nombres=(Flight::request()->data->nombres);
    $apellidos=(Flight::request()->data->apellidos);
 
    $sql = "INSERT INTO `alumnos` (`nombres`, `apellidos`) VALUES (?, ?)";

    $sentecia = Flight::db()->prepare($sql);

    $sentecia->bindParam(1, $nombres);
    $sentecia->bindParam(2, $apellidos);

    $sentecia->execute();

    Flight::jsonp(["Alumno insertado correctamente"]);
  
});

//Metodo Delete (Eliminar un alumno)
Flight::route('DELETE /alumnos', function () {
    
    $id=(Flight::request()->data->id);


    $sql = "DELETE FROM alumnos WHERE id = ?";
  
    $sentecia = Flight::db()->prepare($sql);

    $sentecia->bindParam(1, $id);

    $sentecia->execute();

    Flight::jsonp(["Alumno eliminado correctamente"]);
  
});

//Metodo PUT (Actualizar un alumno)
Flight::route('PUT /alumnos', function () {
    
    $id=(Flight::request()->data->id);
    $nombres=(Flight::request()->data->nombres);
    $apellidos=(Flight::request()->data->apellidos);

    $sql = "UPDATE `alumnos` SET nombres=?, apellidos=? WHERE id = ?";
  
    $sentecia = Flight::db()->prepare($sql);

    
    $sentecia->bindParam(1, $nombres);
    $sentecia->bindParam(2, $apellidos);
    $sentecia->bindParam(3, $id);

    $sentecia->execute();
    
    Flight::jsonp(["Alumno modificado correctamente"]);
  
});

//Metodo GET (Mostrar un alumno determinado)
Flight::route('GET /alumnos/@id', function ($id) {
    
    $sentecia = Flight::db()->prepare("SELECT * FROM `alumnos` WHERE id = ?");

    $sentecia->bindParam(1, $id);

    $sentecia->execute();

    $datos = $sentecia->fetchAll();//PDO::FETCH_ASSOC
    Flight::json($datos);
    
});



Flight::start();
