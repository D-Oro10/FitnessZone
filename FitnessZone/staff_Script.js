document.addEventListener('DOMContentLoaded', function () {
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

    function toggleCoachDiv() {
        var coachDiv = document.querySelector('.coach-div');
        var form = document.querySelector('.Coach');
        var cform = document.querySelector('.coach-form');
        coachDiv.style.display = 'none';
        cform.style.display = 'block';
        form.style.display = 'block';
    }

   function removeRecord(coachName, event) {
    // Ask for confirmation
    var confirmed = window.confirm('Are you sure you want to remove the coach: ' + coachName + '?');

    if (!confirmed) {
        event.preventDefault(); // Prevent the default behavior of the button
        return;
    }

    fetch('remove_staff.php', {
        method: 'POST',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded'
        },
        body: 'coachName=' + coachName
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        fetchData(); // Refresh the data after removing a record
    })
    .catch(error => {
        console.error('There was a problem with the remove operation:', error);
    })
    .finally(() => {
        event.stopPropagation(); // Stop event propagation
    });
}



    document.getElementById('showCoachButton').addEventListener('click', function () {
        console.log('Button clicked!');
        toggleCoachDiv();
        fetchData();
    });

    document.getElementById('tableContainer').addEventListener('click', function (event) {
        if (event.target.classList.contains('removeButton')) {
            console.log('Remove button clicked');
            var coachName = event.target.dataset.coachName;
            removeRecord(coachName, event);
        }
    });

    fetchData(); // Initial data fetch when the page loads
});
