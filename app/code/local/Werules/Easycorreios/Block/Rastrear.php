<?php
	
class Werules_Easycorreios_Block_Rastrear extends Mage_Core_Block_Template
{
	public function getRastreiacodigo($orderid) {
		//return "Hello World Frontend";
		//return Mage::getModel('easycorreios/observer')->rastreiaCodigo();
		$conn = Mage::getSingleton('core/resource')->getConnection('core_read'); // prepara conexao com o banco de dados
		$result = $conn->fetchAll("SELECT * FROM wr_easycorreios WHERE order_num='" . $orderid . "' ORDER BY ordem DESC"); // busca no banco o historico de rastreamento dos correios do pedido
		return $result;
	}
}