<?php
	session_start();
	$conexao = new PDO('mysql:host=localhost;dbname=meusprodutos',"teste", "teste");

	foreach ($_SESSION['dados'] as $produtos) {
		$insert = $conexao->prepare("INSERT INTO pedidos () VALUES (NULL,?,?,?,?)");
		$insert->bindParam(1, $produtos['id_produto']);
		$insert->bindParam(2, $produtos['quantidade']);
		$insert->bindParam(3, $produtos['preco']);
		$insert->bindParam(4, $produtos['total']);

		$insert->execute();
		$id_produto = $produtos['id_produto'];
		$qtdCompra = intval($produtos['quantidade']);

		$select = $conexao->prepare("SELECT quantidade FROM produtos WHERE id = ?");
		$select->bindParam(1, $id_produto);
		$select->execute();
		$quantidade = $select->fetch();
		$qtdEstoque = intval($quantidade['quantidade']);
		$quantidade = $qtdEstoque - $qtdCompra;

		$update = $conexao->prepare("UPDATE produtos SET quantidade = ? WHERE id = ?");
		$update->bindParam(1, $quantidade);
		$update->bindParam(2, $produtos['id_produto']);
		$update->execute();

		unset($_SESSION['dados']);
		unset($_SESSION['itens']);

		echo "<meta HTTP-EQUIV='REFRESH' CONTENT='0;URL=index.php'/>";
	}
	