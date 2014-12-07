<?php
	
class Werules_Easycorreios_Block_Rastrear extends Mage_Core_Block_Template
{
	public function getRastreiacodigo($orderid) {
		//return "Hello World Frontend";
		//return Mage::getModel('easycorreios/observer')->rastreiaCodigo();
		$conn = Mage::getSingleton('core/resource')->getConnection('core_read');
		$result = $conn->fetchAll("SELECT * FROM wr_easycorreios WHERE order_num='" . $orderid . "' ORDER BY ordem DESC");
		return $result;
	}
}