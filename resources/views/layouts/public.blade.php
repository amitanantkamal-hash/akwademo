<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Order #{{ $order->reference_id ?? '' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap CSS (if using Bootstrap) -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            
        <!-- Your custom CSS if needed -->
        @stack('styles')

        <style>
            body {
                font-family: 'Figtree', sans-serif;
                background-color: #f8f9fa;
                margin: 0;
                padding: 0;
            }
            
            .public-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
            }
            
            .public-header {
                background: #fff;
                padding: 20px;
                border-bottom: 1px solid #e0e0e0;
                margin-bottom: 20px;
                text-align: center;
            }
            
            .public-footer {
                background: #fff;
                padding: 20px;
                border-top: 1px solid #e0e0e0;
                margin-top: 40px;
                text-align: center;
                color: #666;
            }
            
            /* Hide all edit buttons and forms in public view */
            .btn-edit, .form-control, select, [data-bs-toggle="modal"],
            .quantity-btn, .edit-item-btn, .delete-item-btn,
            #order-update-form, #shipping-form, #payment-form,
            #contact-form, #dispatch-form, #cancel-form,
            #order-note-form, #edit-item-form,
            .modal, [data-bs-target] {
                display: none !important;
            }
            
            /* Make everything read-only */
            .card-header .btn, .card-toolbar .btn {
                display: none !important;
            }
            
            .form-select-solid {
                background-color: transparent !important;
                border: none !important;
                pointer-events: none !important;
                appearance: none !important;
                padding-left: 0 !important;
            }
            
            .form-select-solid option {
                display: none;
            }
        </style>
    </head>
    <body>
        <!-- Minimal Header (optional) -->
        <div class="public-header">
            <h2 class="mb-0">{{ $Paymenttemplate->business_name }}</h2>
            <p class="text-muted mb-0">Order Details - #{{ $order->reference_id ?? '' }}</p>
        </div>

        <!-- Main Content -->
        <div class="public-container">
            @yield('content')
        </div>

        <!-- Minimal Footer (optional) -->
        <div class="public-footer">
            <p class="mb-0">
                &copy; {{ date('Y') }} {{ config('app.name', 'Our Store') }}. 
                This is a read-only view of your order details.
            </p>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- Your scripts -->
        @stack('scripts')
        
        <script>
            // Disable all interactive elements in public view
            document.addEventListener('DOMContentLoaded', function() {
                // Remove all event listeners from buttons
                const buttons = document.querySelectorAll('button');
                buttons.forEach(btn => {
                    btn.setAttribute('disabled', 'disabled');
                    btn.style.opacity = '0.6';
                    btn.style.cursor = 'not-allowed';
                });
                
                // Disable all form elements
                const formElements = document.querySelectorAll('input, select, textarea');
                formElements.forEach(el => {
                    el.setAttribute('disabled', 'disabled');
                    el.style.backgroundColor = '#f8f9fa';
                });
                
                // Remove all click events
                document.addEventListener('click', function(e) {
                    if (e.target.tagName === 'BUTTON' || 
                        e.target.tagName === 'A' && e.target.getAttribute('href') === '#') {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                }, true);
            });
        </script>
    </body>
</html>