<?php

  /**
   * Contém um exemplo de utilização da classe de Cálculo Remoto de Preços e Prazos
   * dos Correios.
   * 
   * @author Ivan Wilhelm <ivan.whm@me.com>
   * @version 1.0 
   */
  //Ajusta a codificação e o tipo do conteúdo
  header('Content-type: text/txt; charset=utf-8');

  //Importa as classes
  require '../classes/Correios.php';
  require '../classes/CorreiosPrecoPrazo.php';
  require '../classes/CorreiosPrecoPrazoResultado.php';

  try
  {
    //Cria o objeto
    $calculo = new CorreiosPrecoPrazo();
    //Envia os parâmetros
    $calculo->setCepOrigem('89050100');
    $calculo->setCepDestino('89130000');
    $calculo->addServico(Correios::SERVICO_SEDEX_SEM_CONTRATO);
    $calculo->addServico(Correios::SERVICO_PAC_SEM_CONTRATO);
    $calculo->addServico(Correios::SERVICO_SEDEX_10_SEM_CONTRATO);
    $calculo->addServico(Correios::SERVICO_ESEDEX_COM_CONTRATO);
    $calculo->setFormato(Correios::FORMATO_CAIXA_PACOTE);
    $calculo->setPeso(29.56);
    $calculo->setValorDeclarado(9637.89);
    $calculo->hasMaoPropria(FALSE);
    $calculo->hasAvisoRecebimento(TRUE);
    $calculo->setAltura(2.0);
    $calculo->setLargura(11.0);
    $calculo->setComprimento(16.0);
    //Verifica processamento
    if ($calculo->processaConsulta())
    {
      //Itera no retorno
      foreach ($calculo->getRetorno() as $retorno)
      {
        //Se não teve erro
        if ($retorno->getErro() === 0)
        {
          //Imprime o resultado
          $entregaDomiciliar = $retorno->getEntregaDomiciliar() ? 'Sim' : 'Não';
          $entregaSabado = $retorno->getEntregaSabado() ? 'Sim' : 'Não';
          echo 'Serviço................................: ' . $retorno->getCodigo() . PHP_EOL;
          echo 'Valor..................................: R$ ' . number_format($retorno->getValor(), 2, ',', '.') . PHP_EOL;
          echo 'Prazo de entrega.......................: ' . $retorno->getPrazoEntrega() . PHP_EOL;
          echo 'Entrega domiciliar.....................: ' . $entregaDomiciliar . PHP_EOL;
          echo 'Entrega sábado.........................: ' . $entregaSabado . PHP_EOL;
          echo 'Valor do serviço mão própria...........: R$ ' . number_format($retorno->getValorMaoPropria(), 2, ',', '.') . PHP_EOL;
          echo 'Valor do serviço aviso de recebimento..: R$ ' . number_format($retorno->getValorAvisoRecebimento(), 2, ',', '.') . PHP_EOL;
          echo 'Valor do serviço valor declarado.......: R$ ' . number_format($retorno->getValorValorDeclarado(), 2, ',', '.') . PHP_EOL . PHP_EOL;
        } else
        {
          echo 'Ocorreu um erro no cálculo do serviço ' . $retorno->getCodigo() . ': ' . $retorno->getMensagemErro() . PHP_EOL . PHP_EOL;
        }
      }
    } else
    {
      echo 'Ocorreu um erro, tente novamente mais tarde.' . PHP_EOL;
    }
  } catch (Exception $e)
  {
    echo 'Ocorreu um erro ao processar sua solicitação. Erro: ' . $e->getMessage() . PHP_EOL;
  }
