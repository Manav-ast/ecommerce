/**
 * Flash Messages Initialization
 * 
 * This script initializes flash messages from Laravel sessions
 * using SweetAlert2 Toast notifications.
 */

document.addEventListener('DOMContentLoaded', function () {
    // Check if success message exists and display it
    if (typeof successMessage !== 'undefined' && successMessage && successMessage.trim() !== '') {
        showSuccessToast(successMessage);
    }

    // Check if error message exists and display it
    if (typeof errorMessage !== 'undefined' && errorMessage && errorMessage.trim() !== '') {
        showErrorToast(errorMessage);
    }

    // Check if warning message exists and display it
    if (typeof warningMessage !== 'undefined' && warningMessage && warningMessage.trim() !== '') {
        showWarningToast(warningMessage);
    }

    // Check if info message exists and display it
    if (typeof infoMessage !== 'undefined' && infoMessage && infoMessage.trim() !== '') {
        showInfoToast(infoMessage);
    }
});