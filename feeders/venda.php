<?php
require_once 'vendor/autoload.php';
require_once 'controllers/conectaBD.php'; // $conn
include_once 'utils/show_status.php';

$faker = Faker\Factory::create('pt_BR');

$conn->begin_transaction();

// Definindo a query de insert
$stmt = $conn->prepare("INSERT INTO `tb_venda`(`cli_idCliente`,`imo_idImovel`,`ven_valorEntrada`, `ven_parcelaPgmt`, `ven_juros`, `ven_dataVenda`, `ven_valorTotal` VALUES (?, ?, ?, ?, ?)");
$stmt -> bind_param("iidddsd", $idCliente, $idImovel, $valorEntrada, $parcelaPgmt, $juros, $dataVenda, $valorTotal);

try {
    
    for ($i=0; $i < $VENDA_MAX; $i++) { 
        
        $idCliente    = $faker -> numberBetween(1, $CLIENTE_MAX);
        $idImovel     = $faker -> unique() -> numberBetween(1, $IMOVEL_MAX);
        $valorEntrada = $faker -> numberBetween(10000, 20000);
        $parcelaPgmt  = $faker -> numberBetween(5, 12);
        $juros        = 0.5;
        $dataVenda    = $faker -> dateTime();
        
        $sql = $conn -> query("SELECT `imo_valor` FROM `tb_imovel` WHERE `imo_idImovel` = $idImovel");
        $valorParcela = mysqli_fetch_row($sql)[0] / $parcelaPgmt;
        $valorPJ      = $valorParcela + $valorParcela * $juros;
        
        $valorTotal   = $valorPJ * $parcelaPgmt;
        
        
        // $stmt->execute();

        show_status($i+1, $VENDA_MAX);
    }

    // $conn->commit();

} catch (mysqli_sql_exception $exception) {
    $conn->rollback();
}

?>