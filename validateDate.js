function validateDate() {
    var birthDateInput = document.getElementById('birth_date');
    var birthDateValue = birthDateInput.value;

    if (!birthDateValue) {
        alert('Please enter a valid date of birth.');
        return false;
    }

    var currentDate = new Date();
    var selectedDate = new Date(birthDateValue);

    // Check if the selected date is in the future
    if (selectedDate > currentDate) {
        alert('Please select a date of birth that is not in the future.');
        birthDateInput.value = ''; // Clear the invalid date
        return false;
    }

    // Check if the selected date is at least 4 years ago
    var fourYearsAgo = new Date();
    fourYearsAgo.setFullYear(currentDate.getFullYear() - 4);

    if (selectedDate > fourYearsAgo) {
        alert('Please select a date of birth that is at least 4 years ago.');
        return false;
    }

    return true;
}
