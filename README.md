EasyCorreios
========

Módulo para Magento que popula o banco de dados com histórico do rastreamento de um envio dos correios. Depois esse histórico pode ser acessado pelo cliente pela página sualoja.com.br/rastrear

Módulo está em constante desenvolvimento e está atualmente em ALPHA e não tem garantia nenhum, usa por sua conta e risco.

====================

Atualmente ele faz o seguinte:

- Popula o banco de dados com histórico do rastreamento do pedido (correios apenas)
- Atualiza o pedido para "completo" quando o pedido for entregue
- Cronjob é executado 1x por dia, pode ser mudado no arquivo app/code/local/EasyCorreios/app/code/local/Werules/Easycorreios/etc/config.xml
- Cria a pagina sualoja.com.br/rastrear onde o cliente digita o número do pedido e ele consulta o histórico de rastreamento no banco de dados


Alguns detalhes:

No arquivo app/code/local/Werules/Easycorreios/Model/Observer.php linha 20 eu uso uma condição com um pedido custom que eu criei no meu sistema, chamado "shipped", nele eu verifico se o pedido ja foi enviado.
Caso o banco do módulo não seja instalado automaticamente, crie as tabelas como está no arquivo app/code/local/Werules/Easycorreios/sql/easycorreios_setup/mysql4-install-0.0.1.php

==========================================