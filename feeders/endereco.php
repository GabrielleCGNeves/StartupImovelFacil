<?php
require_once 'vendor/autoload.php';
require_once 'controllers/conectaBD.php'; // $conn
include_once 'utils/show_status.php';

$faker = Faker\Factory::create('pt_BR');

$conn->begin_transaction();

// Definindo a query de insert
$stmt = $conn->prepare("INSERT INTO `tb_endereco`(`end_cep`, `end_estado`, `end_cidade`, `end_rua`, `end_numero`, `end_complemento`) VALUES (?, ?, ?, ?, ?, ?)");
$stmt -> bind_param("ssssis", $cep, $estado, $cidade, $rua, $numero, $complemento);

try {
    
    for ($i=0; $i < $ENDERECO_MAX; $i++) { 
        $cep = str_replace("-", "", $faker -> postcode());
        $estado = $faker -> stateAbbr();
        $cidade = $faker -> city();
        $rua = $faker -> unique() -> streetName();
        $numero = $faker -> numberBetween(1, 100);
        $complemento = $i % 2 == 0 ? $faker -> optional($weight=0.4) -> numerify('Casa ##') : $faker -> optional($weight=0.4) -> numerify('Apto ##');
        
        $stmt->execute();

        show_status($i+1, $ENDERECO_MAX);
    }

    $conn->commit();

} catch (mysqli_sql_exception $exception) {
    $conn->rollback();
}

?>