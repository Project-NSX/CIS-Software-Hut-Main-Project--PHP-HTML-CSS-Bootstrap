<li class="nav-item <?php if ($page == 'CVa') {
                        echo 'active';
                    } ?>">
    <a class="nav-link" href="create_va.php"><?php echo $lang['Create a Visiting Academic'] ?></a>
</li>
<li class="nav-item <?php if ($page == 'CVas') {
                        echo 'active';
                    } ?>">
    <a class="nav-link" href="created_vas.php"><?php echo $lang['View My Visitors'] ?></a>
</li>
<li class="nav-item <?php if ($page == 'CV') {
                        echo 'active';
                    } ?>">
    <a class="nav-link" href="create_visit.php"><?php echo $lang['Create a Visit'] ?></a>

<li class="nav-item <?php if ($page == 'VC') {
                        echo 'active';
                    } ?>">
    <a class="nav-link" href="view_complete.php"><?php echo $lang['View My Complete Requests'] ?></a>
</li>