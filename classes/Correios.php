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
    const URL_RASTREADOR = 'http://websro.correios.com.br/sro_bin/sroii_xml.eventos';
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
    const SERVICO_ESEDEX_COM_CONTRATO = '81019';
    const SERVICO_ESEDEX_PRIORITARIO_COM_CONTRATO = '81027';
    const SERVICO_ESEDEX_EXPRESS_COM_CONTRATO = '81025';
    const SERVICO_ESEDEX_COM_CONTRATO_GRUPO_1 = '81868';
    const SERVICO_ESEDEX_COM_CONTRATO_GRUPO_2 = '81833';
    const SERVICO_ESEDEX_COM_CONTRATO_GRUPO_3 = '81850';
    const TIPO_RASTREAMENTO_LISTA = 'L';
    const TIPO_RASTREAMENTO_INTERVALO = 'F';
    const RESULTADO_RASTREAMENTO_TODOS = 'T';
    const RESULTADO_RASTREAMENTO_ULTIMO = 'U';
    const TIPO_EVENTO_BDE = 'BDE';
    const TIPO_EVENTO_BDI = 'BDI';
    const TIPO_EVENTO_BDR = 'BDR';
    const TIPO_EVENTO_CAR = 'CAR';
    const TIPO_EVENTO_CD = 'CD';
    const TIPO_EVENTO_CMR = 'CMR';
    const TIPO_EVENTO_CO = 'CO';
    const TIPO_EVENTO_CUN = 'CUN';
    const TIPO_EVENTO_DO = 'DO';
    const TIPO_EVENTO_EST = 'EST';
    const TIPO_EVENTO_FC = 'FC';
    const TIPO_EVENTO_IDC = 'IDC';
    const TIPO_EVENTO_IE = 'IE';
    const TIPO_EVENTO_IT = 'IT';
    const TIPO_EVENTO_LDI = 'LDI';
    const TIPO_EVENTO_OEC = 'OEC';
    const TIPO_EVENTO_PAR = 'PAR';
    const TIPO_EVENTO_PMT = 'PMT';
    const TIPO_EVENTO_PO = 'PO';
    const TIPO_EVENTO_RO = 'RO';
    const TIPO_EVENTO_TR = 'TR';

    /**
     * Contém os formatos aceitos.
     * 
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
     * 
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
     * Contém os tipos de rastreamento aceitos.
     * 
     * @var array
     * @static
     */
    protected static $tiposRastreamento = array(
      self::TIPO_RASTREAMENTO_LISTA,
      self::TIPO_RASTREAMENTO_INTERVALO,
    );

    /**
     * Contém os resultados de rastreamento aceitos.
     * 
     * @var array
     * @static
     */
    protected static $resultadosRastreamento = array(
      self::RESULTADO_RASTREAMENTO_TODOS,
      self::RESULTADO_RASTREAMENTO_ULTIMO,
    );

    /**
     * Contém a lista dos eventos de rastreamento.
     * 
     * @var array
     * @static
     */
    protected static $tipoEvento = array(
      self::TIPO_EVENTO_BDE => 'Baixa de distribuição externa',
      self::TIPO_EVENTO_BDI => 'Baixa de distribuição interna',
      self::TIPO_EVENTO_BDR => 'Baixa corretiva',
      self::TIPO_EVENTO_CAR => 'Conferência de lista de registro',
      self::TIPO_EVENTO_CD => 'Conferência de nota de despacho',
      self::TIPO_EVENTO_CMR => 'Conferência de lista de registro',
      self::TIPO_EVENTO_CO => 'Coleta de objetos',
      self::TIPO_EVENTO_CUN => 'Conferência de lista de registro',
      self::TIPO_EVENTO_DO => 'Expedição de nota de despacho',
      self::TIPO_EVENTO_EST => 'Estorno',
      self::TIPO_EVENTO_FC => 'Função complementar',
      self::TIPO_EVENTO_IDC => 'Indenização de objetos',
      self::TIPO_EVENTO_IE => 'Comunicação de irregularidade de expedição',
      self::TIPO_EVENTO_IT => 'Passagem interna de objetos',
      self::TIPO_EVENTO_LDI => 'Lista de distribuição interna',
      self::TIPO_EVENTO_OEC => 'Lista de objetos entregues ao carteiro',
      self::TIPO_EVENTO_PAR => 'Conferência unidade internacional',
      self::TIPO_EVENTO_PMT => 'Partida meio de transporte',
      self::TIPO_EVENTO_PO => 'Postagem',
      self::TIPO_EVENTO_RO => 'Expedição de lista de registro',
      self::TIPO_EVENTO_TR => 'Trânsito',
    );

    /**
     * Contém o usuário de acesso aos serviços.
     * 
     * @var string
     */
    private $usuario;

    /**
     * Contém a senha de acesso aos serviços.
     * @var string
     */
    private $senha;

    /**
     * Cria um objeto de comunicação com os Correios.
     * 
     * @param string $usuario Usuário.
     * @param string $senha Senha.
     */
    public function __construct($usuario = '', $senha = '')
    {
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

    /**
     * Retorna o usuário de acesso aos serviços.
     * 
     * @return string
     */
    protected function getUsuario()
    {
      return $this->usuario;
    }

    /**
     * Retorna a senha de acesso aos serviços.
     * 
     * @return string
     */
    protected function getSenha()
    {
      return $this->senha;
    }

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
  