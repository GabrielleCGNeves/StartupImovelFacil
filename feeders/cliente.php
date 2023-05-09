<?php
require_once 'vendor/autoload.php';
require_once 'controllers/conectaBD.php'; // $conn
include_once 'utils/show_status.php';

$faker = Faker\Factory::create('pt_BR');

$conn->begin_transaction();

// Definindo a query de insert
$stmt = $conn->prepare("INSERT INTO `tb_cliente`(`cli_nome`, `cli_cpf`, `cli_tel`, `cli_email`, `end_idEndereco`) VALUES (?, ?, ?, ?, ?)");
$stmt -> bind_param("ssssi", $nome, $cpf, $tel, $email, $idEndereco);

try {
    
    for ($i=0; $i < $CLIENTE_MAX; $i++) { 

        $nome = $faker -> name();
        $cpf = $faker -> cpf(false);
        $tel = $faker -> phoneNumberCleared();
        $email = $faker -> email();
        $idEndereco = $faker -> numberBetween(1, $ENDERECO_MAX);

        $stmt->execute();

        show_status($i+1, $CLIENTE_MAX);
    }

    $conn->commit();

} catch (mysqli_sql_exception $exception) {
    $conn->rollback();
}

?>