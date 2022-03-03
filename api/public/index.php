<?php

ini_set("date.timezone", "Asia/Kuala_Lumpur");

//*
header('Access-Control-Allow-Origin: *');

// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}
//*/

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write(json_encode("hello world"));
    return $response->withHeader('content-type', 'application/json')->withStatus(200);
});


$app->post('/patients', function ($request, $response) {

    //form data
    $formData = json_decode($request->getBody());
    $name = $formData->name;
    $gender = $formData->gender;
    $age = $formData->age;
    $address = $formData->address;
    $city = $formData->city;
    $state = $formData->state;
    $mobileno = $formData->mobileno;

    $sql = "INSERT INTO patients(name, gender, age, address, city, state, mobileno, admissiondate) 
    VALUES (:name, :gender, :age, :address, :city, :state, :mobileno, NOW())";

    $db = new db();
    $conn = $db->connect();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam("name", $name);
    $stmt->bindParam("gender", $gender);
    $stmt->bindParam("age", $age);
    $stmt->bindParam("address", $address);
    $stmt->bindParam("city", $city);
    $stmt->bindParam("state", $state);
    $stmt->bindParam("mobileno", $mobileno);

    $result = $stmt->execute();

    $response->getBody()->write(json_encode($result));
    return $response->withHeader('content-type', 'application/json')->withStatus(200);
});

$app->get('/patients', function (Request $request, Response $response, $args) {

    $sql = "SELECT * FROM patients";
    try {
        $db = new db();
        $conn = $db->connect();

        $stmt = $conn->query($sql);
        $patients = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        $response->getBody()->write(json_encode($patients));
        return $response->withHeader('content-type', 'application/json')->withStatus(200);
    } catch (PDOException $e) {
        $error = array("message" => $e->getMessage());
        $response->getBody()->write(json_encode($error));
        return $response->withHeader('content-type', 'application/json')->withStatus(500);
    }
});

$app->get('/patients/{id}', function (Request $request, Response $response, $args) {

    $id = $args['id'];
    $sql = "SELECT *
                 FROM patients
                 WHERE id = :id";
    try {
        $db = new db();
        $conn = $db->connect();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam("id", $id);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $db = null;
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('content-type', 'application/json')->withStatus(200);
    } catch (PDOException $e) {
        $error = array("message" => $e->getMessage());
        $response->getBody()->write(json_encode($error));
        return $response->withHeader('content-type', 'application/json')->withStatus(500);
    }
});

$app->put('/patients/{id}', function (Request $request, Response $response, $args) {

    $id = $args['id'];
    $sql = "UPDATE patients
            SET name = :name,
                gender = :gender,
                age = :age,
                address = :address,
                city = :city,
                state = :state,
                mobileno = :mobileno
            WHERE id = :id";


    try {


        $formData = json_decode($request->getBody());
        $name = $formData->name;
        $gender = $formData->gender;
        $age = $formData->age;
        $address = $formData->address;
        $city = $formData->city;
        $state = $formData->state;
        $mobileno = $formData->mobileno;

        $db = new db();
        $conn = $db->connect();

        $stmt = $conn->prepare($sql);

        $stmt->bindParam("id", $id);
        $stmt->bindParam("name", $name);
        $stmt->bindParam("gender", $gender);
        $stmt->bindParam("age", $age);
        $stmt->bindParam("address", $address);
        $stmt->bindParam("city", $city);
        $stmt->bindParam("state", $state);
        $stmt->bindParam("mobileno", $mobileno);
        $stmt->execute();

        $result = true;
        $db = null;
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('content-type', 'application/json')->withStatus(200);
    } catch (PDOException $e) {
        $error = array("message" => $e->getMessage());
        $response->getBody()->write(json_encode($error));
        return $response->withHeader('content-type', 'application/json')->withStatus(500);
    }
});

$app->put('/patients/status/{id}', function ($request, $response, $args) {
    try {

        $id = $args['id'];

        $formData = json_decode($request->getBody());
        $status = $formData->status;
        $sql = "";

        if ($status == "Discharge")
            $sql = "UPDATE patients SET 
                status = :status,
                dischargedate = NOW()
                WHERE id = :id";
        else if ($status == "Clinical Death")
            $sql = "UPDATE patients SET 
                status = :status, 
                clinicaldeathdate = NOW()
                WHERE id = :id";
        else if ($status == "ICU")
            $sql = "UPDATE patients SET 
                status = :status, 
                icuadmissiondate = NOW()
                WHERE id = :id";

        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->bindParam("status", $status);

        $result = $stmt->execute();

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('content-type', 'application/json')->withStatus(200);
    } catch (PDOException $e) {
        $error = array("message" => $e->getMessage());
        $response->getBody()->write(json_encode($error));
        return $response->withHeader('content-type', 'application/json')->withStatus(500);
    }
});

$app->run();
