
        $(document).ready(function() {
            // Check if user is logged in and a trainer
            function checkAuth() {
                $.ajax({
                    url: '/api/auth?action=check',
                    method: 'GET',
                    success: function(response) {
                        if (response.role !== 'trainer') {
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
                        // Populate courses
                        $('#coursesList').empty();
                        if (data.schedules && data.schedules.length) {
                            data.schedules.forEach(function(schedule) {
                                $('#coursesList').append(`
                                    <li class="list-group-item">
                                        <strong>${schedule.course_name}</strong><br>
                                        ${new Date(schedule.start_time).toLocaleString()} - ${new Date(schedule.end_time).toLocaleString()}
                                    </li>
                                `);
                            });
                        } else {
                            $('#coursesList').append('<li class="list-group-item">No courses scheduled.</li>');
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
                            $('#assignmentsList').append('<li class="list-group-item">No assignments posted.</li>');
                        }
                    },
                    error: function(xhr) {
                        $('#errorMessage').text(xhr.responseJSON?.message || 'Failed to load dashboard data.').removeClass('d-none');
                    }
                });
            }
            loadDashboard();

            // Handle assignment form submission
            $('#assignmentForm').on('submit', function(e) {
                e.preventDefault();
                $('#errorMessage, #successMessage').addClass('d-none');

                const title = $('#assignmentTitle').val();
                const description = $('#assignmentDescription').val();
                const due_date = $('#assignmentDueDate').val();
                const course_name = $('#assignmentCourse').val();

                if (!title || !due_date) {
                    $('#errorMessage').text('Title and due date are required.').removeClass('d-none');
                    return;
                }

                $.ajax({
                    url: '/api/assignments?action=add',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ title, description, due_date, course_name }),
                    success: function(response) {
                        $('#successMessage').text(response.message).removeClass('d-none');
                        $('#assignmentForm')[0].reset();
                        loadDashboard(); // Refresh assignments list
                    },
                    error: function(xhr) {
                        $('#errorMessage').text(xhr.responseJSON?.message || 'Failed to post assignment.').removeClass('d-none');
                    }
                });
            });

            // Handle schedule form submission
            $('#scheduleForm').on('submit', function(e) {
                e.preventDefault();
                $('#errorMessage, #successMessage').addClass('d-none');

                const course_name = $('#courseName').val();
                const start_time = $('#startTime').val();
                const end_time = $('#endTime').val();
                const location = $('#location').val();

                if (!course_name || !start_time || !end_time) {
                    $('#errorMessage').text('Course name, start time, and end time are required.').removeClass('d-none');
                    return;
                }

                $.ajax({
                    url: '/api/schedules?action=add',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ course_name, start_time, end_time, location }),
                    success: function(response) {
                        $('#successMessage').text(response.message).removeClass('d-none');
                        $('#scheduleForm')[0].reset();
                        loadDashboard(); // Refresh courses list
                    },
                    error: function(xhr) {
                        $('#errorMessage').text(xhr.responseJSON?.message || 'Failed to add schedule.').removeClass('d-none');
                    }
                });
            });

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
    