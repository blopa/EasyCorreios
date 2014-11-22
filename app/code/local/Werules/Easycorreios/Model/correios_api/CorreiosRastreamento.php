<?php

  /**
   * Classe para Rastreamento de Objetos via XML.
   * Baseado na versão 1.5 do manual.
   * 
   * Para automatizar o processo de retorno de informações sobre o rastreamento de objetos, 
   * o cliente pode conectar-se ao servidor do Sistema de Rastreamento de Objetos – SRO e 
   * obter detalhes (rastros) dos objetos postados fazendo uso do padrão XML 
   * (eXtensible Markup Language) para intercâmbio das informações.
   * 
   * Cada consulta ao sistema fornece informações sobre o rastreamento de até 50 objetos 
   * por conexão, sem limites de conexões.
   * 
   * O Cliente deverá informar os números dos objetos a rastrear através de uma 
   * conexão HTTP (HyperText Transfer Protocol).
   *
   * @author Ivan Wilhelm <ivan.whm@me.com>
   * @see http://blog.correios.com.br/comercioeletronico/wp-content/uploads/2011/10/Guia-Tecnico-Rastreamento-XML-Cliente-Vers%C3%A3o-e-commerce-v-1-5.pdf
   * @version 1.1.1
   */
  class CorreiosRastreamento extends Correios
  {

    /**
     * Contém a definição de como a lista de identificadores de objetos deverá ser
     * interpretada pelo servidor de SRO.
     * 
     * @var string
     */
    private $tipo;

    /**
     * Contém a delimitação de escopo da resposta a ser data à consulta do
     * rastreamento de cada objeto.
     * 
     * @var string
     */
    private $resultado;

    /**
     * Contém a lista de objetos a pesquisar.
     * 
     * @var array 
     */
    private $objetos = array();

    /**
     * Contém o objeto de retorno.
     * 
     * @var CorreiosRastreamentoResultado
     */
    private $retorno;

    /**
     * Indica como a lista de identificadores de objetos deverá ser
     * interpretada pelo servidor de SRO.
     * 
     * @param string $tipo Tipo de rastreamento.
     * @throws Exception 
     */
    public function setTipo($tipo)
    {
      if (in_array($tipo, parent::$tiposRastreamento))
      {
        $this->tipo = $tipo;
      } else
      {
        throw new Exception('O tipo de rastreamento informado é inválido.');
      }
    }

    /**
     * Indica o escopo da resposta a ser data à consulta do rastreamento de cada objeto.
     * 
     * @param string $resultado Resultado do rastreamento.
     * @throws Exception 
     */
    public function setResultado($resultado)
    {
      if (in_array($resultado, parent::$resultadosRastreamento))
      {
        $this->resultado = $resultado;
      } else
      {
        throw new Exception('O tipos de resultado de rastreamento informado é inválido.');
      }
    }

    /**
     * Adiona um objeto a lista de objetos a serem pesquisados.
     * 
     * @param string $objeto Objeto de rastreamento
     * @throws Exception 
     */
    public function addObjeto($objeto)
    {
      if (CorreiosSro::validaSro($objeto))
      {
        $this->objetos[] = $objeto;
      } else
      {
        throw new Exception('O número de objeto informado é inválido.');
      }
    }

    /**
     * Retorna a lista dos objetos a serem pesquisados um após o outro, 
     * sem espaços ou outro símbolo separador.
     * 
     * @return string
     */
    private function getObjetos()
    {
      $objetos = implode('', $this->objetos);
      return $objetos;
    }

    /**
     * Retorna o objeto do resultado.
     * 
     * @return CorreiosRastreamentoResultado
     */
    public function getRetorno()
    {
      return $this->retorno;
    }

    /**
     * Returna os parâmetros necessários para a chamada.
     * 
     * @return array
     */
    protected function getParametros()
    {
      $parametros = array(
        'Usuario' => (string) $this->getUsuario(),
        'Senha' => (string) $this->getSenha(),
        'Tipo' => (string) $this->tipo,
        'Resultado' => (string) $this->resultado,
        'Objetos' => (string) $this->getObjetos(),
      );
      return $parametros;
    }

    /**
     * Processa a consulta e armazena o resultado.
     * 
     * @return boolean
     * @throws Exception 
     */
    public function processaConsulta()
    {
      //Ativa o uso de URL FOpen
      ini_set("allow_url_fopen", 1);
      //Inicialização do retorno
      $retorno = FALSE;
      //Valida se o servidor está no ar
      if (@fopen(parent::URL_CALCULADOR, 'r'))
      {
        //Inicia a consulta
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, parent::URL_RASTREADOR);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($this->getParametros()));
        $result = curl_exec($curl);
        $saida = $result;
        curl_close($curl);
        $resultado = simplexml_load_string($saida);
        if ($resultado instanceof SimpleXMLElement)
        {
          $retorno = TRUE;
          $rastreamento = new CorreiosRastreamentoResultado();
          $rastreamento->setVersao(isset($resultado->versao) ? (string) $resultado->versao : '');
          $rastreamento->setQuantidade(isset($resultado->qtd) ? (int) $resultado->qtd : 0);
          $rastreamento->setTipoPesquisa(isset($resultado->TipoPesquisa) ? (string) $resultado->TipoPesquisa : '');
          $rastreamento->setTipoResultado(isset($resultado->TipoResultado) ? (string) $resultado->TipoResultado : '');
          if ($rastreamento->getQuantidade() > 0 and isset($resultado->objeto))
          {
            foreach ($resultado->objeto as $objetoDetalhe)
            {
              $objeto = new CorreiosRastreamentoResultadoOjeto();
              $objeto->setObjeto(isset($objetoDetalhe->numero) ? (string) $objetoDetalhe->numero : '');
              foreach ($objetoDetalhe->evento as $eventoObjeto)
              {
                $evento = new CorreiosRastreamentoResultadoEvento();
                $evento->setTipo(isset($eventoObjeto->tipo) ? (string) $eventoObjeto->tipo : '');
                $evento->setStatus(isset($eventoObjeto->status) ? (integer) $eventoObjeto->status : 0);
                $evento->setData(isset($eventoObjeto->data) ? (string) $eventoObjeto->data : '');
                $evento->setHora(isset($eventoObjeto->hora) ? (string) $eventoObjeto->hora : '');
                $evento->setDescricao(isset($eventoObjeto->descricao) ? (string) $eventoObjeto->descricao : '');
                $evento->setComentario(isset($eventoObjeto->comentario) ? (string) $eventoObjeto->comentario : '');
                $evento->setLocalEvento(isset($eventoObjeto->local) ? (string) $eventoObjeto->local : '');
                $evento->setCodigoEvento(isset($eventoObjeto->codigo) ? (string) $eventoObjeto->codigo : '');
                $evento->setCidadeEvento(isset($eventoObjeto->cidade) ? (string) $eventoObjeto->cidade : '');
                $evento->setUfEvento(isset($eventoObjeto->uf) ? (string) $eventoObjeto->uf : '');
                $evento->setPossuiDestino(isset($eventoObjeto->destino));
                if (isset($eventoObjeto->destino))
                {
                  $evento->setLocalDestino(isset($eventoObjeto->destino->local) ? $eventoObjeto->destino->local : '');
                  $evento->setCidadeDestino(isset($eventoObjeto->destino->cidade) ? $eventoObjeto->destino->cidade : '');
                  $evento->setBairroDestino(isset($eventoObjeto->destino->bairro) ? $eventoObjeto->destino->bairro : '');
                  $evento->setUfDestino(isset($eventoObjeto->destino->uf) ? $eventoObjeto->destino->uf : '');
                  $evento->setCodigoDestino(isset($eventoObjeto->destino->codigo) ? $eventoObjeto->destino->codigo : '');
                }
                $objeto->addEvento($evento);
              }
              $rastreamento->addResultado($objeto);
            }
          }
          $this->retorno = $rastreamento;
        }
      }
      return $retorno;
    }

  }
  