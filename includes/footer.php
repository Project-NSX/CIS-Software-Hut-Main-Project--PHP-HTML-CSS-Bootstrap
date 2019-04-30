</main>
</div>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
</body>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Application JavaScript -->
<script src="js/bangor_va.js" type="text/javascript"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<footer>
    <section class="footerContent">
        <div id="footerLeft">
        </div>
        <div id="footerRight">
            <p>Prifysgol Bangor University</p>
            <p>Bangor, Gwynedd, LL57 2DG</p>
            <p><?php echo $lang['PhoneNo'] ?></p>
            <p><?php echo $lang['ContactEmail'] ?></p>
            <p><?php echo $lang['Charity'] ?></p>
            <a href="index.php?lang=en"><?php echo $lang['lang_en'] ?></a>
            | <a href="index.php?lang=cy"><?php echo $lang['lang_cy'] ?></a>
        </div>
    </section>
</footer>

</html>