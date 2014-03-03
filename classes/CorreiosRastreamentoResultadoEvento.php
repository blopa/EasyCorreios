<?php

  /**
   * Classe que irá conter um evento de rastreamento de encomendas.
   *  
   * @author Ivan Wilhelm <ivan.whm@me.com>
   * @see http://blog.correios.com.br/comercioeletronico/wp-content/uploads/2011/10/Guia-Tecnico-Rastreamento-XML-Cliente-Vers%C3%A3o-e-commerce-v-1-5.pdf
   * @version 1.1
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
     * @var integer
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
    private $localEvento;

    /**
     * Contém o CEP da unidade ECT.
     * 
     * @var string
     */
    private $codigoEvento;

    /**
     * Contém a cidade onde ocorreu o evento.
     * 
     * @var string
     */
    private $cidadeEvento;

    /**
     * Contém a unidade da federação onde ocorreu o evento.
     * 
     * @var string
     */
    private $ufEvento;

    /**
     * Contém o local de destino.
     * 
     * @var string
     */
    private $localDestino;

    /**
     * Contém o CEP de destino.
     * 
     * @var string
     */
    private $codigoDestino;

    /**
     * Contém a cidade de destino.
     * 
     * @var string
     */
    private $cidadeDestino;

    /**
     * Contém o bairro de destino.
     * 
     * @var string
     */
    private $bairroDestino;

    /**
     * Contém a unidade da federação de destino.
     * 
     * @var string
     */
    private $ufDestino;

    /**
     * Indica se o evento possui informação do destino.
     * 
     * @var boolean
     */
    private $possuiDestino;

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
     * @param integer $status Status do evento de retorno.
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
    public function setLocalEvento($local)
    {
      $this->localEvento = $local;
    }

    /**
     * Indica o CEP da unidade ECT.
     * 
     * @param string $codigo CEP da unidade ECT.
     */
    public function setCodigoEvento($codigo)
    {
      $this->codigoEvento = $codigo;
    }

    /**
     * Indica a cidade onde ocorreu o evento.
     * 
     * @param string $cidade Cidade onde ocorreu o evento.
     */
    public function setCidadeEvento($cidade)
    {
      $this->cidadeEvento = $cidade;
    }

    /**
     * Indica a unidade da federação.
     * 
     * @param string $uf Unidade da federação.
     */
    public function setUfEvento($uf)
    {
      $this->ufEvento = $uf;
    }

    /**
     * Indica se o evento possui destino.
     * 
     * @param boolean $possuiDestino Indica se possui destino.
     */
    public function setPossuiDestino($possuiDestino)
    {
      $this->possuiDestino = $possuiDestino;
    }

    /**
     * Indica o local de destino.
     * 
     * @param string $localDestino Local de destino.
     */
    public function setLocalDestino($localDestino)
    {
      $this->localDestino = $localDestino;
    }

    /**
     * Indica o CEP de destino.
     * 
     * @param string $codigoDestino CEP de destino.
     */
    public function setCodigoDestino($codigoDestino)
    {
      $this->codigoDestino = $codigoDestino;
    }

    /**
     * Indica a cidade de destino.
     * 
     * @param string $cidadeDestino Cidade de destino.
     */
    public function setCidadeDestino($cidadeDestino)
    {
      $this->cidadeDestino = $cidadeDestino;
    }

    /**
     * Indica o bairro de destino.
     * 
     * @param string $bairroDestino Bairro de destino.
     */
    public function setBairroDestino($bairroDestino)
    {
      $this->bairroDestino = $bairroDestino;
    }

    /**
     * Indica a UF de destino.
     * 
     * @param string $ufDestino UF de destino.
     */
    public function setUfDestino($ufDestino)
    {
      $this->ufDestino = $ufDestino;
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
     * @return integer
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
    public function getLocalEvento()
    {
      return $this->localEvento;
    }

    /**
     * Retorna o CEP da unidade ECT.
     * 
     * @return string
     */
    public function getCodigoEvento()
    {
      return $this->codigoEvento;
    }

    /**
     * Retorna a cidade onde ocorreu o evento.
     * 
     * @return string
     */
    public function getCidadeEvento()
    {
      return $this->cidadeEvento;
    }

    /**
     * Retorna a unidade da federação.
     * 
     * @return string
     */
    public function getUfEvento()
    {
      return $this->ufEvento;
    }

    /**
     * Retorna se o evento possui destino.
     * 
     * @return boolean
     */
    public function getPossuiDestino()
    {
      return $this->possuiDestino;
    }

    /**
     * Retorna o local de destino.
     * 
     * @return string
     */
    public function getLocalDestino()
    {
      return $this->localDestino;
    }

    /**
     * Retorna o CEP de destino.
     * 
     * @return string
     */
    public function getCodigoDestino()
    {
      return $this->codigoDestino;
    }

    /**
     * Retorna a cidade de destino.
     * 
     * @return string
     */
    public function getCidadeDestino()
    {
      return $this->cidadeDestino;
    }

    /**
     * Retorna o bairro de destino.
     * 
     * @return string
     */
    public function getBairroDestino()
    {
      return $this->bairroDestino;
    }

    /**
     * Retorna a UF de destino.
     * 
     * @return string
     */
    public function getUfDestino()
    {
      return $this->ufDestino;
    }

    /**
     * Retorna a descrição do status do objeto.
     * @return string
     */
    public function getDescricaoStatus()
    {
      return ((isset(Correios::$statusRastreamento[$this->getStatus()])) and in_array($this->tipo, Correios::$statusRastreamento[$this->getStatus()]['tipos'])) ? Correios::$statusRastreamento[$this->getStatus()]['mensagem'] : 'Andamento normal.';
    }

  }
  