<?php require 'includes/header.php';?>
<!--HTML HERE-->
<h2>Create a Visiting Academic</h2>
<?php require'includes/navbars/nav_picker.php';?>
<!--
    TODO: Make this page post to the database
    FIXME: Labels show up on the wrong line when changing window size
-->
<form method="post">

        <fieldset>
            <legend>Name</legend>
            <label for="title">Title: </label>
            <select name="title" id="title">
                <option value="mr">Mr</option>
                <option value="miss">Miss</option>
                <option value="mrs">Mrs</option>
                <option value="ms">Ms</option>
                <option value="dr">Dr</option>
                <option value="prof">Prof</option>
                <option value="other">Other</option>
            </select>
            <label for="f_name">First Name: </label><input type="text" name="f_name">
            <label for="l_name">Last Name: </label><input type="text" name="l_name">
        </fieldset>



    <fieldset>
        <legend>Address</legend>

        <label for="street">Street: </label><input type="text" name="street">

        <label for="town_city">Town / City: </label> <input type="text" name="town_city">

        <label for="county">County: </label><input type="text" name="county">
        <label for="postcode">Postcode: </label><input name="postcode"
            pattern="[A-Za-z]{1,2}[0-9Rr][0-9A-Za-z]? [0-9][ABD-HJLNP-UW-Zabd-hjlnp-uw-z]{2}"
            title="Please enter a valid UK postcode">

    </fieldset>
    <fieldset>
        <legend>Contact Information</legend>

        <label for="email">Email: </label> <input type="email" name="email">

        <label for="phone_number">Phone Number: </label> <input type="tel" name="phone_number" minlength="9" maxlength="14">

    </fieldset>
    <fieldset>
<legend>Academic Information</legend>
<label for="type">Type of Academic: </label>
            <select name="type" id="type">
                <option value="mr">Undergraduate</option>
                <option value="miss">PhD student</option>
<!--TODO: Make the above two fields diaply an additional box for the user to enter additional information-->
                <option value="mrs">Visiting Academic (Position)</option>
                <option value="ms">Other (Specify)</option>
                </select>
                <label for="home_institution">Home Institution: </label><input type="text" name="home_institution">

    </fieldset>
    <button>Send</button>
</form>
<?php require 'includes/footer.php';?>