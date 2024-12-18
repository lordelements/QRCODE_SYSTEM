document.addEventListener('DOMContentLoaded', function () {
    // Target the alert
    const alert = document.getElementById('alert');

    // If the alert exists, set a timer to remove it
    if (alert) {
        setTimeout(() => {
            alert.classList.add('fade'); // Add fade class for smooth transition
            setTimeout(() => alert.remove(), 3000); // Remove after fade
        }, 30000); // 10 seconds
    }
});