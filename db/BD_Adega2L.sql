CREATE DATABASE adega2l

USE adega2l


CREATE TABLE Usuarios (
idUsuario INT AUTO_INCREMENT NOT NULL,
nomeUsuario VARCHAR(50) NOT NULL,
senhaUsuario CHAR(8) NOT NULL,
emailUsuario VARCHAR(50) NOT NULL,
cpfUsuario CHAR(11) NOT NULL,
tipoLogradouro VARCHAR(45) NOT NULL,
nomeLogradouro VARCHAR(100) NOT NULL,
numeroLogradouro VARCHAR(6) NOT NULL,
complementoLogradouro varchar(10),
bairro VARCHAR(30) NOT NULL,
cidade VARCHAR(50) NOT NULL,
estado CHAR(2) NOT NULL,
cep CHAR(8) NOT NULL,
DDI CHAR(3) NOT NULL,
DDD CHAR(3) NOT NULL, 
numeroTelefone CHAR(9),
CONSTRAINT PRIMARY KEY(idUsuario),
CONSTRAINT ck_tipoLogradouro CHECK (tipoLogradouro='Praça' OR tipoLogradouro='Rua' OR tipoLogradouro='Avenida' OR tipoLogradouro='Rodovia' OR tipoLogradouro='Viela')
);


SELECT * FROM Usuarios

CREATE TABLE Vendas(
idVenda INT AUTO_INCREMENT NOT NULL,
idUsuario INT AUTO_INCREMENT NOT NULL,
dataVenda DATETIME NOT NULL,
valorTotalVenda DECIMAL(5,2) NOT NULL,
totalItensVenda INT NOT NULL,
formadePagamento VARCHAR(45) NOT NULL,
CONSTRAINT PRIMARY KEY(idVenda),
CONSTRAINT fk_Usuarios_Vendas FOREIGN KEY (idUsuario),
REFERENCES Usuarios(idUsuario)
);


SELECT * FROM Vendas

CREATE TABLE Produtos(
idProduto INT AUTO_INCREMENT NOT NULL,
nomeProduto VARCHAR(45) NOT NULL,
precoProduto DECIMAL(5,2) NOT NULL,
quantidadeEstoqueProduto INT NOT NULL,
descricaoBebidas VARCHAR(45) NOT NULL,
tipoUnidade VARCHAR(45) NOT NULL,
tamanhoUnidade VARCHAR(45) NOT NULL,
dataValidade DATE NOT NULL,
dataCompraDoProduto DATETIME NOT NULL,
fornecedor VARCHAR(45) NOT NULL, 


CREATE TABLE VendaProdutos(
idProdutos INT AUTO_INCREMENT NOT NULL,
idVenda INT autoincrement NOT NULL,
qtdItens Vendidos INT NOT NULL,
CONSTRAINT PRIMARY KEY (idVenda,idProduto),/*PK Composta*/
CONSTRAINT FK_VendaProdutos_Vendas FOREIGN KEY (idVenda) REFERENCES Vendas(idVenda),
CONSTRAINT FK_VendaProdutos_Produtos FOREIGN KEY (idProduto) REFERENCES Produtos(idProduto)
);

