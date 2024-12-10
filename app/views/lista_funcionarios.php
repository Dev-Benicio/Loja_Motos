<div class="d-flex flex-column vh-100">
  <?php
  use App\Components\navbar;
  $navbar = new navbar();
  echo $navbar->render('Funcionários');
  ?>
  <main class="d-flex flex-column align-items-center gap-4 h-100 px-5 mt-5">
    <div class="d-flex justify-content-between align-items-end w-100">
      <div>
        <h3>Lista de funcionários</h3>
        <span>
          Aqui você pode acompanhar todos os funcionários que foram cadastrados
        </span>
      </div>
      <a
        href="./cadastro"
        class="btn btn-dark rounded-5 px-3 py-0 d-flex align-items-center gap-1">
        <div class="d-grid place-items-center">
          <i class="bi bi-plus fs-4 m-0"></i>
        </div>
        Cadastrar funcionário
      </a>
    </div>
    <?php
    use App\Components\tabela;
    $tabela = new tabela(
      [
        '#',
        'Nome',
        'CPF', 
        'Email',
        'Telefone',
        'Cargo',
        'Admissão',
        'Status',
        'Endereço',
        'Ações',
      ],
      $funcionarios
    );
    echo $tabela->render();
    ?>
  </main>
</div>