/**
 * SweetAlert2 Toast Notifications
 * 
 * This file contains functions for displaying toast notifications using SweetAlert2
 * for create, update, and delete operations in the admin panel.
 */

// Configure default toast settings
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

/**
 * Show a success toast notification
 * @param {string} message - The message to display
 */
function showSuccessToast(message) {
    Toast.fire({
        icon: 'success',
        title: message
    });
}

/**
 * Show an error toast notification
 * @param {string} message - The message to display
 */
function showErrorToast(message) {
    Toast.fire({
        icon: 'error',
        title: message
    });
}

/**
 * Show a warning toast notification
 * @param {string} message - The message to display
 */
function showWarningToast(message) {
    Toast.fire({
        icon: 'warning',
        title: message
    });
}

/**
 * Show an info toast notification
 * @param {string} message - The message to display
 */
function showInfoToast(message) {
    Toast.fire({
        icon: 'info',
        title: message
    });
}

/**
 * Display toast notifications based on session flash messages
 */
function displayFlashMessages() {
    // Check for success message
    if (typeof successMessage !== 'undefined' && successMessage) {
        showSuccessToast(successMessage);
    }
    
    // Check for error message
    if (typeof errorMessage !== 'undefined' && errorMessage) {
        showErrorToast(errorMessage);
    }
    
    // Check for warning message
    if (typeof warningMessage !== 'undefined' && warningMessage) {
        showWarningToast(warningMessage);
    }
    
    // Check for info message
    if (typeof infoMessage !== 'undefined' && infoMessage) {
        showInfoToast(infoMessage);
    }
}

// Initialize flash messages when document is ready
document.addEventListener('DOMContentLoaded', function() {
    displayFlashMessages();
});