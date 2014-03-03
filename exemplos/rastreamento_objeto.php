<?php

  /**
   * Contém um exemplo de utilização da classe de rastreamento de objetos.
   * 
   * @author Ivan Wilhelm <ivan.whm@me.com>
   * @version 1.1
   */
  //Ajusta a codificação e o tipo do conteúdo
  header('Content-type: text/txt; charset=utf-8');

  //Importa as classes
  require '../classes/Correios.php';
  require '../classes/CorreiosRastreamento.php';
  require '../classes/CorreiosRastreamentoResultado.php';
  require '../classes/CorreiosRastreamentoResultadoOjeto.php';
  require '../classes/CorreiosRastreamentoResultadoEvento.php';
  require '../classes/CorreiosSro.php';
  require '../classes/CorreiosSroDados.php';

  try
  {
    //Cria o objeto
    $rastreamento = new CorreiosRastreamento('ECT', 'SRO');
    //Envia os parâmetros
    $rastreamento->setTipo(Correios::TIPO_RASTREAMENTO_LISTA);
    $rastreamento->setResultado(Correios::RESULTADO_RASTREAMENTO_ULTIMO);
    $rastreamento->addObjeto('SF214702548BR');
    $rastreamento->addObjeto('SF214702534BR');
    $rastreamento->addObjeto('SC463841334BR');
    if ($rastreamento->processaConsulta())
    {
      $retorno = $rastreamento->getRetorno();
      if ($retorno->getQuantidade() > 0)
      {
        echo 'Versão.................................: ' . $retorno->getVersao() . PHP_EOL;
        echo 'Quantidade.............................: ' . $retorno->getQuantidade() . PHP_EOL;
        echo 'Tipo de pesquisa.......................: ' . $retorno->getTipoPesquisa() . PHP_EOL;
        echo 'Tipo de resultado......................: ' . $retorno->getTipoResultado() . PHP_EOL . PHP_EOL;
        foreach ($retorno->getResultados() as $resultado)
        {
          echo 'Objeto.................................: ' . $resultado->getObjeto() . PHP_EOL;
          //Se desejar obter informações sobre o objeto
          $dadosObjeto = new CorreiosSroDados($resultado->getObjeto());
          echo 'Serviço................................: ' . $dadosObjeto->getDescricaoTipoServico() . PHP_EOL;
          echo PHP_EOL;
          foreach ($resultado->getEventos() as $eventos)
          {
            echo ' - Tipo................................: ' . $eventos->getTipo() . ' - ' . $eventos->getDescricaoTipo() . PHP_EOL;
            echo ' - Status..............................: ' . $eventos->getStatus() . ' - ' . $eventos->getDescricaoStatus() . PHP_EOL;
            echo ' - Data................................: ' . $eventos->getData() . ' ' . $eventos->getHora() . PHP_EOL;
            echo ' - Descrição...........................: ' . $eventos->getDescricao() . PHP_EOL;
            echo ' - Comentários.........................: ' . $eventos->getComentario() . PHP_EOL;
            echo ' - Local do evento.....................: ' . $eventos->getLocalEvento() . ' (' . $eventos->getCidadeEvento() . ', ' . $eventos->getUfEvento() . ')' . PHP_EOL;
            if ($eventos->getPossuiDestino())
            {
              echo ' - Local de destino....................: ' . $eventos->getLocalDestino() . ' (' . $eventos->getCidadeDestino() . ' - ' . $eventos->getBairroDestino() . ', ' . $eventos->getUfDestino() . ' - ' . $eventos->getCodigoDestino() . ')' . PHP_EOL;
            }
            echo PHP_EOL;
          }
        }
      }
    } else
    {
      echo 'Nenhum rastreamento encontrado.';
    }
  } catch (Exception $e)
  {
    echo 'Ocorreu um erro ao processar sua solicitação. Erro: ' . $e->getMessage() . PHP_EOL;
  }
