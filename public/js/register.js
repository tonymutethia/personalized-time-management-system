
        $(document).ready(function() {
            // Handle form submission
            $('#registerForm').on('submit', function(e) {
                e.preventDefault();

                // Clear previous messages
                $('#errorMessage, #successMessage').addClass('d-none').text('');

                // Get form data
                const fullname = $('#fullname').val();
                const email = $('#email').val();
                const username = $('#username').val();
                const password = $('#password').val();
                const role = $('#role').val();

                // Basic client-side validation
                if (!fullname || !email || !username || !password || !role) {
                    $('#errorMessage').text('Please fill in all fields.').removeClass('d-none');
                    return;
                }

                // Send AJAX request to backend
                $.ajax({
                    url: '/api/auth?action=register',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ fullname, email, username, password, role }),
                    success: function(response) {
                        $('#successMessage').text(response.message).removeClass('d-none');
                        $('#registerForm')[0].reset(); // Clear form
                        setTimeout(() => {
                            window.location.href = 'login.php'; // Redirect to login
                        }, 2000);
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON?.message || 'Registration failed. Please try again.';
                        $('#errorMessage').text(errorMsg).removeClass('d-none');
                    }
                });
            });
        });
    