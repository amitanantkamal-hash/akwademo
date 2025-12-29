@foreach (auth()->user()->getExtraMenus() as $menu)
    @if (isset($menu['isGroup']) && $menu['isGroup'])

        <!-- Depuración para identificar el menú que falla -->
        @if (!isset($menu['id']))
            @dump($menu) <!-- Este menú no tiene la clave 'id', lo mostramos para inspección -->
        @endif

        <a class="nav-link"
           href="#navbar-{{ $menu['id'] ?? 'undefined-id' }}"
           data-toggle="collapse"
           role="button"
           aria-expanded="false"
           aria-controls="navbar-{{ $menu['id'] ?? 'undefined-id' }}">

            <i class="{{ $menu['icon'] }}"></i>
            <span class="nav-link-text">{{ __($menu['name']) }}</span>
        </a>

        <div class="collapse" id="navbar-{{ $menu['id'] ?? 'undefined-id' }}" style="">
            <ul class="nav nav-sm flex-column">
                @foreach ($menu['menus'] as $submenu)
                    <li class="nav-item">
                        {{-- <a class="nav-link @if (Route::currentRouteName() == $submenu['route']) active @endif"
                           href="{{ route($submenu['route'], isset($submenu['params']) ? $submenu['params'] : []) }}"> --}}

                            {{-- <i class="{{ $submenu['icon'] }}"></i> {{ __($submenu['name']) }} --}}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

    @else

        <!-- Depuración para identificar el menú que falla -->
        @if (!isset($menu['route']))
            @dump($menu) <!-- Este menú no tiene la clave 'route', lo mostramos para inspección -->
        @endif

        <li class="nav-item">
            <a class="nav-link @if (Route::currentRouteName() == $menu['route']) active @endif"
               href="{{ route($menu['route'], isset($menu['params']) ? $menu['params'] : []) }}">

                @if (isset($menu['svg']))
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="{{ $menu['color'] }}" viewBox="0 0 16 16">
                        <path d="{{ $menu['svg'] }}"/>
                    </svg>
                    <span style="margin-left: 20px">{{ __($menu['name']) }}</span>
                @else
                {{-- @php dd($menu); @endphp --}}
                {{-- <i class=""></i>{{ __($menu['name']) }} --}}

                @endif
            </a>
        </li>

    @endif
@endforeach
