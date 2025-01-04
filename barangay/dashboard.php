<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'barangay') {
  header('Location: ../login.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barangay Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/admin.css">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <div class="wrapper">
    <?php include '../barangay/includes/aside.php'; ?>
    <div class="main">
      <?php include '../barangay/includes/navbar.php'; ?>
      <main class="content px-3 py-2">
        <div class="container-fluid">
          <h1>Barangay Accounts</h1>
          <div class="row mt-3">
            <div class="col-lg-8 col-12">
              <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down"></i>
              </div>
              <div class="table-responsive">
                <div class="chart-container bg-light rounded mt-3" style="position: relative; height:50vh; width:100vh">
                  <canvas id="myLineChart"></canvas>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-12">
              <div class="chart-container bg-light rounded mt-3" style="position: relative;">
                <canvas id="locationPieChart"></canvas>
              </div>
            </div>
            <div class="col-lg-4 col-12 mt-3">
              <div class="chart-container bg-light rounded" style="position: relative; height:30vh">
                <canvas id="genderBarChart"></canvas>
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
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                fetchAnalytics(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
              }

              function fetchAnalytics(startDate, endDate) {
                $.ajax({
                  url: '../backends/barangay/fetch_dashboard_analytics.php',
                  method: 'GET',
                  data: {
                    startDate: startDate,
                    endDate: endDate
                  },
                  success: function(response) {
                    updateLineChart(response.data);
                    updatePieChart(response.totals);
                    updateBarChart(response.totals);
                  },
                  error: function(error) {
                    console.error('Error fetching analytics data:', error);
                  }
                });
              }

              function updateLineChart(data) {
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

              function updatePieChart(totals) {
                console.log('Updating pie chart');
                const ctx = document.getElementById('locationPieChart').getContext('2d');

                if (pieChart) {
                  console.log('Destroying existing pie chart');
                  pieChart.destroy();
                }

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
                      data: Object.values(totals).slice(0, 4),
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

              function updateBarChart(totals) {
                console.log('Updating bar chart');
                const ctx = document.getElementById('genderBarChart').getContext('2d');

                if (barChart) {
                  console.log('Destroying existing bar chart');
                  barChart.destroy();
                }

                barChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                    labels: [`Male: ${totals.totalmale || 0}`, `Female: ${totals.totalfemale || 0}`],
                    datasets: [{
                      label: 'Gender Distribution',
                      data: [totals.totalmale || 0, totals.totalfemale || 0],
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

              cb(start, end);
              $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                  'Today': [moment(), moment()],
                  'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                  'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                  'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                  'This Month': [moment().startOf('month'), moment().endOf('month')],
                  'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
              }, cb);
            });
          </script>
        </div>
    </div>
    </main>
    <a href="#" class="theme-toggle">
      <i class="fa-regular fa-sun"></i>
      <i class="fa-regular fa-moon"></i>
    </a>
  </div>
  </div>
  <script src="../js/admin.js"></script>
</body>

</html>