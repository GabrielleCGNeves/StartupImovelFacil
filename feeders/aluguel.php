<?php
// :D calmae
require_once 'vendor/autoload.php';
require_once 'controllers/conectaBD.php'; // $conn
include_once 'utils/show_status.php';

$faker = Faker\Factory::create('pt_BR');

$conn->begin_transaction();

//Definindo query de insert
$stmt = $conn->prepare("INSERT INTO`TB_Aluguel`(`imo_idImovel`,`cli_idCliente`,`alu_valorAluguel`,`alu_dataAluga`,`alu_prazoContrato`) VALUES(?,?,?,?,?)");
$stmt -> bind_param("iidsi", $idImovel, $idCliente, $valorAluguel, $dataAluguel, $prazoContrato);

try {

    for ($i=0; $i < $ALUGUEL_MAX; $i++) { 

        $idImovel = $faker -> unique() -> numberBetween(1, $IMOVEL_MAX);
        $idCliente = $faker -> numberBetween(1, $CLIENTE_MAX);
        $dataAluguel = $faker -> dateTimeBetween('-3 years')->format("Y-m-d H:i:s");
        $prazoContrato = $faker -> numberBetween(1, 3);
        
        
        $sql = $conn -> query("SELECT `imo_valor` FROM `tb_imovel` WHERE `imo_idImovel` = $idImovel");
        $valorImovel = mysqli_fetch_row($sql)[0];
        
        $valorAluguel = $valorImovel * (0.6 / 100);

        $stmt->execute();

        show_status($i+1, $ALUGUEL_MAX);
    }

    $conn->commit();

} catch (mysqli_sql_exception $exception) {
    $conn->rollback();
}

?>