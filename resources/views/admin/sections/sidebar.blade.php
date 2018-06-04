<nav id="sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <a class="navbar-brand" href="{{ url('/') }}">
            <h3>{{ config('app.name', 'Laravel') }}</h3>
        </a>
    </div>

    <!-- Sidebar Links -->
    <ul class="list-unstyled components">
        <li class="active"><a href="#">Dashboard</a></li>
        <li><!-- Link with dropdown items -->
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">Posts</a>
            <ul class="collapse list-unstyled" id="homeSubmenu">
                <li><a href="#">List</a></li>
            <li><a href="{{route('posts.create')}}">Create</a></li>
            </ul>
        </li>
    </ul>
</nav>