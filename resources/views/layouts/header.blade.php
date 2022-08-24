<header class="p-3 border-bottom" style="background: #1C2331;" >
    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="{{ route('home') }}" class="nav-link px-2 link-light">Home</a></li>
                @if (Auth::user()->role_id<=2)
                    <li><a href="{{ route('user.index') }}" class="nav-link px-2 link-light">User</a></li>
                @endif
                @if (Auth::user()->role_id<=1)
                    <li><a href="{{ route('company.index') }}" class="nav-link px-2 link-light">Company</a></li>
                    <li><a href="{{ route('topic.index') }}" class="nav-link px-2 link-light">Topic</a></li>
                    <li><a href="{{ route('tag.index') }}" class="nav-link px-2 link-light">Tag</a></li>
                @endif
            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
            </form>

            <div class="dropdown text-end text-light">
                <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" id="dropdownUser1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{Auth::user()->avatar ? asset(Auth::user()->avatar) : asset(config('constant.images.user'))}}" alt="mdo" width="32" height="32"
                        class="rounded-circle border border-light">
                </a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1" style="">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Account</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="{{ route('auth.logout') }}">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
