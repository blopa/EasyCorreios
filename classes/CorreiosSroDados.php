<?php

  /**
   * Classe base para a obtenção de informações a respeito de um SRO.
   * 
   * @author Ivan Wilhelm <ivan.whm@me.com>
   * @version 1.0
   * @final
   */
  final class CorreiosSroDados extends CorreiosSro
  {

    /**
     * Contém o código de rastreamento.
     * @var string
     */
    private $sro;

    /**
     * Contém a sigla do tipo de serviço utilizado.
     * @var string
     */
    private $siglaTipoServico;

    /**
     * Contém a descrição do tipo de serviço utilizado.
     * @var string
     */
    private $descricaoTipoServico;

    /**
     * Contém o código do objeto.
     * @var string
     */
    private $codigoObjeto;

    /**
     * Contém o dígito verificador do objeto.
     * @var integer
     */
    private $digitoVerificador;

    /**
     * Contém a sigla ISO2 do país de origem.
     * @var string
     */
    private $paisOrigem;

    /**
     * Cria um objeto para obter os dados do SRO.
     * @param string $sro Código de rastreamento.
     * @throws Exception
     */
    public function __construct($sro)
    {
      if (parent::validaSro($sro))
      {
        $this->sro = $sro;
        $this->siglaTipoServico = substr($sro, 0, 2);
        $this->descricaoTipoServico = self::$siglasComDescricao[substr($sro, 0, 2)];
        $this->codigoObjeto = substr($sro, 2, 8);
        $this->digitoVerificador = substr($sro, 10, 1);
        $this->paisOrigem = substr($sro, 11, 2);
      } else
      {
        throw new Exception('O número de objeto informado é inválido.');
      }
    }

    /**
     * Retorna o código de rastreamento.
     * @return string
     */
    public function getSro()
    {
      return $this->sro;
    }

    /**
     * Retorna a sigla do tipo de serviço utilizado.
     * @return string
     */
    public function getSiglaTipoServico()
    {
      return $this->siglaTipoServico;
    }

    /**
     * Retorna a descrição do tipo de serviço utilizado.
     * @return string
     */
    public function getDescricaoTipoServico()
    {
      return $this->descricaoTipoServico;
    }

    /**
     * Retorna o código do objeto.
     * @return string
     */
    public function getCodigoObjeto()
    {
      return $this->codigoObjeto;
    }

    /**
     * Retorna o dígito verificador do objeto.
     * @return integer
     */
    public function getDigitoVerificador()
    {
      return $this->digitoVerificador;
    }

    /**
     * Retorna a sigla ISO2 do país de origem.
     * @return string
     */
    public function getPaisOrigem()
    {
      return $this->paisOrigem;
    }

  }
  