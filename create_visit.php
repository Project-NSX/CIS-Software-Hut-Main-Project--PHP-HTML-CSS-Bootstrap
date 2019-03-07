<?php require 'includes/header.php';?>
<!--HTML HERE-->
<h2>Create a Visit</h2>
<?php require'includes/navbars/nav_picker.php';?>
<!--
    FIXME: Labels show up on the wrong line when changing window size
-->
<form method="post">

    <fieldset>
        <legend>Visitor</legend>
        <label for="Visitor">Visitor: </label>
        <select name="visitor" id="visitor">
            <option value="Select" disabled>Select</option>
        </select>

    </fieldset>
    <fieldset>
        <legend>Visit Dates</legend>
        <label for="s_date">Start Date: </label><input type="date" name="s_date">
        <label for="e_date">End Date: </label><input type="date" name="e_date">
    </fieldset>
    <fieldset>
        <legend>IPR Issues</legend>
        <div>
            <p>Are there IPR issues with the visit?</p>
            <input type="radio" name="ipr_issues" value="yes">Yes<br>
            <input type="radio" name="ipr_issues" value="no" checked> No
            <!--TODO: Make attachment icon and message show if "yes" is selected above-->
        </div>
        <legend>Additional Info</legend>
        <label for="summary">Summary of visit</label>: <textarea id="summary" name="summary" rows="4" cols="40"
            placeholder="Please summarise the purpose of the visit" autofocus></textarea>
    </fieldset>
    <fieldset>


        <button>Send</button>


        <?php require 'includes/footer.php';?>