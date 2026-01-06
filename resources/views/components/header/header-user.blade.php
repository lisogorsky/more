    @props(['user' => auth()->user()])

    @guest
        <button class="btn --white" x-data @click="$dispatch('show-register-modal')">
            Войти
        </button>
    @endguest

    @auth
        <div class="user-special">
            <a href="#" class="user-message"><i class="icon-email"></i> <span class="count">1</span></a>
            <a href="#" class="user-alert"><i class="icon-notifications"></i> <span class="count">99+</span></a>
        </div>

        <div class="user">
            <div class="user__image">
                @if ($user?->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Аватар пользователя">
                @else
                    <img src="{{ asset('images/avatar.jpg') }}" alt="Аватар по умолчанию">
                @endif
            </div>
        </div>
        <div class="user__info-wrap">
            <span class="user__name">{{ Auth::user()->name }}</span>
            <div class="user__discr">{{ Auth::user()->roles->first()->name }}</div>
            <livewire:cabinet.cabinet-switcher />
        </div>

        <a href="{{ route('logout') }}" class="user__logout"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="icon-logout"></i>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        </div>
    @endauth
