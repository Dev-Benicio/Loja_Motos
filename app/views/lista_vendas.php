<div class="d-flex flex-column vh-100">
  <?php
  use App\Components\navbar;
  use App\Components\tabela;
  $navbar = new navbar();
  echo $navbar->render("Vendas");
  ?>
  <main class="container d-flex flex-column gap-4 mt-5 pb-4">
    <div class="d-flex justify-content-between align-items-end">
      <div>
        <h1>Vendas realizadas</h1>
        <span>Aqui você pode ver todas as vendas realizadas na loja</span>
      </div>
      <div class="d-flex gap-2 btn-group">
        <a href="./vendas/cadastro" 
           class="btn btn-dark rounded-5 px-3 py-0 d-flex align-items-center gap-1">
          <div class="d-grid place-items-center">
            <i class="bi bi-plus fs-4 m-0"></i>
          </div>
          Nova venda
        </a>
      </div>
    </div>
    <?php
    if (!empty($vendas)) {
      $cabecalho = ['Cliente', 'Quantidade', 'Valor total', 'Data', 'Comissão', 'Ações'];
      $linhas = array_map(function($venda) {
        return [
          $venda['nome_cliente'],
          $venda['quantidade_vendida'],
          $venda['valor_total'],
          $venda['data_venda'],
          $venda['comissao'],
          "<div class='d-flex justify-content-center gap-2'>
            <a href='./vendas/edicao/{$venda['id_venda']}' 
               class='btn btn-light rounded-circle' 
               title='Editar venda'>
              <i class='bi bi-pencil'></i>
            </a>
            <a href='./vendas/exclusao/{$venda['id_venda']}' 
               class='btn btn-dark rounded-circle' 
               title='Excluir venda'>
              <i class='bi bi-trash'></i>
            </a>
          </div>"
        ];
      }, $vendas);

      $tabela = new tabela($cabecalho, $linhas);
      echo $tabela->render();
    } else {
      echo '<div class="alert alert-info">Nenhuma venda registrada</div>';
    }
    ?>
  </main>
</div> 