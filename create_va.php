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
            <select name="title" id="title" class="form-control">
                <option value="mr">Mr</option>
                <option value="miss">Miss</option>
                <option value="mrs">Mrs</option>
                <option value="ms">Ms</option>
                <option value="dr">Dr</option>
                <option value="prof">Prof</option>
                <option value="other">Other</option>
            </select>
            <div class="form-row">
            <div class="form-group col-md-6">
            <label for="f_name">First Name: </label>
            <input type="text" class="form-control" name="f_name">
            </div>
            <div class="form-group col-md-6">
            <label for="l_name">Last Name: </label>
            <input type="text" class="form-control" name="l_name">
            </div>
            </div>
        </fieldset>

        <fieldset>
        <legend>Address</legend>
        <div class="form-row">
        <div class="form-group col-md-6">
        <label for="street">Street: </label>
        <input type="text" class="form-control" name="street">
        </div>
        <div class="form-group col-md-6">
        <label for="town_city">Town / City: </label>
        <input type="text" class="form-control" name="town_city">
        </div>
        </div>
        <div class="form-row">
        <div class="form-group col-md-6">
        <label for="county">County: </label>
        <input type="text" class="form-control" name="county">
        </div>
        <div class="form-group col-md-6">
        <label for="postcode">Postcode: </label>
        <input type="text" name="postcode" pattern="[A-Za-z]{1,2}[0-9Rr][0-9A-Za-z]? [0-9][ABD-HJLNP-UW-Zabd-hjlnp-uw-z]{2}" title="Please enter a valid UK postcode" class="form-control">
        </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>Contact Information</legend>
        <div class="form-row">
        <div class="form-group col-md-6">
        <label for="email">Email: </label>
        <input type="email" class="form-control" name="email">
        </div>
        <div class="form-group col-md-6">
        <label for="phone_number">Phone Number: </label>
        <input type="tel" name="phone_number" class="form-control" minlength="9" maxlength="14">
        </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>Academic Information</legend>
        <label for="type">Type of Academic: </label>
            <select name="type" id="type" class="form-control">
                <option value="undergrad">Undergraduate</option>
                <option value="phd">PhD student</option>
                <option value="vaPos">Visiting Academic (Position)</option>
                <option value="otherSpecify">Other (Specify)</option>
            </select>
            <div class="form-row">
            <label for="home_institution">Home Institution: </label>
            <input type="text" class="form-control" name="home_institution">
            </div>
    </fieldset>

    <button style="margin:10px 0px" type="submit" class="btn btn-primary btn-lg btn-block">Send</button>

</form>
<?php require 'includes/footer.php';?>