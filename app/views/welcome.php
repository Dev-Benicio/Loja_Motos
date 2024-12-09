<div class="d-flex flex-column vh-100">
  <?php
  use App\Components\navbar;
  $navbar = new navbar();
  echo $navbar->render("Bem-vindo");
  ?>
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
          Olá, <?= $nome_usuario ?>!
        </h1>
        <span class="text-body-secondary fw-normal fs-3">
          <?= $texto_boas_vindas ?>
        </span>
      </div>
      <!-- Botão de atalho para a tarefa principal -->
      <a href="<?= $link_botao ?>" class="btn btn-dark rounded-pill mt-4 py-2 w-75 hover-outline">
        <span class="d-flex align-items-center justify-content-center">
          <?= $texto_botao ?>
          <div class="d-flex align-items-center">
            <i class="bi bi-arrow-right ms-2 mt-1"></i>
          </div>
        </span>
      </a>
    </div>
  </main>
</div>