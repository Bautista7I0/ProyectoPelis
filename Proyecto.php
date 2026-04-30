<?php
    /*IDEAS: 
        Al ingrsar un peli: 
        - el ID te debe decir si se entrego a tiempo o no
        - Si esta disponible o no
        - las estadisticas de la pelicula
        - 
    */
    $comprado = false;
    $exit = true;
    $catalogo = array();
    $ID = array();

    class Casetes{

        // Atributos basicos
        private $ID;
        public $nombre;
        public $genero;
        public $duracion;
        public $fechaE;
        public $fechaD;
        
        function __construct($ID, $nombre, $genero, $duracion, $fechaD, $fechaE){
            $this->ID = $ID;
            $this->nombre = $nombre;
            $this->genero = $genero;
            $this->duracion = $duracion;
            $this->fechaD = $fechaD;
            $this->fechaE = $fechaE;
        }
        
        public function getNombre(){
            return $this->nombre;
        }
            
        public function disponible($comprado){
            if($comprado){
                return false;
            }
            return true;
        }

        // Para verificar si se entrego a tiempo o no
        function tiempo($limite, $compra){
            echo "-------------------------------\n" .
            "La pelicula ". $this->nombre."\n"."
            ID:  ". $this->ID ."\n". "
            ● Fue entregado el día: " . $this->fechaE . "\n";
            
            sleep(1);
            if($this->fechaD > $limite){    
                echo "● La entrega se realizo despues del límite establecido: " . $limite . "\n";
                echo"Se le hara una carga de 1500 para la proxima compra\n";
                return $compra * 1.5;
            }
            echo "● La entrega se realizó a tiempo! :) .\n";
        }

        function __toString(){
            return "--------------------------------------------------\n" .
                    "● ID: " . $this->ID ."\n" .
                    "--------------------------------------------------\n" .
                    "● Nombre: " . $this->nombre ."\n" .
                    "--------------------------------------------------\n" .
                    "● Genero: " . $this->genero ."\n" .
                    "--------------------------------------------------\n" .
                    "● Duracion: " . $this->duracion ." minutos\n" .
                    "--------------------------------------------------\n";
                    "● Estado: " .   $this->disponible($comprado) . "\n";
        }
    }

    class Socios{
        // Atributos basicos
        private $codigo;
        private $telefono;
        private $DNI;
        public $nombre;
        public $apellido;
        public $peliculasAlquiladas = array();
        
        function __construct($codigo, $nombre, $apellido, $telefono, $peliculasAlquiladas, $DNI){
            $this->codigo = $codigo;
            $this->DNI = $DNI;
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->telefono = $telefono;
            $this->peliculasAlquiladas = $peliculasAlquiladas;
        }

        public function getNombre(){
            return $this->nombre;
        }

        public function Historial(){
            echo "-------------------------------\n" .
            "● Socio: ". $this->nombre." ".$this->apellido."\n"."
            ● Código:  ". $this->codigo ."\n". "
            ● Peliculas alquiladas: " . implode(", ", $this->peliculasAlquiladas) . "\n";
        }

        function Cuenta($limite, $aumento, $cuenta){
            
        }
    }


    // Funciones
    function Agregar(&$limite, &$catalogo){
        $n = [];

        do {
            $ID= random_int(1000000, 9999999);
        }while (in_array($ID, $n)); 

        $n[] = $ID;

        echo "● Ingrese el nombre de la película: \n";
        $nombre = trim(fgets(STDIN));
        echo"---------------------------------\n";
        echo "● Ingrese el género principal de la película: \n";
        $genero = trim(fgets(STDIN));
        echo"---------------------------------\n";
        echo "● Ingrese la duracion de la película: \n";
        $duracion = fgets(STDIN);
        echo"---------------------------------\n";

        $fechaE = date("d-m-Y");
        $limite = date("d-m-Y",  strtotime($fechaE . ' + 3 days')); 
        $fechaD = date("d-m-Y");
        
        $pelicula = new Casetes($ID, $nombre, $genero, $duracion, $fechaE, $fechaD);
        array_push($catalogo, $pelicula);
    }
    
    function Pago(&$catalogo, $fechaE){
        $total = 0;
        echo "------------------ PAGO -------------------\n";
        echo"Ingrese cuantas peliculas desea alquilar:\n";
        $cant = fgets(STDIN);
        for($i = 1; $i <= $cant; $i++){
            echo "Ingrese el nombre de la película que desea alquilar:\n";
            $busqueda = trim(fgets(STDIN));
            foreach($catalogo as $pelicula){   
                if(stripos(stripslashes(strtolower($pelicula->getNombre())), stripslashes(strtolower($busqueda))) !== false){
                    $pago = 3500;
                    echo $pelicula->getNombre() ."\n";
                    $pelicula->disponible(true);
                }
            }
            echo"--------------------------------------------\n";
            $total+= $pago;
        }
        echo"Ingrese la fecha del día de hoy(dd-mm-yyyy):\n";
        $fechaE = trim(fgets(STDIN));
        $catalogo[$i]->tiempo($fechaE,  strtotime($fechaE . ' + 3 days'), $pago);
        echo"--------------------------------------------\n";
        echo"El costo total del alquiler es: $" . $total . "\n";
        echo"Presione Enter ⏎ para continuar...\n";
        fgets(STDIN);
        system("cls");
        return;

    }

    function Peliculas(&$catalogo){
        if(empty($catalogo)){
            echo "No hay películas registradas.\n";
            return;
        }
        echo"---- Peliculas ----\n";
        echo"\n";
        foreach($catalogo as $pelicula){
            echo"● ".$pelicula->getNombre()."\n";
        }
        echo"Ingrese el nombre de la película que desea buscar:\n";
        $busqueda = trim(fgets(STDIN));
        
        foreach($catalogo as $pelicula){

            if(stripos(stripslashes(strtolower($pelicula->getNombre())), stripslashes(strtolower($busqueda))) !== false){
                echo"● ".$pelicula->__toString()." \n";
            }
        }
        echo"--------------------------------------------\n";
        echo"\n";
        echo"Presione una Tecla para continuar...\n";
        fgets(STDIN);
        system("cls");
    }

    echo"---------- Bienvenido ----------\n";
    echo"Presione Enter ⏎ para continuar...\n";
    fgets(STDIN);
    system("cls");

    do{
        echo"----------------- PROYECTO PELIS -----------------\n";
        echo"1● Catalogo de Peliculas\n";
        echo"2● Agregar nueva Pelicula\n";
        echo"3● Alquiler de Peliculas\n";
        echo"4● Devolución de Pelicula\n";
        echo"5● Socios\n";
        echo" ● Salir\n";
        echo"--------------------------------------------------\n";
        $opc = fgets(STDIN);
        
        sleep(1);
        system("cls");
        
        $fechaE = date("d-m-Y");
        switch($opc){
            
            case 1:
                Peliculas($catalogo);
                break;
            
            case 2:
                Agregar($limite, $catalogo);
                break;

            case 3:
                Pago($catalogo, $fechaE);
                break;
            
            case 4:
                echo "En desarrollo... \n";
                break;
            
            case 5:
                echo "En desarrollo... \n";
                break;

            default:
                throw new Exception("Hasta luego! 👋\n");
        }
    }while($exit);
?>