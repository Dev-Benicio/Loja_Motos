<div class="d-flex flex-column vh-100">
  <header class="d-flex justify-content-between align-items-center border-bottom mt-1 shadow-sm">
    <?php
    use App\Components\navbar;
    $navbar = new navbar();
    echo $navbar->render("Home");
    ?>
  </header>
  <main class="d-flex flex-column align-items-center justify-content-center h-100">
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
      <div class="d-grid gap-1">
        <h1 class="fw-semibold" style="font-size: 2.4rem;">
          Olá, Júlia!
        </h1>
        <span class="text-body-secondary fw-normal fs-3">
          Vamos começar mais um dia de vendas?
        </span>
      </div>
      <!-- Botão de atalho para a tarefa principal -->
      <a href="#" class="btn btn-dark rounded-pill mt-4 py-2 w-75 hover-outline">
        <span class="d-flex align-items-center justify-content-center">
          Começar a vender
          <div class="d-flex align-items-center">
            <i class="bi bi-arrow-right ms-2 mt-1"></i>
          </div>
        </span>
      </a>
    </div>
  </main>
  <!-- Informações para o usuário -->
  <footer>
    <!-- Meta de vendas -->
    <div></div>
  </footer>
</div>