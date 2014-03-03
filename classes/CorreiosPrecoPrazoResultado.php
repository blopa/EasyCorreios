<?php

  /**
   * Classe que irá conter o resultado de uma consulta remota de preço
   * e prazo de entrega dos Correios.
   *  
   * @author Ivan Wilhelm <ivan.whm@me.com>
   * @see http://www.correios.com.br/webServices/PDF/SCPP_manual_implementacao_calculo_remoto_de_precos_e_prazos.pdf
   * @version 1.1
   * @final
   */
  final class CorreiosPrecoPrazoResultado
  {

    /**
     * Contém o código do serviço.
     * 
     * @var string
     */
    private $codigo;

    /**
     * Contém o valor do frete para o serviço.
     * 
     * @var float
     */
    private $valor;

    /**
     * Contém o prazo de entrega em dias.
     * 
     * @var integer
     */
    private $prazoEntrega;

    /**
     * Contém o valor do serviço adicional de mão própria.
     * 
     * @var float
     */
    private $valorMaoPropria;

    /**
     * Contém o valor do serviço adicional de aviso de recebimento.
     * 
     * @var float
     */
    private $valorAvisoRecebimento;

    /**
     * Contém o valor do serviço adicional de valor declarado.
     * 
     * @var float
     */
    private $valorValorDeclarado;

    /**
     * Indica se o serviço realiza entrega domiciliar.
     * 
     * @var boolean
     */
    private $entregaDomiciliar;

    /**
     * Indica se o serviço entrega no Sábado.
     * 
     * @var boolean
     */
    private $entregaSabado;

    /**
     * Contém o código de erro da consulta.
     * Quando retorna zero significa que não houve erro.
     * 
     * @var integer
     */
    private $erro;

    /**
     * Contém a mensagem de erro da consulta.
     * 
     * @var string
     */
    private $mensagemErro;

    /**
     * Cria um objeto para tratar o retorno da consulta.
     * 
     * @param stdClass $retorno Retorno da consulta.
     * @param string $tipoCalculo Tipo de cálculo.
     */
    public function __construct(stdClass $retorno, $tipoCalculo)
    {
      $this->setCodigo($retorno->Codigo);
      $this->setErro($retorno->Erro);
      $this->setMensagemErro($retorno->MsgErro);

      if (($tipoCalculo == Correios::TIPO_CALCULO_PRECO_TODOS) or ($tipoCalculo == Correios::TIPO_CALCULO_PRECO_SO_PRAZO))
      {
        $this->setPrazoEntrega($retorno->PrazoEntrega);
        $this->setEntregaDomiciliar($retorno->EntregaDomiciliar);
        $this->setEntregaSabado($retorno->EntregaSabado);
      }

      if (($tipoCalculo == Correios::TIPO_CALCULO_PRECO_TODOS) or ($tipoCalculo == Correios::TIPO_CALCULO_PRECO_SO_PRECO))
      {
        $this->setValor($retorno->Valor);
        $this->setValorMaoPropria($retorno->ValorMaoPropria);
        $this->setValorAvisoRecebimento($retorno->ValorAvisoRecebimento);
        $this->setValorValorDeclarado($retorno->ValorValorDeclarado);
      }
    }

    /**
     * Informa o código do serviço retornado da consulta.
     * 
     * @param string $codigo Código do serviço.
     */
    private function setCodigo($codigo)
    {
      $this->codigo = (string) $codigo;
    }

    /**
     * Informa o valor do frete.
     * 
     * @param string $valor Valor do frete.
     */
    private function setValor($valor)
    {
      $this->valor = (float) str_replace(',', '.', $valor);
    }

    /**
     * Informa o prazo de entrega retornado.
     * 
     * @param string $prazoEntrega Prazo de entrega.
     */
    private function setPrazoEntrega($prazoEntrega)
    {
      $this->prazoEntrega = (integer) $prazoEntrega;
    }

    /**
     * Informa o valor do serviço adicional de mão própria.
     * 
     * @param string $valorMaoPropria Valor da mão própria.
     */
    private function setValorMaoPropria($valorMaoPropria)
    {
      $this->valorMaoPropria = (float) str_replace(',', '.', $valorMaoPropria);
    }

    /**
     * Informa o valor do serviço adicional de aviso de recebimento.
     * 
     * @param string $valorAvisoRecebimento Valor do aviso de recebimento.
     */
    private function setValorAvisoRecebimento($valorAvisoRecebimento)
    {
      $this->valorAvisoRecebimento = (float) str_replace(',', '.', $valorAvisoRecebimento);
    }

    /**
     * Informa o valor do serviço adicional de valor declarado.
     * 
     * @param string $valorValorDeclarado Valor do valor declarado.
     */
    private function setValorValorDeclarado($valorValorDeclarado)
    {
      $this->valorValorDeclarado = (float) str_replace(',', '.', $valorValorDeclarado);
    }

    /**
     * Informa o serviço realiza entrega domiciliar.
     * 
     * @param string $entregaDomiciliar Entrega domiciliar.
     */
    private function setEntregaDomiciliar($entregaDomiciliar)
    {
      $this->entregaDomiciliar = (boolean) ($entregaDomiciliar == 'S');
    }

    /**
     * Informa se o serviço entrega aos sábados.
     * 
     * @param string $entregaSabado Entrega aos sábados.
     */
    private function setEntregaSabado($entregaSabado)
    {
      $this->entregaSabado = (boolean) ($entregaSabado == 'S');
    }

    /**
     * Informa o código do erro.
     * 
     * @param string $erro Código do erro.
     */
    private function setErro($erro)
    {
      $this->erro = (integer) $erro;
    }

    /**
     * Informa a mensagem de erro, quando hover.
     * 
     * @param string $mensagemErro Mensagem de erro.
     */
    private function setMensagemErro($mensagemErro)
    {
      $this->mensagemErro = (string) $mensagemErro;
    }

    /**
     * Retorna o código do serviço.
     * 
     * @return string
     */
    public function getCodigo()
    {
      return $this->codigo;
    }

    /**
     * Retorna o valor total do frete, incluindo os serviços adicionais.
     * 
     * @return float
     */
    public function getValor()
    {
      return $this->valor;
    }

    /**
     * Retorna o prazo de entrega, em dias.
     * 
     * @return integer
     */
    public function getPrazoEntrega()
    {
      return $this->prazoEntrega;
    }

    /**
     * Retorna o valor do serviço adicional de mão própria.
     * 
     * @return float
     */
    public function getValorMaoPropria()
    {
      return $this->valorMaoPropria;
    }

    /**
     * Retorna o valor do serviço adicional de aviso de recebimento.
     * 
     * @return float
     */
    public function getValorAvisoRecebimento()
    {
      return $this->valorAvisoRecebimento;
    }

    /**
     * Retorna o valor do serviço adicional de valor declarado.
     * 
     * @return float
     */
    public function getValorValorDeclarado()
    {
      return $this->valorValorDeclarado;
    }

    /**
     * Indica se o serviço realiza entrega domiciliar.
     * 
     * @return boolean
     */
    public function getEntregaDomiciliar()
    {
      return $this->entregaDomiciliar;
    }

    /**
     * Indica se o serviço reliza entrega aos sábados.
     * 
     * @return boolean
     */
    public function getEntregaSabado()
    {
      return $this->entregaSabado;
    }

    /**
     * Retorna o código do erro.
     * Caso não hava erro, retorna o código 0.
     * 
     * @return integer
     */
    public function getErro()
    {
      return $this->erro;
    }

    /**
     * Retorna a mensagem de erro, quando houver.
     * 
     * @return string
     */
    public function getMensagemErro()
    {
      return $this->mensagemErro;
    }

  }
  