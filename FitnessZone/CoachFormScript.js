/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/javascript.js to edit this template
 */
document.addEventListener('DOMContentLoaded', function () {
    const myForm = document.getElementById('myForm');
    const done = document.querySelector('.done-btn');

//Staff Info
    const staff_lname = document.getElementById('lname');
    const staff_fname = document.getElementById('fname');
    const staff_mname = document.getElementById('mname');
    
    const staff_Nname = document.getElementById('c_Nname');
    const staff_bday = document.querySelector('[name="C_Bday"]');
    const staff_homeAdd = document.querySelector('[name="homeadd"]');
    
    const staff_fb = document.querySelector('[name="FbLink"]');
    const staff_contact = document.querySelector('[name="c_contact"]');
    
    const staff_weight = document.querySelector('[name="weight"]');
    const staff_height = document.querySelector('[name="height"]');
    
    const staff_status = document.querySelector('[name="status"]');
    const status = document.getElementById('stat');
    const spouse_section = document.getElementById('SpouseInfo_Section');
    
    spouse_section.style.display= 'none';
    
//Spouse Info
    const spouse_lname = document.getElementById('s_lname');
    const spouse_fname = document.getElementById('s_fname');
    const spouse_mname = document.getElementById('s_mname');
    const spouse_contact = document.querySelector('[name="s_contact"]');
    
    
//Emergeny Contact Info
    const Econtact_lname = document.getElementById('E_lname');
    const Econtact_fname = document.getElementById('E_fname');
    const Econtact_mname = document.getElementById('E_mname');

    const Econtact_no = document.querySelector('[name="E_contact"]');

    const Econtact_rel = document.querySelector('[name="relation"]');
    const select = document.getElementById('rel');
    const relOther = document.getElementById('otherInput');
    

    
const invalid = document.querySelectorAll('.invalid-input');
document.addEventListener('focusin', removeInvalidClass);   
    
function removeInvalidClass(event) {
    const element = event.target;
    if (element.classList.contains('invalid-input')) {
        element.classList.remove('invalid-input');
    }
}
    
function validateName(input) {
    const name = /^[A-Za-z\s]+$/;
    return name.test(input);
}

//09123456789 -> test input, katamad manghula
function validateNo(input) {
    const mobileNo = /^(09|\+639)\d{9}$/; 
    return mobileNo.test(input);
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

function validateWeight(weight) {
    // Validate weight (positive number and within a reasonable range, e.g., 10 to 500 kg)
    const minWeight = 10;
    const maxWeight = 500;
    console.log('Input Weight:', weight);
    return !isNaN(weight) && weight > 0 && weight >= minWeight && weight <= maxWeight;
}

function validateHeight(height) {
    // Validate height (positive number and within a reasonable range, e.g., 50 to 300 cm)
    const minHeight = 50;
    const maxHeight = 300;
    console.log('Input Height:', height);
    return !isNaN(height) && height > 0 && height >= minHeight && height <= maxHeight;
}

function toggleCoachDiv() {
        var coachDiv = document.querySelector('.coach-div');
        var form = document.querySelector('.Coach');
        var cform = document.querySelector('.coach-form');
        coachDiv.style.display = 'block';
        cform.style.display = 'none';
        form.style.display = 'none';
        
    }

//https://www.facebook.com/fakeuser123 -> for tester
function validateFBLink(link) {
  // Facebook URL pattern
  const facebookUrlPattern = /^(https?:\/\/)?(www\.)?facebook\.com\/[a-zA-Z0-9.]{1,}$/;

  // Test the link against the FB pattern
  return facebookUrlPattern.test(link);
}

function resetOutlineColor(...fields) {
    fields.forEach(field => {
        console.log(field);  // Add this line
        field.classList.remove('invalid-input');
    });
}

function fetchData() {
        var xhttp = new XMLHttpRequest();

        xhttp.open('GET', 'fetch_staff.php', true);

        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById('tableContainer').innerHTML = this.responseText;
            }
        };

        xhttp.send();
    }

document.getElementById('stat').addEventListener('change', function() {
    if (status.value === 'Married') {
        spouse_section.style.display = 'block';
        spouse_lname.required = true;
        spouse_fname.required = true;
        spouse_contact.required = true;
    } else {
        spouse_section.style.display = 'none';
        spouse_section.value = ''; 
        spouse_section.classList.remove('invalid-input');
        
        spouse_lname.required = false;
        spouse_fname.required = false;
        spouse_contact.required = false;
        
        spouse_lname.value = '';
        spouse_fname.value = '';
        spouse_mname.value = '';
        spouse_contact.value = '';
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

 done.addEventListener('click', function () {
        event.preventDefault();

        const relValue = Econtact_rel.value;
        const spValue = staff_status.value;
        let valid = true;
        
        event.preventDefault();

        if(staff_lname.value === '' || !validateName(staff_lname.value) ||
           staff_fname.value === '' || !validateName(staff_fname.value) ||
           staff_Nname.value === '' || !validateName(staff_Nname.value) ||
           staff_bday.value === '' || staff_homeAdd === '' ||
           staff_fb.value === '' || !validateFBLink(staff_fb.value) ||
           staff_contact === '' || !validateNo(staff_contact.value) ||
           staff_weight === '' || !validateWeight(parseFloat(staff_weight.value)) ||
           staff_height === '' || !validateHeight(parseFloat(staff_height.value)) ||
           spValue === null || spValue === '' ||
           Econtact_lname.value === '' || !validateName(Econtact_lname.value) ||
           Econtact_fname.value === '' || !validateName(Econtact_fname.value) ||
           Econtact_no.value === '' || !validateNo(Econtact_no.value) ||
           relValue === null || relValue === '' ||
           (relValue === 'Other' && relOther.value === '')){
        
        
        //Personal Information
        if(staff_lname.value === '' || !validateName(staff_lname.value)){
            staff_lname.classList.add('invalid-input'); 
        }else {
            staff_lname.classList.remove('invalid-input');
        }
        
        if(staff_fname.value === '' || !validateName(staff_fname.value)){
            staff_fname.classList.add('invalid-input'); 
        }else {
            staff_fname.classList.remove('invalid-input');
        }
        
        if(staff_Nname.value === '' || !validateName(staff_Nname.value)){
            staff_Nname.classList.add('invalid-input'); 
        }else {
            staff_Nname.classList.remove('invalid-input');
        }
        
        if (staff_bday.value === ''){
            staff_bday.classList.add('invalid-input'); 
        }else {
            staff_bday.classList.remove('invalid-input');
        }
        
        if (staff_homeAdd.value === ''){
            staff_homeAdd.classList.add('invalid-input'); 
        }else {
            staff_homeAdd.classList.remove('invalid-input');
        }
        
        if (staff_fb.value === '' || !validateFBLink(staff_fb.value)){
            staff_fb.classList.add('invalid-input'); 
        }else {
            staff_fb.classList.remove('invalid-input');
        }
        
        if(staff_contact.value === '' || !validateNo(staff_contact.value)){
            staff_contact.classList.add('invalid-input'); 
        }else {
            staff_contact.classList.remove('invalid-input');
        }
        
        if(staff_weight.value === '' || !validateWeight(staff_weight.value)){
            staff_weight.classList.add('invalid-input'); 
        }else {
            staff_weight.classList.remove('invalid-input');
        }
        
        if(staff_height.value === '' || !validateHeight(staff_height.value)){
            staff_height.classList.add('invalid-input'); 
        }else {
            staff_height.classList.remove('invalid-input');
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
        
        if (spValue === null || spValue === ''){
            status.classList.add('invalid-input');
        }else {
            status.classList.remove('invalid-input');
        }
        
        if(spValue === 'Married'){
            console.log("spValue:", spValue);
            console.log("spouse_lname.value:", spouse_lname.value);
            
            if (spouse_lname.value === '' || !validateName(spouse_lname.value)){
                spouse_lname.classList.add('invalid-input');
            }else {
                spouse_lname.classList.remove('invalid-input');
            }
        
            if (spouse_fname.value === '' || !validateName(spouse_fname.value)){
                spouse_fname.classList.add('invalid-input');
            }else {
                spouse_fname.classList.remove('invalid-input');
            }
        
            if (spouse_contact.value === '' || !validateNo(spouse_contact.value)){
                spouse_contact.classList.add('invalid-input');
            }else {
                spouse_contact.classList.remove('invalid-input');
            }
            
            if(spouse_mname.value !== '' && !validateName(spouse_mname.value)){
                spouse_mname.classList.add('invalid-input');
            }else{
                spouse_mname.classList.remove('invalid-input');
            }
            
        }else{
            spouse_lname.classList.remove('invalid-input');
            spouse_fname.classList.remove('invalid-input');
            spouse_mname.classList.remove('invalid-input');
            spouse_contact.classList.remove('invalid-input');
        }
        
        
        if (relValue === 'Other'){
            if(relOther.value === '' || !validateRel(relOther.value)){
                relOther.classList.add('invalid-input');
            }else {
                relOther.classList.remove('invalid-input');
            }
        }
        
        if(staff_mname.value !== ''){
            if(!validateName(staff_mname.value)){
                staff_mname.classList.add('invalid-input');  
            }else{
                staff_mname.classList.remove('invalid-input');
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
       if (staff_mname.value !== '' || Econtact_mname.value !== '' || relValue === 'Other' ||
                !validateName(staff_mname.value) || !validateName(Econtact_mname.value) ||
                (spValue === 'Married' && spouse_lname.value === '') ||
                (spValue === 'Married' && spouse_fname.value === '') ||
                (spValue === 'Married' && (spouse_mname.value !== '' && !validateName(spouse_mname.value))) ||
                (spValue === 'Married' && (spouse_contact.value !== '' && !validateNo(spouse_contact.value)))) {

        if (spValue === 'Married' && spouse_lname.value === '') {
            spouse_lname.classList.add('invalid-input');
            valid = false;
        } else {
            spouse_lname.classList.remove('invalid-input');
        }
        
        if (spValue === 'Married' && spouse_fname.value === '') {
            spouse_fname.classList.add('invalid-input');
            valid = false;
        } else {
            spouse_fname.classList.remove('invalid-input');
        }
        
        if (spValue === 'Married' && (spouse_mname.value !== '' && !validateName(spouse_mname.value))) {
            spouse_mname.classList.add('invalid-input');
            valid = false;
        } else {
            spouse_mname.classList.remove('invalid-input');
        }
        
        if (spValue === 'Married' && (spouse_contact.value === '' || !validateNo(spouse_contact.value))){
                spouse_contact.classList.add('invalid-input');
                valid = false;
            }else {
                spouse_contact.classList.remove('invalid-input');
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

        if (valid) {
        resetOutlineColor(staff_lname, staff_fname, staff_contact, staff_homeAdd, staff_bday,
            Econtact_lname, Econtact_fname, Econtact_no, select, relOther, status);

        console.log("Correct And Complete credentials");
        const confirmation = window.confirm("Add new Coach?");

        if (confirmation) {
        $.ajax({
            type: 'POST',
            url: 'Register_Coach.php',
            data: $(myForm).serialize(),
            success: function (response) {
                console.log('AJAX success. Response:', response);
                if (response === 'success') {
                    alert('New Coach Successfully Added.');
                    toggleCoachDiv();
                    fetchData();
                    myForm.reset();
                } else if (response === 'Coach already exists!') {
                    alert('Coach is already recorded. Please use a different name.');
                    staff_lname.classList.add('invalid-input'); 
                    staff_fname.classList.add('invalid-input');
        
                    if(staff_mname.value !== ''){
                        staff_mname.classList.add('invalid-input');
                    } 
                    
                } else {
                    alert('An error occurred while processing your request.');
                    console.error('AJAX error. Response:', response);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('An error occurred while processing your request.');
                console.error('AJAX error. Status:', textStatus, 'Error:', errorThrown);
            }
        });
    } else {
        toggleCoachDiv();
        myForm.reset();
    }

    }}
});

    

});

