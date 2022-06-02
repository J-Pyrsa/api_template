<?php
/**
 * authors
 *
 * PHP version 7.4
 *
 * @author   Erwin Palma
 * @link     https://github.com/swagger-api/swagger-codegen
 */
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();


/**
 * GET object
 * 
 * This function retrieves the list of authors, just call the function
 * http://myapiserver.com/{version}/authors
 * 
 * @return $response
 */
$app->get('/authors', function (Request $request, Response $response) {
    // sql sentence
    $sql = "SELECT * FROM authors";

    try {
        $db         = new DB(); // creates a new DB instance
        $conn       = $db->connect(); // connecting to the DB
        $stmt       = $conn->query($sql); // preparing the statement
        $authors    = $stmt->fetchAll(PDO::FETCH_OBJ); // getting the results
        $db         = null; // cleaning up the DB instance

        $response->getBody()->write(json_encode($authors));

        // Setting the response in json format and sending the status 200
        return $response
            ->withHeader('content-type', 'application/json')
            ->withstatus(200);

    } catch (PDOException $e) {
        // If there is one error one message will be returned.
        $error = array(
            'message' => $e->getMessage()
        );
        // Setting the response in json format and sending the status 500
        $response->getbody()->write(json_encode($error));
        return $response
            ->withheader('content-type', 'application/json')
            ->withstatus(500);
    }
});

/**
 * GET object
 * 
 * This function retrieves the list of authors, just call the function
 * http://myapiserver.com/{version}/authors/{id}
 * 
 * @return $response
 */
$app->get('/authors/{id}', function (Request $request, Response $response, array $args) {
    // get the id from the url as parameter, for example {url}/authors/7
    $id = $args['id'];

    // set the query to retrieve all the elements from the table
    $sql = "SELECT * FROM authors WHERE id = $id";

    try {
        $db = new DB(); // creates a new DB instance
        $conn   = $db->connect(); // connecting to the DB
        $stmt   = $conn->query($sql); // preparing the statement
        $author = $stmt->fetchAll(PDO::FETCH_OBJ);  // getting the results
        $db = null; // cleaning up the DB instance

        $response->getBody()->write(json_encode($author)); // getting the data
        // Setting the response in json format and sending the status 200
        return $response
            ->withHeader('content-type', 'application/json')
            ->withstatus(200);

    } catch (PDOException $e) {
        // If there is one error one message will be returned.
        $error = array(
            'message' => $e->getMessage()
        );
        // Setting the response in json format and sending the status 500
        $response->getbody()->write(json_encode($error));
        return $response
            ->withheader('content-type', 'application/json')
            ->withstatus(500);
    }
});

$app->post('/authors', function (Request $request, Response $response, array $args) {
    // get the id from the parameters
    $name   = $request->getParam('name');
    $email  = $request->getParam('email');

    $sql = "INSERT INTO authors (name, email) VALUES (:name,:email)";

    try {
        $db = new DB();
        $conn = $db->connect();
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name',$name, PDO::PARAM_STR);
        $stmt->bindParam(':email',$email, PDO::PARAM_STR);

        $result = $stmt->execute();

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

$app->delete('/authors/{id}', function (Request $request, Response $response, array $args) {
    // get the id from the parameters
    $id   = $args['id'];


    $sql = "DELETE FROM authors WHERE id = $id";

    try {
        $db = new DB();
        $conn = $db->connect();
        
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute();

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

$app->put('/authors/{id}', function (Request $request, Response $response, array $args) {
    // get the id from the parameters
    $id   = $args['id'];
        //$id     = $request->getParam('id');
    $name   = $request->getParam('name');
    $email  = $request->getParam('email');

    $sql = "UPDATE authors SET name= :name, email = :email WHERE id = $id";

    try {
        $db = new DB();
        $conn = $db->connect();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name',$name, PDO::PARAM_STR);
        $stmt->bindParam(':email',$email, PDO::PARAM_STR);

        $result = $stmt->execute();

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