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
      $cabecalho = [
        '#',
        'Cliente',
        'Forma de pagamento',
        'Valor total',
        'Data',
        'Quantidade vendida',
        'Ações'
      ];
      $tabela = new tabela($cabecalho, $vendas);
      echo $tabela->render();
    } else {
      echo '<div class="alert alert-info">Nenhuma venda registrada</div>';
    }
    ?>
  </main>
</div> 