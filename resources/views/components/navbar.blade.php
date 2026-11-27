<nav class="navbar navbar-expand navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Training Institute</a>

        <div class="navbar-nav ms-auto align-items-center">
            @guest
                <a class="nav-link" href="{{ route('register') }}">Register</a>
                <a class="nav-link" href="{{ route('login') }}">Login</a>
            @endguest

            @auth
                <a class="nav-link" href="{{ route('courses.index') }}">Courses</a>
                <a class="nav-link" href="{{ route('students.index') }}">Students</a>
                <span class="nav-link text-light">
                    {{ auth()->user()->name }} ({{ auth()->user()->role }})
                </span>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm ms-2">Log Out</button>
                </form>
            @endauth
        </div>
    </div>
</nav>
