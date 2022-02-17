<nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    Admin Page

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <form action="logout" method="POST">
            @csrf
            <button style="background: none; border: none; color: #4e73df; transition: 150ms all;" class="logout_btn" type="submit">Logout</button>
            <style>
                .logout_btn:hover {
                    color: #2e59d9;
                    transform: scale(1.1);
                }
            </style>
        </form>

    </ul>

</nav>
