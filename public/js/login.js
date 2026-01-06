
$(document).ready(function() {
    // Handle form submission
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();

        // Clear previous messages
        $('#errorMessage, #successMessage').addClass('d-none').text('');

        // Get form data
        const email = $('#email').val();
        const password = $('#password').val();

        // Basic client-side validation
        if (!email || !password) {
            $('#errorMessage').text('Please fill in all fields.').removeClass('d-none');
            return;
        }

        // Send AJAX request to backend
        $.ajax({
            url: '/api/auth?action=login',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ email, password }),
            success: function(response) {
                $('#successMessage').text(response.message).removeClass('d-none');
                // Redirect based on role
                const redirectUrl = response.role === 'student' ? 'student-dashboard.html' : 'trainer-dashboard.html';
                setTimeout(() => {
                    window.location.href = redirectUrl;
                }, 2000);
            },
            error: function(xhr) {
                const errorMsg = xhr.responseJSON?.message || 'Login failed. Please try again.';
                $('#errorMessage').text(errorMsg).removeClass('d-none');
            }
        });
    });

    // Placeholder for Forgot Password (not implemented)
    $('a[href="#forgot-password"]').on('click', function(e) {
        e.preventDefault();
        alert('Forgot Password functionality is not implemented yet.');
    });
});
