<nav class="navbar navbar-expand-lg sticky-top navbar-light p-2 m-0 mb-3" style="background-color: #f5355c;">
    <div class="container">
        <!-- Toggle button -->
        <button class="navbar-dark navbar-toggler icon1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Wyloguj (mobile view) -->
        <div class="logout navbar-toggler">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-primary" type="submit">Wyloguj</button>
            </form>
        </div>

        <div class="offcanvas offcanvas-start text-white" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel" style="background-color: #f5355c;">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">
                    <a class="nav-link" href="{{ route('profile.edit') }}">
                        Konto <i class="fa-solid fa-user"></i>
                    </a>
                </h5> 
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body" >
                <div class="navbar-collapse" id="navbarNavAltMarkup">
                    <ul class="navbar-nav text-lg-center align-items-center">
                        <li class="nav-item me-1">
                            <!-- Zastąp 'index.php' właściwą trasą np. do składania wniosków o licencje -->
                            <a class="nav-link" href="{{ route('license-requests.create') }}">Wniosek o Licencje</a>
                        </li>
                        <li class="nav-item me-1">
                            <!-- Twoje Licencje -->
                            <a class="nav-link" href="{{ route('licenses.my') }}">Twoje Licencje</a>
                        </li>

                        @auth
                            @if (Auth::user()->role == "admin" || Auth::user()->role == "moderator")
                                <li class="nav-item me-1 dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Modyfikacja Licencji
                                    </a>
                                    <ul class="dropdown-menu">
                                        <!-- Zastąp linki do .php odpowiednimi trasami -->
                                        <li><a class="dropdown-item" href="{{ route('license-requests.index') }}">Akceptuj Licencje</a></li>
                                        <li><a class="dropdown-item" href="{{ route('licenses.create') }}">Dodaj Licencje</a></li>
                                        <li><a class="dropdown-item" href="{{ route('license-categories.create') }}">Dodaj Kategorie Licencji</a></li>
                                        <li><a class="dropdown-item" href="{{ route('licenses.all') }}">Wszystkie Licencje</a></li>
                                    </ul>
                                </li>
                                @if (Auth::user()->role == "admin")
                                    <li class="nav-item me-1">
                                        <!-- Edycja użytkowników -->
                                        <a class="nav-link" href="{{ route('users.index') }}">Edycja użytkowników</a>
                                    </li>
                                @endif
                            @endif
                        @endauth
                    </ul>
                </div>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                    <ul class="navbar-nav mb-2 mb-lg-0 text-center align-items-center">
                        <li class="nav-item me-4 dropdown">
                            <a class="nav-link bell-icon" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bell fa-lg"></i>
                                <span class="position-absolute top-0 mt-1 start-0 translate-middle badge rounded-pill text-danger bg-white">
                                    99+
                                    <span class="visually-hidden">Nieprzeczytane wiadomości</span>
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('license-requests.index') }}">Akceptuj Licencje</a></li>
                                <li><a class="dropdown-item" href="{{ route('licenses.create') }}">Dodaj Licencje</a></li>
                                <li><a class="dropdown-item" href="{{ route('license-categories.create') }}">Dodaj Kategorie Licencji</a></li>
                                <li><a class="dropdown-item" href="{{ route('licenses.all') }}">Wszystkie Licencje</a></li>
                            </ul>
                        </li>
                        <li class="nav-item me-1">
                            <a class="nav-link" href="{{ route('profile.edit') }}">Konto</a>
                        </li>
                        <li class="nav-link list-inline-item me-auto">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary">Wyloguj</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
