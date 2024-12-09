<div class="d-flex flex-column justify-content-between vh-100">
  <?php
    use App\Components\navbar;
    $navbar = new navbar();
    echo $navbar->render('Clientes');
  ?>
  <main class="d-flex align-items-center gap-3 h-100 px-5">
    <?php
      use App\Components\tabela;
      $tabela = new tabela(
        [
          '#' => '#',
          'nome' => 'Nome',
          'cpf' => 'CPF',
          'telefone' => 'Telefone',
          'email' => 'Email',
          'data_nascimento' => 'Data de Nascimento',
          'endereco' => 'Endereço',
          'editar_deletar' => 'Ações',
        ],
        $clientes
      );
      echo $tabela->render();
    ?>
  </main>
</div>