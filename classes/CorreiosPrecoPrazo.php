<?php

  /**
   * Classe para Cálculo de Preços e Prazos de Encomendas.
   * Baseado na versão 1.7 do cálculo.
   * 
   * O cálculo remoto de preços e prazos de encomendas dos Correios é destinado
   * aos clientes que possuem contrato de Sedex, e-Sedex e PAC, que necessitam
   * calcular, no seu website e de forma personalizada, o preço e o prazo de entrega
   * de uma encomenda.
   * 
   * É possível também a um cliente que não possui contrato de encomenda com os
   * Correios realizar o cálculo, porém, neste caso os preços apresentados serão aqueles 
   * praticados no balcão da agência.
   *
   * @author Ivan Wilhelm <ivan.whm@me.com>
   * @see http://www.correios.com.br/webServices/PDF/SCPP_manual_implementacao_calculo_remoto_de_precos_e_prazos.pdf
   * @version 1.1
   * @final
   */
  final class CorreiosPrecoPrazo extends Correios
  {

    /**
     * Contém o CEP de origem.
     * @var string
     */
    private $cepOrigem;

    /**
     * Contém o CEP de destino.
     * @var string
     */
    private $cepDestino;

    /**
     * Contém o peso da mercadoria.
     * @var float
     */
    private $peso;

    /**
     * Contém o formato da encomenda.
     * @var integer
     */
    private $formato;

    /**
     * Contém o comprimento da embalagem.
     * @var float
     */
    private $comprimento;

    /**
     * Contém a altura da embalagem.
     * @var float
     */
    private $altura;

    /**
     * Contém a largura da embalagem.
     * @var float
     */
    private $largura;

    /**
     * Contém o diâmetro da embalagem.
     * @var float
     */
    private $diametro;

    /**
     * Indica se a encomenda terá mão própria.
     * @var boolean
     */
    private $maoPropria;

    /**
     * Contém o valor declarado da encomenda.
     * @var float
     */
    private $valorDeclarado;

    /**
     * Indica se a encomenda terá aviso de recebimento.
     * @var boolean
     */
    private $avisoRecebimento;

    /**
     * Contém os códigos de serviço utilizados.
     * @var array
     */
    private $servicosConsulta = array();

    /**
     * Contém o retorno da consulta.
     * 
     * @var CorreiosPrecoPrazoResult[]
     */
    private $retornos = array();

    /**
     * Adiciona um código de serviço para realizar a consulta.
     * 
     * @param string $codigoServico Código do serviço.
     * @throws Exception 
     */
    public function addServico($codigoServico)
    {
      if (in_array($codigoServico, parent::$servicos))
      {
        $this->servicosConsulta[] = $codigoServico;
      } else
      {
        throw new Exception('Código de servico inválido.');
      }
    }

    /**
     * Indica o CEP (sem o hífen) de origem da encomenda.
     * 
     * @param string $cepOrigem CEP de origem.
     */
    public function setCepOrigem($cepOrigem)
    {
      $this->cepOrigem = $cepOrigem;
    }

    /**
     * Indica o CEP (sem o hífen) de destino da encomenda.
     * 
     * @param string $cepDestino CEP de destino.
     */
    public function setCepDestino($cepDestino)
    {
      $this->cepDestino = $cepDestino;
    }

    /**
     * Indica o peso da encomenda, incluindo sua embalagem.
     * O peso deve ser informado em quilogramas.
     * 
     * @param float $peso Peso da encomenda.
     * @throws Exception 
     */
    public function setPeso($peso)
    {
      if (is_float($peso))
      {
        $this->peso = $peso;
      } else
      {
        throw new Exception('Peso inválido.');
      }
    }

    /**
     * Indica o formato da encomenda, incluindo sua embalagem.
     *
     * @param integer $formato Formato da encomenda.
     * @throws Exception 
     */
    public function setFormato($formato)
    {
      if (in_array($formato, parent::$formatos))
      {
        $this->formato = $formato;
      } else
      {
        throw new Exception('Formato inválido.');
      }
    }

    /**
     * Indica o comprimendo da encomenda, incluindo sua embalagem, em centímetros.
     * 
     * @param float $comprimento Comprimento da encomenda.
     * @throws Exception 
     */
    public function setComprimento($comprimento)
    {
      if (is_float($comprimento))
      {
        $this->comprimento = $comprimento;
      } else
      {
        throw new Exception('Comprimento inválido.');
      }
    }

    /**
     * Indica a altura da encomenda, incluindo sua embalagem, em centímetros.
     * 
     * @param float $altura Altura da embalagem.
     * @throws Exception 
     */
    public function setAltura($altura)
    {
      if (is_float($altura))
      {
        $this->altura = $altura;
      } else
      {
        throw new Exception('Altura inválida.');
      }
    }

    /**
     * Indica a largura da encomenda, incluindo sua embalagem, em centímetros.
     * 
     * @param float $largura Largura da embalagem.
     * @throws Exception 
     */
    public function setLargura($largura)
    {
      if (is_float($largura))
      {
        $this->largura = $largura;
      } else
      {
        throw new Exception('Largura inválida.');
      }
    }

    /**
     * Indica o diâmetro da encomenda, incluindo sua embalagem, em centímetros.
     * 
     * @param float $diametro Diâmetro da embalagem.
     * @throws Exception 
     */
    public function setDiametro($diametro)
    {
      if (is_float($diametro))
      {
        $this->diametro = $diametro;
      } else
      {
        throw new Exception('Diâmetro inválido.');
      }
    }

    /**
     * Indica se a encomenda será entregue com o serviço adicional de mão própria.
     * 
     * @param boolean $maoPropria Mão própria.
     * @throws Exception 
     */
    public function hasMaoPropria($maoPropria)
    {
      if (is_bool($maoPropria))
      {
        $this->maoPropria = $maoPropria;
      } else
      {
        throw new Exception('Mão própria inválida.');
      }
    }

    /**
     * Indica se a encomenda será entregue com o serviço adicional valor declarado.
     * Neste atributo deve ser apresentado o valor declarado desejado, em Reais.
     * 
     * @param float $valorDeclarado Valor declarado da encomenda.
     * @throws Exception 
     */
    public function setValorDeclarado($valorDeclarado)
    {
      if (is_float($valorDeclarado))
      {
        $this->valorDeclarado = $valorDeclarado;
      } else
      {
        throw new Exception('Valor declarado inválido.');
      }
    }

    /**
     * Indica se a encomenda será entregue com o serviço adicional aviso de recebimento.
     * 
     * @param boolean $avisoRecebimento Aviso de recebimento.
     * @throws Exception 
     */
    public function hasAvisoRecebimento($avisoRecebimento)
    {
      if (is_bool($avisoRecebimento))
      {
        $this->avisoRecebimento = $avisoRecebimento;
      } else
      {
        throw new Exception('Aviso de recebimento inválido.');
      }
    }

    /**
     * Retorna o código dos serviços que serão utilizados na consulta.
     * 
     * @return string
     */
    private function getServicos()
    {
      $servicos = implode(',', $this->servicosConsulta);
      return $servicos;
    }

    /**
     * Contém o retorno da consulta.
     * 
     * @return CorreiosPrecoPrazoResultado[]
     */
    public function getRetorno()
    {
      return $this->retornos;
    }

    /**
     * Returna os parâmetros necessários para a chamada.
     * 
     * @return array
     */
    protected function getParametros()
    {
      $parametros = array(
        'nCdEmpresa' => (string) $this->getUsuario(),
        'sDsSenha' => (string) $this->getSenha(),
        'nCdServico' => (string) $this->getServicos(),
        'sCepOrigem' => (string) $this->cepOrigem,
        'sCepDestino' => (string) $this->cepDestino,
        'nVlPeso' => (float) $this->peso,
        'nCdFormato' => (integer) $this->formato,
        'nVlComprimento' => (float) $this->comprimento,
        'nVlAltura' => (float) $this->altura,
        'nVlLargura' => (float) $this->largura,
        'nVlDiametro' => (float) $this->diametro,
        'sCdMaoPropria' => (string) $this->maoPropria ? 'S' : 'N',
        'nVlValorDeclarado' => (float) $this->valorDeclarado,
        'sCdAvisoRecebimento' => (string) $this->avisoRecebimento ? 'S' : 'N',
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
      ini_set("soap.wsdl_cache_enabled", 0);
      //Inicia transação junto a Braspag
      try
      {
        if (@fopen(parent::URL_CALCULADOR, 'r'))
        {
          $soap = new SoapClient(parent::URL_CALCULADOR);
          $retorno = $soap->CalcPrecoPrazo($this->getParametros());

          if ($retorno instanceof stdClass)
          {
            $retornosConsulta = $retorno->CalcPrecoPrazoResult->Servicos->cServico;
            if (is_array($retornosConsulta))
            {
              foreach ($retornosConsulta as $retornoConsulta)
              {
                $servico = new CorreiosPrecoPrazoResultado($retornoConsulta);
                $this->retornos[] = $servico;
              }
            } else if ($retornosConsulta instanceof stdClass)
            {
              $servico = new CorreiosPrecoPrazoResultado($retornosConsulta);
              $this->retornos[] = $servico;
            }
            return TRUE;
          } else
          {
            return FALSE;
          }
        } else
        {
          return FALSE;
        }
      } catch (SoapFault $sf)
      {
        throw new Exception($sf->getMessage());
      }
    }

  }
  