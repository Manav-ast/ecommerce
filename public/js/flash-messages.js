/**
 * Flash Messages Initialization
 * 
 * This script initializes flash messages from Laravel sessions
 * using SweetAlert2 Toast notifications.
 */

document.addEventListener('DOMContentLoaded', function () {
    // Check if success message exists and display it
    if (typeof successMessage !== 'undefined') {
        showSuccessToast(successMessage);
    }

    // Check if error message exists and display it
    if (typeof errorMessage !== 'undefined') {
        showErrorToast(errorMessage);
    }

    // Check if warning message exists and display it
    if (typeof warningMessage !== 'undefined') {
        showWarningToast(warningMessage);
    }

    // Check if info message exists and display it
    if (typeof infoMessage !== 'undefined') {
        showInfoToast(infoMessage);
    }
});