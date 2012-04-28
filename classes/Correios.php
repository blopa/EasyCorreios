<?php

  /**
   * Classe base para os serviços dos Correios.
   * 
   * @author Ivan Wilhelm <ivan.whm@me.com>
   * @version 1.0
   * @abstract
   */
  abstract class Correios
  {

    const URL_CALCULADOR = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx?WSDL';
    const FORMATO_CAIXA_PACOTE = 1;
    const FORMATO_ROLO_PRISMA = 2;
    const FORMATO_ENVELOPE = 3;
    const SERVICO_SEDEX_SEM_CONTRATO = '40010';
    const SERVICO_SEDEX_A_COBRAR_SEM_CONTRATO_1 = '40045';
    const SERVICO_SEDEX_A_COBRAR_COM_CONTRATO_2 = '40126';
    const SERVICO_SEDEX_10_SEM_CONTRATO = '40215';
    const SERVICO_SEDEX_HOJE_SEM_CONTRATO = '40290';
    const SERVICO_SEDEX_COM_CONTRATO_1 = '40096';
    const SERVICO_SEDEX_COM_CONTRATO_2 = '40436';
    const SERVICO_SEDEX_COM_CONTRATO_3 = '40444';
    const SERVICO_SEDEX_COM_CONTRATO_4 = '40568';
    const SERVICO_SEDEX_COM_CONTRATO_5 = '40606';
    const SERVICO_PAC_SEM_CONTRATO = '41106';
    const SERVICO_PAC_COM_CONTRATO = '41068';
    const SERVICO_ESEDEX_COM_CONTRATO = '';
    const SERVICO_ESEDEX_PRIORITARIO_COM_CONTRATO = '81027';
    const SERVICO_ESEDEX_EXPRESS_COM_CONTRATO = '81025';
    const SERVICO_ESEDEX_COM_CONTRATO_GRUPO_1 = '81868';
    const SERVICO_ESEDEX_COM_CONTRATO_GRUPO_2 = '81833';
    const SERVICO_ESEDEX_COM_CONTRATO_GRUPO_3 = '81850';

    /**
     * Contém os formatos aceitos.
     * @var array
     * @static
     */
    protected static $formatos = array(
      self::FORMATO_CAIXA_PACOTE,
      self::FORMATO_ROLO_PRISMA,
      self::FORMATO_ENVELOPE,
    );

    /**
     * Contém todos os serviços aceitos.
     * @var array
     * @static
     */
    protected static $servicos = array(
      self::SERVICO_SEDEX_SEM_CONTRATO,
      self::SERVICO_SEDEX_A_COBRAR_SEM_CONTRATO_1,
      self::SERVICO_SEDEX_A_COBRAR_COM_CONTRATO_2,
      self::SERVICO_SEDEX_10_SEM_CONTRATO,
      self::SERVICO_SEDEX_HOJE_SEM_CONTRATO,
      self::SERVICO_SEDEX_COM_CONTRATO_1,
      self::SERVICO_SEDEX_COM_CONTRATO_2,
      self::SERVICO_SEDEX_COM_CONTRATO_3,
      self::SERVICO_SEDEX_COM_CONTRATO_4,
      self::SERVICO_SEDEX_COM_CONTRATO_5,
      self::SERVICO_PAC_SEM_CONTRATO,
      self::SERVICO_PAC_COM_CONTRATO,
      self::SERVICO_ESEDEX_COM_CONTRATO,
      self::SERVICO_ESEDEX_PRIORITARIO_COM_CONTRATO,
      self::SERVICO_ESEDEX_EXPRESS_COM_CONTRATO,
      self::SERVICO_ESEDEX_COM_CONTRATO_GRUPO_1,
      self::SERVICO_ESEDEX_COM_CONTRATO_GRUPO_2,
      self::SERVICO_ESEDEX_COM_CONTRATO_GRUPO_3,
    );

    /**
     * Returna os parâmetros necessários para a chamada.
     * 
     * @return array
     * @abstract
     */
    abstract protected function getParametros();

    /**
     * Realiza o processamento da consulta.
     * 
     * @return boolean 
     * @abstract
     */
    abstract public function processaConsulta();
  }

?>
