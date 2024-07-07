/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/javascript.js to edit this template
 */

document.addEventListener('DOMContentLoaded', function (){
//Section 1: Personal Information & Emergency Contact
const mTypeSelect = document.getElementById('M_type');
const payTypeSelect = document.getElementById('p_type');
const payTypeWrap = document.getElementById('p_typebox');
const next = document.querySelector('.next-btn');
const back = document.querySelector('.back-btn');

//Section 1: Input

//Member Name:
const user_lname = document.getElementById('lname');
const user_fname = document.getElementById('fname');
const user_mname = document.getElementById('mname');

//Contact No.
const user_contact = document.querySelector('[name="M_contact"]');

//Email
const user_email = document.querySelector('[name="M_Email"]');

//Address:
const user_homeAdd = document.querySelector('[name="homeadd"]');
const user_city = document.querySelector('[name="Mcity"]');
const user_cd = document.querySelector('[name="Mpostcd"]');

//Birthday:
const user_bday = document.querySelector('[name="MBday"]');

//Section2: Membership Details
const next2 = document.querySelector('.next-btn2');
const back2 = document.querySelector('.back-btn2');
const btn2 = document.querySelector('.btn2');

//Emergency Contact Name:
const Econtact_lname = document.getElementById('E_lname');
const Econtact_fname = document.getElementById('E_fname');
const Econtact_mname = document.getElementById('E_mname');

//Emergency Contact No.
const Econtact_no = document.querySelector('[name="E_contact"]');

//Emergency Contact Relationship:
const Econtact_rel = document.querySelector('[name="relation"]');
const select = document.getElementById('rel');
const relOther = document.getElementById('otherInput');

//Section 3: Finalization
const final_panel = document.getElementById('Section3');
const done3 = document.querySelector('.done-btn3');
const back3 = document.querySelector('.back-btn3');
const btn3 = document.querySelector('.btn3');

//Section Panels
const m_personalInfo = document.querySelector('.Section');
const memberInfo = document.querySelector('.Section2');
const header = document.querySelector('.head');

memberInfo.style.display = 'none';

const invalid = document.querySelectorAll('.invalid-input');
document.addEventListener('focusin', removeInvalidClass);

//Log In Credentials
const user_name = document.querySelector('[name="username"]');
const user_pass = document.querySelector('[name="userpassword"]'); 
const secure_pass = document.querySelector('[name="confirm_pass"]');

function validateName(input) {
    const name = /^[A-Za-z\s]+$/;
    return name.test(input);
}

//09123456789 -> test input, katamad manghula
function validateNo(input) {
    const mobileNo = /^(09|\+639)\d{9}$/; 
    return mobileNo.test(input);
}

function validateEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

function validateCity(city){
    const City = /^[A-Za-z]+$/;
    return City.test(city);
}

function validatePCode(postalCode) {
    const postalCd = /^[0-9]{4}$/; 
    return postalCd.test(postalCode);
}

function validateRel(input) {
    const name = /^[A-Za-z]+$/;
    return name.test(input);
}

function resetOutlineColor(...fields) {
    fields.forEach(field => {
        console.log(field);  // Add this line
        field.classList.remove('invalid-input');
    });
}


back2.addEventListener('click', function() {
    mTypeSelect.value = '';
    payTypeSelect.value = '';
    document.querySelector('[name="username"]').value = '';
    document.querySelector('[name="userpassword"]').value = '';
    document.querySelector('[name="confirm_pass"]').value = '';
    
    m_personalInfo.style.display = 'block';
    memberInfo.style.display = 'none';
    btn2.style.display = 'none';
    payTypeWrap.style.display = 'none';
    back.classList.remove('active');
});

next.addEventListener('click', function() { //Good luck guys, medj nakakahilo toh
    const relValue = Econtact_rel.value;
    let valid = true;
    

    if(user_lname.value === '' || !validateName(user_lname.value) ||
       user_fname.value === '' || !validateName(user_fname.value) ||
       user_contact.value === '' || !validateNo(user_contact.value) ||
       user_email.value === '' || !validateEmail(user_email.value) ||
       user_homeAdd.value === '' || user_bday.value === '' ||
       user_city.value === '' || !validateCity(user_city.value) ||
       user_cd.value === '' || !validatePCode(user_cd.value) ||
       Econtact_lname.value === '' || !validateName(Econtact_lname.value) ||
       Econtact_fname.value === '' || !validateName(Econtact_fname.value) ||
       Econtact_no.value === '' || !validateNo(Econtact_no.value) ||
       relValue === null || relValue === '' ||
       (relValue === 'Other' && relOther.value === '')){
   
        //Personal Information
        if(user_lname.value === '' || !validateName(user_lname.value)){
            user_lname.classList.add('invalid-input'); 
        }else {
            user_lname.classList.remove('invalid-input');
        }
        
        if(user_fname.value === '' || !validateName(user_fname.value)){
            user_fname.classList.add('invalid-input'); 
        }else {
            user_fname.classList.remove('invalid-input');
        }
        
        if(user_contact.value === '' || !validateNo(user_contact.value)){
            user_contact.classList.add('invalid-input'); 
        }else {
            user_contact.classList.remove('invalid-input');
        }
        
        if(user_email.value === '' || !validateEmail(user_email.value)){
            user_email.classList.add('invalid-input'); 
        }else {
            user_email.classList.remove('invalid-input');
        }
        
        if (user_homeAdd.value === ''){
            user_homeAdd.classList.add('invalid-input'); 
        }else {
            user_homeAdd.classList.remove('invalid-input');
        }
        
        if (user_bday.value === ''){
            user_bday.classList.add('invalid-input'); 
        }else {
            user_bday.classList.remove('invalid-input');
        }
        
        if (user_city.value === '' || !validateCity(user_city.value)){
            user_city.classList.add('invalid-input');
        }else {
            user_city.classList.remove('invalid-input');
        }
        
        if (user_cd.value === '' || !validatePCode(user_cd.value)){
            user_cd.classList.add('invalid-input');
        }else {
            user_cd.classList.remove('invalid-input');
        }
        
        //Emergency Contact Information
        if (Econtact_lname.value === '' || !validateName(Econtact_lname.value)){
            Econtact_lname.classList.add('invalid-input');
        }else {
            Econtact_lname.classList.remove('invalid-input');
        }
        
        if (Econtact_fname.value === '' || !validateName(Econtact_fname.value)){
            Econtact_fname.classList.add('invalid-input');
        }else {
            Econtact_fname.classList.remove('invalid-input');
        }
        
        if (Econtact_no.value === '' || !validateNo(Econtact_no.value)){
            Econtact_no.classList.add('invalid-input');
        }else {
            Econtact_no.classList.remove('invalid-input');
        }
        
        if (relValue === null || relValue === ''){
            select.classList.add('invalid-input');
        }else {
            select.classList.remove('invalid-input');
        }
        
        if (relValue === 'Other'){
            if(relOther.value === '' || !validateRel(relOther.value)){
                relOther.classList.add('invalid-input');
            }else {
                relOther.classList.remove('invalid-input');
            }
        }
        
        if(user_mname.value !== ''){
            if(!validateName(user_mname.value)){
                user_mname.classList.add('invalid-input');  
            }else{
                user_mname.classList.remove('invalid-input');
            }
        }
        
        if(Econtact_mname.value !== ''){
            if(!validateName(Econtact_mname.value)){
                Econtact_mname.classList.add('invalid-input');  
            }else{
                Econtact_mname.classList.remove('invalid-input');
            }
        }
        
        console.log("Incomplete credentials");
         
    }else{
        if (user_mname.value !== '' || Econtact_mname.value !== '' || relValue === 'Other') {

        if (user_mname.value !== '' && !validateName(user_mname.value)) {
            user_mname.classList.add('invalid-input');
            valid = false;
        } else {
            user_mname.classList.remove('invalid-input');
        }

        if (Econtact_mname.value !== '' && !validateName(Econtact_mname.value)) {
            Econtact_mname.classList.add('invalid-input');
            valid = false;
        } else {
            Econtact_mname.classList.remove('invalid-input');
        }

        if (relValue === 'Other') {
            if (relOther.value === '' || !validateRel(relOther.value)) {
                relOther.classList.add('invalid-input');
                valid = false;
            } else {
                relOther.classList.remove('invalid-input');
            }
        }
    } else {
        valid = true;
}

        $.ajax({
            type: 'POST',
            url: 'ManualMemberVerifier.php',
            data: {
                m_lname: user_lname.value,
                m_fname: user_fname.value,
                m_mname: user_mname.value,
                M_Email: user_email.value
            },
        success: function (response) {
    console.log('AJAX success. Response:', response);
    if (response === 'exists') {
        user_email.classList.add('invalid-input'); 
        user_fname.classList.add('invalid-input');  
        user_lname.classList.add('invalid-input');
        
        if(user_mname.value !== ''){
            user_mname.classList.add('invalid-input');
        }
        alert('User or Email already exists. Please check your information.');
        valid = false;
        
    }

    // Final Condition to proceed to the next section
    if (valid) {
        resetOutlineColor(user_lname, user_fname, user_contact, user_homeAdd, user_city, user_cd, user_bday,
            Econtact_lname, Econtact_fname, Econtact_no, select, relOther);

        m_personalInfo.style.display = 'none';
        memberInfo.style.display = 'block';
        btn2.style.display = 'block';
    }
},
    error: function () {
        console.log('AJAX error');
        alert('Error connecting to MemberVerifier.php');
    }
});
            
    }
});


document.getElementById('rel').addEventListener('change', function() {
    if (select.value === 'Other') {
        relOther.style.display = 'block';
    } else {
        relOther.style.display = 'none';
        relOther.value = ''; 
        relOther.classList.remove('invalid-input');
    }
});


payTypeWrap.style.display = 'none';

mTypeSelect.addEventListener('change', function() {
    if (mTypeSelect.value !== '') {
        payTypeWrap.style.display = 'block';
    } else {
        payTypeWrap.style.display = 'none';
    }
});

payTypeSelect.disabled = true;

mTypeSelect.addEventListener('change', function() {
    if (mTypeSelect.value !== '') {
        payTypeSelect.disabled = false;
    } else {
        payTypeSelect.disabled = true;
    }
});

mTypeSelect.addEventListener('change', function() {
    payTypeSelect.innerHTML = '';
    
    if (mTypeSelect.value === 'Student') {
        addOptions(['Daily', 'Monthly', '3 Months']);
    } else if (mTypeSelect.value === 'Member') {
        addOptions(['Daily', 'Monthly', '3 Months', 'Annual']);
    }
});

function OptionTip(value, type) {
    if(type === 'Student'){
        switch (value){
            case 'Daily':
                return '60';
            case 'Monthly':
                return '850';
            case '3 Months':
                return '2000';
            default:
                return '';
        }
    }else{
        switch (value) {
            case 'Daily':
                return '80';
            case 'Monthly':
                return '1000';
            case '3 Months':
                return '2500';
            case 'Annual':
                return '8000';
            default:
                return '';
        }
    }
}

function addOptions(values) {
    console.log('Adding options:', values);
    values.forEach(value => {
        const option = document.createElement('option');
        option.value = value;
        option.textContent = value;
        option.title = OptionTip(value, mTypeSelect.value);
        payTypeSelect.appendChild(option);
    });
}

invalid.forEach(input => {
    input.addEventListener('input', function() {
        this.classList.remove('invalid-input');
    });
});


function removeInvalidClass(event) {
    const element = event.target;
    if (element.classList.contains('invalid-input')) {
        element.classList.remove('invalid-input');
    }
}



/*document.addEventListener('DOMContentLoaded', function () {
    var nextButton = document.querySelector('.next-btn2');
    nextButton.addEventListener('click', displayPersonalInfo);
});*/

function displayPersonalInfo() {
    //Personal Information section
    var lastName = document.getElementById('lname').value;
    var firstName = document.getElementById('fname').value;
    var middleInitial = document.getElementById('mname').value;
    var contactNo = document.querySelector('[name="M_contact"]').value;
    var address = document.querySelector('[name="homeadd"]').value;
    var city = document.querySelector('[name="Mcity"]').value;
    var postalCode = document.querySelector('[name="Mpostcd"]').value;
    var birthDate = document.querySelector('[name="MBday"]').value;
    
    //Emergency Contact Information Section
    var ELastName = document.getElementById('E_lname').value;
    var EFirstName = document.getElementById('E_fname').value;
    var EMiddleName = document.getElementById('E_mname').value;
    var EContactNo = document.querySelector('[name="E_contact"]').value;
    var ERelation = document.querySelector('[name="relation"]').value;
    var otherRelationValue = (ERelation === 'Other') ? document.getElementById('otherInput').value : '';
    
    //Membership Info
    var membershipType = mTypeSelect.value;
    var paymentType = payTypeSelect.value;

    var content = "<p class='tag'>Personal Information:</p><br>";
    content += "<p class='lbl'>Name:</p> <p class='info'>" + firstName + " " + middleInitial + " " + lastName + "</p><br>";
    content += "<p class='lbl'>Contact No.: </p> <p class='info'>" + contactNo + "</p><br>";
    content += "<p class='lbl'>Address: </p> <p class='info'>" + address + ", " + city + ", " + postalCode + "</p><br>";
    content += "<p class='lbl'>Birth Date: </p> <p class='info'>" + birthDate + "</p><br><br>";
    content += "<p class='tag'>Emergency Contact Information:</p><br>";
    content += "<p class='lbl'>Name:</p> <p class='info'>" + EFirstName + " " + EMiddleName + " " + ELastName + "</p><br>";
    content += "<p class='lbl'>Contact No.: </p> <p class='info'>" + EContactNo + "</p><br>";
    
    if(ERelation === 'Other'){
        content += "<p class='lbl'>Relationship: </p> <p class='info'>" + otherRelationValue + "</p><br><br>";
    }else{
        content += "<p class='lbl'>Relationship: </p> <p class='info'>" + ERelation  + "</p><br><br>";
    }
    
    content += "<p class='tag'>Membership Information:</p><br>";
    content += "<p class='lbl'>Membership Type: </p> <p class='info'>" + membershipType + "</p><br>";
    content += "<p class='lbl'>Payment Type: </p> <p class='info'>" + paymentType + "</p><br><br><br><br>";
    
    var section3 = document.getElementById('Section3');
    section3.innerHTML = content;
}

next2.addEventListener('click', function(event) {
    const membershipType = mTypeSelect.value;
    const paymentType = payTypeSelect.value;
    const userName = document.querySelector('[name="username"]').value;
    const userPassword = document.querySelector('[name="userpassword"]').value; 
    const securePass = document.querySelector('[name="confirm_pass"]').value;
   

    // Check if any field is empty
    if (membershipType === '' || paymentType === '' || userName === '' || userPassword === '' || securePass === '') {
        if(membershipType === ''){
            mTypeSelect.classList.add('invalid-input'); 
        }else {
            mTypeSelect.classList.remove('invalid-input');
        }
        
        if(paymentType === ''){
            payTypeSelect.classList.add('invalid-input'); 
        }else {
            payTypeSelect.classList.remove('invalid-input');
        }
        
        if(userName === ''){
            document.querySelector('[name="username"]').classList.add('invalid-input');
        }else {
            document.querySelector('[name="username"]').classList.remove('invalid-input');
        }

        if(userPassword === ''){
            document.querySelector('[name="userpassword"]').classList.add('invalid-input'); 
        }else {
            document.querySelector('[name="userpassword"]').classList.remove('invalid-input');
        }

        if(securePass === ''){
            document.querySelector('[name="confirm_pass"]').classList.add('invalid-input');
        }else {
            document.querySelector('[name="confirm_pass"]').classList.remove('invalid-input');
        }
        
        event.preventDefault();
        return;
    }
    
    if (securePass !== userPassword) {
        document.querySelector('[name="confirm_pass"]').classList.add('invalid-input'); 
        event.preventDefault();
        return;
    } else {
        document.querySelector('[name="confirm_pass"]').classList.remove('invalid-input');
    }
    
    resetOutlineColor(mTypeSelect, payTypeSelect, document.querySelector('[name="username"]'), 
    document.querySelector('[name="userpassword"]'), 
    document.querySelector('[name="confirm_pass"]'));
    btn2.style.display = 'none';
    m_personalInfo.style.display = 'none';
    memberInfo.style.display = 'none';
    btn3.style.display = 'block';
    final_panel.style.display = 'block';
    header.style.display = 'none';
    displayPersonalInfo();   
});

back3.addEventListener('click', function(){
    final_panel.innerHTML = '';
    header.style.display = 'block';
    memberInfo.style.display = 'block';
    btn2.style.display = 'block';
    final_panel.style.display = 'none';
    btn3.style.display = 'none';
});

});