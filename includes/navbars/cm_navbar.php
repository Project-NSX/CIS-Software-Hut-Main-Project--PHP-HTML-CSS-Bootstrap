<nav id="nav1" class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item <?php if ($page == 'home') {
                                    echo 'active';
                                } ?>">
                <a class="nav-link" href="view_requests.php"><?php echo $lang['Home'] ?>
<span class="sr-only"></span></a>
            </li>
            <?php require 'includes/navbars/va_tools.php'; ?>
            <li class="nav-item <?php if ($page == 'CMRPA') {
                                    echo 'active';
                                } ?>">
                <a class="nav-link" href="cm_requests_pending_approval.php"><?php echo $lang['College Manager - View Requests Pending Approval'] ?></a>
            </li>
            <li class="nav-item <?php if ($page == 'CMAR') {
                                    echo 'active';
                                } ?>">
                <a class="nav-link" href="cm_approved_requests.php"><?php echo $lang['College Manager - View Approved Requests'] ?></a>
            </li>
            <li class="nav-item <?php if ($page == 'CMDR') {
                                    echo 'active';
                                } ?>">
                <a class="nav-link" href="cm_denied_requests.php"><?php echo $lang['College Manager - View Denied Requests'] ?></a>
            </li>
        </ul>
    </div>
</nav>