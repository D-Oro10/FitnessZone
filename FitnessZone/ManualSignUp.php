
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Other/html.html to edit this template
-->
<html>
    <head>
        <link rel="stylesheet" href="ManualSignUp_Style.css" type="text/css"/>
        <link rel="icon" href="FitnessZoneLogo.jpg" type="image/x-icon"><!-- Must place credits on all the bg images used -->
        <title>Fitness Zone Registration</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <form action="ManualRegister.php" method="post">
        <div class ="Box">
        <div class ="Container">
            <div class="Form">
                <div class="head">
                <p><span class="g">G</span>YM <span class="m">M</span>EMBERSHIP <span class="m">R</span>EGISTRATION</p><!--Definitely need to fix this shit, I suck at designs -->
                </div>
                <div class="Section" id="Section">
                    <p class="tag">Personal Information:</p>
                    <label>Name</label>
                    <br>
                    <input type="text" name="m_lname" id="lname" placeholder="Last Name" required>
                    <b>,</b>
                    <input type="text" name="m_fname" id="fname" placeholder="First Name" required>
                    <input type="text" name="m_mname" id="mname" placeholder="Middle Initial ex. Reyes (optional)">
                    <br>
                    <label>Contact No.</label>
                    <br>
                    <input type="tel" name="M_contact" placeholder="Contact No."  required>
                    <br>
                    <label>Email</label>
                    <br>
                    <input type="email" name="M_Email" placeholder="Email"  required>
                    <br>
                    <label>Address</label>
                    <br>
                    <input type="text" name="homeadd" placeholder="Address" required>
                    <input type="text" name="Mcity" placeholder="City ex. Quezon" required>
                    <input type="number" name="Mpostcd" placeholder="Postal Code" required>
                    <br>
                    <label>Birth Date</label>
                    <br>
                    <input type="date" name="MBday" required>
                    <br><br>
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
                    <div class="btn">
                        <button class="sign-btn back-btn">Back</button>
                        <button class="sign-btn next-btn">Next</button>
                    </div>
                </div>
                <div class="Section2" id="Section2">
                    <p class="tag">Membership Details:</p>
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
                    <input type="text" name="username" id="user_nm" placeholder="Username" required><br>
                    <input type="password" name="userpassword" id="user_pass" placeholder="Password" required><br>
                    <label>Re-Enter Password</label>
                    <br>
                    <input type="password" name="confirm_pass" id="secure_pass" placeholder="Password" required><br><br><br> 
                </div> 
                <div class="btn2">
                    <button class="sign-btn2 back-btn2">Back</button><!-- why won't these two shits separate with a space in between???!  -->
                    <button class="sign-btn2 next-btn2">Next</button>
                </div>
                <br>
                <div class="Section3" id="Section3">
                
                </div>
                <div class="btn3">
                    <button class="sign-btn3 back-btn3">Back</button><!-- why won't these two shits separate with a space in between???!  -->
                    <button type="submit" name="submit" class="sign-btn3 done-btn3">Submit</button>
                </div>
            </div>
        </div>
        </div>
        </form>
        <script src="ManualSignUpScript.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    </body>
</html>
