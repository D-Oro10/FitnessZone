// Declare the function globally
function handleButtonClick(memberID, currentStatus, button, userEmail) {
    if (currentStatus === 'unpaid') {
        const fetchURL = 'Updated_Members.php';
        console.log('Fetching:', fetchURL);

        fetch(fetchURL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                memberID: memberID,
                userEmail: userEmail,
                newStatus: 'paid'
            })
        })
        .then((response) => {
            console.log('Server Response:', response);

            if (!response.ok) {
                throw new Error('Failed to update payment status on the server: ' + response.statusText);
            }
            return response.json();
        })
        .then((data) => {
            if (data.success) {
                button.innerText = 'paid';
                console.log('User Email:', userEmail);
                console.log('Sending email:', 'MailHandler.php');

                // Now, you can perform the email sending logic here
                // Use data.memberID and userEmail as needed in your email sending logic

                console.log('Email sent successfully:', 'Email sent successfully');
            } else {
                console.error('Failed to update payment status on the server:', data.error);
            }
        })
        .catch((error) => {
            console.error('Error during AJAX request:', error);
        });
    }
}

// Remainder of your code inside the DOMContentLoaded event listener
document.addEventListener('DOMContentLoaded', function () {
    function fetchData() {
        var xhttp = new XMLHttpRequest();

        xhttp.open('GET', 'FetchRequest_Table.php', true);

        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById('tableContainer').innerHTML = this.responseText;
                addEventListenersToButtons();
            }
        };

        xhttp.send();
    }

    function addEventListenersToButtons() {
        var buttons = document.querySelectorAll('button[data-memberid]');
        buttons.forEach(function (button) {
            button.addEventListener('click', function () {
                var memberID = this.getAttribute('data-memberid');
                var currentStatus = this.getAttribute('data-status');
                var userEmail = this.getAttribute('data-email');
                handleButtonClick(memberID, currentStatus, this, userEmail);
            });
        });
    }

    fetchData();
});

