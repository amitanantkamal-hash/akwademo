<!--begin::Card-->
<div class="card">
  <!--begin::Card header-->
  <div class="card-header border-0 pt-6">
      <h3 class="card-title align-items-start flex-column">
          <span class="card-label fw-bold fs-3 mb-1">
              <i class="ki-duotone ki-setting-3 fs-2 text-primary me-2">
                  <span class="path1"></span>
                  <span class="path2"></span>
              </i>
              {{ __('Step 1: Create developer account and a new Facebook app') }}
          </span>
      </h3>
  </div>
  <!--end::Card header-->
  
  <!--begin::Card body-->
  <div class="card-body py-4">
      @if ($company->getConfig('whatsapp_webhook_verified','no')=='yes')
          <!--begin::Alert-->
          <div class="alert alert-dismissible bg-light-success d-flex flex-column flex-sm-row p-5 mb-10">
              <i class="ki-duotone ki-check-circle fs-2hx text-success me-4 mb-5 mb-sm-0">
                  <span class="path1"></span>
                  <span class="path2"></span>
              </i>
              <div class="d-flex flex-column pe-0 pe-sm-10">
                  <h4 class="fw-semibold">{{ __('Success') }}</h4>
                  <span>{{__('Congratulation. Webhook is successfully verified.')}}</span>
              </div>
          </div>
          <!--end::Alert-->
      @endif

      <!--begin::Steps-->
      <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid">
          <div class="flex-row-fluid py-3">
              <!--begin::Step 1-->
              <div class="d-flex flex-column mb-10">
                  <div class="d-flex flex-column flex-md-row align-items-md-center mb-2">
                      <span class="bullet bullet-dot bg-primary me-5 mb-2 mb-md-0"></span>
                      <div class="d-flex flex-column flex-md-row align-items-md-center flex-wrap">
                          <span class="text-gray-700 fw-semibold fs-6 me-md-2">
                              {{__('Create a Developer account and a new Facebook app as described here') }}
                          </span>
                          <a target="_blank" href="https://developers.facebook.com/docs/whatsapp/cloud-api/get-started#set-up-developer-assets" 
                             class="btn btn-icon btn-sm btn-light-primary mt-2 mt-md-0 ms-md-2">
                              <i class="ki-duotone ki-exit-up fs-2">
                                  <span class="path1"></span>
                                  <span class="path2"></span>
                              </i>
                          </a>
                      </div>
                  </div>
              </div>
              <!--end::Step 1-->
              
               <!--begin::Step 2-->
               <div class="d-flex flex-column mb-10">
                <div class="d-flex align-items-center mb-2">
                    <span class="bullet bullet-dot bg-primary me-5"></span>
                    <span class="text-gray-700 fw-semibold fs-6">
                        Once you have your Facebook app created, in the dashboard of the app, locate the WhatsApp product-&gt;Setup.
                    </span>
                </div>
            </div>
            <!--end::Step 2-->

            <!--begin::Step 3-->
            <div class="d-flex flex-column mb-10">
                <div class="d-flex align-items-center mb-2">
                    <span class="bullet bullet-dot bg-primary me-5"></span>
                    <span class="text-gray-700 fw-semibold fs-6">
                        Then go to WhatsApp &gt; Configuration and enter the following info
                    </span>
                </div>
              
              <!--begin::Callback URL-->
              <div class="ms-8 ps-5 mt-3">
                  <div class="fw-bold fs-6 text-gray-600 mb-2">{{ (__('Callback URL'))}}</div>
                  <div class="d-flex flex-column flex-md-row align-items-md-center">
                      <div class="d-flex align-items-center w-100">
                          <span class="text-success fw-semibold fs-6 me-2 text-break">{{ rtrim(config('app.url'),'/')}}/webhook/wpbox/receive/{{$token}}</span>
                          <button type="button" class="btn btn-icon btn-sm btn-light btn-copy mt-2 mt-md-0 ms-md-2" 
                                  data-text="{{ rtrim(config('app.url'),'/')}}/webhook/wpbox/receive/{{$token}}">
                              <i class="ki-duotone ki-copy fs-2">
                                  <span class="path1"></span>
                                  <span class="path2"></span>
                                  <span class="path3"></span>
                              </i>
                          </button>
                      </div>
                  </div>
              </div>
              <!--end::Callback URL-->
              
              <!--begin::Verify Token-->
              <div class="ms-8 ps-5 mt-5">
                  <div class="fw-bold fs-6 text-gray-600 mb-2">{{ (__('Verify token'))}}</div>
                  <div class="d-flex flex-column flex-md-row align-items-md-center">
                      <div class="d-flex align-items-center w-100">
                          <span class="text-success fw-semibold fs-6 me-2 text-break">{{$token}}</span>
                          <button type="button" class="btn btn-icon btn-sm btn-light btn-copy mt-2 mt-md-0 ms-md-2" 
                                  data-text="{{$token}}">
                              <i class="ki-duotone ki-copy fs-2">
                                  <span class="path1"></span>
                                  <span class="path2"></span>
                                  <span class="path3"></span>
                              </i>
                          </button>
                      </div>
                  </div>
              </div>
              <!--end::Verify Token-->
            </div>
          </div>
      </div>
  </div>
  <!--end::Card body-->
</div>
<!--end::Card-->

@section('topjs')
<script>
  document.addEventListener('DOMContentLoaded', function() {
      // Initialize clipboard functionality
      const initClipboard = () => {
          const copyButtons = document.querySelectorAll('.btn-copy');
          
          copyButtons.forEach(button => {
              button.addEventListener('click', function(e) {
                  e.preventDefault();
                  e.stopPropagation();
                  
                  const textToCopy = this.getAttribute('data-text');
                  const el = document.createElement('textarea');
                  el.value = textToCopy;
                  document.body.appendChild(el);
                  el.select();
                  
                  try {
                      document.execCommand('copy');
                      Swal.fire({
                          toast: true,
                          position: 'top-end',
                          icon: 'success',
                          title: 'Copied to clipboard!',
                          showConfirmButton: false,
                          timer: 2000,
                          timerProgressBar: true,
                          didOpen: (toast) => {
                              toast.addEventListener('mouseenter', Swal.stopTimer);
                              toast.addEventListener('mouseleave', Swal.resumeTimer);
                          }
                      });
                  } catch (err) {
                      Swal.fire({
                          toast: true,
                          position: 'top-end',
                          icon: 'error',
                          title: 'Failed to copy text',
                          showConfirmButton: false,
                          timer: 2000,
                          background: 'var(--kt-body-bg)',
                          color: 'var(--kt-text-dark)',
                          iconColor: 'var(--kt-danger)'
                      });
                  }
                  
                  document.body.removeChild(el);
              });
          });
      };

      // Initialize on load
      initClipboard();
  });
</script>
@endsection