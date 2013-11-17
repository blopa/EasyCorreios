<?php

  /**
   * Classe que irá conter um evento de rastreamento de encomendas.
   *  
   * @author Ivan Wilhelm <ivan.whm@me.com>
   * @see http://blog.correios.com.br/comercioeletronico/wp-content/uploads/2011/10/Guia-Tecnico-Rastreamento-XML-Cliente-Vers%C3%A3o-e-commerce-v-1-5.pdf
   * @version 1.0
   */
  final class CorreiosRastreamentoResultadoEvento extends CorreiosRastreamentoResultadoOjeto
  {

    /**
     * Contém o tipo do evento de retorno.
     * 
     * @var string
     */
    private $tipo;

    /**
     * Contém o status do evento de retorno.
     * 
     * @var string
     */
    private $status;

    /**
     * Contém a data do evento.
     * 
     * @var string
     */
    private $data;

    /**
     * Contém a hora do evento.
     * 
     * @var string
     */
    private $hora;

    /**
     * Contém a descrição do evento.
     * 
     * @var string
     */
    private $descricao;

    /**
     * Contém um comentário adicional sobre o evento.
     * 
     * @var string
     */
    private $comentario;

    /**
     * Contém o local onde ocorreu o evento.
     * 
     * @var string
     */
    private $local;

    /**
     * Contém o CEP da unidade ECT.
     * 
     * @var string
     */
    private $codigo;

    /**
     * Contém a cidade onde ocorreu o evento.
     * 
     * @var string
     */
    private $cidade;

    /**
     * Contém a unidade da federação.
     * 
     * @var string
     */
    private $uf;

    /**
     * Indica o tipo do evento de retorno.
     * 
     * @param string $tipo Tipo do evento de retorno.
     */
    public function setTipo($tipo)
    {
      $this->tipo = $tipo;
    }

    /**
     * Indica o status do evento de retorno.
     * 
     * @param string $status Status do evento de retorno.
     */
    public function setStatus($status)
    {
      $this->status = $status;
    }

    /**
     * Indica a data do evento.
     * 
     * @param string $data Data do evento.
     */
    public function setData($data)
    {
      $this->data = $data;
    }

    /**
     * Indica a hora do evento.
     * 
     * @param string $hora Hora do evento.
     */
    public function setHora($hora)
    {
      $this->hora = $hora;
    }

    /**
     * Indica a descrição do evento.
     * 
     * @param string $descricao Descrição do evento.
     */
    public function setDescricao($descricao)
    {
      $this->descricao = $descricao;
    }

    /**
     * Indica um comentário adicional sobre o evento.
     * 
     * @param string $comentario Comentário adicional sobre o evento.
     */
    public function setComentario($comentario)
    {
      $this->comentario = $comentario;
    }

    /**
     * Indica o local onde ocorreu o evento.
     * 
     * @param string $local Local onde ocorreu o evento.
     */
    public function setLocal($local)
    {
      $this->local = $local;
    }

    /**
     * Indica o CEP da unidade ECT.
     * 
     * @param string $codigo CEP da unidade ECT.
     */
    public function setCodigo($codigo)
    {
      $this->codigo = $codigo;
    }

    /**
     * Indica a cidade onde ocorreu o evento.
     * 
     * @param string $cidade Cidade onde ocorreu o evento.
     */
    public function setCidade($cidade)
    {
      $this->cidade = $cidade;
    }

    /**
     * Indica a unidade da federação.
     * 
     * @param string $uf Unidade da federação.
     */
    public function setUf($uf)
    {
      $this->uf = $uf;
    }

    /**
     * Retorna o tipo do evento de retorno.
     * 
     * @return string
     */
    public function getTipo()
    {
      return $this->tipo;
    }

    /**
     * Retorna a descrição do tipo.
     * 
     * @return string 
     */
    public function getDescricaoTipo()
    {
      return (isset(Correios::$tipoEvento[$this->tipo]) ? Correios::$tipoEvento[$this->tipo] : '');
    }

    /**
     * Retorna o status do evento de retorno.
     * 
     * @return string
     */
    public function getStatus()
    {
      return $this->status;
    }

    /**
     * Retorna a data do evento.
     * 
     * @return string
     */
    public function getData()
    {
      return $this->data;
    }

    /**
     * Retorna a hora do evento.
     * 
     * @return string
     */
    public function getHora()
    {
      return $this->hora;
    }

    /**
     * Retorna a descrição do evento.
     * 
     * @return string
     */
    public function getDescricao()
    {
      return $this->descricao;
    }

    /**
     * Retorna um comentário adicional sobre o evento.
     * 
     * @return string
     */
    public function getComentario()
    {
      return $this->comentario;
    }

    /**
     * Retorna o local onde ocorreu o evento.
     * 
     * @return string
     */
    public function getLocal()
    {
      return $this->local;
    }

    /**
     * Retorna o CEP da unidade ECT.
     * 
     * @return string
     */
    public function getCodigo()
    {
      return $this->codigo;
    }

    /**
     * Retorna a cidade onde ocorreu o evento.
     * 
     * @return string
     */
    public function getCidade()
    {
      return $this->cidade;
    }

    /**
     * Retorna a unidade da federação.
     * 
     * @return string
     */
    public function getUf()
    {
      return $this->uf;
    }

  }
  