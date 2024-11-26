<div class="d-flex flex-column vh-100">
  <!-- HEADER -->
  <header class="d-flex justify-content-between align-items-center border-bottom py-2 mt-1">
    <!-- Nome do site e da página atual -->
    <div class="d-flex flex-column ps-5">
      <span class="status-text fw-light mb-0 fs-6">Dashboard</span>
      <h2 class="brand-name fw-semibold fs-5 mt-1">Thunder Gears</h2>
    </div>
    <?php

    use App\Components\navbar;

    $navbar = new navbar();
    echo $navbar->render();
    ?>
  </header>

  <!-- Bento Grid com cards de relatórios -->
  <main class="container gap-5 mt-4">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="row">
      <div class="col position-relative">
        <img
          src="./assets/images/motocross_dashboard.png"
          alt="Pessoa em uma motocicleta de motocross fazendo uma manobra no alto, depois de uma rampa"
          class="object-fit-fill w-100"
          style="min-height: 400px;">
        <!-- Top 3 funcionários -->
        <ul
          class="d-flex flex-column justify-content-center gap-3 list-group position-absolute top-0 end-0 h-100"
          style="margin-right: 2em; scale: 0.95;">
          <li class="list-group-item active bg-black border-0 text-white pt-1 pb-2 px-4 rounded-3">
            <span class="fw-medium fs-4">
              Os mais Thunders!
            </span>
            <p class="block fs-6 mb-0 text-white-50">
              Esses são os vendedores destaque do mês.
            </p>
          </li>
          <!-- Lista dos top 3 funcionários -->
          <li class="d-flex align-items-center gap-3 list-group-item border-0 rounded-3" style="padding: 0.8rem 0.75rem;">
            <!-- Avatar -->
            <div class="position-relative">
              <div
                class="d-flex align-items-center justify-content-center bg-body-secondary rounded-circle p-2"
                style="height: 50px; width: 50px;">
                <i class="bi bi-person fs-2 text-secondary"></i>
              </div>
              <div class="position-absolute top-50 start-50 ms-1 d-flex align-items-center justify-content-center">
                <i class="bi bi-award fs-3"></i>
              </div>
            </div>
            <!-- Informações do funcionário -->
            <div class="d-flex justify-content-between w-100">
              <div class="d-flex flex-column justify-content-center">
                <span class="fw-semibold" style="font-size: 1.15rem; line-height: 1.15rem;">
                  Júlia Silva
                </span>
                <p class="mb-0 text-secondary">
                  1° Lugar
                </p>
              </div>
              <div class="d-flex flex-column justify-content-center align-items-end  me-2">
                <span class="fw-semibold fs-6">
                  Vendas
                </span>
                <p class="mb-0" style="font-size: 1.05rem;">
                  R$ 1900,65
                </p>
              </div>
            </div>
          </li>
          <li class="d-flex align-items-center gap-3 list-group-item border-0 rounded-3" style="padding: 0.8rem 0.75rem;">
            <!-- Avatar -->
            <div class="position-relative">
              <div
                class="d-flex align-items-center justify-content-center bg-body-secondary rounded-circle p-2"
                style="height: 50px; width: 50px;">
                <i class="bi bi-person fs-2 text-secondary"></i>
              </div>
              <div class="position-absolute top-50 start-50 ms-1 d-flex align-items-center justify-content-center">
                <i class="bi bi-award fs-3"></i>
              </div>
            </div>
            <!-- Informações do funcionário -->
            <div class="d-flex justify-content-between w-100">
              <div class="d-flex flex-column justify-content-center">
                <span class="fw-semibold" style="font-size: 1.15rem; line-height: 1.15rem;">
                  Júlia Silva
                </span>
                <p class="mb-0 text-secondary">
                  1° Lugar
                </p>
              </div>
              <div class="d-flex flex-column justify-content-center align-items-end  me-2">
                <span class="fw-semibold fs-6">
                  Vendas
                </span>
                <p class="mb-0" style="font-size: 1.05rem;">
                  R$ 1900,65
                </p>
              </div>
            </div>
          </li>
          <li class="d-flex align-items-center gap-3 list-group-item border-0 rounded-3" style="padding: 0.8rem 0.75rem;">
            <!-- Avatar -->
            <div class="position-relative">
              <div
                class="d-flex align-items-center justify-content-center bg-body-secondary rounded-circle p-2"
                style="height: 50px; width: 50px;">
                <i class="bi bi-person fs-2 text-secondary"></i>
              </div>
              <div class="position-absolute top-50 start-50 ms-1 d-flex align-items-center justify-content-center">
                <i class="bi bi-award fs-3"></i>
              </div>
            </div>
            <!-- Informações do funcionário -->
            <div class="d-flex justify-content-between w-100">
              <div class="d-flex flex-column justify-content-center">
                <span class="fw-semibold" style="font-size: 1.15rem; line-height: 1.15rem;">
                  Júlia Silva
                </span>
                <p class="mb-0 text-secondary">
                  1° Lugar
                </p>
              </div>
              <div class="d-flex flex-column justify-content-center align-items-end  me-2">
                <span class="fw-semibold fs-6">
                  Vendas
                </span>
                <p class="mb-0" style="font-size: 1.05rem;">
                  R$ 1900,65
                </p>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <div class="row">
      <div class="col card">
        <span class="card-title d-flex justify-content-center align-items-center">Ocupação do estoque</span>
        <div class="card-body d-flex justify-content-center">
          <svg class="svg-icon h-75 w-75" viewBox="0 0 120 120">
            <defs>
              <clipPath id="half-circle">
                <rect x="0" y="0" width="120" height="60" />
              </clipPath>
            </defs>
            <circle
              cx="60"
              cy="60"
              r="50"
              stroke-width="8" />
            <circle
              cx="60"
              cy="60"
              r="50"
              stroke-width="12" />
            <style>
              svg {
                & circle {
                  fill: none;
                  stroke: black;
                  stroke-dasharray: 320;
                  stroke-dashoffset: 160px;
                  clip-path: url(#half-circle);

                  &:nth-child(2) {
                    stroke-dashoffset: 0;
                    stroke: gray;
                  }

                  &:nth-child(3) {
                    stroke-dashoffset: calc(160px * (1 - 0.75));
                    stroke: blue;
                  }
                }
              }
            </style>
          </svg>
        </div>
      </div>

      <div class="col">
        <span>Motos com maior rotatividade</span>
      </div>

      <div class="col">
        <span>Status de reposição</span>
      </div>

      <div class="col">
        <nav>
          <!-- Outros relatórios -->
        </nav>
      </div>
    </div>
  </main>
</div>