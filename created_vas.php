<!-- Variable used to highlight the appropriate button on the navbar -->
<?php $page = 'CVas';
require 'includes/header.php';
require 'includes/deny_hr_role.php'; // Redirects users with the "Human Resources" role to prevent access to this page
require 'includes/deny_va_role.php'; // Redirect visiting academics to prevent access to the page.
?>

<!--Javascript to stop the form being entered when enter key is pressed-->
<script type="text/javascript">
    function noenter() {
        return !(window.event && window.event.keyCode == 13);
    }
</script>

<h2><?php echo $lang['My Visitors'] ?></h2>
<?php require 'includes/navbars/nav_picker.php'; ?>

<?php
require_once 'includes/database.php';

//Detects if the Update button has been pressed, if so updates the current record with teh values of the text boxes
if (isset($_POST['update'])) {
    $UpdateQuery = "UPDATE visitingAcademic SET title = '$_POST[title]', visitorType = '$_POST[visitorType]', visitorTypeExt = '$_POST[visitorTypeExt]', homeInstitution = '$_POST[homeInstitution]', department = '$_POST[department]', street = '$_POST[street]', city = '$_POST[city]', county = '$_POST[county]', postcode = '$_POST[postcode]', email = '$_POST[email]', phoneNumber = '$_POST[phoneNumber]' WHERE visitorId = '$_POST[hidden]'";
    mysqli_query($link, $UpdateQuery);
};

//Detects if the Delete button has been pressed and deletes the record which the button appears on
if (isset($_POST['delete'])) {
    $DeleteQuery = "DELETE FROM visitingAcademic WHERE visitorId = '$_POST[hidden]'";
    mysqli_query($link, $DeleteQuery);
};

