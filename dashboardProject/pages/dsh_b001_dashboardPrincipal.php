<main class="main-content position-relative border-radius-lg ">
  <!-- Navbar -->
  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
    data-scroll="false">
    <div class="container-fluid py-1 px-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
          <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Dashboard</a></li>
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Principal</li>
        </ol>
      </nav>
    </div>
  </nav>
  <!-- End Navbar -->
  <div class="container-fluid py-4">
    <div class="row">
      <!-- <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Vencido</p>
                  <h5 id="cardTotalVencido" class="font-weight-bolder" data-valor="0,00">
                    R$: 
                  </h5>
                  
                  <p class="mb-0">
                    
                  </p>

                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                  
                  <i class="fa-regular fa-calendar-xmark text-lg opacity-10"></i>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">

                  <p class="text-sm mb-0 text-uppercase font-weight-bold">Total a Vencer</p>
                  <h5 id="cardTotalAVencer" class="font-weight-bolder" data-valor="0,00">
                    R$:
                  </h5>

                  <p class="mb-0">
                    
                  </p>
                </div>

              </div>
              <div class="col-4 text-end">

                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                  
                  <i class="fa-regular fa-credit-card text-lg opacity-10"></i>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">

        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-uppercase font-weight-bold">Quantidade de Clientes</p>
                  <h5 id="cardQuantidadeClientes" class="font-weight-bolder" data-quantidade="0">
                    
                  </h5>
                  <p class="mb-0">
                    
                  </p>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                  <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
      <div class="col-xl-3 col-sm-6">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-uppercase font-weight-bold">Produto mais vendido</p>
                  <h5 id='cardProdutoMaisVendido' class="font-weight-bolder" data-produto="">
                    
                  </h5>
                  <p class="mb-0">
                    
                  </p>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                  <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
    </div>
    <div class="row mt-4">
      <div class="col-lg-4 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">

          <div class="card-header pb-0 pt-3 bg-transparent">
            <h6 class="text-capitalize">Banco Brasil</h6>
            
          </div>
          <div class="card-body p-3" style="height: 300px;overflow-x: hidden;">
              
              
              <div class="dx-viewport demo-container">
                <div id="containerBuscaSaldo"></div> <!-- TABELA -->
              </div>

          </div>
        </div>

      </div>

      <div class="col-lg-8">

        <div class="card h-100 p-0 overflow-hidden">
            <div class="card-header pb-0 p-3">

              <div class="d-flex justify-content-between">
                <h6 class="mb-2">Carteira (VP) por Produto</h6>
                <h8 class="mb-2">Em milhões de reais</h8>
              </div>

            </div>
            
            <div class="card-body p-3">

              <div class="demo-container">
                <div id="carteiraVPPorProduto"></div>
              </div>

            </div>

        </div>
      </div>

      

    </div>

    <div class="row mt-4">
      <div class="col-lg-4 mb-lg-0 mb-4">
        <div class="card ">
          <div class="card-header pb-0 p-3">

            <div class="d-flex justify-content-between">
              <h6 class="mb-2">Carteira a Vencer</h6>
            </div>

          </div>
          
          <div class="card-body p-3" style="height: 300px;overflow-x: hidden;">
            <div class="dx-viewport demo-container">
              <div id="containerCarteiraAVencer"></div>
            </div>
          </div>

        </div>
      </div>
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header pb-0 p-3">
            <h6 class="mb-0">Carteira a vencer (Anual)</h6>
          </div>

          <div class="card-body p-3" style="height: 300px;overflow-x: hidden;">
              <div class="dx-viewport demo-container">
                <div id="containerCarteiraAVencerAgrupadaAnual"></div>
              </div>
          </div>

        </div>
      </div>

    </div>

    <footer class="footer pt-3  ">
      <div class="container-fluid">

        <!-- <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="copyright text-center text-sm text-muted text-lg-start">
              ©
              <script>
                document.write(new Date().getFullYear())
              </script>,
              made with <i class="fa fa-heart"></i> by
              <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
              for a better web.
            </div>
          </div>
          <div class="col-lg-6">
            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
              <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About
                  Us</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted"
                  target="_blank">License</a>
              </li>
            </ul>
          </div>
        </div> -->

      </div>
    </footer>
  </div>
</main>


<script src="./assets/js/dsh_b001_dashboardPrincipal.js?_<?=filemtime('./assets/js/dsh_b001_dashboardPrincipal.js');?>"></script>
<link rel='stylesheet' href="./assets/css/dsh_b001_dashboardPrincipal.css?_<?=filemtime('./assets/css/dsh_b001_dashboardPrincipal.css');?>"></s>