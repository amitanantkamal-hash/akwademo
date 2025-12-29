@props(['id' => null, 'maxWidth' => null])

<x-modal-custom :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div>
        <div class="fs-6 fw-bold mb-1 mt-8">
            {{ $title }}
        </div>

        <div class="fw-semibold text-gray-600">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 text-right">
        {{ $footer }}
    </div>
</x-modal-custom>
