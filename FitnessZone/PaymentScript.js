/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */


document.addEventListener('DOMContentLoaded', function () {
    function fetchData() {
        var xhttp = new XMLHttpRequest();

        xhttp.open('GET', 'Fetch_Payment.php', true);

        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById('tableContainer').innerHTML = this.responseText;
                addEventListenersToButtons();
            }
        };

        xhttp.send();
    }

    function addEventListenersToButtons() {
        var buttons = document.getElementsByClassName('payButton');

        Array.from(buttons).forEach(function (button) {
            button.addEventListener('click', function () {
                var paymentId = this.getAttribute('data-paymentid');

                // Make an asynchronous POST request to Update_PaymentStatus.php
                var updateXhttp = new XMLHttpRequest();
                updateXhttp.open('POST', 'Update_Payment.php', true);
                updateXhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                updateXhttp.onreadystatechange = function () {
                    if (this.readyState === 4 && this.status === 200) {
                        // Update the PaymentStatus in the table cell
                        document.getElementById('paymentStatus' + paymentId).innerHTML = 'paid';
                        button.disabled = true;
                        button.classList.add('disabledButton');
                    }
                };
                updateXhttp.send('paymentId=' + paymentId);
            });
        });
    }

    fetchData();
});

