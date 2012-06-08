<?php

  /**
   * Classe que irá conter o resultado de um rastreamento de encomendas.
   *  
   * @author Ivan Wilhelm <ivan.whm@me.com>
   * @see http://blog.correios.com.br/comercioeletronico/wp-content/uploads/2011/10/Guia-Tecnico-Rastreamento-XML-Cliente-Vers%C3%A3o-e-commerce-v-1-5.pdf
   * @version 1.0
   */
  class CorreiosRastreamentoResultado extends CorreiosRastreamento
  {

    /**
     * Contém a versão do SRO do XML.
     * 
     * @var string
     */
    private $versao;

    /**
     * Contém a quantidade de objetos consultados.
     * 
     * @var integer
     */
    private $quantidade;

    /**
     * Contém a lista ou intervalo de objetos.
     * 
     * @var string
     */
    private $tipoPesquisa;

    /**
     * Contém o último evento ou todos os eventos.
     * 
     * @var string
     */
    private $tipoResultado;

    /**
     * Contém resultados em forma de eventos.
     * 
     * @var CorreiosRastreamentoResultadoOjeto[]
     */
    private $resultados;

    /**
     * Indica a versão do SRO do XML.
     * 
     * @param string $versao Versão do SRO do XML.
     */
    public function setVersao($versao)
    {
      $this->versao = $versao;
    }

    /**
     * Indica a quantidade de objetos consultados.
     * 
     * @param integer $quantidade Quantidade de objetos consultados.
     */
    public function setQuantidade($quantidade)
    {
      $this->quantidade = (int) $quantidade;
    }

    /**
     * Indica a lista ou intervalo de objetos.
     * 
     * @param string $tipoPesquisa Lista ou intervalo de objetos.
     */
    public function setTipoPesquisa($tipoPesquisa)
    {
      $this->tipoPesquisa = $tipoPesquisa;
    }

    /**
     * Indica o último evento ou todos os eventos.
     * 
     * @param string $tipoResultado Último evento ou todos os eventos.
     */
    public function setTipoResultado($tipoResultado)
    {
      $this->tipoResultado = $tipoResultado;
    }

    /**
     * Adiciona um resultado de objeto.
     * 
     * @param CorreiosRastreamentoResultadoOjeto $objeto Resultado.
     */
    public function addResultado(CorreiosRastreamentoResultadoOjeto $objeto)
    {
      $this->resultados[] = $objeto;
    }

    /**
     * Retorna a versão do SRO do XML.
     * 
     * @return string
     */
    public function getVersao()
    {
      return $this->versao;
    }

    /**
     * Retorna a quantidade de objetos consultados.
     * 
     * @return integer 
     */
    public function getQuantidade()
    {
      return $this->quantidade;
    }

    /**
     * Retorna a lista ou intervalo de objetos.
     * 
     * @return string
     */
    public function getTipoPesquisa()
    {
      return $this->tipoPesquisa;
    }

    /**
     * Retorna o último evento ou todos os eventos.
     * 
     * @return string
     */
    public function getTipoResultado()
    {
      return $this->tipoResultado;
    }

    /**
     * Retorna os resultados em forma de eventos.
     * 
     * @return CorreiosRastreamentoResultadoOjeto[] 
     */
    public function getResultados()
    {
      return $this->resultados;
    }

  }

?>
