DROP DATABASE IF EXISTS ImovelFacil;
CREATE DATABASE ImovelFacil;
USE ImovelFacil;

CREATE TABLE TB_Endereco (
    end_idEndereco INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    end_cep VARCHAR(8) NULL,
    end_estado VARCHAR(2)  NULL,
    end_cidade VARCHAR(30) NULL,
    end_rua VARCHAR(40) NULL,
    end_numero INT NULL,
    end_complemento VARCHAR(20) NULL
);


CREATE TABLE TB_Imovel (
        imo_idImovel INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        imo_descricao VARCHAR(50)  NULL,
        imo_valor DOUBLE(9,2)  NULL,
        imo_metroQuadrado FLOAT  NULL,
        imo_quarto INTEGER  NULL,
        imo_banheiro INTEGER  NULL,
        imo_vagaEstac INTEGER  NULL,
        end_idEndereco INT NOT NULL,
        FOREIGN KEY(end_idEndereco)
        REFERENCES TB_Endereco(end_idEndereco)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
    );



CREATE TABLE TB_Cliente (
        cli_idCliente INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
        cli_nome VARCHAR(50)  NULL,
        cli_cpf VARCHAR(11)  NULL,
        cli_tel VARCHAR(11)  NULL,
        cli_email VARCHAR(30)  NULL,
        end_idEndereco INT NOT NULL,
        FOREIGN KEY(end_idEndereco)
        REFERENCES TB_Endereco(end_idEndereco)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
    );



CREATE TABLE TB_Venda (
  ven_idVenda INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  cli_idCliente INT NOT NULL,
  imo_idImovel INTEGER NOT NULL,
  ven_valorEntrada DOUBLE(9,2)  NULL,
  ven_parcelaPgmt INTEGER  NULL,
  ven_juros INTEGER  NULL,
  ven_dataVenda DATETIME  NULL,
  ven_valorTotal DOUBLE(9,2)  NULL,
  FOREIGN KEY(imo_idImovel)
  REFERENCES TB_Imovel(imo_idImovel)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
  FOREIGN KEY(cli_idCliente)
  REFERENCES TB_Cliente(cli_idCliente)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
  );



CREATE TABLE TB_Aluguel (
  alu_idAluguel INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  imo_idImovel INT NOT NULL,
  cli_idCliente INT NOT NULL,
  alu_valorAluguel DOUBLE(7,2) NULL,
  alu_dataAluga DATETIME NULL,
  alu_prazoContrato INT NULL,
  FOREIGN KEY(imo_idImovel)
  REFERENCES TB_Imovel(imo_idImovel)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
  FOREIGN KEY(cli_idCliente)
  REFERENCES TB_Cliente(cli_idCliente)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
  );