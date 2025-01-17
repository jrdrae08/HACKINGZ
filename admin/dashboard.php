<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
?>
<!-- Admin dashboard content goes here -->

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" href="../css/admin.css">

    <style>

    </style>
</head>

<body>
    <div class="wrapper">

        <!-- aside nav -->
        <?php include '../admin/includes/aside.php'; ?>

        <div class="main">

            <!-- navbar -->
            <?php include '../admin/includes/navbar.php'; ?>

            <main class="content py-2">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h3>Dashboard</h3>
                    </div>
                    <div class="row">
                        <h5>Totals</h5>
                        <div class="col-12 col-md-4 mb-2 d-flex">
                            <div class="card flex-fill border-0 new shadow">
                                <div class="card-body text-center">
                                    <h4 class="fw-bold" class="fw-bold">Total Visitors</h4>
                                    <h5 class=""> 282,731,298</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-2 d-flex">
                            <div class="card flex-fill border-0 ongoing shadow">
                                <div class="card-body text-center">
                                    <h4 class="fw-bold">Total Businesses Registered</h4>
                                    <h5> 62,323</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 d-flex">
                            <div class="card flex-fill border-0 available shadow">
                                <div class="card-body text-center">
                                    <h4 class="fw-bold">Total Tourist Account Registered</h4>
                                    <h5>5</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

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
                                        <div class="chart-container p-2 bg-light d-flex justify-content-center rounded shadow">
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

                    <script type="text/javascript">
                        $(function() {
                            let myLineChart = null;
                            let locationPieChart = null;
                            let genderBarChart = null;
                            var start = moment().subtract(29, 'days');
                            var end = moment();

                            function cb(start, end) {
                                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                                fetchChartData(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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

                            function fetchChartData(startDate, endDate) {
                                fetch(`../../backends/admin/analytics_demog.php?startDate=${startDate}&endDate=${endDate}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        updateLineChart(data);
                                        updatePieChart(data);
                                        updateGenderChart(data);
                                    });
                            }

                            function calculateLocationTotals(data) {
                                return data.reduce((acc, curr) => ({
                                    thisCity: acc.thisCity + parseInt(curr.thisCity || 0),
                                    otherCity: acc.otherCity + parseInt(curr.otherCity || 0),
                                    otherProvince: acc.otherProvince + parseInt(curr.otherProvince || 0),
                                    foreignCountry: acc.foreignCountry + parseInt(curr.foreignCountry || 0)
                                }), {
                                    thisCity: 0,
                                    otherCity: 0,
                                    otherProvince: 0,
                                    foreignCountry: 0
                                });
                            }

                            function calculateGenderTotals(data) {
                                return data.reduce((acc, curr) => ({
                                    male: acc.male + parseInt(curr.totalmale || 0),
                                    female: acc.female + parseInt(curr.totalfemale || 0)
                                }), {
                                    male: 0,
                                    female: 0
                                });
                            }

                            function updateLineChart(data) {
                                const labels = data.map(item => item.date);
                                const totalAttendees = data.map(item => parseInt(item.totalnumAttendees) || 0);
                                const total = totalAttendees.reduce((a, b) => parseInt(a) + parseInt(b), 0);

                                if (myLineChart) myLineChart.destroy();

                                const lineCtx = document.getElementById('myLineChart').getContext('2d');
                                myLineChart = new Chart(lineCtx, {
                                    type: 'line',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Total Number of Attendees',
                                            data: totalAttendees,
                                            borderColor: 'rgba(75, 192, 192, 1)',
                                            borderWidth: 1,
                                            fill: false
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            title: {
                                                display: true,
                                                text: `Total Attendees: ${parseInt(total)}`
                                            },
                                            tooltip: {
                                                callbacks: {
                                                    label: function(context) {
                                                        return `Attendees: ${parseInt(context.parsed.y)}`;
                                                    }
                                                }
                                            }
                                        },
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                min: 0,
                                                max: 150,
                                                ticks: {
                                                    stepSize: 10
                                                }
                                            }
                                        }
                                    }
                                });
                            }

                            function updatePieChart(data) {
                                const locationTotals = calculateLocationTotals(data);
                                if (locationPieChart) locationPieChart.destroy();

                                const pieCtx = document.getElementById('locationPieChart').getContext('2d');
                                locationPieChart = new Chart(pieCtx, {
                                    type: 'pie',
                                    data: {
                                        labels: [
                                            `This City: ${locationTotals.thisCity}`,
                                            `Other City: ${locationTotals.otherCity}`,
                                            `Other Province: ${locationTotals.otherProvince}`,
                                            `Foreign Country: ${locationTotals.foreignCountry}`
                                        ],
                                        datasets: [{
                                            data: [
                                                locationTotals.thisCity,
                                                locationTotals.otherCity,
                                                locationTotals.otherProvince,
                                                locationTotals.foreignCountry
                                            ],
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.8)',
                                                'rgba(54, 162, 235, 0.8)',
                                                'rgba(255, 206, 86, 0.8)',
                                                'rgba(75, 192, 192, 0.8)'
                                            ]
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                position: 'bottom',
                                                labels: {
                                                    generateLabels: function(chart) {
                                                        const data = chart.data;
                                                        if (data.labels.length && data.datasets.length) {
                                                            return data.labels.map((label, i) => ({
                                                                text: label,
                                                                fillStyle: data.datasets[0].backgroundColor[i],
                                                                hidden: isNaN(data.datasets[0].data[i]),
                                                                index: i
                                                            }));
                                                        }
                                                        return [];
                                                    }
                                                }
                                            },
                                            title: {
                                                display: true,
                                                text: 'Attendee Locations'
                                            }
                                        }
                                    }
                                });
                            }

                            function updateGenderChart(data) {
                                const genderTotals = calculateGenderTotals(data);
                                if (genderBarChart) genderBarChart.destroy();

                                const barCtx = document.getElementById('genderBarChart').getContext('2d');
                                genderBarChart = new Chart(barCtx, {
                                    type: 'bar',
                                    data: {
                                        labels: ['Male', 'Female'],
                                        datasets: [{
                                            axis: 'y',
                                            label: 'Total Count',
                                            data: [genderTotals.male, genderTotals.female],
                                            backgroundColor: [
                                                'rgba(54, 162, 235, 0.8)',
                                                'rgba(255, 99, 132, 0.8)'
                                            ],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        indexAxis: 'y',
                                        responsive: true,
                                        plugins: {
                                            title: {
                                                display: true,
                                                text: 'Gender Distribution'
                                            },
                                            tooltip: {
                                                callbacks: {
                                                    label: function(context) {
                                                        let label = context.dataset.label || '';
                                                        if (context.parsed.x !== null) {
                                                            label = context.label + ': ' + context.parsed.x;
                                                        }
                                                        return label;
                                                    }
                                                }
                                            }
                                        },
                                        scales: {
                                            x: {
                                                beginAtZero: true
                                            },
                                            y: {
                                                ticks: {
                                                    callback: function(value, index) {
                                                        const count = [genderTotals.male, genderTotals.female][index];
                                                        return `${['Male', 'Female'][index]}: ${count}`;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            }

                            cb(start, end); // Initial load
                        });
                    </script>


                </div>
            </main>
            <a href="#" class="theme-toggle">
                <i class="bi bi-brightness-high-fill"></i>
                <i class="bi bi-moon-fill"></i>
            </a>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a href="#" class="text-muted">
                                    <strong>HaKingz</strong>
                                </a>
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted">Contact</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted">About Us</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted">Terms</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted">Booking</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/admin.js"></script>
</body>

</html>