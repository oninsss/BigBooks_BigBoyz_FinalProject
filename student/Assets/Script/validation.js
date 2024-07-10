document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded');
    // Select modal elements and date inputs
    var modals = document.querySelectorAll('.modal');
    var startDateInputs = document.querySelectorAll('.modal input#start_date');
    var endDateInputs = document.querySelectorAll('.modal input#end_date');

    // Function to show alert in modal
    function showAlert(modal, message) {
        console.log('showAlert');
        var modalBody = modal.querySelector('.modal-body');
        var alertMessage = '<div class="alert alert-danger" role="alert">' + message + '</div>';
        modalBody.insertAdjacentHTML('beforeend', alertMessage);
        disableConfirmButton(modal, true);
    }

    // Function to remove alert from modal
    function removeAlert(modal) {
        console.log('removeAlert');
        var modalBody = modal.querySelector('.modal-body');
        var alert = modalBody.querySelector('.alert');
        if (alert) {
            modalBody.removeChild(alert);
        }
        disableConfirmButton(modal, false);
    }

    // Function to disable or enable the Confirm button
    function disableConfirmButton(modal, disable) {
        var confirmButton = modal.querySelector('#confirmButton');
        confirmButton.disabled = disable;
    }

    // Function to check if the end date precedes the start date
    function checkDateOrder(startInput, endInput, modal) {
        console.log('checkDateOrder');
        var startDate = new Date(startInput.value);
        var endDate = new Date(endInput.value);

        if (endDate < startDate) {
            console.log('tamangcheckDateOrder');
            return true;
        } else {
            removeAlert(modal); // Remove alert if dates are valid
            return false;
        }
    }

    // Function to check date difference and show/remove alert
    function checkDateDifference(startInput, endInput, modal) {
        console.log('checkDateDifference');
        var startDate = new Date(startInput.value);
        var endDate = new Date(endInput.value);

        // Calculate difference in milliseconds
        var difference = endDate.getTime() - startDate.getTime();
        var daysDifference = Math.floor(difference / (1000 * 60 * 60 * 24));

        // Show alert if difference is more than 7 days
        if (daysDifference > 7) {
            console.log('tamangcheckDateDifference');
            return true;
        } else {
            removeAlert(modal); // Remove alert if dates are valid
            return false;
        }
    }

    // Function to check if start date and end date are in the past
    function checkDates(startInput, endInput, modal) {
        console.log('checkDates');
        var startDate = new Date(startInput.value);
        var endDate = new Date(endInput.value);

        // Check if either start date or end date is in the past
        var today = new Date(); //make sure that it gets the day today
        startDate.setHours(0, 0, 0, 0);
        endDate.setHours(0, 0, 0, 0);
        today.setHours(0, 0, 0, 0);

        if (startDate < today || endDate < today) {
            console.log('checkDates');
            return true;
        } else {
            removeAlert(modal); // Remove alert if dates are valid
            return false;
        }
    }

    // Event listeners for date inputs change
    startDateInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            console.log('change');
            var modal = input.closest('.modal');
            removeAlert(modal);
            var endInput = modal.querySelector('input#end_date');
            if (endInput.value) {
                var a = checkDateDifference(input, endInput, modal);
                var b = checkDates(input, endInput, modal);
                var c = checkDateOrder(input, endInput, modal);

                if (a || b || c) {
                    if (a) {
                        removeAlert(modal);
                        showAlert(modal, 'The difference between the start date and end date should not be more than 7 days.');
                    }
                    if (b) {
                        removeAlert(modal);
                        showAlert(modal, 'The start date or end date should not be in the past.');
                    }
                    if (c) {
                        removeAlert(modal);
                        showAlert(modal, 'The end date should not precede the start date.');
                    }
                } else if (a && b) {
                    removeAlert(modal);
                    showAlert(modal, 'The difference between the start date and end date should not be more than 7 days.');
                    showAlert(modal, 'The start date or end date should not be in the past.');
                } else if (a && c) {
                    removeAlert(modal);
                    showAlert(modal, 'The difference between the start date and end date should not be more than 7 days.');
                    showAlert(modal, 'The end date should not precede the start date.');
                } else if (b && c) {
                    removeAlert(modal);
                    showAlert(modal, 'The start date or end date should not be in the past.');
                    showAlert(modal, 'The end date should not precede the start date.');
                } else {
                    removeAlert(modal);
                }
            } else {
                removeAlert(modal); // Remove alert if end date is empty
            }
        });
    });

    endDateInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            console.log('change');
            var modal = input.closest('.modal');
            removeAlert(modal);
            var startInput = modal.querySelector('input#start_date');
            if (startInput.value) {
                var a = checkDateDifference(startInput, input, modal);
                var b = checkDates(startInput, input, modal);
                var c = checkDateOrder(startInput, input, modal);

                if (a || b || c) {
                    if (a) {
                        showAlert(modal, 'The difference between the start date and end date should not be more than 7 days.');
                    }
                    if (b) {
                        showAlert(modal, 'The start date or end date should not be in the past.');
                    }
                    if (c) {
                        showAlert(modal, 'The end date should not precede the start date.');
                    }
                } else if (a && b) {
                    showAlert(modal, 'The difference between the start date and end date should not be more than 7 days.');
                    showAlert(modal, 'The start date or end date should not be in the past.');
                } else if (a && c) {
                    showAlert(modal, 'The difference between the start date and end date should not be more than 7 days.');
                    showAlert(modal, 'The end date should not precede the start date.');
                } else if (b && c) {
                    showAlert(modal, 'The start date or end date should not be in the past.');
                    showAlert(modal, 'The end date should not precede the start date.');
                } else {
                    removeAlert(modal);
                }
            } else {
                removeAlert(modal); // Remove alert if start date is empty
            }
        });
    });
});
