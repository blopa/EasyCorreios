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
    const TIPO_EVENTO_BLQ = 'BLQ';
    const TIPO_EVENTO_CAR = 'CAR';
    const TIPO_EVENTO_CD = 'CD';
    const TIPO_EVENTO_CMR = 'CMR';
    const TIPO_EVENTO_CMT = 'CMT';
    const TIPO_EVENTO_CO = 'CO';
    const TIPO_EVENTO_CUN = 'CUN';
    const TIPO_EVENTO_DO = 'DO';
    const TIPO_EVENTO_EST = 'EST';
    const TIPO_EVENTO_FC = 'FC';
    const TIPO_EVENTO_IDC = 'IDC';
    const TIPO_EVENTO_IE = 'IE';
    const TIPO_EVENTO_IT = 'IT';
    const TIPO_EVENTO_LDI = 'LDI';
    const TIPO_EVENTO_LDE = 'LDE';
    const TIPO_EVENTO_OEC = 'OEC';
    const TIPO_EVENTO_PAR = 'PAR';
    const TIPO_EVENTO_PMT = 'PMT';
    const TIPO_EVENTO_PO = 'PO';
    const TIPO_EVENTO_RO = 'RO';
    const TIPO_EVENTO_TR = 'TR';
    const TIPO_EVENTO_TRI = 'TRI';
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
      self::TIPO_EVENTO_BLQ => 'Bloqueado',
      self::TIPO_EVENTO_CAR => 'Conferência de lista de registro',
      self::TIPO_EVENTO_CD => 'Conferência de nota de despacho',
      self::TIPO_EVENTO_CMR => 'Conferência de lista de registro',
      self::TIPO_EVENTO_CMT => 'Conferência de lista de trânsito',
      self::TIPO_EVENTO_CO => 'Coleta de objetos',
      self::TIPO_EVENTO_CUN => 'Conferência de lista de registro',
      self::TIPO_EVENTO_DO => 'Expedição de nota de despacho',
      self::TIPO_EVENTO_EST => 'Estorno',
      self::TIPO_EVENTO_FC => 'Função complementar',
      self::TIPO_EVENTO_IDC => 'Indenização de objetos',
      self::TIPO_EVENTO_IE => 'Comunicação de irregularidade de expedição',
      self::TIPO_EVENTO_IT => 'Passagem interna de objetos',
      self::TIPO_EVENTO_LDI => 'Lista de distribuição interna',
      self::TIPO_EVENTO_LDE => 'Lista de distribuição externa',
      self::TIPO_EVENTO_OEC => 'Lista de objetos entregues ao carteiro',
      self::TIPO_EVENTO_PAR => 'Conferência unidade internacional',
      self::TIPO_EVENTO_PMT => 'Partida meio de transporte',
      self::TIPO_EVENTO_PO => 'Postagem',
      self::TIPO_EVENTO_RO => 'Expedição de lista de registro',
      self::TIPO_EVENTO_TR => 'Trânsito',
      self::TIPO_EVENTO_TRI => 'Trânsito',
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
     * Eventos atualizados de acordo com a nova tabela de eventos disponibilizada pelos Correios.
     * 
     * @see http://www.correios.com.br/voce/acompanhar/rastreamento/atualizacaoSRO.cfm
     * 
     * @var array
     * @static
     */
    public static $statusRastreamento = array(
      0 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Objeto entregue ao destinatário.',
          'acao' => 'Finalizar a entrega. Não é mais necessário prosseguir com o acompanhamento.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Objeto entregue ao destinatário.',
          'acao' => 'Finalizar a entrega. Não é mais necessário prosseguir com o acompanhamento.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Objeto entregue ao destinatário.',
          'acao' => 'Finalizar a entrega. Não é mais necessário prosseguir com o acompanhamento.',
        ),
        Correios::TIPO_EVENTO_CD => array(
          'mensagem' => 'Objeto recebido na Unidade dos Correios.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_CMT => array(
          'mensagem' => 'Objeto recebido na Unidade dos Correios.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_CUN => array(
          'mensagem' => 'Objeto recebido na Unidade dos Correios.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_DO => array(
          'mensagem' => 'Objeto encaminhado para.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_LDE => array(
          'mensagem' => 'Objeto saiu para entrega ao remetente.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_LDI => array(
          'mensagem' => 'Objeto aguardando retirada no endereço indicado.',
          'acao' => 'Acompanhar. O interessado deverá buscar o objeto em uma Unidade dos Correios.',
        ),
        Correios::TIPO_EVENTO_OEC => array(
          'mensagem' => 'Objeto saiu para entrega ao destinatário.',
          'acao' => 'Acompanhar. O interessado deverá buscar o objeto em uma Unidade dos Correios.',
        ),
        Correios::TIPO_EVENTO_PO => array(
          'mensagem' => 'Objeto postado.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_RO => array(
          'mensagem' => 'Objeto encaminhado para.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_TRI => array(
          'mensagem' => 'Objeto encaminhado para.',
          'acao' => 'Acompanhar.',
        ),
      ),
      1 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Objeto entregue ao destinatário.',
          'acao' => 'Finalizar a entrega. Não é mais necessário prosseguir com o acompanhamento.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Objeto entregue ao destinatário.',
          'acao' => 'Finalizar a entrega. Não é mais necessário prosseguir com o acompanhamento.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Objeto entregue ao destinatário.',
          'acao' => 'Finalizar a entrega. Não é mais necessário prosseguir com o acompanhamento.',
        ),
        Correios::TIPO_EVENTO_BLQ => array(
          'mensagem' => 'Entrega de objeto bloqueada a pedido do remetente.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_CD => array(
          'mensagem' => 'Objeto recebido na Unidade dos Correios.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_CO => array(
          'mensagem' => 'Objeto coletado.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_CUN => array(
          'mensagem' => 'Objeto recebido na Unidade dos Correios.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_DO => array(
          'mensagem' => 'Objeto encaminhado para.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_EST => array(
          'mensagem' => 'Favor desconsiderar a informação anterior.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_FC => array(
          'mensagem' => 'Objeto será devolvido por solicitação do remetente.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_IDC => array(
          'mensagem' => 'Objeto não localizado.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_LDI => array(
          'mensagem' => 'Objeto aguardando retirada no endereço indicado.',
          'acao' => 'Acompanhar. O interessado deverá buscar o objeto em uma Unidade dos Correios.',
        ),
        Correios::TIPO_EVENTO_OEC => array(
          'mensagem' => 'Objeto saiu para entrega ao destinatário.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_PMT => array(
          'mensagem' => 'Objeto encaminhado para.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_PO => array(
          'mensagem' => 'Objeto postado.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_RO => array(
          'mensagem' => 'Objeto encaminhado para.',
          'acao' => 'Acompanhar.',
        ),
      ),
      2 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'A entrega não pode ser efetuada - Carteiro não atendido.',
          'acao' => 'Acompanhar. O interessado deverá buscar o objeto em uma Unidade dos Correios.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'A entrega não pode ser efetuada - Carteiro não atendido.',
          'acao' => 'Acompanhar. O interessado deverá buscar o objeto em uma Unidade dos Correios.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'A entrega não pode ser efetuada - Carteiro não atendido.',
          'acao' => 'Acompanhar. O interessado deverá buscar o objeto em uma Unidade dos Correios.',
        ),
        Correios::TIPO_EVENTO_CD => array(
          'mensagem' => 'Objeto recebido na Unidade dos Correios.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_DO => array(
          'mensagem' => 'Objeto encaminhado para.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_EST => array(
          'mensagem' => 'Favor desconsiderar a informação anterior.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_FC => array(
          'mensagem' => 'Objeto com data de entrega agendada.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_IDC => array(
          'mensagem' => 'Objeto não localizado.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_LDI => array(
          'mensagem' => 'Objeto disponível para retirada em Caixa Postal.',
          'acao' => 'Acompanhar. O interessado deverá buscar o objeto em uma Unidade dos Correios.',
        ),
      ),
      3 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Remetente não retirou objeto na Unidade dos Correios.',
          'acao' => 'Acompanhar. O interessado não buscou o objeto na unidade dos Correios durante o período de guarda.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Remetente não retirou objeto na Unidade dos Correios.',
          'acao' => 'Acompanhar. O interessado não buscou o objeto na unidade dos Correios durante o período de guarda.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Remetente não retirou objeto na Unidade dos Correios.',
          'acao' => 'Acompanhar. O interessado não buscou o objeto na unidade dos Correios durante o período de guarda.',
        ),
        Correios::TIPO_EVENTO_CD => array(
          'mensagem' => 'Objeto recebido na Unidade dos Correios.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_EST => array(
          'mensagem' => 'Favor desconsiderar a informação anterior.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_FC => array(
          'mensagem' => 'Objeto mal encaminhado.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_IDC => array(
          'mensagem' => 'Objeto não localizado.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_LDI => array(
          'mensagem' => 'Objeto aguardando retirada no endereço indicado.',
          'acao' => 'Acompanhar. O interessado deverá buscar o objeto em uma Unidade dos Correios.',
        ),
      ),
      4 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'A entrega não pode ser efetuada - Cliente recusou-se a receber.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'A entrega não pode ser efetuada - Cliente recusou-se a receber.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'A entrega não pode ser efetuada - Cliente recusou-se a receber.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_EST => array(
          'mensagem' => 'Favor desconsiderar a informação anterior.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_FC => array(
          'mensagem' => 'A entrega não pode ser efetuada - Endereço incorreto.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_IDC => array(
          'mensagem' => 'Objeto não localizado.',
          'acao' => 'Acompanhar.',
        ),
      ),
      5 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'A entrega não pode ser efetuada',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'A entrega não pode ser efetuada',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'A entrega não pode ser efetuada',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_EST => array(
          'mensagem' => 'Favor desconsiderar a informação anterior.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_FC => array(
          'mensagem' => 'Objeto devolvido aos Correios.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_IDC => array(
          'mensagem' => 'Objeto não localizado.',
          'acao' => 'Acompanhar.',
        ),
      ),
      6 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'A entrega não pode ser efetuada - Cliente desconhecido no local.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'A entrega não pode ser efetuada - Cliente desconhecido no local.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'A entrega não pode ser efetuada - Cliente desconhecido no local.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_EST => array(
          'mensagem' => 'Favor desconsiderar a informação anterior.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_IDC => array(
          'mensagem' => 'Objeto não localizado.',
          'acao' => 'Acompanhar.',
        ),
      ),
      7 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'A entrega não pode ser efetuada - Endereço incorreto.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'A entrega não pode ser efetuada - Endereço incorreto.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'A entrega não pode ser efetuada - Endereço incorreto.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_FC => array(
          'mensagem' => 'A entrega não pode ser efetuada - Empresa sem expediente.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_IDC => array(
          'mensagem' => 'Objeto não localizado.',
          'acao' => 'Acompanhar.',
        ),
      ),
      8 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'A entrega não pode ser efetuada - Endereço incorreto.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'A entrega não pode ser efetuada - Endereço incorreto.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'A entrega não pode ser efetuada - Endereço incorreto.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
      ),
      9 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Objeto não localizado.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Objeto não localizado.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Objeto não localizado.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
        Correios::TIPO_EVENTO_EST => array(
          'mensagem' => 'Favor desconsiderar a informação anterior.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_OEC => array(
          'mensagem' => 'Objeto saiu para entrega ao destinatário.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_PO => array(
          'mensagem' => 'Objeto postado após o horário limite da agência.',
          'acao' => 'Acompanhar.',
        )
      ),
      10 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'A entrega não pode ser efetuada - Cliente mudou-se.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'A entrega não pode ser efetuada - Cliente mudou-se.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'A entrega não pode ser efetuada - Cliente mudou-se.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
      ),
      12 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Remetente não retirou objeto na Unidade dos Correios.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Remetente não retirou objeto na Unidade dos Correios.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Remetente não retirou objeto na Unidade dos Correios.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
      ),
      14 => array(
        Correios::TIPO_EVENTO_LDI => array(
          'mensagem' => 'Objeto aguardando retirada no endereço indicado.',
          'acao' => 'Acompanhar. O interessado deverá buscar o objeto em uma Unidade dos Correios.',
        ),
      ),
      15 => array(
        Correios::TIPO_EVENTO_PAR => array(
          'mensagem' => 'Objeto recebido em destino.',
          'acao' => 'Acompanhar.',
        ),
      ),
      16 => array(
        Correios::TIPO_EVENTO_PAR => array(
          'mensagem' => 'Objeto recebido no Brasil.',
          'acao' => 'Acompanhar.',
        ),
      ),
      17 => array(
        Correios::TIPO_EVENTO_PAR => array(
          'mensagem' => 'Objeto liberado pela alfândega.',
          'acao' => 'Acompanhar.',
        ),
      ),
      18 => array(
        Correios::TIPO_EVENTO_PAR => array(
          'mensagem' => 'Objeto recebido na unidade de exportação.',
          'acao' => 'Acompanhar.',
        ),
      ),
      19 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'A entrega não pode ser efetuada - Endereço incorreto.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'A entrega não pode ser efetuada - Endereço incorreto.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'A entrega não pode ser efetuada - Endereço incorreto.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
      ),
      20 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'A entrega não pode ser efetuada - Carteiro não atendido.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'A entrega não pode ser efetuada - Carteiro não atendido.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'A entrega não pode ser efetuada - Carteiro não atendido.',
          'acao' => 'Acompanhar.',
        ),
      ),
      21 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'A entrega não pode ser efetuada - Carteiro não atendido.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'A entrega não pode ser efetuada - Carteiro não atendido.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'A entrega não pode ser efetuada - Carteiro não atendido.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
      ),
      22 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Objeto devolvido aos Correios.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Objeto devolvido aos Correios.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Objeto devolvido aos Correios.',
          'acao' => 'Acompanhar.',
        ),
      ),
      23 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Objeto devolvido ao remetente.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Objeto devolvido ao remetente.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Objeto devolvido ao remetente.',
          'acao' => 'Acompanhar.',
        ),
      ),
      24 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Objeto disponível para retirada em Caixa Postal.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Objeto disponível para retirada em Caixa Postal.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Objeto disponível para retirada em Caixa Postal.',
          'acao' => 'Acompanhar.',
        ),
      ),
      25 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'A entrega não pode ser efetuada - Empresa sem expediente.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'A entrega não pode ser efetuada - Empresa sem expediente.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'A entrega não pode ser efetuada - Empresa sem expediente.',
          'acao' => 'Acompanhar.',
        ),
      ),
      26 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Destinatário não retirou objeto na Unidade dos Correios.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Destinatário não retirou objeto na Unidade dos Correios.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Destinatário não retirou objeto na Unidade dos Correios.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
      ),
      28 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Objeto e/ou conteúdo avariado.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Objeto e/ou conteúdo avariado.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Objeto e/ou conteúdo avariado.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
      ),
      32 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Objeto com data de entrega agendada.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Objeto com data de entrega agendada.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Objeto com data de entrega agendada.',
          'acao' => 'Acompanhar.',
        ),
      ),
      33 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'A entrega não pode ser efetuada - Destinatário não apresentou documento exigido.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'A entrega não pode ser efetuada - Destinatário não apresentou documento exigido.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'A entrega não pode ser efetuada - Destinatário não apresentou documento exigido.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
      ),
      34 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'A entrega não pode ser efetuada - Logradouro com numeração irregular.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'A entrega não pode ser efetuada - Logradouro com numeração irregular.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'A entrega não pode ser efetuada - Logradouro com numeração irregular.',
          'acao' => 'Acompanhar.',
        ),
      ),
      35 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Coleta ou entrega de objeto não efetuada.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Coleta ou entrega de objeto não efetuada.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Coleta ou entrega de objeto não efetuada.',
          'acao' => 'Acompanhar.',
        ),
      ),
      36 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Coleta ou entrega de objeto não efetuada.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Coleta ou entrega de objeto não efetuada.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Coleta ou entrega de objeto não efetuada.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
      ),
      37 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Objeto e/ou conteúdo avariado por acidente com veículo.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Objeto e/ou conteúdo avariado por acidente com veículo.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Objeto e/ou conteúdo avariado por acidente com veículo.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
      ),
      38 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Objeto endereçado à empresa falida.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Objeto endereçado à empresa falida.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Objeto endereçado à empresa falida.',
          'acao' => 'Acompanhar.',
        ),
      ),
      40 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'A importação do objeto/conteúdo não foi autorizada pelos órgãos fiscalizadores.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'A importação do objeto/conteúdo não foi autorizada pelos órgãos fiscalizadores.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'A importação do objeto/conteúdo não foi autorizada pelos órgãos fiscalizadores.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
      ),
      41 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'A entrega do objeto está condicionada à composição do lote.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'A entrega do objeto está condicionada à composição do lote.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'A entrega do objeto está condicionada à composição do lote.',
          'acao' => 'Acompanhar.',
        ),
      ),
      42 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Lote de objetos incompleto.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Lote de objetos incompleto.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Lote de objetos incompleto.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
      ),
      43 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Objeto apreendido por órgão de fiscalização ou outro órgão anuente.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Objeto apreendido por órgão de fiscalização ou outro órgão anuente.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Objeto apreendido por órgão de fiscalização ou outro órgão anuente.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
      ),
      45 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Objeto recebido na unidade de distribuição.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Objeto recebido na unidade de distribuição.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Objeto recebido na unidade de distribuição.',
          'acao' => 'Acompanhar.',
        ),
      ),
      46 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Tentativa de entrega não efetuada.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Tentativa de entrega não efetuada.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Tentativa de entrega não efetuada.',
          'acao' => 'Acompanhar.',
        ),
      ),
      47 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Saída para entrega cancelada.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Saída para entrega cancelada.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Saída para entrega cancelada.',
          'acao' => 'Acompanhar.',
        ),
      ),
      48 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Retirada em Unidade dos Correios não autorizada pelo remetente.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Retirada em Unidade dos Correios não autorizada pelo remetente.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Retirada em Unidade dos Correios não autorizada pelo remetente.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
      ),
      49 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'As dimensões do objeto impossibilitam o tratamento e a entrega.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'As dimensões do objeto impossibilitam o tratamento e a entrega.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'As dimensões do objeto impossibilitam o tratamento e a entrega.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
      ),
      50 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Objeto roubado.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Objeto roubado.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Objeto roubado.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
      ),
      51 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Objeto roubado.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Objeto roubado.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Objeto roubado.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
      ),
      52 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Objeto roubado.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Objeto roubado.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Objeto roubado.',
          'acao' => 'Acionar atendimento dos Correios.',
        ),
      ),
      53 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Objeto reimpresso e reenviado.',
          'acao' => 'Acompanhar. O objeto impresso pelos Correios precisou ser refeito e reenviado.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Objeto reimpresso e reenviado.',
          'acao' => 'Acompanhar. O objeto impresso pelos Correios precisou ser refeito e reenviado.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Objeto reimpresso e reenviado.',
          'acao' => 'Acompanhar. O objeto impresso pelos Correios precisou ser refeito e reenviado.',
        ),
      ),
      54 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Para recebimento do objeto, é necessário o pagamento do ICMS Importação.',
          'acao' => 'Acompanhar. O interessado deverá pagar o imposto devido para retirar o objeto em uma Unidade dos Correios.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Para recebimento do objeto, é necessário o pagamento do ICMS Importação.',
          'acao' => 'Acompanhar. O interessado deverá pagar o imposto devido para retirar o objeto em uma Unidade dos Correios.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Para recebimento do objeto, é necessário o pagamento do ICMS Importação.',
          'acao' => 'Acompanhar. O interessado deverá pagar o imposto devido para retirar o objeto em uma Unidade dos Correios.',
        ),
      ),
      55 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Solicitada revisão do tributo estabelecido.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Solicitada revisão do tributo estabelecido.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Solicitada revisão do tributo estabelecido.',
          'acao' => 'Acompanhar.',
        ),
      ),
      56 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Declaração aduaneira ausente ou incorreta.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Declaração aduaneira ausente ou incorreta.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Declaração aduaneira ausente ou incorreta.',
          'acao' => 'Acompanhar o retorno do objeto ao remetente.',
        ),
      ),
      57 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Revisão de tributo concluída - Objeto liberado.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Revisão de tributo concluída - Objeto liberado.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Revisão de tributo concluída - Objeto liberado.',
          'acao' => 'Acompanhar.',
        ),
      ),
      58 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Revisão de tributo concluída - Tributo alterado.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Revisão de tributo concluída - Tributo alterado.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Revisão de tributo concluída - Tributo alterado.',
          'acao' => 'Acompanhar.',
        ),
      ),
      59 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Revisão de tributo concluída - Tributo mantido.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Revisão de tributo concluída - Tributo mantido.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Revisão de tributo concluída - Tributo mantido.',
          'acao' => 'Acompanhar.',
        ),
      ),
      66 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Área com distribuição sujeita a prazo diferenciado.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Área com distribuição sujeita a prazo diferenciado.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Área com distribuição sujeita a prazo diferenciado.',
          'acao' => 'Acompanhar.',
        ),
      ),
      69 => array(
        Correios::TIPO_EVENTO_BDE => array(
          'mensagem' => 'Objeto com atraso na entrega.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDI => array(
          'mensagem' => 'Objeto com atraso na entrega.',
          'acao' => 'Acompanhar.',
        ),
        Correios::TIPO_EVENTO_BDR => array(
          'mensagem' => 'Objeto com atraso na entrega.',
          'acao' => 'Acompanhar.',
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
  