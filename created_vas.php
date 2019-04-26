<!-- Variable used to highlight the appropriate button on the navbar -->
<?php $page = 'CVas';
require 'includes/header.php';
require 'includes/deny_hr_role.php' // Redirects users with the "Human Resources" role to prevent access to this page
?>

<!--Javascript to stop the form being entered when enter key is pressed-->
<script type="text/javascript">
    function noenter() {
        return !(window.event && window.event.keyCode == 13);
    }
</script>

<h2>My Visitors</h2>
<?php require 'includes/navbars/nav_picker.php'; ?>

<?php
require_once 'includes/database.php';

if (isset($_POST['update'])) {
    $UpdateQuery = "UPDATE visitingAcademic SET title = '$_POST[title]', visitorType = '$_POST[visitorType]', visitorTypeExt = '$_POST[visitorTypeExt]', homeInstitution = '$_POST[homeInstitution]', department = '$_POST[department]', street = '$_POST[street]', city = '$_POST[city]', county = '$_POST[county]', postcode = '$_POST[postcode]', email = '$_POST[email]', phoneNumber = '$_POST[phoneNumber]' WHERE visitorId = '$_POST[hidden]'";
    mysqli_query($link, $UpdateQuery);
};

if (isset($_POST['delete'])) {
    $DeleteQuery = "DELETE FROM visitingAcademic WHERE visitorId = '$_POST[hidden]'";
    mysqli_query($link, $DeleteQuery);
};

