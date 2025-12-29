@section('content')
  @extends('layouts.app-client')
  @include('wpbox::meta.script')
  <div class="card mb-6">
    <div class="card-body pt-9 pb-0">
      <!--begin::Details-->
      <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
        <div class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
          <img class="mw-50px mw-lg-75px" src="{{ asset('custom/imgs/' . $socialMedia . '.svg') }}" alt="image">
        </div>
        <div class="flex-grow-1">
          <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
            <div class="flex-1 d-flex flex-column">
              <!--begin::Status-->
              <div class="d-flex align-items-center mb-1">
                <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">
                  {{ ucfirst($socialMedia) }}
                </a>
                <span id="badge"></span>
              </div>

              <div class="d-flex flex-wrap fw-semibold mb-2 fs-5 text-gray-500">
                Envía campañas de marketing, recibe y responde fácilmente mensajes de {{ ucfirst($socialMedia) }}<br />
                desde tu bandeja de entrada.
              </div>
              <div class="d-flex flex-row justify-content-start align-items-center">
                <span class="me-4">
                  <span class="me-2">
                    <img class="theme-dark-show" height="15" src='{{ asset('custom/imgs/icono-dark.png') }}'
                      alt="icono dotflo" />
                    <img class="theme-light-show" height="15" src='{{ asset('custom/imgs/icono-light.png') }}'
                      alt="icono dotflo" />
                  </span>
                  Construido por Anantkamal Wademo.
                </span>
                {{-- <span class="d-flex align-items-center">
                  <span class="me-2"><i class="ki-duotone ki-information text-warning fs-1 mt-2">
                      <span class="path1"></span>
                      <span class="path2"></span>
                      <span class="path3"></span>
                    </i>
                  </span>
                  Integración obligatoria.
                </span> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="separator"></div>
      <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
        <li class="nav-item">
          <a class="nav-link text-active-primary py-5 me-6 active"
            href="{{ route('meta.setup', ['socialMedia' => $socialMedia]) }}">
            Overview </a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link text-active-primary py-5 me-6">
            Conectar
            <span class="badge badge-light-info ms-4">Beta</span>
          </a>
        </li> --}}
      </ul>
    </div>
  </div>

  <div class="row p-0 gap-6 gap-xxl-2">
    <div class="col-xxl-8">
      <div class="card mb-5 mb-xl-0 p-8">
        <div class="card-body p-0">
          <div>
            <p class="fs-6 fw-semibold text-gray-600" style="text-align: justify;"'>
              Envía mensajes privados de {{ $socialMedia }} a tu bandeja de entrada de Anantkamal Wademo, manteniendo todas
              las comunicaciones de tus clientes en un solo lugar, para brindarles la comodidad que desean
              sin
              sacrificar la eficiencia de los compañeros de equipo ni las capacidades de generación de
              informes.
              <br />
              {{-- <span style="display: block; margin-top: 10px;"></span>
              <span class="ms-4">
                <i class="ki-duotone ki-check-circle text-dark">
                  <span class="path1"></span>
                  <span class="path2"></span>
                </i>
                Los clientes pueden iniciar conversaciones fácilmente usando tu número
                de teléfono
                designado.</span>
              <br /> --}}
              <span class="ms-4">
                <i class="ki-duotone ki-check-circle text-dark">
                  <span class="path1"></span>
                  <span class="path2"></span>
                </i>
                Los compañeros de equipo pueden administrar de manera eficiente las
                conversaciones de {{ ucfirst($socialMedia) }} directamente desde Whatbox, con las mismas herramientas y
                procesos con los que ya están familiarizados.</span>
              <br />
              <span class="ms-4">
                <i class="ki-duotone ki-check-circle text-dark">
                  <span class="path1"></span>
                  <span class="path2"></span>
                </i>
                Cuando los clientes reciben las campañas o los
                bots concluyen, pueden interacturar
                directamente con los agentes en Anantkamal Wademo.
              </span>
              {{-- <br />
              <span class="ms-4">
                <i class="ki-duotone ki-check-circle text-dark">
                  <span class="path1"></span>
                  <span class="path2"></span>
                </i>
                {{$socialMedia}} está incluido en informes personalizados y exportaciones de campañas, por lo
                que
                puedes evaluar cada interacción de soporte a lo largo de la conversación y exportar los
                resultados a CSV.
              </span> --}}
              <span style="display: block; margin-top: 20px;"></span>
            </p>

            {{-- <div class="bg-white theme-dark-show rounded mb-8 p-8"><img class="w-100"
                src="{{ asset('custom/imgs/whatsapp/IMAGEN 1 Dotflo-01.png') }}" alt='Imagen dotflo' />
            </div>
            <div class="bg-white theme-dark-show rounded mb-8 p-8">
              <img class="w-100" src="{{ asset('custom/imgs/whatsapp/IMAGEN 2 Dotflo-01.png') }}"
                alt='Imagen dotflo' />
            </div>
            <div class="bg-white theme-dark-show rounded p-8">
              <img class="w-100" src="{{ asset('custom/imgs/whatsapp/IMAGEN 3 Dotflo-01.png') }}"
                alt='Imagen dotflo' />
            </div>

            <img class="w-100 theme-light-show" src="{{ asset('custom/imgs/whatsapp/IMAGEN 1 Dotflo-01.png') }}"
              alt='Imagen dotflo' />
            <img class="w-100 theme-light-show" src="{{ asset('custom/imgs/whatsapp/IMAGEN 2 Dotflo-01.png') }}"
              alt='Imagen dotflo' />
            <img class="w-100 theme-light-show" src="{{ asset('custom/imgs/whatsapp/IMAGEN 3 Dotflo-01.png') }}"
              alt='Imagen dotflo' /> --}}
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card card-xxl-stretch-50  mb-xl-10 p-8 h-100 pb--8">
        <div class="card-body p-0 gap-3 d-flex flex-column">
          <div id="alert-div"></div>

          <p class="lead" id="loginMessage"></p>

          <button onclick="checkLoginState()" type="button" class="btn btn-info w-100">
            @if ($socialMedia == 'instagram')
              <svg x="0px" y="0px" width="24" height="24" viewBox="0 0 50 50">
                <path fill="#ffffff"
                  d="M 16 3 C 8.8324839 3 3 8.8324839 3 16 L 3 34 C 3 41.167516 8.8324839 47 16 47 L 34 47 C 41.167516 47 47 41.167516 47 34 L 47 16 C 47 8.8324839 41.167516 3 34 3 L 16 3 z M 16 5 L 34 5 C 40.086484 5 45 9.9135161 45 16 L 45 34 C 45 40.086484 40.086484 45 34 45 L 16 45 C 9.9135161 45 5 40.086484 5 34 L 5 16 C 5 9.9135161 9.9135161 5 16 5 z M 37 11 A 2 2 0 0 0 35 13 A 2 2 0 0 0 37 15 A 2 2 0 0 0 39 13 A 2 2 0 0 0 37 11 z M 25 14 C 18.936712 14 14 18.936712 14 25 C 14 31.063288 18.936712 36 25 36 C 31.063288 36 36 31.063288 36 25 C 36 18.936712 31.063288 14 25 14 z M 25 16 C 29.982407 16 34 20.017593 34 25 C 34 29.982407 29.982407 34 25 34 C 20.017593 34 16 29.982407 16 25 C 16 20.017593 20.017593 16 25 16 z">
                </path>
              </svg>
            @else
              <svg width="24" height="24" x="0px" y="0px" viewBox="0 0 50 50">
                <path fill="#ffffff"
                  d="M 25 3 C 12.861562 3 3 12.861562 3 25 C 3 36.019135 11.127533 45.138355 21.712891 46.728516 L 22.861328 46.902344 L 22.861328 29.566406 L 17.664062 29.566406 L 17.664062 26.046875 L 22.861328 26.046875 L 22.861328 21.373047 C 22.861328 18.494965 23.551973 16.599417 24.695312 15.410156 C 25.838652 14.220896 27.528004 13.621094 29.878906 13.621094 C 31.758714 13.621094 32.490022 13.734993 33.185547 13.820312 L 33.185547 16.701172 L 30.738281 16.701172 C 29.349697 16.701172 28.210449 17.475903 27.619141 18.507812 C 27.027832 19.539724 26.84375 20.771816 26.84375 22.027344 L 26.84375 26.044922 L 32.966797 26.044922 L 32.421875 29.564453 L 26.84375 29.564453 L 26.84375 46.929688 L 27.978516 46.775391 C 38.71434 45.319366 47 36.126845 47 25 C 47 12.861562 37.138438 3 25 3 z M 25 5 C 36.057562 5 45 13.942438 45 25 C 45 34.729791 38.035799 42.731796 28.84375 44.533203 L 28.84375 31.564453 L 34.136719 31.564453 L 35.298828 24.044922 L 28.84375 24.044922 L 28.84375 22.027344 C 28.84375 20.989871 29.033574 20.060293 29.353516 19.501953 C 29.673457 18.943614 29.981865 18.701172 30.738281 18.701172 L 35.185547 18.701172 L 35.185547 12.009766 L 34.318359 11.892578 C 33.718567 11.811418 32.349197 11.621094 29.878906 11.621094 C 27.175808 11.621094 24.855567 12.357448 23.253906 14.023438 C 21.652246 15.689426 20.861328 18.170128 20.861328 21.373047 L 20.861328 24.046875 L 15.664062 24.046875 L 15.664062 31.566406 L 20.861328 31.566406 L 20.861328 44.470703 C 11.816995 42.554813 5 34.624447 5 25 C 5 13.942438 13.942438 5 25 5 z">
                </path>
              </svg>
            @endif
            Iniciar sesión con {{ ucfirst($socialMedia) }}
          </button>
          <button type="button" class="btn btn-info w-100" onclick="logout()">Log out</button>
        </div>
      </div>
    </div>
  </div>
  {{-- <div class="btn btn-info container" onclick="openModal()">Launch modal</div> --}}
  <div class="modal fade" id="metaModal" tabindex="-1" aria-labelledby="metaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title w-100 text-center" id="metaModalLabel">Select a page</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
            onclick="closeModal()"></button>
        </div>
        <div class="modal-body" id="pageList">
        </div>
      </div>
    </div>
  </div>
@endsection
