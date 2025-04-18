
function validateSignupForm() {
   
    const name = document.getElementById('name').value.trim();
    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const isAdminYes = document.querySelector('input[name="is_admin"][value="yes"]').checked;
    const isAdminNo = document.querySelector('input[name="is_admin"][value="no"]').checked;

    
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; 
    const passwordMinLength = 8; 

    
    document.querySelectorAll('.sign-error').forEach((el) => el.remove());

    
    if (!name) {
        showError('Name is required.');
        return false;
    }


    if (!username) {
        showError('Username is required.');
        return false;
    }

   
    if (!email) {
        showError('Email is required.');
        return false;
    } else if (!emailRegex.test(email)) {
        showError('Please enter a valid email address.');
        return false;
    }

  
    if (!password) {
        showError('Password is required.');
        return false;
    } else if (password.length < passwordMinLength) {
        showError(`Password must be at least ${passwordMinLength} characters long.`);
        return false;
    }

    
    if (!isAdminYes && !isAdminNo) {
        showError('Please select whether you are an admin or not.');
        return false;
    }

  
    return true;
}


function showError(message) {
    const errorElement = document.createElement('p');
    errorElement.className = 'sign-error';
    errorElement.textContent = message;


    const form = document.querySelector('.sign-form');
    form.insertBefore(errorElement, form.firstChild);
}


document.addEventListener('DOMContentLoaded', () => {
    const signupForm = document.querySelector('.sign-form');
    if (signupForm) {
        signupForm.addEventListener('submit', (event) => {
            if (!validateSignupForm()) {
                event.preventDefault();
            }
        });
    }
});