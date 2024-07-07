/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/javascript.js to edit this template
 */

document.addEventListener('DOMContentLoaded', function () {
    
const UpdateForm = document.getElementById('myForm');
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

//Emergency Contact Name:
const Econtact_name = document.getElementById('E_Name');

//Emergency Contact No.
const Econtact_no = document.querySelector('[name="E_contact"]');

//Relation
const Econtact_rel = document.querySelector('[name="relation"]');
const select = document.getElementById('rel');
const relOther = document.getElementById('otherInput');
    
//Membership Details
const mTypeSelect = document.getElementById('M_type');
const payTypeSelect = document.getElementById('p_type');
const payTypeWrap = document.getElementById('p_typebox');

const done = document.getElementById('update');

//const urlParams = new URLSearchParams(window.location.search);
const memberID = document.getElementById('memberID').value;
 // urlParams.get('memberID');
    
    
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
// Fetch data from the server using memberID
    fetch(`Fetch_MemberInfo.php?memberID=${memberID}`)
        .then(response => response.json())
        .then(data => {
            // Log the retrieved data to the console for debugging
            console.log(data);

            // Fill the form fields with data from the database
            fillFormFields(data);
        })
        .catch(error => console.error('Error:', error));

    function fillFormFields(data) {

        function setValueById(elementId, value, readOnly = false) {
        const element = document.getElementById(elementId);
        if (element) {
            element.value = value;
            element.readOnly = readOnly;
        } else {
            console.error(`Element with ID '${elementId}' not found.`);
        }
    }

    setValueById('M_name', data.MemberName, true);//read_only
    setValueById('M_contact', data.ContactNo);
    setValueById('homeadd', data.Address);
    setValueById('Mcity', data.City);
    setValueById('Mpostcd', data.PostCode);
    setValueById('MBday', data.Birthdate);
    setValueById('E_Name', data.EContactPerson);
    setValueById('E_contact', data.EContactNo);


        // Set 'rel' (Relationship) and 'otherInput' based on data.RTC
        const relSelect = document.getElementById('rel');
        const otherInput = document.getElementById('otherInput');
        if (relSelect && otherInput) {
            const rtcValue = data.RTC;
            const rtcOption = Array.from(relSelect.options).find(option => option.value === rtcValue);

            if (rtcOption) {
                // RTC value is among the choices in 'rel'
                setValueById('rel', rtcValue);
                otherInput.value = '';
                relOther.style.display = 'none';
            } else {
                // RTC value does not exist in 'rel' choices
                setValueById('rel', 'Other');
                otherInput.value = rtcValue;
                relOther.style.display = 'block';
            }
        }

        if (mTypeSelect) {
            if (data.MembershipCode === 'M') {
                setValueById('M_type', 'Member');
            } else if (data.MembershipCode === 'S') {
                setValueById('M_type', 'Student');
            }
        }

        payTypeWrap.style.display = 'none';
        payTypeSelect.disabled = true;
        payTypeSelect.innerHTML = '';

        if (mTypeSelect.value === 'Student') {
            addOptions(['Daily', 'Monthly', '3 Months']);
        } else if (mTypeSelect.value === 'Member') {
            addOptions(['Daily', 'Monthly', '3 Months', 'Annual']);
        }

        if (mTypeSelect.value !== '') {
            payTypeWrap.style.display = 'block';
            payTypeSelect.disabled = false;
        }
        payTypeSelect.value = data.FeeInterval;
    } //fetch

//Update Validator
    mTypeSelect.addEventListener('change', function () {
        if (mTypeSelect.value !== '') {
            payTypeWrap.style.display = 'block';
            payTypeSelect.disabled = false;
        } else {
            payTypeWrap.style.display = 'none';
            payTypeSelect.disabled = true;
        }

        payTypeSelect.innerHTML = '';

        if (mTypeSelect.value === 'Student') {
            addOptions(['Daily', 'Monthly', '3 Months']);
        } else if (mTypeSelect.value === 'Member') {
            addOptions(['Daily', 'Monthly', '3 Months', 'Annual']);
        }
    });

    // 'change' event listener for relSelect
    document.getElementById('rel').addEventListener('change', function () {
        if (select.value === 'Other') {
            console.log('Displaying relOther');
            relOther.style.display = 'block';
        } else {
            console.log('Hiding relOther');
            relOther.style.display = 'none';
            relOther.value = '';
            relOther.classList.remove('invalid-input');
        }
    });

    // 'change' event listener for mTypeSelect (payTypeSelect is disabled initially)
    mTypeSelect.addEventListener('change', function () {
        payTypeSelect.innerHTML = '';

        if (mTypeSelect.value === 'Student') {
            addOptions(['Daily', 'Monthly', '3 Months']);
        } else if (mTypeSelect.value === 'Member') {
            addOptions(['Daily', 'Monthly', '3 Months', 'Annual']);
        }
    });

    function OptionTip(value, type) {
        if (type === 'Student') {
            switch (value) {
                case 'Daily':
                    return '60';
                case 'Monthly':
                    return '850';
                case '3 Months':
                    return '2000';
                default:
                    return '';
            }
        } else {
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
    
done.addEventListener('click', function() { //Good luck guys, medj nakakahilo toh
    const relValue = Econtact_rel.value;
    let valid = true;
    
    event.preventDefault();
    
    if(user_contact.value === '' || !validateNo(user_contact.value) ||
       user_email.value === '' || !validateEmail(user_email.value) ||
       user_homeAdd.value === '' || user_bday.value === '' ||
       user_city.value === '' || !validateCity(user_city.value) ||
       user_cd.value === '' || !validatePCode(user_cd.value) ||
       Econtact_name.value === '' || !validateName(Econtact_name.value) ||
       Econtact_no.value === '' || !validateNo(Econtact_no.value) ||
       relValue === null || relValue === '' ||
       (relValue === 'Other' && relOther.value === '')){
        //Personal Information
        
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
        if (Econtact_name.value === '' || !validateName(Econtact_name.value)){
            Econtact_name.classList.add('invalid-input');
        }else {
            Econtact_name.classList.remove('invalid-input');
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
        
        
        console.log("Incomplete credentials");
         
    }else{
        if (relValue === 'Other' && (relOther.value === '' || !validateRel(relOther.value))) {
            if (relOther.value === '' || !validateRel(relOther.value)) {
                relOther.classList.add('invalid-input');
                valid = false;
            } else {
                relOther.classList.remove('invalid-input');
            }
        }else {
            valid = true;
    }
        

// Final Condition to proceed to the next section
if (valid) {
    resetOutlineColor(user_contact, user_email, user_homeAdd, user_city, user_cd, user_bday,
    Econtact_name,Econtact_no, select, relOther);
    
    console.log("Correct And Complete credentials");
    const confirmation = window.confirm("Are you sure you want to update your information?");
            
            if (confirmation) {
                resetOutlineColor(user_contact, user_homeAdd, user_city, user_cd, user_bday,
                    Econtact_name, Econtact_no, select, relOther);
                console.log("Correct And Complete credentials");
                UpdateForm.submit();
            } else {
                console.log("Update canceled by the user");
            }
}

            
    }
});
   
    
    
});
