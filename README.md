# MyErp
It was a college job for the web development class. The ideia was create a project of erp, this is a prototype of erp
Faculdade Metropolitanas Unidas
Tecnologia da informação
Sistemas de informação
Henrique Araujo / RA: 2028401
Gabriel Silva de Jesus / RA: 2276350
Leonardo Jordão Soares / RA: 2215309
Rafael Vieira Lorente / RA: 2485507

MyERP
Documentação do Softaware
Volume I
São Paulo
2020
Resumo
Documentar nosso software para entendimento de como funciona nossa ferra-
menta para nosso cliente.
Palavras-chave: Abstract. Resumo. Software.

Sumário
1 Proposta
1.1 Tela de Login
1.2 Menu
2 Produtos
2.1 Cadastro de Produto
2.2 Editar Produtos
3 Clientes
3.1 Editar Clientes
3.2 Cadastro de Cliente
4 Pedidos
4.1 Cadastro de Pedido
4.2 Editar Pedido
5 Ferramentas usadas
5.1 MySQL
5.2 PHP
5.3 CSS e Bootstrap
3
1 Proposta
A Nossa ferramenta se dedica a facilitar a vida do nosso cliente, auxiliando eles
a controlar a seu estoque e seus produtos seja ele sendo uma garrafa de agua ate um
armario por exemplo.
1.1 Tela de Login
Todos funcionario teram seu login e senha para que tenha acesso a ferramenta
e assim ter acesso a seu estoque e controle dele.
Figura 1 – Login
Todos os colaboradores que usarem a ferramenta tera login gravados no banco
de dados para que seja feito o registro dos mesmo. Caso usuario nao tenha sido
registrado no banco ele nao ira conseguir ter acesso a ferramenta.
1.2 Menu
O Menu sera onde você tera as opção que os colaboradores iram utilizar,
como “Pedido”, “Cilentes” e “Podutos”. Caso o colaborador queira sair do seu lo-
gin no canto superior direito tera botão “sair” onde ao clicar o mesmo sera direcionada
pra a tela de login novamente.
Capítulo 1. Proposta 4
(^)
Figura 2 – Menu inicial

5
2 Produtos
Na parte de produtos podera vizualizar e editar com produtos cadastrados, como
quantidades daquele produtos que estão no seu estoque, lista inteira de todos os seus
produtos e ate seu SKU (“Stock Keeping Unit”) que seria indentificação unica do seu
produto.

Figura 3 – Produtos
Aqui alem de vizualizar todo seu produto voce tambem podera editar, ou seja,
podera colocar quantos produtos que voce quiser, assim como remove-los.

2.1 Cadastro de Produto
Figura 4 – Cadastro de Produto
Capítulo 2. Produtos 6
Aqui podera relalizar o cadastro de novos produtos que chegar em sua loja, com
nome, valor, descrição, quantidade e seu Sku.
2.2 Editar Produtos
Figura 5 – Editar Produtos
Nesta tela podera editar todo sua lista de produto, mudar seu valor e quantos
tem no seu estoque. Aqui tambem pode remover os produtos se caso nao ter mais ele
em estoque ou nao receber mais.
7
3 Clientes
Na parte de clientes podera vizualizar de uma completa e simples os nomes
dos seus fornecedores, cada um contendo seu CNPJ (Cadastro Nacional da Pessoa
Jurídica) e Nome.

Figura 6 – Clientes
Aqui tera liberdade de remover ou adicionar seus fornecedores de acordo com
sua preferencia. Telas abaixo de “editar clientes” e “cadastrar cliente”.

3.1 Editar Clientes
Figura 7 – Editar clientes
Nesta tela é bem simples, aqui onde voce ira realizar a “edição” dos seus clientes,
pode removelos se caso nao houver mais ligada a empresa.

Capítulo 3. Clientes 8
3.2 Cadastro de Cliente
Figura 8 – Cadastro de cliente
Aqui onde ira realizar o cadastro de novos clientes pelo seu nome e numero de
documento que recomendamos que seja um numero unico para facilitar a procura dele
posteriormente.
4 Pedidos
Nessa area tera a vizualização direta a seus pedidos feitos ao fornecedor.
Contendo as informaçoes importantes para controle. Contendo as informaçoes de
SKU, valores, quantidades e o total.

Pedidos
Cada um dos seus pedidos tera um numero unico para facilitar o controle e a busca do
mesmo. Esses numero unicos de cada produto fica na coluna de "Numero de Pedidos".

4.1 Cadastro de Pedido
Cadastro de pedido
Aqui como as telas anteriores de cadastro, voce podera cadastrar novos pedidos
como, numero de pedido, sua quantidade e seu preço unitaria e etc.

4.2 Editar Pedido
Editar pedido
Nesta tela voce tera como editar todos os seus pedidos e tambem remove-los se caso
nao querer mais o produto que mencionou antes.

5 Ferramentas usadas
5.1 MySQL
Com as informações dadas pelo nosso cliente, usamos o banco de dados MySQL para
cadastrar os login de todos os colaboradores e regras de uso.

[Disponibilizados a estrutura do banco de dados que usamos em arquivo separados.

5.2 PHP
Todas regras de Acesso, edição e adição de produtos foram desenvolvidos em cima da
linguagem PHP.

[Disponibilizados a estrutura do banco de dados que usamos em arquivo separados].

5.3 CSS e Bootstrap
Todo o Design das telas foram feitas em css e a framework Bootstrap.

[Disponibilizados a estrutura do banco de dados que usamos em arquivo separados.

Leitura completa em Documentacao_final.pdf