$myVisitors = "SELECT * FROM visitingAcademic WHERE hostAcademic = '{$_SESSION['username']}' ";
$myVisitorsResult = $link->query($myVisitors);
if ($myVisitorsResult->num_rows > 0) {
    $num = 1;
    echo "<div id='accordion'>";
    while ($row = $myVisitorsResult->fetch_assoc()) {
        $id = $row['visitorId']; //no need to be displayed
        $hostAcademic = $row['hostAcademic']; //not allowed to change
        $title = $row['title'];
        $fName = htmlspecialchars($row["fName"]); //not allowed to change
        $lName = htmlspecialchars($row["lName"]); //not allowed to change
        $visitorType = $row["visitorType"];
        $visitorTypeEXT = htmlspecialchars($row["visitorTypeExt"]);
        $homeInstitution = htmlspecialchars($row["homeInstitution"]);
        $department = htmlspecialchars($row["department"]);
        $street = htmlspecialchars($row["street"]);
        $city = htmlspecialchars($row["city"]);
        $county = htmlspecialchars($row["county"]);
        $postcode = htmlspecialchars($row["postcode"]);
        $email = htmlspecialchars($row["email"]);
        $phoneNumber = htmlspecialchars($row["phoneNumber"]);

        if ($visitorType == "Academic" || $visitorType == "Other") {
            $visitorTypeShow = $visitorType . ": " .  htmlspecialchars($visitorTypeEXT);
        } else {
            $visitorTypeShow = $visitorType;
        }
        ?>
        <form action=created_vas.php method=post>
            <?php
            echo "<h2><b>Visiting Academic $num:</b> $title $fName $lName</h2>";
            $num++;
            ?>

            <fieldset>
                <legend>Personal Details</legend>
                <div class='row'>
                    <div class='col-sm-2'><b>Title:</b></div>
                    <div class='col-sm-2'><select name="title" id="title" class="form-control" required>'
                            style="margin:0px 0px 10px 0px" required>
                            <option value="Mr" <?php if ($title === 'Mr') {
                                                    echo "selected";
                                                } ?>>Mr</option>
                            <option value="Mrs" <?php if ($title === 'Mrs') {
                                                    echo "selected";
                                                } ?>>Mrs</option>
                            <option value="Miss" <?php if ($title === 'Miss') {
                                                        echo "selected";
                                                    } ?>>Miss</option>
                            <option value="Ms" <?php if ($title === 'Ms') {
                                                    echo "selected";
                                                } ?>>Ms</option>
                            <option value="Dr" <?php if ($title === 'Dr') {
                                                    echo "selected";
                                                } ?>>Dr</option>
                            <option value="Professor" <?php if ($title === 'Professor') {
                                                            echo "selected";
                                                        } ?>>Professor</option>
                            <option value="Rev" <?php if ($title === 'Rev') {
                                                    echo "selected";
                                                } ?>>Rev</option>
                            <option value="Sir" <?php if ($title === 'Sir') {
                                                    echo "selected";
                                                } ?>>Sir</option>
                            <option value="Lady" <?php if ($title === 'Lady') {
                                                        echo "selected";
                                                    } ?>>Lady</option>
                            <option value="Lord" <?php if ($title === 'Lord') {
                                                        echo "selected";
                                                    } ?>>Lord</option>
                            <option value="Captain" <?php if ($title === 'Captain') {
                                                        echo "selected";
                                                    } ?>>Captain</option>
                            <option value="Major" <?php if ($title === 'Major') {
                                                        echo "selected";
                                                    } ?>>Major</option>
                            <option value="Dame" <?php if ($title === 'Dame') {
                                                        echo "selected";
                                                    } ?>>Dame</option>
                            <option value="Colonel" <?php if ($title === 'Colonel') {
                                                        echo "selected";
                                                    } ?>>Colonel</option>
                        </select>
                    </div>
                    <?php
                    $sql = "SELECT count(*) AS 'No' FROM visit WHERE visitorId = '$id' GROUP BY 'visitorId'";
                    $result = $link->query($sql);
                    if ($result->num_rows > 0) {
                        echo "<div class='col-sm-2'><b>First Name:</b></div>";
                        echo "<div class='col-sm-2'> <input type=text name=fName class='form-control' value='$fName' disabled onkeypress='return noenter()' required></div>";
                        echo "<div class='col-sm-2'><b>Last Name:</b></div>";
                        echo "<div class='col-sm-2'> <input type=text name=lName class='form-control' value='$lName' disabled onkeypress='return noenter()' required></div>";
                    } else {
                        echo "<div class='col-sm-2'><b>First Name:</b></div>";
                        echo "<div class='col-sm-2'> <input type=text name=fName class='form-control' value='$fName'  onkeypress='return noenter()' required></div>";
                        echo "<div class='col-sm-2'><b>Last Name:</b></div>";
                        echo "<div class='col-sm-2'> <input type=text name=lName class='form-control' value='$lName' onkeypress='return noenter()' required></div>";
                    }
                    ?>

                </div>
            </fieldset>


            <fieldset>
                <legend>Visitor Details</legend>
                <div class='row'>
                    <div class='col-sm-2'><b>Visitor Type:</b></div>
                    <div class='col-sm-5'><select name="visitorType" id="visitor" class="form-control" value="<?php echo $visitorType ?>" required>
                            <option value="Undergraduate" <?php if ($visitorType === 'Undergraduate') {
                                                                echo "selected";
                                                            } ?>>Undergraduate</option>
                            <option value="PhD Student" <?php if ($visitorType === 'PhD Student') {
                                                            echo "selected";
                                                        } ?>>PhD Student</option>
                            <option value="Visiting Academic" <?php if ($visitorType === 'Academic') {
                                                                    echo "selected";
                                                                } ?>>Visiting Academic (position)</option>
                            <option value="Other" <?php if ($visitorType === 'Other') {
                                                        echo "selected";
                                                    } ?>>Other (specify)</option>
                        </select></div>
                    <div class='col-sm-5'> <input type=text name=visitorTypeExt class="form-control" value="<?php echo $visitorTypeEXT ?>" onkeypress="return noenter()"></div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Home Institution Details</legend>
                <div class='row'>
                    <div class='col-sm-3'><b>Home Institution Name:</b></div>
                    <div class='col-sm-3'> <input type=text name=homeInstitution class="form-control" value="<?php echo $homeInstitution ?>" onkeypress="return noenter()" required></div>
                    <div class='col-sm-3'><b>Department Name:</b></div>
                    <div class='col-sm-3'> <input type=text name=department class="form-control" value="<?php echo $department ?>" onkeypress="return noenter()" required></div>
                </div>
                <div class='row'>
                    <div class='col-sm-2'><b>Street:</b></div>
                    <div class='col-sm-4'> <input type=text name=street class="form-control" value="<?php echo $street ?>" onkeypress="return noenter()" required></div>
                    <div class='col-sm-2'><b>City:</b></div>
                    <div class='col-sm-4'> <input type=text name=city class="form-control" value="<?php echo $city ?>" onkeypress="return noenter()" required></div>
                </div>
                <div class='row'>
                    <div class='col-sm-2'><b>County:</b></div>
                    <div class='col-sm-4'> <input type=text name=county class="form-control" value="<?php echo $county ?>" onkeypress="return noenter()" required></div>
                    <div class='col-sm-2'><b>Postcode:</b></div>
                    <div class='col-sm-4'> <input type=text name=postcode class="form-control" pattern="([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9][A-Za-z]?))))\s?[0-9][A-Za-z]{2})" title="Please enter a valid UK postcode" value="<?php echo $postcode ?>" onkeypress="return noenter()" required></div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Contact Details</legend>
                <div class='row'>
                    <div class='col-sm-2'><b>Email Address:</b></div>
                    <div class='col-sm-4'> <input type=email name=email class="form-control" value="<?php echo $email ?>" onkeypress="return noenter()"></div>
                    <div class='col-sm-2'><b>Phone Number:</b></div>
                    <div class='col-sm-4'> <input type=tel name=phoneNumber class="form-control" minlength="9" maxlength="14" value="<?php echo $phoneNumber ?>" onkeypress="return noenter()"></div>
                </div>
            </fieldset>
            <div class="container" style="margin-top:10px">
                <div class="row">

                    <?php


                    $sql = "SELECT count(*) AS 'No' FROM visit WHERE visitorId = '$id' GROUP BY 'visitorId'";
                    $result = $link->query($sql);
                    if ($result->num_rows > 0) {
                        echo "<div class='col-sm'><input type=submit name=update value=Update class='btn btn-success' style='width:100%'></div>";
                        echo "<div class='col-sm'><input type=submit name=delete value=Delete class='btn btn-danger' disabled style='width:100%'></div>";
                    } else {
                        echo "<div class='col-sm'><input type=submit name=update value=Update class='btn btn-success' style='width:100%'></div>";
                        echo "<div class='col-sm'><input type=submit name=delete value=Delete class='btn btn-danger' style='width:100%'></div>";
                    }


                    ?>

                    <input type=hidden name=hidden value=<?php echo $id ?>>
                </div>
            </div>

        </form>
        <br>
        <br>
        <br>
    <?php
}
echo "</div>";
} else {
    echo "0 results";
}
?>
<?php require 'includes/footer.php'; ?>