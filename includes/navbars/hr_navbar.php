<nav id="nav1" class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item <?php if ($page =='home'){echo 'active';}?>">
                <a class="nav-link" href="hr_pending_approval.php">Home<span class="sr-only"></span></a>
            </li>
            <li class="nav-item <?php if ($page =='HRAR'){echo 'active';}?>">
                <a class="nav-link" href="hr_approved_requests.php">HR - Approved Requests</a>
            </li>
            <li class="nav-item <?php if ($page =='HRDR'){echo 'active';}?>">
                <a class="nav-link" href="hr_disapproved_requests.php">HR - Disapproved Requests</a>
        </ul>
    </div>
</nav>