<?php
	//Importa as classes da API dos correios
	require 'correios_api/Correios.php';
	require 'correios_api/CorreiosRastreamento.php';
	require 'correios_api/CorreiosRastreamentoResultado.php';
	require 'correios_api/CorreiosRastreamentoResultadoOjeto.php';
	require 'correios_api/CorreiosRastreamentoResultadoEvento.php';
	require 'correios_api/CorreiosSro.php';
	require 'correios_api/CorreiosSroDados.php';

class Werules_Easycorreios_Model_Observer
{
    public function atualizaCodigo()
    {
		$conn = Mage::getSingleton('core/resource')->getConnection('core_read'); // prepara conexao com o banco de dados para leitura
		$result = $conn->fetchAll("SELECT * FROM sales_flat_shipment_track INNER JOIN sales_flat_order ON sales_flat_shipment_track.order_id = sales_flat_order.entity_id WHERE sales_flat_shipment_track.order_id NOT IN (SELECT order_num FROM wr_easycorreios)"); // seleciona todos os pedidos que foram enviados que ja nao estejam cadastrados na tabela do modulo
		if($result){ // se retornar algum resultado
			foreach ($result as $row) {
				$resultado = $this->rastreiaCodigo($row['track_number']); // chama a funcao que vai rastrear o codigo
				if($resultado != false && $row['status'] == "complete"){ // soh vai funcionar se voce tiver emitido a invoice antes de enviar o pedido, dai o pedido fica com o estado "complete". Voce pode tambem colocar qualquer custom status que voce tenha criado, na versao que eu uso na minha loja aqui coloquei o status "shipped"
					$dataCad = $resultado['data'] . " " . $resultado['hora'] . ":00"; // clocando data e hora no padrao do banco de dados
					$dataCad = str_replace('/', '-', $dataCad);
					$dataCad = date('Y-m-d H:i:s', strtotime($dataCad));
					$conn = Mage::getSingleton('core/resource')->getConnection('core_write'); // prepara conexao com o banco de dados para escrita
					$conn->query
					("
						INSERT INTO wr_easycorreios 
							(order_num, 
							tracking_num, 
							tipo, 
							servico, 
							local_evento, 
							local_destino, 
							descricao, 
							status, 
							atualizado_em, 
							ordem, 
							situacao)
						VALUES 
							(" . $row['order_id'] . ",
							'" . $resultado['tracking_num'] . "', 
							'" . $resultado['tipo'] . "', 
							'" . $resultado['servico'] . "', 
							'" . $resultado['local_evento'] . "', 
							'" . $resultado['local_destino'] . "', 
							'" . $resultado['descricao'] . "', 
							" . $resultado['status'] . ", 
							'" . $dataCad . "', 
							0, 
							'recente')"
					); // nessa query cadastramos no banco de dados os resultados da consulta de rastreamento dos correios
				}
			}
		}
		$this->completaPedido(); // chama a funcao que vai mudar o status do pedido pra completo caso o pedido tenha sido entregue
		$result = $conn->fetchAll("SELECT * FROM wr_easycorreios WHERE situacao='recente'"); // busca todos os codigos do banco que ainda nao tenham sido entregues
		if($result){
			foreach ($result as $row) {
				$resultado = $this->rastreiaCodigo($row['tracking_num']); // chama a funcao para rastreio de pedido nos correios
				if($resultado != false){
					$dataBanco = date('d/m/Y H:i', strtotime($row['atualizado_em']));
					$dataBusca = $resultado['data'] . " " . $resultado['hora'];
					$ordem = (int)$row['ordem'];
					$ordem++;
					if(($resultado['tipo'] != $row['tipo']) || ($resultado['status'] != $row['status']) || ($dataBusca != $dataBanco)) // verificando se houve alguma mudanca no rastreamento comparando os dados do banco com os do resultado da consulta nos correios
					{
						$dataBusca = $dataBusca . ":00";
						$dataBusca = str_replace('/', '-', $dataBusca);
						$dataBusca = date('Y-m-d H:i:s', strtotime($dataBusca));
						$situacao = "recente";
						/*if($resultado['tipo'] == "BDE" || $resultado['tipo'] == "BDI" || $resultado['tipo'] == "BDR" && $resultado['status'] == "1"){ // pedido foi entregue
							$situacao = "entregue";
							$order = Mage::getModel('sales/order')->load($row['order_num']);
							$order->setData('state', Mage_Sales_Model_Order::STATE_COMPLETE);
							$order->setStatus("complete");
							$order->save();
						}*/
						$conn = Mage::getSingleton('core/resource')->getConnection('core_write'); // prepara conexao com o banco de dados para escrita
						$conn->query("UPDATE wr_easycorreios SET situacao='antiga' WHERE easycorreios_id=" . $row['easycorreios_id'] . "");
						$conn->query
						("
							INSERT INTO wr_easycorreios 
								(order_num, 
								tracking_num, 
								tipo, 
								servico, 
								local_evento, 
								local_destino, 
								descricao, 
								status, 
								atualizado_em, 
								ordem, 
								situacao)
							VALUES 
								(" . $row['order_num'] . ",
								'" . $resultado['tracking_num'] . "', 
								'" . $resultado['tipo'] . "', 
								'" . $resultado['servico'] . "', 
								'" . $resultado['local_evento'] . "', 
								'" . $resultado['local_destino'] . "', 
								'" . $resultado['descricao'] . "', 
								" . $resultado['status'] . ", 
								'" . $dataBusca . "', 
								" . $ordem . ", 
								'" . $situacao . "')"
						); // insere os novos resultados do rastreio no banco de dados
					}
				}
			}
		}
    }
	
