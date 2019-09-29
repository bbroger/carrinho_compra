<?php 

	session_start();

	if(!isset($_SESSION['itens'])){
		$_SESSION['itens'] = array();
	}

	if(isset($_GET['add']) && $_GET['add'] == "carrinho"){
		$idProduto = $_GET['id'];
		if(!isset($_SESSION['itens'][$idProduto])){
			$_SESSION['itens'][$idProduto] = 1;
		}else{
			$_SESSION['itens'][$idProduto] += 1;
		}
	}

	if(count($_SESSION['itens']) == 0){
		echo "Carrinho Vazio <br/><a href='index.php'>Adicionar Itens</a>";
	}else{
		$_SESSION['dados'] = array();
		$conexao = new PDO('mysql:host=localhost;dbname=meusprodutos',"teste", "teste");
		foreach($_SESSION['itens'] as $idProduto => $quantidade){
			$select = $conexao->prepare(" SELECT * FROM produtos WHERE id = ?");
			$select->bindParam(1,$idProduto);
			$select->execute();
			$produtos = $select->fetchAll();
			$total = $quantidade * $produtos[0]["preco"];
			echo "Nome: ".$produtos[0]["nome"]."<br/>";
			echo "Preço: R$ ".number_format($produtos[0]['preco'],2,',','.')."<br/>";
			echo "Quantidade: ".$quantidade."<br/>";
			echo "Total: R$ ".number_format($total,2,',','.');
			echo "<br/><a href='remover.php?remover=carrinho&id=".$idProduto."'>Remover</a><hr/>";

			array_push($_SESSION['dados'],
				array(
					'id_produto' => $idProduto,
					'quantidade' => $quantidade,
					'preco' => $produtos[0]['preco'],
					'total' => $total
				)
			);
		}
		echo "<br/><a href='index.php'>Continuar comprando</a>";
		echo "<br/><a href='finalizar.php'>Finalizar compra</a>";
	}