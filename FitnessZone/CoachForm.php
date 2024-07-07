<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->

<html>
    <head>
        <link rel="stylesheet" href="CoachForm_Style.css" type="text/css"/>
        <link rel="icon" href="FitnessZoneLogo.jpg" type="image/x-icon"><!-- Must place credits on all the bg images used -->
        <title>Coach Staff Registration</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <form id="myForm" action="RegisterCoach.php" method="post">
        <div class ="Box">
        <div class ="Container">
            <div class="Form">
                <div class="Section" id="Section">
                    <p class="tag">Staff Information:</p>
                    <label>Name</label>
                    <br>
                    <input type="text" name="c_lname" id="lname" placeholder="Last Name" required>
                    <b>,</b>
                    <input type="text" name="c_fname" id="fname" placeholder="First Name" required>
                    <input type="text" name="c_mname" id="mname" placeholder="Middle Initial ex. Reyes (optional)">
                    <br>
                    <label>Nickname</label>
                    <br>
                    <input type="text" name="c_Nname" id="c_Nname" placeholder="Nickname" required>
                    <br>
                    <label>Birth Date</label>
                    <br>
                    <input type="date" name="C_Bday" required>
                    <br>
                    <label>Address</label>
                    <br>
                    <input type="text" name="homeadd" placeholder="Address" required>
                    <br>
                    <label>Facebook Account Link:</label>
                    <br>
                    <input type="url" name="FbLink" placeholder="FB Link" required>
                    <br>
                    <label>Contact No.</label>
                    <br>
                    <input type="tel" name="c_contact" placeholder="Contact No."  required>
                    <br>
                    <label>Weight</label>
                    <br>
                    <input type="number" name="weight" placeholder="weight" required>
                    <br>
                    <label>Height</label>
                    <br>
                    <input type="number" name="height" placeholder="height(cm)"  required>
                    <br>
                    <label>Status</label>
                    <br>
                    <select name="status" id="stat">
                        <option value="" disabled selected hidden>Status:</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option><!-- JS query for other selection/user input -->
                    </select>
                    <br>
                    <div class="SpouseInfo" id="SpouseInfo_Section">
                        <label>Spouse</label>
                        <br>
                        <input type="text" name="s_lname" id="s_lname" placeholder="Last Name">
                        <b>,</b>
                        <input type="text" name="s_fname" id="s_fname" placeholder="First Name">
                        <input type="text" name="s_mname" id="s_mname" placeholder="Middle Initial ex. Reyes (optional)">
                        <br>
                        <label>Spouse Contact No.</label>
                        <br>
                        <input type="tel" name="s_contact" placeholder="Contact No.">
                        <br>
                    </div>
                    <p class="tag">Emergency Contact:</p>
                    <label>Name</label>
                    <br>
                    <input type="text" name="e_lname" id="E_lname" placeholder="Last Name" required>
                    <b>,</b>
                    <input type="text" name="e_fname" id="E_fname" placeholder="First Name" required>
                    <input type="text" name="e_mname" id="E_mname" placeholder="Middle Initial ex. Reyes (optional)">
                    <br>
                    <label>Contact No.</label>
                    <br>
                    <input type="tel" name="E_contact" placeholder="Contact No." required>
                    <br>
                    <select name="relation" id="rel">
                        <option value="" disabled selected hidden>Relationship:</option>
                        <option value="Mother">Mother</option>
                        <option value="Father">Father</option>
                        <option value="Husband">Husband</option>
                        <option value="Wife">Wife</option>
                        <option value="Other">Other:</option><!-- JS query for other selection/user input -->
                    </select>
                    <input type="text" id="otherInput" name="otherInput" placeholder="Enter Other Relation">
                    <br>
                    <br>
                <div class="btn">
                    <button type="submit" name="submitbtn" id="submitbtn" class="sign-btn done-btn">Submit</button>
                </div>
            </div>
        </div>
        </div>
        </div>
        </form>
        <script src="CoachFormScript.js"></script>
    </body>
</html>
