<nav id="nav1" class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item <?php if ($page == 'home') {
                                    echo 'active';
                                } ?>">
                <a class="nav-link" href="view_requests.php"><?php echo $lang['Home'] ?><span class="sr-only"></span></a>
            </li>
            <?php require 'includes/navbars/va_tools.php'; ?>
            <li class="nav-item <?php if ($page == 'HOSRPA') {
                                    echo 'active';
                                } ?>">
                <a class="nav-link" href="hos_requests_pending_approval.php"><?php echo $lang['Head of School - View Requests Pending Approval'] ?></a>
            </li>
            <li class="nav-item <?php if ($page == 'HOSAR') {
                                    echo 'active';
                                } ?>">
                <a class="nav-link" href="hos_approved_requests.php"><?php echo $lang['Head of School - View Approved Requests'] ?></a>
            </li>
            <li class="nav-item <?php if ($page == 'HOSDR') {
                                    echo 'active';
                                } ?>">
                <a class="nav-link" href="hos_denied_requests.php"><?php echo $lang['Head of School - View Denied Requests'] ?></a>
            </li>
        </ul>
    </div>
</nav>