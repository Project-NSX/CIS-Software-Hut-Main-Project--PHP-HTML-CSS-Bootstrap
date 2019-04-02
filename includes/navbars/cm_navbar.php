<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="cm_landing.php">Home<span class="sr-only"></span></a>
            </li>
            <?php require 'includes/navbars/va_tools.php';?>


            <li class="nav-item">
                <a class="nav-link" href="cm_requests_pending_approval.php">College Manager - View Requests Pending Approval</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cm_approved_requests.php">College Manager - View Approved Requests</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cm_denied_requests.php">College Manager - View Denied Requests</a>
            </li>
        </ul>
    </div>
</nav>