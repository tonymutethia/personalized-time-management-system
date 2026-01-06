
        $(document).ready(function() {
            // Check if user is logged in and a student
            function checkAuth() {
                $.ajax({
                    url: '/api/auth?action=check',
                    method: 'GET',
                    success: function(response) {
                        if (response.role !== 'student') {
                            window.location.href = 'login.html';
                        }
                    },
                    error: function() {
                        window.location.href = 'login.html';
                    }
                });
            }
            checkAuth();

            // Fetch dashboard data
            function loadDashboard() {
                $.ajax({
                    url: '/api/dashboard',
                    method: 'GET',
                    success: function(data) {
                        // Populate schedules
                        $('#schedulesList').empty();
                        if (data.schedules && data.schedules.length) {
                            data.schedules.forEach(function(schedule) {
                                $('#schedulesList').append(`
                                    <li class="list-group-item">
                                        <strong>${schedule.course_name}</strong><br>
                                        ${new Date(schedule.start_time).toLocaleString()} - ${new Date(schedule.end_time).toLocaleString()}<br>
                                        Location: ${schedule.location || 'N/A'}
                                    </li>
                                `);
                            });
                        } else {
                            $('#schedulesList').append('<li class="list-group-item">No upcoming schedules.</li>');
                        }

                        // Populate assignments
                        $('#assignmentsList').empty();
                        if (data.assignments && data.assignments.length) {
                            data.assignments.forEach(function(assignment) {
                                $('#assignmentsList').append(`
                                    <li class="list-group-item">
                                        <strong>${assignment.title}</strong><br>
                                        Course: ${assignment.course_name || 'N/A'}<br>
                                        Due: ${new Date(assignment.due_date).toLocaleString()}
                                    </li>
                                `);
                            });
                        } else {
                            $('#assignmentsList').append('<li class="list-group-item">No assignments due.</li>');
                        }

                        // Populate notifications (proxy for exams)
                        $('#notificationsList').empty();
                        if (data.notifications && data.notifications.length) {
                            data.notifications.forEach(function(notification) {
                                $('#notificationsList').append(`
                                    <li class="list-group-item">
                                        <strong>${notification.title}</strong><br>
                                        ${notification.message}<br>
                                        Posted: ${new Date(notification.created_at).toLocaleString()}
                                    </li>
                                `);
                            });
                        } else {
                            $('#notificationsList').append('<li class="list-group-item">No notifications.</li>');
                        }
                    },
                    error: function(xhr) {
                        $('#errorMessage').text(xhr.responseJSON?.message || 'Failed to load dashboard data.').removeClass('d-none');
                    }
                });
            }
            loadDashboard();

            // Handle logout
            $('#logoutBtn').on('click', function() {
                $.ajax({
                    url: '/api/auth?action=logout',
                    method: 'POST',
                    success: function() {
                        window.location.href = 'login.html';
                    }
                });
            });
        });
    