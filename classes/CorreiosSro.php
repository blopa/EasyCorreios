<?php

  /**
   * Classe base para para a validação e geração de dígito verificador
   * de SRO dos Correios.
   * 
   * @author Ivan Wilhelm <ivan.whm@me.com>
   * @version 1.0
   * @abstract
   */
  abstract class CorreiosSro
  {

    /**
     * Contém as siglas e suas respectivas descrições, adotadas
     * no sistema de identificador de objetos.
     * 
     * @see http://www.correios.com.br/servicos/rastreamento/internacional/siglas.cfm
     * @var array
     */
    protected static $siglasComDescricao = array(
      'AL' => 'AGENTES DE LEITURA',
      'AR' => 'AVISO DE RECEBIMENTO',
      'AS' => 'ENCOMENDA PAC – AÇÃO SOCIAL',
      'CA' => 'OBJETO INTERNACIONAL',
      'CB' => 'OBJETO INTERNACIONAL',
      'CC' => 'COLIS POSTAUX',
      'CD' => 'OBJETO INTERNACIONAL',
      'CE' => 'OBJETO INTERNACIONAL',
      'CF' => 'OBJETO INTERNACIONAL',
      'CG' => 'OBJETO INTERNACIONAL',
      'CH' => 'OBJETO INTERNACIONAL',
      'CI' => 'OBJETO INTERNACIONAL',
      'CJ' => 'REGISTRADO INTERNACIONAL',
      'CK' => 'OBJETO INTERNACIONAL',
      'CL' => 'OBJETO INTERNACIONAL',
      'CM' => 'OBJETO INTERNACIONAL',
      'CN' => 'OBJETO INTERNACIONAL',
      'CO' => 'OBJETO INTERNACIONAL',
      'CP' => 'COLIS POSTAUX',
      'CQ' => 'OBJETO INTERNACIONAL',
      'CR' => 'CARTA REGISTRADA SEM VALOR DECLARADO',
      'CS' => 'OBJETO INTERNACIONAL',
      'CT' => 'OBJETO INTERNACIONAL',
      'CU' => 'OBJETO INTERNACIONAL',
      'CV' => 'REGISTRADO INTERNACIONAL',
      'CW' => 'OBJETO INTERNACIONAL',
      'CX' => 'OBJETO INTERNACIONAL',
      'CY' => 'OBJETO INTERNACIONAL',
      'CZ' => 'OBJETO INTERNACIONAL',
      'DA' => 'REM EXPRES COM AR DIGITAL',
      'DB' => 'REM EXPRES COM AR DIGITAL BRADESCO',
      'DC' => 'REM EXPRESSA CRLV/CRV/CNH e NOTIFICAÇÃO',
      'DD' => 'DEVOLUÇÃO DE DOCUMENTOS',
      'DE' => 'REMESSA EXPRESSA TALÃO E CARTÃO C/ AR',
      'DF' => 'E-SEDEX (LÓGICO)',
      'DI' => 'REM EXPRES COM AR DIGITAL ITAU',
      'DL' => 'ENCOMENDA SEDEX (LÓGICO)',
      'DP' => 'REM EXPRES COM AR DIGITAL PRF',
      'DS' => 'REM EXPRES COM AR DIGITAL SANTANDER',
      'DT' => 'REMESSA ECON.SEG.TRANSITO C/AR DIGITAL',
      'DX' => 'ENCOMENDA SEDEX 10 (LÓGICO)',
      'EA' => 'OBJETO INTERNACIONAL',
      'EB' => 'OBJETO INTERNACIONAL',
      'EC' => 'ENCOMENDA PAC',
      'ED' => 'OBJETO INTERNACIONAL',
      'EE' => 'SEDEX INTERNACIONAL',
      'EF' => 'OBJETO INTERNACIONAL',
      'EG' => 'OBJETO INTERNACIONAL',
      'EH' => 'ENCOMENDA NORMAL COM AR DIGITAL',
      'EI' => 'OBJETO INTERNACIONAL',
      'EJ' => 'ENCOMENDA INTERNACIONAL',
      'EK' => 'OBJETO INTERNACIONAL',
      'EL' => 'OBJETO INTERNACIONAL',
      'EM' => 'OBJETO INTERNACIONAL',
      'EN' => 'ENCOMENDA NORMAL NACIONAL',
      'EO' => 'OBJETO INTERNACIONAL',
      'EP' => 'OBJETO INTERNACIONAL',
      'EQ' => 'ENCOMENDA SERVIÇO NÃO EXPRESSA ECT',
      'ER' => 'REGISTRADO',
      'ES' => 'E-SEDEX',
      'ET' => 'OBJETO INTERNACIONAL',
      'EU' => 'OBJETO INTERNACIONAL',
      'EV' => 'OBJETO INTERNACIONAL',
      'EW' => 'OBJETO INTERNACIONAL',
      'EX' => 'OBJETO INTERNACIONAL',
      'EY' => 'OBJETO INTERNACIONAL',
      'EZ' => 'OBJETO INTERNACIONAL',
      'FA' => 'FAC REGISTRATO (LÓGICO)',
      'FE' => 'ENCOMENDA FNDE',
      'FF' => 'REGISTRADO DETRAN',
      'FH' => 'REGISTRADO FAC COM AR DIGITAL',
      'FM' => 'REGISTRADO - FAC MONITORADO',
      'FR' => 'REGISTRADO FAC',
      'IA' => 'INTEGRADA AVULSA',
      'IC' => 'INTEGRADA A COBRAR',
      'ID' => 'INTEGRADA DEVOLUCAO DE DOCUMENTO',
      'IE' => 'INTEGRADA ESPECIAL',
      'IF' => 'CPF',
      'II' => 'INTEGRADA INTERNO',
      'IK' => 'INTEGRADA COM COLETA SIMULTANEA',
      'IM' => 'INTEGRADA MEDICAMENTOS',
      'IN' => 'OBJ DE CORRESP E EMS REC EXTERIOR',
      'IP' => 'INTEGRADA PROGRAMADA',
      'IR' => 'IMPRESSO REGISTRADO',
      'IS' => 'INTEGRADA STANDARD',
      'IT' => 'INTEGRADO TERMOLÁBIL',
      'IU' => 'INTEGRADA URGENTE',
      'JA' => 'REMESSA ECONOMICA C/AR DIGITAL',
      'JB' => 'REMESSA ECONOMICA C/AR DIGITAL',
      'JC' => 'REMESSA ECONOMICA C/AR DIGITAL',
      'JD' => 'REMESSA ECONOMICA C/AR DIGITAL',
      'JE' => 'REMESSA ECONÔMICA C/AR DIGITAL',
      'JG' => 'REGISTRATO AGÊNCIA (FÍSICO)',
      'JJ' => 'REGISTRADO JUSTIÇA',
      'JL' => 'OBJETO REGISTRADO (LÓGICO)',
      'JM' => 'MALA DIRETA POSTAL ESPECIAL (LÓGICO)',
      'LA' => 'LOGÍSTICA REVERSA SIMULTÂNEA - ENCOMENDA SEDEX (AGÊNCIA)',
      'LB' => 'LOGÍSTICA REVERSA SIMULTÂNEA - ENCOMENDA E-SEDEX (AGÊNCIA)',
      'LC' => 'CARTA EXPRESSA',
      'LE' => 'LOGÍSTICA REVERSA ECONOMICA',
      'LP' => 'LOGÍSTICA REVERSA SIMULTÂNEA - ENCOMENDA PAC (AGÊNCIA)',
      'LS' => 'LOGISTICA REVERSA SEDEX',
      'LV' => 'LOGISTICA REVERSA EXPRESSA',
      'LX' => 'CARTA EXPRESSA',
      'LY' => 'CARTA EXPRESSA',
      'MA' => 'SERVIÇOS ADICIONAIS',
      'MB' => 'TELEGRAMA DE BALCÃO',
      'MC' => 'MALOTE CORPORATIVO',
      'ME' => 'TELEGRAMA',
      'MF' => 'TELEGRAMA FONADO',
      'MK' => 'TELEGRAMA CORPORATIVO',
      'MM' => 'TELEGRAMA GRANDES CLIENTES',
      'MP' => 'TELEGRAMA PRÉ-PAGO',
      'MS' => 'ENCOMENDA SAUDE',
      'MT' => 'TELEGRAMA VIA TELEMAIL',
      'MY' => 'TELEGRAMA INTERNACIONAL ENTRANTE',
      'MZ' => 'TELEGRAMA VIA CORREIOS ON LINE',
      'NE' => 'TELE SENA RESGATADA',
      'PA' => 'PASSAPORTE',
      'PB' => 'ENCOMENDA PAC - NÃO URGENTE',
      'PC' => 'ENCOMENDA PAC A COBRAR',
      'PD' => 'ENCOMENDA PAC - NÃO URGENTE',
      'PF' => 'PASSAPORTE',
      'PG' => 'ENCOMENDA PAC (ETIQUETA FÍSICA)',
      'PH' => 'ENCOMENDA PAC (ETIQUETA LÓGICA)',
      'PR' => 'REEMBOLSO POSTAL - CLIENTE AVULSO',
      'RA' => 'REGISTRADO PRIORITÁRIO',
      'RB' => 'CARTA REGISTRADA',
      'RC' => 'CARTA REGISTRADA COM VALOR DECLARADO',
      'RD' => 'REMESSA ECONOMICA DETRAN',
      'RE' => 'REGISTRADO ECONÔMICO',
      'RF' => 'OBJETO DA RECEITA FEDERAL',
      'RG' => 'REGISTRADO DO SISTEMA SARA',
      'RH' => 'REGISTRADO COM AR DIGITAL',
      'RI' => 'REGISTRADO',
      'RJ' => 'REGISTRADO AGÊNCIA',
      'RK' => 'REGISTRADO AGÊNCIA',
      'RL' => 'REGISTRADO LÓGICO',
      'RM' => 'REGISTRADO AGÊNCIA',
      'RN' => 'REGISTRADO AGÊNCIA',
      'RO' => 'REGISTRADO AGÊNCIA',
      'RP' => 'REEMBOLSO POSTAL - CLIENTE INSCRITO',
      'RQ' => 'REGISTRADO AGÊNCIA',
      'RR' => 'CARTA REGISTRADA SEM VALOR DECLARADO',
      'RS' => 'REGISTRADO LÓGICO',
      'RT' => 'REM ECON TALAO/CARTAO SEM AR DIGITAL',
      'RU' => 'REGISTRADO SERVIÇO ECT',
      'RV' => 'REM ECON CRLV/CRV/CNH COM AR DIGITAL',
      'RY' => 'REM ECON TALAO/CARTAO COM AR DIGITAL',
      'RZ' => 'REGISTRADO',
      'SA' => 'SEDEX ANOREG',
      'SB' => 'SEDEX 10 AGÊNCIA (FÍSICO)',
      'SC' => 'SEDEX A COBRAR',
      'SD' => 'REMESSA EXPRESSA DETRAN',
      'SE' => 'ENCOMENDA SEDEX',
      'SF' => 'SEDEX AGÊNCIA',
      'SG' => 'SEDEX DO SISTEMA SARA',
      'SI' => 'SEDEX AGÊNCIA',
      'SJ' => 'SEDEX HOJE',
      'SK' => 'SEDEX AGÊNCIA',
      'SL' => 'SEDEX LÓGICO',
      'SM' => 'SEDEX MESMO DIA',
      'SN' => 'SEDEX COM VALOR DECLARADO',
      'SO' => 'SEDEX AGÊNCIA',
      'SP' => 'SEDEX PRÉ-FRANQUEADO',
      'SQ' => 'SEDEX',
      'SR' => 'SEDEX',
      'SS' => 'SEDEX FÍSICO',
      'ST' => 'REM EXPRES TALAO/CARTAO SEM AR DIGITAL',
      'SU' => 'ENCOMENDA SERVIÇO EXPRESSA ECT',
      'SV' => 'REM EXPRES CRLV/CRV/CNH COM AR DIGITAL',
      'SW' => 'E-SEDEX',
      'SX' => 'SEDEX 10',
      'SY' => 'REM EXPRES TALAO/CARTAO COM AR DIGITAL',
      'SZ' => 'SEDEX AGÊNCIA',
      'TE' => 'TESTE (OBJETO PARA TREINAMENTO)',
      'TS' => 'TESTE (OBJETO PARA TREINAMENTO)',
      'VA' => 'ENCOMENDAS COM VALOR DECLARADO',
      'VC' => 'ENCOMENDAS',
      'VD' => 'ENCOMENDAS COM VALOR DECLARADO',
      'VE' => 'ENCOMENDAS',
      'VF' => 'ENCOMENDAS COM VALOR DECLARADO',
      'XM' => 'SEDEX MUNDI',
      'XR' => 'ENCOMENDA SUR POSTAL EXPRESSO',
      'XX' => 'ENCOMENDA SUR POSTAL 24 HORAS',
    );

    /**
     * Realiza a validação completa do SRO.
     * @param string $sro
     * @return boolean
     */
    public static function validaSro($sro)
    {
      //Valida a estrutura do SRO
      if (preg_match('/[A-Z]{2}[0-9]{9}[A-Z]{2}/', $sro))
      {
        //Valida a sigla do SRO
        if (isset(self::$siglasComDescricao[substr($sro, 0, 2)]))
        {
          //Valida o dígito verificador
          if (self::calculaDigitoVerificador(substr($sro, 2, 8)) == substr($sro, 10, 1))
          {
            return TRUE;
          }
        }
      }
      return FALSE;
    }

    /**
     * Calcula o dígito verificador do SRO.
     * Retorna -1 se o cálculo for incorreto.
     * @param string $sro SRO
     * @return int
     */
    public static function calculaDigitoVerificador($sro)
    {
      //Inicializa o retorno
      $retorno = -1;
      //Valida a quantidade de caracteres
      if (strlen(trim($sro)) === 8)
      {
        //Valida
        $soma = 0;
        for ($i = 0; $i <= 8; $i++)
        {
          $soma = $soma + (int) substr($sro, $i, 1) * (int) substr('86423597', $i, 1);
        }
        //Calcula o dígito validador
        switch ($soma % 11)
        {
          case 0:
            $retorno = 5;
            break;
          case 1:
            $retorno = 0;
            break;
          default:
            $retorno = 11 - ($soma % 11);
            break;
        }
      }
      //Retorna
      return $retorno;
    }

  }
  