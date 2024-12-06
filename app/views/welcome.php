<div class="d-flex flex-column vh-100">
  <header class="d-flex justify-content-between align-items-center border-bottom mt-1 shadow-sm">
    <?php
    use App\Components\navbar;
    $navbar = new navbar();
    echo $navbar->render("Bem-vindo");
    ?>
  </header>
  <main class="m-auto">
    <div class="text-center">
      <!-- Logo -->
      <div
        class="d-inline-block bg-body-tertiary rounded-circle border border-5 border-body-secondary mb-3 px-2"
        style="scale: 0.9;">
        <i
          class="bi bi-gear fs-2 text-body"
          style="-webkit-text-stroke: 0.5px;">
        </i>
      </div>
      <!-- Mensagem de boas vindas -->
      <div class="d-grid gap-3 mb-1">
        <h1 class="fw-semibold" style="font-size: 2.4rem;">
          Olá, <?= App\Helpers\sessao::get_sessao('usuario')['nome'] ?>!
        </h1>
        <span class="text-body-secondary fw-normal fs-3">
          <?php
          $_btn_link;
          switch (App\Helpers\sessao::get_sessao('usuario')['cargo']) {
            case 'vendedor':
              echo "Vamos começar mais um dia de vendas?";
              $_btn_link = "./vendas";
              break;
            case 'estoquista':
              echo "Deseja ver como anda o seu estoque?";
              $_btn_link = "./estoque";
              break;
            case 'admin':
              echo "Aoba chefe, quer ver como anda os négocios?";
              $_btn_link = "./dashboard";
              break;
            default:
              echo "Ué, quem é tu? Cargo desconhecido.";
              $_btn_link = "./logout";
          }
          ?>
        </span>
      </div>
      <!-- Botão de atalho para a tarefa principal -->
      <a href="<?= $_btn_link ?>" class="btn btn-dark rounded-pill mt-4 py-2 w-75 hover-outline">
        <span class="d-flex align-items-center justify-content-center">
          <?php
          switch (App\Helpers\sessao::get_sessao('usuario')['cargo']) {
            case 'vendedor':
              echo "Começar a vender";
              break;
            case 'estoquista':
              echo "Ver estoque";
              break;
            case 'admin':
              echo "Ver relatórios";
              break;
            default:
              echo "Bora sair daqui, bora...";
          }
          ?>
          <div class="d-flex align-items-center">
            <i class="bi bi-arrow-right ms-2 mt-1"></i>
          </div>
        </span>
      </a>
    </div>
  </main>
</div>