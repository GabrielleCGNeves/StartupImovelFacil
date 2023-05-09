<?php
require_once 'vendor/autoload.php';
require_once 'controllers/conectaBD.php'; // $conn
include_once 'utils/show_status.php';

$faker = Faker\Factory::create('pt_BR');

$conn->begin_transaction();

// Definindo a query de insert
$stmt = $conn->prepare("INSERT INTO `tb_imovel`(`imo_descricao`, `imo_valor`, `imo_metroQuadrado`, `imo_quarto`, `imo_banheiro`, `imo_vagaEstac`, `end_idEndereco`) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt -> bind_param("sddiiii", $descricao, $valor, $metroQuadrado, $quarto, $banheiro, $vagaEstac, $idEndereco);

try {
    
    for ($i=0; $i < $IMOVEL_MAX; $i++) { 

        $descricao =        $faker -> sentence();
        $valor =            $faker -> numberBetween(100000, 300000);
        $metroQuadrado =    $faker -> numberBetween(20, 200);
        $quarto =           $faker -> numberBetween(1, 4);
        $banheiro =         $faker -> numberBetween(1, 3);
        $vagaEstac =        $faker -> numberBetween(1, 4);
        $idEndereco =       $faker -> unique() -> numberBetween(1, $ENDERECO_MAX);

        $stmt->execute();

        show_status($i+1, $IMOVEL_MAX);
    }

    $conn->commit();

} catch (mysqli_sql_exception $exception) {
    $conn->rollback();
}

?>