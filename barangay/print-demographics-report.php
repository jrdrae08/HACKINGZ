<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'barangay') {
  header('Location: ../login.php');
  exit;
}
$barangayId = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Print Demographics Report</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
  <div class="wrapper">

    <!-- aside nav -->
    <?php include '../barangay/includes/aside.php'; ?>

    <div class="main">

      <!-- navbar -->
      <?php include '../barangay/includes/navbar.php'; ?>

      <main class="content px-3 py-2">
        <div class="container-fluid">
          <div class="mb-3">
            <h3>Generate Report</h3>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span>
                    <input type="hidden" id="start_date" name="start_date">
                    <input type="hidden" id="end_date" name="end_date">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <button id="generateReport" class="btn btn-primary">
                <i class="bi bi-file-earmark-pdf"></i> Generate Report
              </button>
            </div>
          </div>
          <script>
            $(function() {
              var start = moment().startOf('month');
              var end = moment().endOf('month');

              function updateDateRangeSubtitle(start, end) {
                let subtitle;
                if (start.format('YYYY-MM') === end.format('YYYY-MM')) {
                  subtitle = `Current month: ${start.format('MMMM YYYY')}`;
                } else if (start.format('YYYY') === end.format('YYYY')) {
                  subtitle = `Period: ${start.format('MMMM')} - ${end.format('MMMM YYYY')}`;
                } else {
                  subtitle = `Period: ${start.format('MMMM YYYY')} - ${end.format('MMMM YYYY')}`;
                }
                $('.card-subtitle').text(subtitle);
              }

              function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $('#start_date').val(start.format('YYYY-MM-DD'));
                $('#end_date').val(end.format('YYYY-MM-DD'));
                updateDateRangeSubtitle(start, end);
                updateTable(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
              }

              $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                  'This Month': [moment().startOf('month'), moment().endOf('month')],
                  'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                  'This Year': [moment().startOf('year'), moment().endOf('year')],
                  'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
                }
              }, cb);

              cb(start, end);
            });

            function updateTable(startDate, endDate) {
              $.ajax({
                url: '../../backends/barangay/print-report-brgy.php',
                type: 'GET',
                data: {
                  startDate,
                  endDate
                },
                success: function(data) {
                  console.log('Data received:', data); // Debug data structure

                  if (!Array.isArray(data)) {
                    console.error('Expected an array but got:', data);
                    return;
                  }

                  $('table tbody').empty();
                  let totals = {
                    thisCityMale: 0,
                    thisCityFemale: 0,
                    thisCity: 0,
                    otherCityMale: 0,
                    otherCityFemale: 0,
                    otherCity: 0,
                    otherProvinceMale: 0,
                    otherProvinceFemale: 0,
                    otherProvince: 0,
                    foreignCountryMale: 0,
                    foreignCountryFemale: 0,
                    foreignCountry: 0,
                    totalnumAttendees: 0
                  };

                  // Create a map of dates to data
                  const dataMap = {};
                  data.forEach(item => {
                    dataMap[item.date] = item;
                  });

                  // Generate rows for each day of the month
                  const start = moment(startDate);
                  const end = moment(endDate);
                  for (let date = start.clone(); date.isSameOrBefore(end); date.add(1, 'day')) {
                    const item = dataMap[date.format('YYYY-MM-DD')] || {};
                    const row = `
<tr>
  <td class="border-2 border-dark">${date.format('D')}</td>
  <td class="border-2 border-dark">${date.format('ddd')}</td>
  <td class="border-2 border-dark">${item.thisCityMale || 0}</td>
  <td class="border-2 border-dark">${item.thisCityFemale || 0}</td>
  <td class="border-2 border-dark">${item.thisCity || 0}</td>
  <td class="border-2 border-dark">${item.otherCityMale || 0}</td>
  <td class="border-2 border-dark">${item.otherCityFemale || 0}</td>
  <td class="border-2 border-dark">${item.otherCity || 0}</td>
  <td class="border-2 border-dark">${item.otherProvinceMale || 0}</td>
  <td class="border-2 border-dark">${item.otherProvinceFemale || 0}</td>
  <td class="border-2 border-dark">${item.otherProvince || 0}</td>
  <td class="border-2 border-dark">${item.foreignCountryMale || 0}</td>
  <td class="border-2 border-dark">${item.foreignCountryFemale || 0}</td>
  <td class="border-2 border-dark">${item.foreignCountry || 0}</td>
  <td class="border-2 border-dark">${item.totalnumAttendees || 0}</td>
</tr>`;
                    $('table tbody').append(row);

                    // Update totals
                    totals.thisCityMale += parseInt(item.thisCityMale) || 0;
                    totals.thisCityFemale += parseInt(item.thisCityFemale) || 0;
                    totals.thisCity += parseInt(item.thisCity) || 0;
                    totals.otherCityMale += parseInt(item.otherCityMale) || 0;
                    totals.otherCityFemale += parseInt(item.otherCityFemale) || 0;
                    totals.otherCity += parseInt(item.otherCity) || 0;
                    totals.otherProvinceMale += parseInt(item.otherProvinceMale) || 0;
                    totals.otherProvinceFemale += parseInt(item.otherProvinceFemale) || 0;
                    totals.otherProvince += parseInt(item.otherProvince) || 0;
                    totals.foreignCountryMale += parseInt(item.foreignCountryMale) || 0;
                    totals.foreignCountryFemale += parseInt(item.foreignCountryFemale) || 0;
                    totals.foreignCountry += parseInt(item.foreignCountry) || 0;
                    totals.totalnumAttendees += parseInt(item.totalnumAttendees) || 0;
                  }

                  // Append totals row
                  const totalsRow = `
<tr>
  <td class="border-2 border-dark" colspan="2">Total of this month</td>
  <td class="border-2 border-dark">${totals.thisCityMale}</td>
  <td class="border-2 border-dark">${totals.thisCityFemale}</td>
  <td class="border-2 border-dark">${totals.thisCity}</td>
  <td class="border-2 border-dark">${totals.otherCityMale}</td>
  <td class="border-2 border-dark">${totals.otherCityFemale}</td>
  <td class="border-2 border-dark">${totals.otherCity}</td>
  <td class="border-2 border-dark">${totals.otherProvinceMale}</td>
  <td class="border-2 border-dark">${totals.otherProvinceFemale}</td>
  <td class="border-2 border-dark">${totals.otherProvince}</td>
  <td class="border-2 border-dark">${totals.foreignCountryMale}</td>
  <td class="border-2 border-dark">${totals.foreignCountryFemale}</td>
  <td class="border-2 border-dark">${totals.foreignCountry}</td>
  <td class="border-2 border-dark">${totals.totalnumAttendees}</td>
</tr>`;
                  $('table tbody').append(totalsRow);
                },
                error: function(xhr, status, error) {
                  console.error('Ajax error:', error);
                }
              });
            }

            const barangayId = <?php echo json_encode($barangayId); ?>;

            // Update click handler to use barangayId
            $('#generateReport').click(function() {
              const startDate = $('#start_date').val();
              const endDate = $('#end_date').val();

              window.open(`../../backends/barangay/generate-demographics-pdf.php?startDate=${startDate}&endDate=${endDate}&barangayId=${barangayId}`, '_blank');
            });
          </script>
        </div>
        <hr>


        <!-- Table Element -->
        <div class="card border-0 shadow mt-5">
          <div class="card-header">
            <h5 class="card-title">
              Tourism Visitor Record
            </h5>
            <h6 class="card-subtitle text-muted">
              Current month: October
            </h6>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th rowspan="3" class=" border-2 border-dark">Day</th>
                    <th rowspan="3" class=" border-2 border-dark">Week Day <br>(Mon-Sun) </th>
                    <th colspan="9" class="bg-success border-2 border-dark" style="text-align: center;">Philippines</th>
                    <th colspan="3" class="bg-info  border-2 border-dark" style="text-align: center;">Foreign Country Residence</th>
                    <th rowspan="3" class="bg-warning-subtle border-2 border-dark" style="text-align: center;">Grand Total<br>Number of Visitors</th>
                  </tr>
                  <tr>
                    <th colspan="3" class="bg-success-subtle border border-bottom border-dark border-1" style="text-align: center;">This City/Municipality</th>
                    <th colspan="3" class="bg-success-subtle  border-2 border-dark" style="text-align: center;">Other City/Municipality</th>
                    <th colspan="3" class="bg-success-subtle  border-2 border-dark" style="text-align: center;">Other Province</th>
                    <th colspan="3" class="bg-info-subtle  border-2 border-dark" style="text-align: center;">Foreign Country</th>
                  </tr>
                  <tr>
                    <th class="bg-primary-subtle  border-2 border-dark">Male</th>
                    <th class="bg-danger-subtle  border-2 border-dark">Female</th>
                    <th class="bg-warning-subtle border-2 border-dark">Total</th>
                    <th class="bg-primary-subtle border-2 border-dark">Male</th>
                    <th class="bg-danger-subtle  border-2 border-dark">Female</th>
                    <th class="bg-warning-subtle border-2 border-dark">Total</th>
                    <th class="bg-primary-subtle border-2 border-dark">Male</th>
                    <th class="bg-danger-subtle  border-2 border-dark">Female</th>
                    <th class="bg-warning-subtle border-2 border-dark">Total</th>
                    <th class="bg-primary-subtle border-2 border-dark">Male</th>
                    <th class="bg-danger-subtle  border-2 border-dark">Female</th>
                    <th class="bg-warning-subtle border-2 border-dark">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="border-2 border-dark">1</td>
                    <td class="border-2 border-dark">Mon</td>
                    <td class="border-2 border-dark"></td>
                    <td class="border-2 border-dark"></td>
                    <td class="border-2 border-dark"></td>
                    <td class="border-2 border-dark"></td>
                    <td class="border-2 border-dark"></td>
                    <td class="border-2 border-dark"></td>
                    <td class="border-2 border-dark"></td>
                    <td class="border-2 border-dark"></td>
                    <td class="border-2 border-dark"></td>
                    <td class="border-2 border-dark"></td>
                    <td class="border-2 border-dark"></td>
                    <td class="border-2 border-dark"></td>
                    <td class="border-2 border-dark"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </main>
      <a href="#" class="theme-toggle">
        <i class="fa-regular fa-sun"></i>
        <i class="fa-regular fa-moon"></i>
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