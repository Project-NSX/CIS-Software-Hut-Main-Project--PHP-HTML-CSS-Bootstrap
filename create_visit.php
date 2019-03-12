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
        <select name="visitor" id="visitor" class="form-control">
            <option value="Select" disabled>Select</option>
        </select>
    </fieldset>
    <fieldset>
        <legend>Visit Dates</legend>
        <div class="form-row">
        <div class="form-group col-md-6">
        <label for="s_date">Start Date: </label>
        <input type="date" name="s_date" class="form-control">
        </div>
        <div class="form-group col-md-6">
        <label for="e_date">End Date: </label>
        <input type="date" name="e_date" class="form-control">
        </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>IPR Issues</legend>
        <p>Are there IPR issues with the visit?</p>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ipr_issues" id="inlineRadio1" value="yes">
            <label class="form-check-label" for="inlineRadio1">Yes</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ipr_issues" id="inlineRadio1" value="no">
            <label class="form-check-label" for="inlineRadio1">No</label>
        </div>
            <!--TODO: Make attachment icon and message show if "yes" is selected above-->
        <legend>Additional Info</legend>
        <div class="form-group">
            <label for="summary">Summary of visit</label>
            <textarea class="form-control" id="summary" name="summary" rows="4" cols="40" placeholder="Please summarise the purpose of the visit"></textarea>
        </div>
    </fieldset>

    <button style="margin:10px 0px" type="submit" class="btn btn-primary btn-lg btn-block">Send</button>

<?php require 'includes/footer.php';?>