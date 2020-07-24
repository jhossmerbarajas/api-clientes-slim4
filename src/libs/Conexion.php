<?php
    
    namespace Src\Libs\Conexion;

    #Para usar namespace con PDO, se debe incluir la siguiente línea de código.
    use \PDO;

    class Conexion {

        private $host;
        private $user;
        private $pass;
        private $dbname;

        public function __construct() {

            $this->host = constant('HOST');
            $this->user = constant('USER');
            $this->pass = constant('PASS');
            $this->dbname = constant('DBNAME');

        }

        public function connect() {

            try {

                $cnx = 'mysql:host=' . $this->host . '; dbname=' . $this->dbname;
                $opt = [
                    PDO::ATTR_ERRMODE           => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES  => false
                ];
                $pdo = new PDO($cnx, $this->user, $this->pass, $opt);
                return $pdo;

            } catch (PDOException $e) {
                echo 'Error de Conexión. ' . $e->getMessage();
            }
        
        }

    }

?>