<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->get('/negocios', function (Request $request, Response $response) {
    // set the query to retrieve all the elements from the table
    $sql = "SELECT * FROM tbl_negocio";

    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->query($sql);
        $negocios = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        $response->getBody()->write(json_encode($negocios));

        return $response
            ->withHeader('content-type', 'application/json')
            ->withstatus(200);

    } catch (PDOException $e) {
        $error = array(
            'message' => $e->getMessage()
        );
        $response->getbody()->write(json_encode($error));
        return $response
            ->withheader('content-type', 'application/json')
            ->withstatus(500);
    }
});

$app->get('/negocios/{id}', function (Request $request, Response $response, array $args) {
    // get the id from the parameters
    $id = $args['id'];

    // set the query to retrieve all the elements from the table
    $sql = "SELECT * FROM tbl_negocio WHERE id = $id";

    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->query($sql);
        $negocio = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        $response->getBody()->write(json_encode($negocio));

        return $response
            ->withHeader('content-type', 'application/json')
            ->withstatus(200);

    } catch (PDOException $e) {
        $error = array(
            'message' => $e->getMessage()
        );
        $response->getbody()->write(json_encode($error));
        return $response
            ->withheader('content-type', 'application/json')
            ->withstatus(500);
    }
});

$app->post('/negocios', function (Request $request, Response $response, array $args) {
    // get the id from the parameters
    $nombre = $request->getParam('nombre');
    $direccion = $request->getParam('direccion');
    $telefonos = $request->getParam('telefonos');
    $horarios = $request->getParam('horarios');
    $googlemaps = $request->getParam('googlemaps');
    $email = $request->getParam('email');
    $consumo_minimo = $request->getParam('consumo_minimo');
    $consumi_minimo_cantidad = $request->getParam('consumi_minimo_cantidad');
    $logo = $request->getParam('logo');
    $descripcion = $request->getParam('descripcion');
    $website = $request->getParam('website');

    // set the query to retreave all the allements from the table
    $sql = "CALL addBussines(
        :nombre,
        :direccion,
        :telefonos,
        :horarios,
        :googlemaps,
        :email,
        :consumo_minimo,
        :consumi_minimo_cantidad,
        :logo,
        :descripcion,
        :website)";

    try {
        $db = new DB();
        $conn = $db->connect();
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre',$nombre, PDO::PARAM_STR);
        $stmt->bindParam(':direccion',$direccion, PDO::PARAM_STR);
        $stmt->bindParam(':telefonos',$telefonos, PDO::PARAM_STR);
        $stmt->bindParam(':horarios',$horarios, PDO::PARAM_STR);
        $stmt->bindParam(':googlemaps',$googlemaps, PDO::PARAM_STR);
        $stmt->bindParam(':email',$email, PDO::PARAM_STR);
        $stmt->bindParam(':consumo_minimo',$consumo_minimo, PDO::PARAM_INT);
        $stmt->bindParam(':consumi_minimo_cantidad',$consumi_minimo_cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':logo',$logo, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion',$descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':website',$website, PDO::PARAM_STR);

        $result = $stmt->execute();

        //$negocio = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        $response->getBody()->write(json_encode($result));

        return $response
            ->withHeader('content-type', 'application/json')
            ->withstatus(200);

    } catch (PDOException $e) {
        $error = array(
            'message' => $e->getMessage()
        );
        $response->getbody()->write(json_encode($error));
        return $response
            ->withheader('content-type', 'application/json')
            ->withstatus(500);
    }
});