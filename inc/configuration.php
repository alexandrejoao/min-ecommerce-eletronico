<?php

session_start();

require_once 'inc/configuration.php';


class Sql
{
    //host
    private $host = 'us-cdbr-east-05.cleardb.net';

    //usuario
    private $usuario = 'b73247dfff2465';

    //senha
    private $senha = 'f0633a1c';

    //banco de dados
    private $database = 'heroku_cc35a753502f7d0';

    public $conn;

    public function __construct()
    {
        return $this->conn = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);
    }

    public function query($string_query)
    {

        return mysqli_query($this->conn, $string_query);
    }

    public function select($string_query)
    {

        $result = $this->query($string_query);

        $data = array();

        while ($row = mysqli_fetch_array($result)) {

            foreach ($row as $key => $value) {

                //$row[$key] = utf8_encode($value); /* Removendo esse código faz o calculo do frete */

            }

            array_push($data, $row);
        }

        unset($result);

        return $data;
    }

    public function __destruct()
    {
        mysqli_close($this->conn);
    }
}

    //$a = new Sql(); /* Chamando o método construct */

    //unset($a); /* Fechando método destruct */
