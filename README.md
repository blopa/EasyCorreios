Correios
========

Várias Classes em PHP para diversos serviços dos Correios.

Estrutura das pastas
====================

classes: Contém as classes necessárias para as consultas.

exemplos: Contém exemplos de cada uma das consultas disponíveis.

manuais: Contém os manuais oficiais dos Correios.


Cálculo Remoto de Preço e Prazo de entrega
==========================================

O cálculo remoto de preços e prazos de encomendas dos Correios é destinado
aos clientes que possuem contrato de Sedex, e-Sedex e PAC, que necessitam
calcular, no seu website e de forma personalizada, o preço e o prazo de entrega
de uma encomenda.
 
É possível também a um cliente que não possui contrato de encomenda com os
Correios realizar o cálculo, porém, neste caso os preços apresentados serão aqueles 
praticados no balcão da agência.

Você pode baixar a especificação do webservice de preços e prazos [aqui](http://www.correios.com.br/webServices/PDF/SCPP_manual_implementacao_calculo_remoto_de_precos_e_prazos.pdf).

Os manuais de especificação serão salvos também na pasta manuais deste projeto,
afim de manter um histórico.

A versão atual destas classes está trabalhando com a versão 1.7 do webservice
dos Correios.


Rastreamento de encomendas
==========================

Para automatizar o processo de retorno de informações sobre o rastreamento de objetos, 
o cliente pode conectar-se ao servidor do Sistema de Rastreamento de Objetos – SRO e 
obter detalhes (rastros) dos objetos postados fazendo uso do padrão XML 
(eXtensible Markup Language) para intercâmbio das informações.

Cada consulta ao sistema fornece informações sobre o rastreamento de até 50 objetos 
por conexão, sem limites de conexões.

O Cliente deverá informar os números dos objetos a rastrear através de uma 
conexão HTTP (HyperText Transfer Protocol).

Você pode baixar a especificação do webservice de preços e prazos [aqui](http://blog.correios.com.br/comercioeletronico/wp-content/uploads/2011/10/Guia-Tecnico-Rastreamento-XML-Cliente-Vers%C3%A3o-e-commerce-v-1-5.pdf).

Os manuais de especificação serão salvos também na pasta manuais deste projeto,
afim de manter um histórico.

A versão atual destas classes está trabalhando com a versão 1.5 do webservice
dos Correios.

Contatos
========

Ivan Wilhelm

E-mail: ivan.whm@me.com

Twitter: @ivanwhm

