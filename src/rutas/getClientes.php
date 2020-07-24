<?php

    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    
    use Slim\Factory\AppFactory;

    /*
     * Se agrega este namespace con el comando "composer dump-autoload" en el archivo composer.json 
     */
    use Src\Libs\Conexion\Conexion;
      
    

    $app = AppFactory::create();
    
    // Todos los Clientes
    $app->get('/api/clientes', function (Request $request, Response $response, $args) {
           
        $cnx = new Conexion;
        $query = $cnx->connect()->prepare("SELECT * FROM cliente");
        $query->execute();

        $row = $query->fetchAll(PDO::FETCH_ASSOC);

        // Imprimir resultados en formato JSON
        $result = json_encode($row);

        $response->getBody()->write($result);
        return $response
                  ->withHeader('Content-Type', 'application/json');
       
        
        $row = null;
        $cnx = null;
    });


        //  Un solo Cliente Por ID
    $app->get('/api/clientes/{id}', function (Request $request, Response $response, $args) {
           
        $idCliente = $request->getAttribute('id');
        
        $cnx = new Conexion;
        $query = $cnx->connect()->prepare("SELECT * FROM cliente WHERE id = :idCliente");
        $query->bindParam(':idCliente', $idCliente, PDO::PARAM_STR);
        $query->execute();

        $row = $query->fetchAll(PDO::FETCH_ASSOC);
        
        // Imprimir resultados en formato JSON
        $result = json_encode($row);

        $response->getBody()->write($result);
        return $response
                  ->withHeader('Content-Type', 'application/json');
       
        
        $row = null;
        $cnx = null;
    });


    // Registrar Nuevo Cliente

    $app->post('/api/clientes/save', function (Request $request, Response $response) {
        
        $body = json_decode(file_get_contents("php://input"), true); // Recibir y procesar datos desde Postman
        $name = $body['name'];
        $lastName = $body['lastName'];
        $email = $body['email'];
 
        $cnx = new Conexion;
        $query = $cnx->connect()->prepare("INSERT INTO cliente (name, lastName, email)
                                            VALUES (:name, :lastName, :email)");
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();

        // Imprimir resultados en formato JSON
        $trueInsert = 'Exito en el Registro';
        $result = json_encode($trueInsert);

        $response->getBody()->write($result);
        return $response
                  ->withHeader('Content-Type', 'application/json');
     
    
    });

    // Update Data
     $app->put('/api/clientes/update/{id}', function (Request $request, Response $response) {
        
        $idCliente = $request->getAttribute('id');
        var_dump($idCliente);

        $body = json_decode(file_get_contents("php://input"), true); // Recibir y procesar datos desde Postman
        $name = $body['name'];
        $lastName = $body['lastName'];
        $email = $body['email'];
 
        $cnx = new Conexion;
        $query = $cnx->connect()->prepare("UPDATE cliente SET
                                            name = :name,
                                            lastName = :lastName,
                                            email = :email
                                            WHERE id = $idCliente");           
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();

        // Imprimir resultados en formato JSON
        $trueInsert = 'Actualización Exitosa';
        $result = json_encode($trueInsert);

        $response->getBody()->write($result);
        return $response
                  ->withHeader('Content-Type', 'application/json');
     
    
    });

    // Delete Data
    $app->delete('/api/clientes/delete/{id}', function (Request $request, Response $response) {
        
        $idCliente = $request->getAttribute('id');
 
        $cnx = new Conexion;
        $query = $cnx->connect()->prepare("DELETE FROM cliente WHERE id = :id");           
        $query->bindParam(':id', $idCliente, PDO::PARAM_STR);
        $query->execute();

        // Imprimir resultados en formato JSON

        $trueInsert = 'Eliminación Exitosa';
        $result = json_encode($trueInsert);

        $response->getBody()->write($result);
        return $response
                  ->withHeader('Content-Type', 'application/json');
     
    
    });


