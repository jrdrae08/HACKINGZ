<?php
include '../backends/subadmin/dashboard-notif.php';
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Owner Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="../css/businessowner.css">

    <style>
        /* Override default available class but keep it for dashboard cards */
        .card.available {
            background-color: var(--bs-danger);
            color: var(--bs-emphasis-color);
        }

        /* Reset daterangepicker colors */
        .daterangepicker td.available {
            background-color: inherit !important;
            color: inherit !important;
        }

        .daterangepicker td.active,
        .daterangepicker td.in-range {
            background-color:
                #ebf4fb !important;
            color: black !important;
        }
    </style>

</head>

<body>
    <div class="wrapper">

        <?php include '../businessowner/includes/aside.php'; ?>

        <div class="main">

            <?php include '../businessowner/includes/navbar.php'; ?>

            <main class="content px-3 py-2">
                <div class="container-fluid">
                    <div class="my-3">
                        <h3>Dashboard</h3>
                    </div>
                    <div class="row">
                        <h5>Tourist Reservation</h5>
                        <div class="col-12 col-md-4 d-flex">
                            <div class="card flex-fill border-0 new shadow">
                                <div class="card-body text-center">
                                    <h5>New</h5>
                                    <h4><?php echo $pendingCount; ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 d-flex s">
                            <div class="card flex-fill border-0 upcoming shadow">
                                <div class="card-body text-center">
                                    <h5>Upcoming</h5>
                                    <h4><?php echo $acceptedCount; ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 d-flex">
                            <div class="card flex-fill border-0 ongoing shadow">
                                <div class="card-body text-center">
                                    <h5>Ongoing</h5>
                                    <h4><?php echo $ongoingCount; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <?php if ($reminderSent == 1 && $isRenew == 0 && is_null($reuploadDate) && $renewalReject == 0): ?>
                        <div class="warning bg-danger border border-secondary rounded shadow p-2 mb-2">
                            <h5 class="fw-bold text-light">Warning!</h5>
                            <p class="fw-bold text-light">Your business permit will soon expire. Please upload your new business permit as soon as possible to keep your business visible on the website. Use this reference number to renew your business: <strong><?php echo htmlspecialchars($refNum); ?></strong></p>
                            <a href="https://majayjaytourism.ngrok.io/businessowner/enter_renew_code.php" class="btn btn-primary" target="_blank">Click here to upload</a>
                        </div>
                    <?php endif; ?>

                    <?php if ($reminderSent == 1 && !is_null($reuploadDate)): ?>
                        <div class="warning bg-warning border border-secondary rounded shadow p-2">
                            <h5 class="fw-bold text-dark">Pending...</h5>
                            <p class="fw-bold text-dark">Please wait for the Administrator to check and accept the business permit you uploaded.</p>
                        </div>
                    <?php endif; ?>

                    <?php if ($reminderSent == 1 && $isRenew == 0 && is_null($reuploadDate) && $renewalReject == 1): ?>
                        <div class="warning bg-danger border border-secondary rounded shadow p-2 mb-2">
                            <h5 class="fw-bold text-light">Warning!</h5>
                            <p class="fw-bold text-light">Your business permit has been rejected. Please upload your new business permit as soon as possible to keep your business visible on the website. You can check your email for the reason why your renewal was rejected. Use this reference number to renew your business: <strong><?php echo htmlspecialchars($refNum); ?></strong></p>
                            <a href="https://majayjaytourism.ngrok.io/businessowner/enter_renew_code.php" class="btn btn-primary" target="_blank">Click here to upload</a>
                        </div>
                    <?php endif; ?>

                    <div class="row mt-3">
                        <h5>Data Analytics</h5>
                        <div class=" col-xl-3 col-lg-4 col-12 mb-3 d-flex">
                            <p class="me-2">Filter:</p>
                            <div id="reportrange" class="shadow rounded" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-8 col-12 mb-3">
                                    <div class="table-responsive">
                                        <div class="chart-container p-2 bg-light d-flex justify-content-center rounded shadow"  style="height: 50vh;">
                                            <canvas id="myLineChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-12 mb-2">
                                    <div class="chart-container d-flex justify-content-center bg-light rounded p-2 shadow mb-3">
                                        <canvas id="genderBarChart"></canvas>
                                    </div>
                                    <div class="chart-container d-flex justify-content-center bg-light rounded p-2 shadow">
                                        <canvas id="locationPieChart"></canvas>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-12 mb-2">

                                </div>
                            </div>
                        </div>



                    </div>
                    <script>
                        $(function() {
                            let lineChart = null;
                            let pieChart = null;
                            let barChart = null;

                            var start = moment().subtract(29, 'days');
                            var end = moment();

                            function cb(start, end) {
                                console.log('Date range selected:', {
                                    start: start.format('YYYY-MM-DD'),
                                    end: end.format('YYYY-MM-DD')
                                });
                                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                                fetchAnalytics(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
                            }

                            $('#reportrange').daterangepicker({
                                startDate: start,
                                endDate: end,
                                ranges: {
                                    'Today': [moment(), moment()],
                                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                                    'Last 14 Days': [moment().subtract(13, 'days'), moment()],
                                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                                    'This Week': [moment().startOf('week'), moment().endOf('week')],
                                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                                    'Maximum': [moment().subtract(1, 'year'), moment()]
                                }
                            }, cb);

                            function fetchAnalytics(startDate, endDate) {
                                console.log('Fetching analytics for:', {
                                    startDate,
                                    endDate
                                });

                                fetch(`../../backends/subadmin/fetch_dashboard_analytics.php?startDate=${startDate}&endDate=${endDate}`)
                                    .then(response => {
                                        console.log('Response status:', response.status);
                                        if (response.status === 401) {
                                            window.location.href = '../login.php';
                                            return;
                                        }
                                        if (!response.ok) {
                                            throw new Error('Network response was not ok');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        console.log('Received data:', data);
                                        if (data.error) {
                                            throw new Error(data.error);
                                        }
                                        if (!Array.isArray(data)) {
                                            throw new Error('Invalid data format received');
                                        }
                                        updateCharts(data);
                                    })
                                    .catch(error => {
                                        console.error('Error fetching analytics:', error);
                                        alert('Error loading dashboard data: ' + error.message);
                                    });
                            }

                            function updateCharts(data) {
                                console.log('Updating charts with data length:', data.length);
                                try {
                                    updateLineChart(data);
                                    updatePieChart(data);
                                    updateBarChart(data);
                                } catch (error) {
                                    console.error('Error updating charts:', error);
                                }
                            }

                            function updateLineChart(data) {
                                // Initialize total with default 0
                                const totalAttendees = data.reduce((sum, item) =>
                                    sum + parseInt(item.totalnumAttendees || 0), 0
                                );

                                console.log('Updating line chart');
                                const ctx = document.getElementById('myLineChart').getContext('2d');

                                if (lineChart) {
                                    console.log('Destroying existing line chart');
                                    lineChart.destroy();
                                }

                                lineChart = new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: data.map(item => moment(item.date).format('MM/DD/YYYY')),
                                        datasets: [{
                                            label: `Total Attendees: ${totalAttendees || 0}`,
                                            data: data.map(item => parseInt(item.totalnumAttendees || 0)),
                                            borderColor: 'rgb(75, 192, 192)',
                                            tension: 0.1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: {
                                            tooltip: {
                                                enabled: true
                                            },
                                            legend: {
                                                display: true
                                            }
                                        },
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                ticks: {
                                                    precision: 0
                                                }
                                            }
                                        }
                                    }
                                });
                            }

                            function updatePieChart(data) {
                                console.log('Updating pie chart');
                                const ctx = document.getElementById('locationPieChart').getContext('2d');

                                if (pieChart) {
                                    console.log('Destroying existing pie chart');
                                    pieChart.destroy();
                                }

                                // Initialize totals with defaults
                                const totals = {
                                    thisCity: 0,
                                    otherCity: 0,
                                    otherProvince: 0,
                                    foreignCountry: 0
                                };

                                // Calculate with null checks
                                data.forEach(curr => {
                                    totals.thisCity += parseInt(curr.thisCity || 0);
                                    totals.otherCity += parseInt(curr.otherCity || 0);
                                    totals.otherProvince += parseInt(curr.otherProvince || 0);
                                    totals.foreignCountry += parseInt(curr.foreignCountry || 0);
                                });

                                console.log('Location totals:', totals);

                                pieChart = new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: [
                                            `This City: ${totals.thisCity}`,
                                            `Other City: ${totals.otherCity}`,
                                            `Other Province: ${totals.otherProvince}`,
                                            `Foreign: ${totals.foreignCountry}`
                                        ],
                                        datasets: [{
                                            data: Object.values(totals),
                                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            title: {
                                                display: true,
                                                text: 'Attendee Locations',
                                                position: 'top',
                                                font: {
                                                    size: 12,
                                                    bold: true
                                                },
                                                padding: {
                                                    top: 10,
                                                    bottom: 10
                                                }
                                            },
                                            legend: {
                                                position: 'bottom'
                                            }
                                        }
                                    }
                                });
                            }

                            function updateBarChart(data) {
                                console.log('Updating bar chart');
                                const ctx = document.getElementById('genderBarChart').getContext('2d');

                                if (barChart) {
                                    console.log('Destroying existing bar chart');
                                    barChart.destroy();
                                }

                                // Initialize with default values
                                const totals = {
                                    male: 0,
                                    female: 0
                                };

                                // Calculate totals with null checks
                                data.forEach(curr => {
                                    totals.male += parseInt(curr.totalmale || 0);
                                    totals.female += parseInt(curr.totalfemale || 0);
                                });

                                console.log('Gender totals:', totals);

                                barChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: [`Male: ${totals.male || 0}`, `Female: ${totals.female || 0}`],
                                        datasets: [{
                                            label: 'Gender Distribution',
                                            data: [totals.male || 0, totals.female || 0],
                                            backgroundColor: ['#36A2EB', '#FF6384']
                                        }]
                                    },
                                    options: {
                                        indexAxis: 'y',
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        scales: {
                                            x: {
                                                beginAtZero: true,
                                                ticks: {
                                                    precision: 0 // Show whole numbers only
                                                }
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                display: false
                                            }
                                        }
                                    }
                                });
                            }

                            // Initial load
                            console.log('Initializing dashboard...');
                            cb(start, end);
                        });
                    </script>
                </div>
            </main>
            <a href="#" class="theme-toggle">
                <i class="bi bi-brightness-high-fill"></i>
                <i class="bi bi-moon-fill"></i>
            </a>
            <footer class="footer">
                <?php include '../businessowner/includes/footer.php'; ?>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/businessowner.js"></script>
</body>

</html>