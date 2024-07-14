document.addEventListener('DOMContentLoaded', function () {
    // Login Chart
    var loginCtx = document.getElementById('loginChart').getContext('2d');
    var loginLabels = JSON.parse(document.getElementById('loginChart').dataset.labels);
    var loginData = JSON.parse(document.getElementById('loginChart').dataset.data);

    var primaryColor = 'rgba(0, 123, 255, 0.5)';
    var primaryBorderColor = 'rgba(0, 123, 255, 1)';

    var loginChart = new Chart(loginCtx, {
        type: 'bar',
        data: {
            labels: loginLabels,
            datasets: [{
                label: 'Login Count',
                data: loginData,
                backgroundColor: primaryColor,
                borderColor: primaryBorderColor,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Reminder Chart
    var reminderCtx = document.getElementById('reminderChart').getContext('2d');
    var reminderLabels = JSON.parse(document.getElementById('reminderChart').dataset.labels);
    var reminderData = JSON.parse(document.getElementById('reminderChart').dataset.data);

    var secondaryColor = 'rgba(40, 167, 69, 0.5)'; // Bootstrap success color with 0.5 opacity
    var secondaryBorderColor = 'rgba(40, 167, 69, 1)'; // Bootstrap success color solid

    var reminderChart = new Chart(reminderCtx, {
        type: 'bar',
        data: {
            labels: reminderLabels,
            datasets: [{
                label: 'Reminder Count',
                data: reminderData,
                backgroundColor: secondaryColor,
                borderColor: secondaryBorderColor,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Status Pie Chart
    var statusCtx = document.getElementById('statusChart').getContext('2d');
    var statusLabels = JSON.parse(document.getElementById('statusChart').dataset.labels);
    var statusData = JSON.parse(document.getElementById('statusChart').dataset.data);

    var statusColors = [
        'rgba(255, 99, 132, 0.5)',
        'rgba(54, 162, 235, 0.5)',
        'rgba(255, 206, 86, 0.5)',
        'rgba(75, 192, 192, 0.5)',
        'rgba(153, 102, 255, 0.5)',
        'rgba(255, 159, 64, 0.5)'
    ];
    var statusBorderColors = [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
    ];

    var statusChart = new Chart(statusCtx, {
        type: 'pie',
        data: {
            labels: statusLabels,
            datasets: [{
                label: 'Login Status Distribution',
                data: statusData,
                backgroundColor: statusColors,
                borderColor: statusBorderColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true, // Ensure the chart is responsive
            maintainAspectRatio: false // Disable maintaining the aspect ratio
        }
    });

    var toastElement = document.getElementById('topUserToast');
    var toast = new bootstrap.Toast(toastElement, {
        autohide: false
    });
    toast.show();
});