//SQL statement to retrieve columns from database table
$myVisitors = "SELECT * FROM visitingAcademic WHERE hostAcademic = '{$_SESSION['username']}' ";
$myVisitorsResult = $link->query($myVisitors);
if ($myVisitorsResult->num_rows > 0) {
    $num = 1;
    echo "<div id='accordion'>";
    while ($row = $myVisitorsResult->fetch_assoc()) {
        //saves column value of row in variables
        $id = $row['visitorId'];
        $hostAcademic = $row['hostAcademic'];
        $title = $row['title'];
        $fName = htmlspecialchars($row["fName"]);
        $lName = htmlspecialchars($row["lName"]);
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
            echo $lang['visAcNo'];
            echo "$num:</b> $title $fName $lName</h2>";
            $num++;
            ?>

            <fieldset>
                <legend><?php echo $lang['Personal Details'] ?></legend>
                <div class='row'>
                    <div class='col-sm-2'><b><?php echo $lang['Title'] ?>:</b></div>
                    <!-- Dropdown for title -->
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
                    //Check if the visitorId is in the table Visits
                    $sql = "SELECT count(*) AS 'No' FROM visit WHERE visitorId = '$id' GROUP BY 'visitorId'";
                    $result = $link->query($sql);
                    if ($result->num_rows > 0) {
                        //If the count is returned that means that there is a visit for that user, therefore the name can't be changed
                        echo $lang['fNamecount'];
                        echo "<div class='col-sm-2'> <input type=text name=fName class='form-control' value='$fName' disabled onkeypress='return noenter()' required></div>";
                        echo $lang['sNamecount'];
                        echo "<div class='col-sm-2'> <input type=text name=lName class='form-control' value='$lName' disabled onkeypress='return noenter()' required></div>";
                    } else {
                        //If nothing gets returned that means that there is not a visit for that user, therefore the name can be changed
                        echo $lang['fNamecount'];
                        echo "<div class='col-sm-2'> <input type=text name=fName class='form-control' value='$fName'  onkeypress='return noenter()' required></div>";
                        echo $lang['sNamecount'];
                        echo "<div class='col-sm-2'> <input type=text name=lName class='form-control' value='$lName' onkeypress='return noenter()' required></div>";
                    }
                    ?>
                </div>
            </fieldset>

            <fieldset>
                <legend><?php echo $lang['Visitor Details'] ?></legend>
                <div class='row'>
                    <div class='col-sm-2'><b><?php echo $lang['Visitor Type'] ?>:</b></div>
                    <div class='col-sm-5'><select name="visitorType" id="visitor" class="form-control" value="<?php echo $visitorType ?>" required>
                            <!-- If the visitorType from the database matches the option, it makes the option selected -->
                            <option value="Undergraduate" <?php if ($visitorType === 'Undergraduate') {
                                                                echo "selected";
                                                            } ?>><?php echo $lang['Undergraduate'] ?></option>
                            <option value="PhD Student" <?php if ($visitorType === 'PhD Student') {
                                                            echo "selected";
                                                        } ?>><?php echo $lang['PhD Student'] ?></option>
                            <option value="Visiting Academic" <?php if ($visitorType === 'Academic') {
                                                                    echo "selected";
                                                                } ?>><?php echo $lang['Visiting Academic (Position)'] ?></option>
                            <option value="Other" <?php if ($visitorType === 'Other') {
                                                        echo "selected";
                                                    } ?>><?php echo $lang['Other (Specify)'] ?></option>
                        </select></div>
                    <div class='col-sm-5'> <input type=text name=visitorTypeExt class="form-control" value="<?php echo $visitorTypeEXT ?>" onkeypress="return noenter()"></div>
                </div>
            </fieldset>

            <fieldset>
                <legend><?php echo $lang['Home Institution Details'] ?></legend>
                <div class='row'>
                    <div class='col-sm-3'><b><?php echo $lang['Home Institution Name'] ?>:</b></div>
                    <div class='col-sm-3'> <input type=text name=homeInstitution class="form-control" value="<?php echo $homeInstitution ?>" onkeypress="return noenter()" required></div>
                    <div class='col-sm-3'><b><?php echo $lang['Department Name'] ?>:</b></div>
                    <div class='col-sm-3'> <input type=text name=department class="form-control" value="<?php echo $department ?>" onkeypress="return noenter()" required></div>
                </div>
                <div class='row'>
                    <div class='col-sm-2'><b><?php echo $lang['Street'] ?>:</b></div>
                    <div class='col-sm-4'> <input type=text name=street class="form-control" value="<?php echo $street ?>" onkeypress="return noenter()" required></div>
                    <div class='col-sm-2'><b><?php echo $lang['Town / City'] ?>:</b></div>
                    <div class='col-sm-4'> <input type=text name=city class="form-control" value="<?php echo $city ?>" onkeypress="return noenter()" required></div>
                </div>
                <div class='row'>
                    <div class='col-sm-2'><b><?php echo $lang['County'] ?>:</b></div>
                    <div class='col-sm-4'> <input type=text name=county class="form-control" value="<?php echo $county ?>" onkeypress="return noenter()" required></div>
                    <div class='col-sm-2'><b><?php echo $lang['Postcode'] ?>:</b></div>
                    <div class='col-sm-4'> <input type=text name=postcode class="form-control" pattern="([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9][A-Za-z]?))))\s?[0-9][A-Za-z]{2})" title="Please enter a valid UK postcode" value="<?php echo $postcode ?>" onkeypress="return noenter()" required></div>
                </div>
            </fieldset>

            <fieldset>
                <legend><?php echo $lang['Contact Details'] ?></legend>
                <div class='row'>
                    <div class='col-sm-2'><b><?php echo $lang['Email'] ?>:</b></div>
                    <div class='col-sm-4'> <input type=email name=email class="form-control" value="<?php echo $email ?>" onkeypress="return noenter()"></div>
                    <div class='col-sm-2'><b><?php echo $lang['Phone Number'] ?>:</b></div>
                    <div class='col-sm-4'> <input type=tel name=phoneNumber class="form-control" minlength="9" maxlength="14" value="<?php echo $phoneNumber ?>" onkeypress="return noenter()"></div>
                </div>
            </fieldset>
            <div class="container" style="margin-top:10px">
                <div class="row">

                    <?php


                    $sql = "SELECT count(*) AS 'No' FROM visit WHERE visitorId = '$id' GROUP BY 'visitorId'";
                    $result = $link->query($sql);
                    if ($result->num_rows > 0) {
                        //If the count is returned that means that there is a visit for that user, therefore the user can't be deleted
                        echo $lang['vasUpdate'];
                        echo $lang['vasDelete1'];
                    } else {
                        //If nothing is returned that means that there is not a visit for that user, therefore the user can be deleted
                        echo $lang['vasUpdate'];
                        echo $lang['vasDelete2'];
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