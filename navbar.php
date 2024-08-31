<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/dashboard.php">AdManager</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ads/list_ads.php">Ads List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ads/create_ad.php">Create Ad</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/categories.php">Manage Categories</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <a href="/logout.php" class="btn btn-danger">Logout</a>
                </form>
            </div>
        </div>
    </div>
</nav>