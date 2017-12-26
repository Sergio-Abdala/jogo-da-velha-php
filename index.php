<?php /*Faça um jogo da velha com PHP. O jogo será com dois jogadores. Se houver
um vencedor, o nome dele deve ser mostrado. Utilize inputs do tipo text onde serão
informados os caracteres “X” ou “O”, não aceite outro tipo de caractere. O jogo termina
quando houver empate ou um ganhador, informe a situação do final do jogo. Mostre o
tempo de duração do jogo.*/
	//nomes 
		if (isset($_GET['nomeum'])) { // se existir nome um
			//passar todos os get do corpo do jogo pra caixa alta facilita na comparação...
			for ($i=0; $i < 9; $i++) { 
				$_GET['corpo'.$i] = strtoupper($_GET['corpo'.$i]);// => letras maiúsculas uppercase 
			}
			$nomeum = $_GET['nomeum']; //variavel que armazena nome do jogador recebe get
		}else{	$nomeum = ""; }//variavel nome recebe vazio, ñ existe o get...
		if (isset($_GET['nomedois'])) {
			$nomedois = $_GET['nomedois'];
		}else{ $nomedois = ""; }
	//corpo do jogo		
		$resp[0]="";
		for ($k=0; $k < 9; $k++) { 
			if (isset($_GET['corpo'.$k]) && !empty($_GET['corpo'.$k])) {			
				if($_GET['corpo'.$k] == 'X' || $_GET['corpo'.$k] == 'O'){
					$resp[$k] = $_GET['corpo'.$k];
				}else{ $resp[$k] = ""; echo "<script>alert('caracter invalido use O ou X...');</script>"; $_GET['corpo'.$k]=""; }	
			}else{ $resp[$k]=""; }
		}
		//condições de vitoria
		$venceu = "";//variavel onde sera armazenado caracter do vencedor
		// central
			if ($_GET['corpo4'] == $_GET['corpo3'] && $_GET['corpo4'] == $_GET['corpo5'] || $_GET['corpo4'] == $_GET['corpo1'] && $_GET['corpo4'] == $_GET['corpo7'] || $_GET['corpo4'] == $_GET['corpo0'] && $_GET['corpo4'] == $_GET['corpo8'] || $_GET['corpo4'] == $_GET['corpo2'] && $_GET['corpo4'] == $_GET['corpo6']) {
				$venceu = $_GET['corpo4'];
			}
		// cima
			if ($_GET['corpo1'] == $_GET['corpo0'] && $_GET['corpo1'] == $_GET['corpo2']) {
				$venceu = $_GET['corpo1'];
			}
		// esquerda
			if ($_GET['corpo3'] == $_GET['corpo0'] && $_GET['corpo3'] == $_GET['corpo6']) {
				$venceu = $_GET['corpo3'];
			}
		//direita
			if ($_GET['corpo5'] == $_GET['corpo2'] && $_GET['corpo5'] == $_GET['corpo8']) {
				$venceu = $_GET['corpo5'];
			}
		//baixo
			if ($_GET['corpo7'] == $_GET['corpo6'] && $_GET['corpo7'] == $_GET['corpo8']) {
				$venceu = $_GET['corpo7'];
			}		
	//fim de jogo
		if(!empty($venceu)){
			if ($venceu == 'O') {
				if (empty($_GET['nomeum'])) {
					$_GET['nomeum'] = "Anonimo";
				}
				$fim = $_GET['nomeum']." Venceu...";
			}
			if ($venceu == 'X') {
				if (empty($_GET['nomedois'])) {
					$_GET['nomedois'] = "Anonimo";
				}
				$fim = $_GET['nomedois']." Venceu...";
			}
		}
		//empate
		if(empty($venceu) && !empty($_GET['corpo0']) && !empty($_GET['corpo1']) && !empty($_GET['corpo2']) && !empty($_GET['corpo3']) && !empty($_GET['corpo4']) && !empty($_GET['corpo5']) && !empty($_GET['corpo6']) && !empty($_GET['corpo7']) && !empty($_GET['corpo8'])){
			$fim = "Empate...";
		}
		/*/ guia rapido para enterder objeto DateTime
			$data1 = new DateTime(Date('Y-m-d H:i:s'));
			$data2 = new DateTime('2016-11-12 12:30:30');
			$intervalo = $data1->diff( $data2 );
			echo "Intervalo é de {".$intervalo->y."} anos, {".$intervalo->m."} meses e {".$intervalo->d."} dias e {".$intervalo->h."} horas e {".$intervalo->i."} min e {".$intervalo->s."} seg";
		/*/
		//tempo de partida
		if(isset($_GET['nomeum'])){
			$data1 = new DateTime(Date('Y-m-d H:i:s'));
			$data2 = new DateTime($_COOKIE['data']);
			$difere = $data1->diff( $data2 );
			$tempo = "Duração do jogo: <small>".$difere->i." min e ".$difere->s." seg</small>";
		}else{
			setcookie('data', Date('Y-m-d H:i:s'),  time() + (86400 * 30), "/");
			$tempo="Duração do jogo: <small>00 min e 00 seg</small>";
		}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="fundo.png">

	<title>jogo da velha</title>
	<style type="text/css">
		div#cabecalho{
			text-align: center;
		}
		.jg{
			width: 50px;
			height: 50px;
			margin: 10px;
			font-size: 56px;
			text-align: center;
			border: none;
		}
		.jognome{
			text-align: center;
			border: none;
		}
		div#jogo{
			background: url("fundo.png"); background-repeat: no-repeat; background-position: center;
		}
		.bot{
			border-radius: 10px;
			padding: 5px;
			background-color: #babaca;
		}
	</style>
</head>
<body>
	<form method="get" action="#">
		<div id="cabecalho">
			<h1>jogo da velha <br /> <?= $fim; ?></h1>
			0 <input type="text" placeholder="entre com nome do jogador" name="nomeum" value="<?= $nomeum; ?>" class="jognome">&nbsp;0&nbsp;&nbsp;&nbsp;&nbsp;X<input class="jognome" type="text" placeholder="entre com nome do jogador" name="nomedois" value="<?= $nomedois; ?>">X
			<div id="jogo">
				<?php for($k=0; $k<9; $k++): ?>
					<?php if($k % 3 == 0): ?><!-- a cada tres input um br -->
						<br />
					<?php endif; ?>
					<input size="1" type="text" name="corpo<?= $k; ?>" class="jg" value="<?= $resp[$k]; ?>">
				<?php endfor; ?>
			</div>
			<input type="submit" name="botao" value=" jogar " class="bot"> &nbsp; &nbsp; &nbsp; <a href="index.php">reset</a>
			<p><?= $tempo; ?></p>
		</div>

	</form>
</body>
</html>