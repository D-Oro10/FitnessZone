
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Other/html.html to edit this template
-->
<html>
    <head>
        <link rel="stylesheet" href="Setting_MemberInfoStyle.css" type="text/css"/>
        <link rel="icon" href="FitnessZoneLogo.jpg" type="image/x-icon"><!-- Must place credits on all the bg images used -->
        <title>Fitness Zone Settings/Membership Info</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <form id="myForm" name="myForm" action="Update_MemberInfo.php" method="post">
        <div class ="Box">
        <div class ="Container">
            <div class="Form">
                <div class="Section" id="Section">
                    <p class="tag">Personal Information:</p>
                    <input type="hidden" id="memberID" name="memberID" value="1"> <!-- <?php echo $memberID; ?>-->
                    <label>Name</label>
                    <br>
                    <input type="text" name="m_name" id="M_name">
                    <br>
                    <label>Contact No.</label>
                    <br>
                    <input type="tel" name="M_contact" id="M_contact" placeholder="Contact No."  required>
                    <br>
                    <label>Email</label>
                    <br>
                    <input type="email" name="M_Email" id="M_Email" placeholder="Email"  required>
                    <br>
                    <label>Address</label>
                    <br>
                    <input type="text" name="homeadd" id="homeadd" placeholder="Address" required>
                    <input type="text" name="Mcity" id="Mcity" placeholder="City ex. Quezon" required>
                    <input type="number" name="Mpostcd" id="Mpostcd" placeholder="Postal Code" required>
                    <br>
                    <label>Birth Date</label>
                    <br>
                    <input type="date" name="MBday" id="MBday" required>
                    <br><br>
                    <p class="tag">Emergency Contact:</p>
                    <label>Name</label>
                    <br>
                    <input type="text" name="e_name" id="E_Name" placeholder="Name (First Name, Middle Name, Last Name) Ex: Paulo John Garcia Santos" required>
                    <br>
                    <label>Contact No.</label>
                    <br>
                    <input type="tel" name="E_contact" id="E_contact" placeholder="Contact No." required>
                    <br>
                    <select name="relation" id="rel">
                        <option value="" disabled selected hidden>Relationship:</option>
                        <option value="Mother">Mother</option>
                        <option value="Father">Father</option>
                        <option value="Husband">Husband</option>
                        <option value="Wife">Wife</option>
                        <option value="Other">Other:</option><!-- JS query for other selection/user input -->
                    </select>
                    <input type="text" name="otherInput" id="otherInput" placeholder="Enter Other Relation">
                    <p class="tag">Membership Details:</p>
                    <label>Membership Type</label>
                    <br>
                    <select name="M_Type" id="M_type">
                        <option value="" disabled selected hidden>Membership Type:</option>
                        <option value="Student">Student</option>
                        <option value="Member">Member</option>
                    </select><br>
                    <div id="p_typebox">
                        <label>Installment Plan</label>
                        <br>
                        <select name="Pay_Type" id="p_type">
                            <option value="" disabled selected hidden>Installment Plan:</option>
                            <!--
                            <option value="Daily">Daily</option>
                            <option value="Monthly">Monthly</option>
                            <option value="3Months">3 Months</option>
                            <option value="Annual" class="Annual_opt">Annual</option>
                            -->
                        </select>
                    </div>
                    <button type="submit" name="update" id="update" class="done-btn">Update</button>
                </div>
            </div>
        </div>
        </div>
        </form>
        <script src="SettingsInfoScript.js"></script>
    </body>
</html>
