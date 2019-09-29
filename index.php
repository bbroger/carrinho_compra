<?php 

	$conexao = new PDO('mysql:host=localhost;dbname=meusprodutos',"teste", "teste");

	$select = $conexao->prepare(" SELECT * FROM produtos");
	$select->execute();
	$fetch = $select->fetchAll();

	foreach ($fetch as $produto) {
		echo 'Nome do Produto: '.$produto['nome'].'<br/>';
		echo 'Quantidade: '.$produto['quantidade'].'<br/>';
		echo 'Preco: R$ '.number_format($produto['preco'],2,',','.').'<br/>';
		echo '<a href="carrinho.php?add=carrinho&id='.$produto['id'].'">Comprar</a><br/>';
		echo '<hr><br/>';
	}
