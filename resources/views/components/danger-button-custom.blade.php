<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-danger px-6 mt-4']) }}>
    {{ $slot }}
</button>
