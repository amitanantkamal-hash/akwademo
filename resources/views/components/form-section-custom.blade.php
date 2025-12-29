@props(['submit'])

<div>
    <div>
        <form wire:submit="{{ $submit }}" method="POST">
            @method("POST")
            {{ $form }}
            @if (isset($actions))
                <div>
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>
