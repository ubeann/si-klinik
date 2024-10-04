// Get references to the sign up button, sign in button, and the container element
const signUpButton = document.getElementById('signUp'); // Button for sign-up action
const signInButton = document.getElementById('signIn'); // Button for sign-in action
const container = document.getElementById('container'); // Container that holds the sign-up and sign-in forms

// Add an event listener to the sign-up button
signUpButton.addEventListener('click', () => {
    // When the sign-up button is clicked, add the 'right-panel-active' class to the container
    // This will likely trigger a CSS transition or animation to show the sign-up form
    container.classList.add('right-panel-active');
});

// Add an event listener to the sign-in button
signInButton.addEventListener('click', () => {
    // When the sign-in button is clicked, remove the 'right-panel-active' class from the container
    // This will likely reverse the transition or animation to show the sign-in form
    container.classList.remove('right-panel-active');
});
