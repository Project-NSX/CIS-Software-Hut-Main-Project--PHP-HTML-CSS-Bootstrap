<nav id="nav1" class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php if ($page == 'home') {
                                    echo 'active';
                                } ?>">
                <a class="nav-link" href="view_requests.php">Home<span class="sr-only"></span></a>
            </li>
            <?php require 'includes/navbars/va_tools.php'; ?>
        </ul>
    </div>
</nav>