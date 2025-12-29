<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn btn-secondary']) }}>
    <span class="indicator-label"> {{ $slot }}</span>
</button>
