<?php
	//Importa as classes
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
		$conn = Mage::getSingleton('core/resource')->getConnection('core_read');
		$result = $conn->fetchAll("SELECT * FROM sales_flat_shipment_track INNER JOIN sales_flat_order ON sales_flat_shipment_track.order_id = sales_flat_order.entity_id WHERE sales_flat_shipment_track.order_id NOT IN (SELECT order_num FROM wr_easycorreios)");
		if($result){
			foreach ($result as $row) {
				$resultado = $this->rastreiaCodigo($row['track_number']);
				if($resultado != false && $row['status'] == "shipped"){ //aqui estou usando um status custom que eu criei
					$dataCad = $resultado['data'] . " " . $resultado['hora'] . ":00";
					$dataCad = str_replace('/', '-', $dataCad);
					$dataCad = date('Y-m-d H:i:s', strtotime($dataCad));
					$conn = Mage::getSingleton('core/resource')->getConnection('core_write');
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
					);
				}
			}
		}
		$result = $conn->fetchAll("SELECT * FROM wr_easycorreios WHERE situacao='recente'");
		if($result){
			foreach ($result as $row) {
				$resultado = $this->rastreiaCodigo($row['tracking_num']);
				if($resultado != false){
					$dataBanco = date('d/m/Y H:i', strtotime($row['atualizado_em']));
					$dataBusca = $resultado['data'] . " " . $resultado['hora'];
					$ordem = (int)$row['ordem'];
					$ordem++;
					if(($resultado['tipo'] != $row['tipo']) || ($resultado['status'] != $row['status']) || ($dataBusca != $dataBanco)){ // verificando se houve alguma mudanca no rastreamento
						$dataBusca = $dataBusca . ":00";
						$dataBusca = str_replace('/', '-', $dataBusca);
						$dataBusca = date('Y-m-d H:i:s', strtotime($dataBusca));
						$situacao = "recente";
						if($resultado['tipo'] == "BDE" || $resultado['tipo'] == "BDI" || $resultado['tipo'] == "BDR" && $resultado['status'] == "1"){ // pedido foi entregue
							$situacao = "entregue";
							$order = Mage::getModel('sales/order')->load($row['order_num']);
							$order->setData('state', Mage_Sales_Model_Order::STATE_COMPLETE);
							$order->setStatus("complete");
							$order->save();
						}
						$conn = Mage::getSingleton('core/resource')->getConnection('core_write');
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
						);
					}
				}
			}
		}
    }
	
	public function rastreiaCodigo($codigo){
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
		} else
		{
		  return false;
		}
		} catch (Exception $e)
		{
			return false;
		}
	}
}