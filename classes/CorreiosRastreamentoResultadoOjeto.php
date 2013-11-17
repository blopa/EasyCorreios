<?php

  /**
   * Classe que irá conter um objeto de rastreamento de encomendas.
   *  
   * @author Ivan Wilhelm <ivan.whm@me.com>
   * @see http://blog.correios.com.br/comercioeletronico/wp-content/uploads/2011/10/Guia-Tecnico-Rastreamento-XML-Cliente-Vers%C3%A3o-e-commerce-v-1-5.pdf
   * @version 1.0
   */
  class CorreiosRastreamentoResultadoOjeto extends CorreiosRastreamentoResultado
  {

    /**
     * Contém o número do objeto enviado.
     * 
     * @var string
     */
    private $objeto;

    /**
     * Contém a descrição de um determinado evento.
     * 
     * @var CorreiosRastreamentoResultadoEvento[]
     */
    private $evento;

    /**
     * Indica o número do objeto enviado.
     * 
     * @param string $objeto Número do objeto enviado.
     */
    public function setObjeto($objeto)
    {
      $this->objeto = $objeto;
    }

    /**
     * Adiciona um evento ao rastreamento.
     * 
     * @param CorreiosRastreamentoResultadoEvento $evento Evento do objeto.
     */
    public function addEvento(CorreiosRastreamentoResultadoEvento $evento)
    {
      $this->evento[] = $evento;
    }

    /**
     * Retorna o número do objeto enviado.
     * 
     * @return string
     */
    public function getObjeto()
    {
      return $this->objeto;
    }

    /**
     * Retorna a descrição de um determinado evento.
     * 
     * @return CorreiosRastreamentoResultadoEvento[] 
     */
    public function getEventos()
    {
      return $this->evento;
    }

  }
  