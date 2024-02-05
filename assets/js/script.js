// JavaScript to dynamically enable/disable the "Team Option" and "Team Name" fields based on the selected option and role
document.addEventListener('DOMContentLoaded', function () {
    const teamOptionNA = document.getElementById('teamOptionNA');
    const teamOptionYes = document.getElementById('teamOptionYes');
    const teamNameField = document.getElementById('teamName');
    const roleSelect = document.getElementById('role');

    function validateForm() {
        // Get input values

        var firstNameInput = document.getElementById('firstName').value;
        // Validate First Name
        if (firstNameInput.trim() === '') {
            document.getElementById('error-message').innerHTML = 'First Name is required.';
            return false;
        }

        var lastNameInput = document.getElementById('lastName').value;
        // Validate Last Name
        if (lastNameInput.trim() === '') {
            document.getElementById('error-message').innerHTML = 'Last Name is required.';
            return false;
        }

        // Validate Date of Birth
        if (dobInput.trim() === '') {
            document.getElementById('dobError').innerHTML = 'Date of Birth is required.';
            return false;
        }
        
        // Validate age greater than 18
        var today = new Date();
        var birthDate = new Date(dobInput);
        var age = today.getFullYear() - birthDate.getFullYear();

        if (age < 18) {
            document.getElementById('dobError').innerHTML = 'Age must be greater than 18.';
            return false;
        }

        // Validate Email using regex
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailInput)) {
            document.getElementById('error-message').innerHTML = 'Invalid email address.';
            return false;
        }
        
        // Password validation regex
        var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/;
        var passwordInput = document.getElementById('password').value;
        if (!passwordRegex.test(passwordInput)) {
            document.getElementById('error-message').innerHTML = 'Password should be between 8 to 15 characters and contain at least one uppercase letter, one lowercase letter, one special character, and one digit.';
            return false;
        }

        return true;
    }

    function updateTeamFields() {
        const isUmpire = roleSelect.value === 'umpire';
        teamOptionNA.disabled = isUmpire;
        teamOptionYes.disabled = isUmpire;
        teamNameField.disabled = isUmpire || (teamOptionNA.checked && !teamOptionNA.disabled);
    }

    // Initial update
    updateTeamFields();

    // Event listeners for changes in team option and role
    teamOptionNA.addEventListener('change', updateTeamFields);
    teamOptionYes.addEventListener('change', updateTeamFields);
    roleSelect.addEventListener('change', updateTeamFields);
});