	public function completaPedido() // funcao que completa pedido
	{
		$conn = Mage::getSingleton('core/resource')->getConnection('core_read'); // prepara conexao com o banco de dados para leitura
		$result = $conn->fetchAll("SELECT * FROM wr_easycorreios WHERE situacao='recente' AND status='1' AND (tipo='BDE' OR tipo='BDI' OR tipo='BDR')"); // verifica se o pedido esta como entregue. status, BDE, BDI e BDR sao informacoes dadas pelos correios que indicam que um pacote foi entregue
		foreach ($result as $row)
		{
			try
			{
				$conn = Mage::getSingleton('core/resource')->getConnection('core_write'); // prepara conexao com o banco de dados para escrita
				$conn->query("UPDATE wr_easycorreios SET situacao='entregue' WHERE easycorreios_id=" . $row['easycorreios_id'] . ""); // muda a situacao do rastreio para "entregue"
				$order = Mage::getModel('sales/order')->load($row['order_num']); // carrega as informacoes do pedido
				$order->setData('state', Mage_Sales_Model_Order::STATE_COMPLETE); // muda o STATE do pedido para completo
				$order->setStatus("complete"); // muda o status do pedido para completo
				$order->save(); // salva 
			}
			catch (Exception $e)
			{
				return false;
			}
		}
	}
	
	public function rastreiaCodigo($codigo) // funcao que rastreia pedido nos correios. funcao retirada da pagina de exemplo da API do Ivan
	{
		try
		{
			$rastreamento = new CorreiosRastreamento('ECT', 'SRO');
			$rastreamento->setTipo(Correios::TIPO_RASTREAMENTO_LISTA);
			$rastreamento->setResultado(Correios::RESULTADO_RASTREAMENTO_ULTIMO);
			$rastreamento->addObjeto($codigo);
			if ($rastreamento->processaConsulta())
			{
			  $resposta = array();
			  $retorno = $rastreamento->getRetorno();
			  if ($retorno->getQuantidade() > 0)
			  {
				$resposta['versao'] = $retorno->getVersao();
				$resposta['qtd'] = $retorno->getQuantidade();
				$resposta['tipopesq'] = $retorno->getTipoPesquisa();
				$resposta['tiporesult'] = $retorno->getTipoResultado();
				foreach ($retorno->getResultados() as $resultado)
				{
				  $resposta['tracking_num'] = $resultado->getObjeto();
				  $dadosObjeto = new CorreiosSroDados($resultado->getObjeto());
				  $resposta['servico'] = $dadosObjeto->getDescricaoTipoServico();
				  foreach ($resultado->getEventos() as $eventos)
				  {
					$resposta['tipo'] = $eventos->getTipo();
					$resposta['desctipo'] = $eventos->getDescricaoTipo();
					$resposta['status'] = $eventos->getStatus();
					$resposta['descstatus'] = $eventos->getDescricaoStatus();
					$resposta['acaostatus'] = $eventos->getAcaoStatus();
					$resposta['data'] = $eventos->getData();
					$resposta['hora'] = $eventos->getHora();
					$resposta['descricao'] = $eventos->getDescricao();
					$resposta['comentarios'] = $eventos->getComentario();
					$resposta['local_evento'] = $eventos->getLocalEvento() . ' (' . $eventos->getCidadeEvento() . ', ' . $eventos->getUfEvento() . ')';
					$resposta['local_destino'] = "";
					if ($eventos->getPossuiDestino())
					{
					  $resposta['local_destino'] = $eventos->getLocalDestino() . ' (' . $eventos->getCidadeDestino() . ' - ' . $eventos->getBairroDestino() . ', ' . $eventos->getUfDestino() . ' - ' . $eventos->getCodigoDestino() . ')';
					}
				  }
				}
				return $resposta;
			  }
			}
			else
			{
			  return false;
			}
		}
		catch (Exception $e)
		{
			return false;
		}
	}
}