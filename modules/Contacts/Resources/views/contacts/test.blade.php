@extends('client.app')

@section('content')
    <div class="row g-5 g-xl-10">
        <!--begin::Col-->
        <div class="col-xl-4">

            <!--begin::List widget 21-->
            <div class="card card-flush h-xl-100">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-900">Active Lessons</span>

                        <span class="text-muted mt-1 fw-semibold fs-7">Avg. 72% completed lessons</span>
                    </h3>

                    <!--begin::Toolbar-->
                    <div class="card-toolbar">
                        <a href="#" class="btn btn-sm btn-light">All Lessons</a>
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body pt-5">

                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center me-3">
                            <!--begin::Logo-->
                            <img src="/metronic8/demo38/assets/media/svg/brand-logos/laravel-2.svg" class="me-4 w-30px"
                                alt="">
                            <!--end::Logo-->

                            <!--begin::Section-->
                            <div class="flex-grow-1">
                                <!--begin::Text-->
                                <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Laravel</a>
                                <!--end::Text-->

                                <!--begin::Description-->
                                <span class="text-gray-500 fw-semibold d-block fs-6">PHP Framework</span>
                                <!--end::Description--->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Statistics-->
                        <div class="d-flex align-items-center w-100 mw-125px">
                            <!--begin::Progress-->
                            <div class="progress h-6px w-100 me-2 bg-light-success">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 65%"
                                    aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <!--end::Progress-->

                            <!--begin::Value-->
                            <span class="text-gray-500 fw-semibold">
                                65%
                            </span>
                            <!--end::Value-->
                        </div>
                        <!--end::Statistics-->
                    </div>
                    <!--end::Item-->

                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->


                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center me-3">
                            <!--begin::Logo-->
                            <img src="/metronic8/demo38/assets/media/svg/brand-logos/vue-9.svg" class="me-4 w-30px"
                                alt="">
                            <!--end::Logo-->

                            <!--begin::Section-->
                            <div class="flex-grow-1">
                                <!--begin::Text-->
                                <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Vue 3</a>
                                <!--end::Text-->

                                <!--begin::Description-->
                                <span class="text-gray-500 fw-semibold d-block fs-6">JS Framework</span>
                                <!--end::Description--->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Statistics-->
                        <div class="d-flex align-items-center w-100 mw-125px">
                            <!--begin::Progress-->
                            <div class="progress h-6px w-100 me-2 bg-light-warning">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 87%"
                                    aria-valuenow="87" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <!--end::Progress-->

                            <!--begin::Value-->
                            <span class="text-gray-500 fw-semibold">
                                87%
                            </span>
                            <!--end::Value-->
                        </div>
                        <!--end::Statistics-->
                    </div>
                    <!--end::Item-->

                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->


                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center me-3">
                            <!--begin::Logo-->
                            <img src="/metronic8/demo38/assets/media/svg/brand-logos/bootstrap5.svg" class="me-4 w-30px"
                                alt="">
                            <!--end::Logo-->

                            <!--begin::Section-->
                            <div class="flex-grow-1">
                                <!--begin::Text-->
                                <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Bootstrap
                                    5</a>
                                <!--end::Text-->

                                <!--begin::Description-->
                                <span class="text-gray-500 fw-semibold d-block fs-6">CSS Framework</span>
                                <!--end::Description--->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Statistics-->
                        <div class="d-flex align-items-center w-100 mw-125px">
                            <!--begin::Progress-->
                            <div class="progress h-6px w-100 me-2 bg-light-primary">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 44%"
                                    aria-valuenow="44" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <!--end::Progress-->

                            <!--begin::Value-->
                            <span class="text-gray-500 fw-semibold">
                                44%
                            </span>
                            <!--end::Value-->
                        </div>
                        <!--end::Statistics-->
                    </div>
                    <!--end::Item-->

                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->


                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center me-3">
                            <!--begin::Logo-->
                            <img src="/metronic8/demo38/assets/media/svg/brand-logos/angular-icon.svg" class="me-4 w-30px"
                                alt="">
                            <!--end::Logo-->

                            <!--begin::Section-->
                            <div class="flex-grow-1">
                                <!--begin::Text-->
                                <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Angular
                                    16</a>
                                <!--end::Text-->

                                <!--begin::Description-->
                                <span class="text-gray-500 fw-semibold d-block fs-6">JS Framework</span>
                                <!--end::Description--->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Statistics-->
                        <div class="d-flex align-items-center w-100 mw-125px">
                            <!--begin::Progress-->
                            <div class="progress h-6px w-100 me-2 bg-light-info">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 70%" aria-valuenow="70"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <!--end::Progress-->

                            <!--begin::Value-->
                            <span class="text-gray-500 fw-semibold">
                                70%
                            </span>
                            <!--end::Value-->
                        </div>
                        <!--end::Statistics-->
                    </div>
                    <!--end::Item-->

                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->


                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center me-3">
                            <!--begin::Logo-->
                            <img src="/metronic8/demo38/assets/media/svg/brand-logos/spring-3.svg" class="me-4 w-30px"
                                alt="">
                            <!--end::Logo-->

                            <!--begin::Section-->
                            <div class="flex-grow-1">
                                <!--begin::Text-->
                                <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Spring</a>
                                <!--end::Text-->

                                <!--begin::Description-->
                                <span class="text-gray-500 fw-semibold d-block fs-6">Java Framework</span>
                                <!--end::Description--->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Statistics-->
                        <div class="d-flex align-items-center w-100 mw-125px">
                            <!--begin::Progress-->
                            <div class="progress h-6px w-100 me-2 bg-light-danger">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 56%"
                                    aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <!--end::Progress-->

                            <!--begin::Value-->
                            <span class="text-gray-500 fw-semibold">
                                56%
                            </span>
                            <!--end::Value-->
                        </div>
                        <!--end::Statistics-->
                    </div>
                    <!--end::Item-->

                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->


                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center me-3">
                            <!--begin::Logo-->
                            <img src="/metronic8/demo38/assets/media/svg/brand-logos/typescript-1.svg" class="me-4 w-30px"
                                alt="">
                            <!--end::Logo-->

                            <!--begin::Section-->
                            <div class="flex-grow-1">
                                <!--begin::Text-->
                                <a href="#"
                                    class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">TypeScript</a>
                                <!--end::Text-->

                                <!--begin::Description-->
                                <span class="text-gray-500 fw-semibold d-block fs-6">Better Tooling</span>
                                <!--end::Description--->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Statistics-->
                        <div class="d-flex align-items-center w-100 mw-125px">
                            <!--begin::Progress-->
                            <div class="progress h-6px w-100 me-2 bg-light-success">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 82%"
                                    aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <!--end::Progress-->

                            <!--begin::Value-->
                            <span class="text-gray-500 fw-semibold">
                                82%
                            </span>
                            <!--end::Value-->
                        </div>
                        <!--end::Statistics-->
                    </div>
                    <!--end::Item-->



                </div>
                <!--end::Body-->
            </div>
            <!--end::List widget 21-->
        </div>
        <!--end::Col-->
        <div   class="h-325px w-100 min-h-auto ps-4 pe-6" style="min-height: 340px;">
            <canvas id="myChart"></canvas>
        </div>

    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');

        const myChart = new Chart(ctx, {

            type: 'bar', // Tipo de gráfico
            data: {
                labels: ['QA Analysis', 'Marketing', 'Web Dev', 'Maths', 'Front-end Dev', 'Physics',
                'Philosophy'], // Etiquetas
                datasets: [{
                    label: 'Hours Spent',
                    data: [154, 42, 75, 110, 23, 87, 50], // Datos correspondientes a las etiquetas
                    backgroundColor: [
                        '{{env('THEME_HIGHLIGHT')}}', // Color de fondo para 'QA Analysis'
                    ],
                    borderColor: [
                        'rgba(23,198,83,1)', // Color del borde
                    ],
                    borderWidth: 0.1,
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Hours'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Courses'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw + ' hours';
                            }
                        }
                    }
                },
                layout: 10,
            }
        });
    </script>
@endsection
