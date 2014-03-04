<?php

  /**
   * Classe base para os serviços dos Correios.
   * 
   * @author Ivan Wilhelm <ivan.whm@me.com>
   * @version 1.2
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
    const RESULTADO_RASTREAMENTO_PRIMEIRO = 'P';
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
    const TIPO_CALCULO_PRECO_SO_PRECO = 'P';
    const TIPO_CALCULO_PRECO_SO_PRAZO = 'Z';
    const TIPO_CALCULO_PRECO_TODOS = 'T';
    const TIPO_CALCULO_PRECO_SO_PRECO_COM_DATABASE = 'PD';
    const TIPO_CALCULO_PRECO_SO_PRAZO_COM_DATABASE = 'ZD';
    const TIPO_CALCULO_PRECO_TODOS_COM_DATABASE = 'TD';

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
      self::RESULTADO_RASTREAMENTO_PRIMEIRO,
    );

    /**
     * Contém a lista de tipos de cálculo de preços e prazos possíveis.
     * 
     * @var array
     * @static
     */
    protected static $tiposCalculo = array(
      self::TIPO_CALCULO_PRECO_TODOS,
      self::TIPO_CALCULO_PRECO_SO_PRECO,
      self::TIPO_CALCULO_PRECO_SO_PRAZO,
      self::TIPO_CALCULO_PRECO_TODOS_COM_DATABASE,
      self::TIPO_CALCULO_PRECO_SO_PRECO_COM_DATABASE,
      self::TIPO_CALCULO_PRECO_SO_PRAZO_COM_DATABASE,
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
     * Contém a descrição dos serviços.
     * 
     * @var array
     * @static
     */
    public static $descricaoServico = array(
      self::SERVICO_SEDEX_SEM_CONTRATO => 'Sedex sem contrato',
      self::SERVICO_SEDEX_A_COBRAR_SEM_CONTRATO_1 => 'Sedex a Cobrar sem contrato',
      self::SERVICO_SEDEX_A_COBRAR_COM_CONTRATO_2 => 'Sedex a Cobrar com contrato',
      self::SERVICO_SEDEX_10_SEM_CONTRATO => 'Sedex 10 sem contrato',
      self::SERVICO_SEDEX_HOJE_SEM_CONTRATO => 'Sedex Hoje sem contrato',
      self::SERVICO_SEDEX_COM_CONTRATO_1 => 'Sedex com contrato',
      self::SERVICO_SEDEX_COM_CONTRATO_2 => 'Sedex com contrato',
      self::SERVICO_SEDEX_COM_CONTRATO_3 => 'Sedex com contrato',
      self::SERVICO_SEDEX_COM_CONTRATO_4 => 'Sedex com contrato',
      self::SERVICO_SEDEX_COM_CONTRATO_5 => 'Sedex com contrato',
      self::SERVICO_PAC_SEM_CONTRATO => 'PAC sem contrato',
      self::SERVICO_PAC_COM_CONTRATO => 'PAC com contrato',
      self::SERVICO_ESEDEX_COM_CONTRATO => 'eSedex com contrato',
      self::SERVICO_ESEDEX_PRIORITARIO_COM_CONTRATO => 'eSedex Prioritário com contrato',
      self::SERVICO_ESEDEX_EXPRESS_COM_CONTRATO => 'eSedex Express com contrato',
      self::SERVICO_ESEDEX_COM_CONTRATO_GRUPO_1 => 'eSedex com contrato',
      self::SERVICO_ESEDEX_COM_CONTRATO_GRUPO_2 => 'eSedex com contrato',
      self::SERVICO_ESEDEX_COM_CONTRATO_GRUPO_3 => 'eSedex com contrato',
    );

    /**
     * Contém a relação de mensagens de retorno ao cliente quando ocorre algum
     * evento na entrega pelos correios.
     * 
     * @var array
     * @static
     */
    public static $statusRastreamento = array(
      1 => array(
        'mensagem' => 'Entregue.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      2 => array(
        'mensagem' => 'Destinatário ausente – encaminhado para entrega interna.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      3 => array(
        'mensagem' => 'Não procurado.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      4 => array(
        'mensagem' => 'Recusado – em tratamento, aguarde.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      5 => array(
        'mensagem' => 'Em devolução – informações.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      6 => array(
        'mensagem' => 'Destinatário desconhecido no endereço – Em tratamento, aguarde.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      7 => array(
        'mensagem' => 'Endereço insuficiente para entrega – Em tratamento, aguarde.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      8 => array(
        'mensagem' => 'Não existe o número indicado – Em tratamento, aguarde.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      9 => array(
        'mensagem' => 'Por favor, entre em contato conosco.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      10 => array(
        'mensagem' => 'Destinatário mudou-se – Em tratamento, aguarde.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      12 => array(
        'mensagem' => 'Por favor, entre em contato conosco.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      19 => array(
        'mensagem' => 'Endereço incorreto – Poderá haver atraso ou devolução.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      20 => array(
        'mensagem' => 'Destinatário ausente. Será realizada uma nova tentativa de entrega.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      21 => array(
        'mensagem' => 'Destinatário ausente. O objeto está sendo devolvido ao remetente.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      22 => array(
        'mensagem' => 'Reintegrado ao fluxo postal – Em tratamento, aguarde.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      23 => array(
        'mensagem' => 'Distribuído ao remetente.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      24 => array(
        'mensagem' => 'Disponível na caixa postal.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      25 => array(
        'mensagem' => 'Empresa sem expediente.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      26 => array(
        'mensagem' => 'Não procurado – O objeto está sendo devolvido ao remetente.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      27 => array(
        'mensagem' => 'Pedido não solicitado – O objeto está sendo devolvido ao remetente.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      28 => array(
        'mensagem' => 'Por favor, entre em contato conosco.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      31 => array(
        'mensagem' => 'Por favor, entre em contato conosco.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      32 => array(
        'mensagem' => 'Entrega programada.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      33 => array(
        'mensagem' => 'Documentação não fornecida pelo Destinatário.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      34 => array(
        'mensagem' => 'Logradouro com numeração irregular - Em verificação, aguarde.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      35 => array(
        'mensagem' => 'Logística reversa simultânea – nova tentativa.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      36 => array(
        'mensagem' => 'Logística reversa simultânea – devolução da entrega.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      40 => array(
        'mensagem' => 'Devolvido ao remetente – Importação não autorizada.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDI,
        ),
      ),
      41 => array(
        'mensagem' => 'Aguardando parte do lote.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      42 => array(
        'mensagem' => 'Devolvido ao remetente – Lote incompleto.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      43 => array(
        'mensagem' => 'Por favor, entre em contato conosco.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      44 => array(
        'mensagem' => 'Por favor, entre em contato conosco.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      45 => array(
        'mensagem' => 'Recebido na unidade de distribuição.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      46 => array(
        'mensagem' => 'Entrega não efetuada.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      47 => array(
        'mensagem' => 'A saída do carteiro foi cancelada. Será retomada o mais breve possível.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      48 => array(
        'mensagem' => 'Endereço sem distribuição domiciliária e com entrega interna não autorizada pelo remetente.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      50 => array(
        'mensagem' => 'Por favor, entre em contato conosco.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      51 => array(
        'mensagem' => 'Por favor, entre em contato conosco.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      52 => array(
        'mensagem' => 'Por favor, entre em contato conosco.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
      69 => array(
        'mensagem' => 'Por favor, entre em contato conosco.',
        'tipos' => array(
          Correios::TIPO_EVENTO_BDE,
          Correios::TIPO_EVENTO_BDI,
          Correios::TIPO_EVENTO_BDR,
        ),
      ),
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
  