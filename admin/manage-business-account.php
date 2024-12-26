<?php

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// backends/admin/pending_businesses.php
include "../backends/admin/fetch_pending_businesses.php";
include "../backends/admin/fetch_approved_businesses.php";
include "../backends/admin/fetch_rejected_businesses.php";
include "../backends/admin/fetch_archived_businesses.php";
include "../backends/admin/fetch_total_accepted.php";
include "../backends/admin/fetch_total_archived.php";
include "../backends/admin/fetch_active_account.php";
include "../backends/admin/fetch_inactive_account.php";

$pendingBusinesses = getPendingBusinesses($pdo);
$approvedBusinesses = getApprovedBusinesses($pdo);
$rejectedBusinesses = getRejectedBusinesses($pdo);
$archivedBusinesses = getArchivedBusinesses($pdo);
$totalAccepted = getTotalAccepted($pdo);
$totalArchived = getTotalArchived($pdo);
$totalActive = getTotalActive($pdo);
$totalInActive = getTotalInactive($pdo);
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <link rel="stylesheet" href="../css/admin.css">

    <style>
        .highlight-new {
            background-color: #F2F2F2ff;
            /* Highlight color */
        }
    </style>

    <script>
        function checkForUpdates() {
            fetch('../backends/check_for_updates.php')
                .then(response => response.text())
                .then(data => {
                    if (data === 'true') {
                        location.reload();
                    }
                })
                .catch(error => console.error('Error checking for updates:', error));
        }

        // Check for updates every 1 second (1000 milliseconds)
        setInterval(checkForUpdates, 1000);
    </script>
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
                        <h4>Manage Business Registrations</h4>
                    </div>
                    <div class="row">
                        <h5 class="text-center">Management Summary</h5>
                        <div class="col-6 col-md-3 mb-2 d-flex">
                            <div class="card flex-fill border-0 illustration bg-light text-dark shadow">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="row g-0 w-100">
                                        <div class="col-12">
                                            <div class="p-3 m-1">
                                                <h4 class="text-center text-dark">Status</h4>
                                                <ul>
                                                    <li>Active: <span id="totalActive"><?php echo $totalActive; ?></span></li>
                                                    <li>Inactive: <span id="totalInActive"><?php echo $totalInActive; ?></span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-2 d-flex">
                            <div class="card flex-fill border-0 illustration bg-primary shadow">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="row g-0 w-100">
                                        <div class="col-12">
                                            <div class="p-3 m-1 text-center">
                                                <h4>Total Pending</h4>
                                                <h2 class="mb-0" id="totalPending"><?php $totalPending; ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <script>
                            function fetchTotalPending() {
                                fetch('../backends/admin/fetch_totalpending_businesses.php')
                                    .then(response => response.text())
                                    .then(data => {
                                        document.getElementById('totalPending').innerText = data;
                                    })
                                    .catch(error => console.error('Error fetching total pending:', error));
                            }

                            function fetchTotalAccepted() {
                                fetch('../backends/admin/fetch_total_accepted.php')
                                    .then(response => response.text())
                                    .then(data => {
                                        document.getElementById('totalAccepted').innerText = data;
                                    })
                                    .catch(error => console.error('Error fetching total accepted:', error));
                            }

                            function fetchTotalActive() {
                                fetch('../backends/admin/fetch_active_account.php')
                                    .then(response => response.text())
                                    .then(data => {
                                        document.getElementById('totalActive').innerText = data;
                                    })
                                    .catch(error => console.error('Error fetching total active:', error));
                            }

                            function fetchTotalInactive() {
                                fetch('../backends/admin/fetch_inactive_account.php')
                                    .then(response => response.text())
                                    .then(data => {
                                        document.getElementById('totalInactive').innerText = data;
                                    })
                                    .catch(error => console.error('Error fetching total inactive:', error));
                            }

                            window.onload = function() {
                                fetchTotalPending();
                                fetchTotalAccepted();
                                fetchTotalActive();
                                fetchTotalInactive();
                                setInterval(fetchTotalPending, 3000); // Refresh total pending every 60 seconds
                                setInterval(fetchTotalAccepted, 3000); // Refresh total accepted every 60 seconds
                                setInterval(fetchTotalActive, 3000); // Refresh total active every 60 seconds
                                setInterval(fetchTotalInactive, 3000); // Refresh total inactive every 60 seconds
                            };
                        </script>

                        <div class="col-6 col-md-3 mb-2 d-flex">
                            <div class="card flex-fill border-0 illustration bg-success shadow">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="row g-0 w-100">
                                        <div class="col-12">
                                            <div class="p-3 m-1 text-center">
                                                <h4>Total Accepted</h4>
                                                <h2 class="mb-0" id="totalAccepted"><?php echo $totalAccepted; ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            function fetchTotalAccepted() {
                                fetch('../backends/admin/fetch_total_accepted.php')
                                    .then(response => response.text())
                                    .then(data => {
                                        document.getElementById('totalAccepted').innerText = data;
                                    })
                                    .catch(error => console.error('Error fetching total accepted:', error));
                            }
                            // Fetch total accepted applications when the page loads
                            window.onload = function() {
                                fetchTotalPending();
                                setInterval(fetchTotalPending, 3000); // Refresh total pending every 60 seconds
                            };
                        </script>

                        <div class="col-6 col-md-3 mb-2 d-flex">
                            <div class="card flex-fill border-0 illustration bg-danger shadow">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="row g-0 w-100">
                                        <div class="col-12">
                                            <div class="p-3 m-1 text-center">
                                                <h4>Total Archived</h4>
                                                <h2 class="mb-0" id="totalArchived"><?php echo $totalArchived; ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table Element -->
                        <div class="col-lg-12 col-md-6 py-2">
                            <div class="card border-0 shadow">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 my-3 d-flex justify-content-center align-items-start">
                                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link pills my-1 me-2 shadow" id="pills-pending-tab" data-bs-toggle="pill" data-bs-target="#pills-pending" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">PENDING</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link pills my-1 me-2 shadow active" id="pills-accepted-tab" data-bs-toggle="pill" data-bs-target="#pills-accepted" type="button" role="tab" aria-controls="pills-home" aria-selected="true">ACCEPTED</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link pills my-1 me-2 shadow" id="pills-rejected-tab" data-bs-toggle="pill" data-bs-target="#pills-rejected" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">REJECTED</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link pills my-1 me-2 shadow" id="pills-archived-tab" data-bs-toggle="pill" data-bs-target="#pills-archived" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">ARCHIVED</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link pills my-1 shadow" id="pills-expired-tab" data-bs-toggle="pill" data-bs-target="#pills-expired" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">BUSINESS PERMIT</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <!-- pending business -->
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade " id="pills-pending" role="tabpanel" aria-labelledby="pills-pending-tab" tabindex="0">
                                            <div class="table-responsive">
                                                <table id="pendingBusinessesTable" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Date Registered</th>
                                                            <th scope="col">Type of Business</th>
                                                            <th scope="col">Business Name</th>
                                                            <th scope="col">Actions</th>
                                                            <th scope="col">Remarks</th>
                                                        </tr>
                                                    </thead>

                                                </table>
                                            </div>

                                            <!-- Confirmation Modal for Pending -->
                                            <div class="modal fade" id="confirmationModalPending" tabindex="-1" aria-labelledby="confirmationModalLabelPending" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="confirmationModalLabelPending">Confirm Action</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p id="confirmationMessagePending">Are you sure you want to proceed?</p>
                                                            <div id="rejectReasons" style="display: none;">
                                                                <div>
                                                                    <input type="checkbox" id="checkbox1" name="checkbox1">
                                                                    <label for="checkbox1">Business Permit is Expired</label>
                                                                </div>
                                                                <div>
                                                                    <input type="checkbox" id="checkbox2" name="checkbox2">
                                                                    <label for="checkbox2">Your Image is Not clear</label>
                                                                </div>
                                                                <div>
                                                                    <input type="checkbox" id="checkbox3" name="checkbox3">
                                                                    <label for="checkbox3">Not a legit business</label>
                                                                </div>
                                                                <div>
                                                                    <input type="checkbox" id="checkbox4" name="checkbox4">
                                                                    <label for="checkbox4">Others</label>
                                                                </div>
                                                                <div id="otherReasonDiv" style="display: none;">
                                                                    <textarea id="otherReasonText" placeholder="Please specify the reason" style="width: 100%; height: 100px;"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="button" class="btn btn-primary" id="confirmButtonPending">Confirm</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    let actionType = '';
                                                    let applicationId = '';

                                                    const pendingBusinesses = <?php echo json_encode($pendingBusinesses); ?>;

                                                    function displayPendingBusinesses() {
                                                        const table = $('#pendingBusinessesTable').DataTable({
                                                            columnDefs: [{
                                                                    orderable: false,
                                                                    targets: 3
                                                                } // Disable sorting on the "Actions" column
                                                            ],
                                                            order: [
                                                                [0, 'desc']
                                                            ], // Sort first column (Date Registered) in descending order
                                                            createdRow: function(row, data, dataIndex) {
                                                                const status = $(row).find('.status').text();
                                                                if ((status === 'New' || status === 'Reapply')) {
                                                                    $(row).addClass('highlight-new');
                                                                }
                                                            }
                                                        });
                                                        table.clear(); // Clear the table

                                                        // Loop through all businesses and display them
                                                        pendingBusinesses.forEach(business => {
                                                            let status = '';
                                                            if (business.isReapply == 1) {
                                                                status = 'Reapply';
                                                            } else if (business.IsRead == 0) {
                                                                status = 'New';
                                                            } else {
                                                                status = ' ';
                                                            }

                                                            const row = `
                    <tr ${((status === 'New' || status === 'Reapply') && business.IsRead == 0) ? 'class="highlight-new"' : ''}>
                        <td>${business['Date Registered']}</td>
                        <td>${business['BusinessType']}</td>
                        <td>${business['BusinessName']}</td>
                        <td>
                            <button class="btn btn-primary m-1 view-details" data-bs-toggle="modal" data-bs-target="#viewbusinessinfo" data-application-id="${business.ApplicationID}" data-business='${JSON.stringify(business)}'>
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-success m-1" data-application-id="${business['ApplicationID']}"><i class="bi bi-check-lg"></i></button>
                            <button class="btn btn-danger m-1" data-application-id="${business['ApplicationID']}"><i class="bi bi-x-lg"></i></button>
                        </td>
                        <td class="status">${status}</td>
                    </tr>
                `;
                                                            table.row.add($(row));
                                                        });

                                                        table.draw();
                                                        attachEventListeners();
                                                    }

                                                    function attachEventListeners() {
                                                        $('#pendingBusinessesTable').on('click', 'button', function(event) {
                                                            const button = $(this);
                                                            applicationId = button.data('application-id');
                                                            if (button.hasClass('btn-success')) {
                                                                actionType = 'approve';
                                                                confirmationMessagePending.innerText = 'Are you sure you want to approve this business?';
                                                                rejectReasonsDiv.style.display = 'none';
                                                                confirmButtonPending.disabled = false;
                                                                confirmationModalPending.show();
                                                            } else if (button.hasClass('btn-danger')) {
                                                                actionType = 'reject';
                                                                confirmationMessagePending.innerText = 'Are you sure you want to reject this business?';
                                                                rejectReasonsDiv.style.display = 'block';
                                                                confirmButtonPending.disabled = true;
                                                                confirmationModalPending.show();
                                                            } else if (button.hasClass('view-details')) {
                                                                $.ajax({
                                                                    url: '../../backends/admin/update_read_status.php',
                                                                    method: 'POST',
                                                                    data: {
                                                                        applicationID: applicationId
                                                                    },
                                                                    success: function(response) {
                                                                        if (response.success) {
                                                                            button.closest('tr').find('.status').text('Read');
                                                                        } else {
                                                                            console.error('Failed to update read status:', response.message);
                                                                        }
                                                                    },
                                                                    error: function(error) {
                                                                        console.error('Error updating read status:', error);
                                                                    }
                                                                });
                                                            }
                                                        });

                                                        $('#rejectReasons input[type="checkbox"]').on('change', function() {
                                                            if (this.id === 'checkbox4') {
                                                                $('#otherReasonDiv').toggle(this.checked);
                                                            }
                                                            updateConfirmButtonState();
                                                        });
                                                    }

                                                    function updateConfirmButtonState() {
                                                        const anyChecked = $('#rejectReasons input[type="checkbox"]').is(':checked');
                                                        confirmButtonPending.disabled = !anyChecked;
                                                    }

                                                    displayPendingBusinesses(); // Display all businesses on page load

                                                    const confirmationModalPending = new bootstrap.Modal(document.getElementById('confirmationModalPending'));
                                                    const confirmButtonPending = document.getElementById('confirmButtonPending');
                                                    const confirmationMessagePending = document.getElementById('confirmationMessagePending');
                                                    const rejectReasonsDiv = document.getElementById('rejectReasons');

                                                    confirmButtonPending.addEventListener('click', function() {
                                                        if (actionType === 'approve' || actionType === 'reject') {
                                                            const rejectReasons = [];
                                                            $('#rejectReasons input[type="checkbox"]:checked').each(function() {
                                                                if (this.id === 'checkbox4') {
                                                                    const otherReasonText = $('#otherReasonText').val();
                                                                    if (otherReasonText) {
                                                                        rejectReasons.push(otherReasonText);
                                                                    }
                                                                } else {
                                                                    rejectReasons.push($(this).next('label').text());
                                                                }
                                                            });

                                                            fetch('../backends/admin/update_status.php', {
                                                                    method: 'POST',
                                                                    headers: {
                                                                        'Content-Type': 'application/json'
                                                                    },
                                                                    body: JSON.stringify({
                                                                        ApplicationID: applicationId,
                                                                        Status: actionType === 'approve' ? 'Approved' : 'Rejected',
                                                                        IsReject: actionType === 'reject' ? 1 : 0,
                                                                        RejectReasons: rejectReasons
                                                                    })
                                                                })
                                                                .then(response => response.json())
                                                                .then(data => {
                                                                    if (data.success) {
                                                                        alert(`Status updated to ${actionType === 'approve' ? 'Approved' : 'Rejected'} successfully!`);
                                                                        location.reload();
                                                                    } else {
                                                                        alert('Failed to update status: ' + (data.error || 'Unknown error.'));
                                                                    }
                                                                    confirmationModalPending.hide();
                                                                })
                                                                .catch(error => {
                                                                    console.error('Error:', error);
                                                                    confirmationModalPending.hide();
                                                                });
                                                        }
                                                    });

                                                    $('#confirmationModalPending').on('hidden.bs.modal', function() {
                                                        $('.modal-backdrop').remove();
                                                    });
                                                });
                                            </script>
                                        </div>

                                        <!-- Accepted business -->
                                        <div class="tab-pane fade show active" id="pills-accepted" role="tabpanel" aria-labelledby="pills-accepted-tab" tabindex="0">
                                            <div class="table-responsive">
                                                <table id="acceptedBusinessesTable" class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Date Registered</th>
                                                            <th scope="col">Type of Business</th>
                                                            <th scope="col">Business Name</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Actions</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <script>
                                            function attachEventListeners() {
                                                $('#pendingBusinessesTable').on('click', 'button', function(event) {
                                                    const button = $(this);
                                                    applicationId = button.data('application-id');
                                                    if (button.hasClass('btn-success')) {
                                                        actionType = 'approve';
                                                        confirmationMessagePending.innerText = 'Are you sure you want to approve this business?';
                                                        otherReasonReject.style.display = 'none';
                                                        confirmButtonPending.disabled = false;
                                                        confirmationModalPending.show();
                                                    } else if (button.hasClass('btn-danger')) {
                                                        actionType = 'reject';
                                                        confirmationMessagePending.innerText = 'Are you sure you want to reject this business?';
                                                        otherReasonReject.style.display = 'block';
                                                        confirmButtonPending.disabled = true;
                                                        confirmationModalPending.show();
                                                    } else if (button.hasClass('view-details')) {
                                                        $.ajax({
                                                            url: '../../backends/admin/update_read_status.php',
                                                            method: 'POST',
                                                            data: {
                                                                applicationID: applicationId
                                                            },
                                                            success: function(response) {
                                                                if (response.success) {
                                                                    button.closest('tr').find('.status').text('Read');
                                                                } else {
                                                                    console.error('Failed to update read status:', response.message);
                                                                }
                                                            },
                                                            error: function(error) {
                                                                console.error('Error updating read status:', error);
                                                            }
                                                        });
                                                    }
                                                });

                                                $('#rejectReuploadReasons input[type="checkbox"]').on('change', function() {
                                                    if (this.id === 'checkbox4.1') {
                                                        $('#otherReasonReject').toggle(this.checked);
                                                    }
                                                    updateConfirmButtonState();
                                                });
                                            }

                                            function updateConfirmButtonState() {
                                                const anyChecked = $('#rejectReuploadReasons input[type="checkbox"]').is(':checked');
                                                confirmButtonPending.disabled = !anyChecked;
                                            }

                                            displayPendingBusinesses(); // Display all businesses on page load

                                            const confirmationModalPending = new bootstrap.Modal(document.getElementById('confirmationModalPending'));
                                            const confirmButtonPending = document.getElementById('confirmButtonPending');
                                            const confirmationMessagePending = document.getElementById('confirmationMessagePending');
                                            const otherReasonReject = document.getElementById('rejectReuploadReasons');

                                            confirmButtonPending.addEventListener('click', function() {
                                                if (actionType === 'approve' || actionType === 'reject') {
                                                    const rejectReuploadReasons = [];
                                                    $('#rejectReuploadReasons input[type="checkbox"]:checked').each(function() {
                                                        if (this.id === 'checkbox4.1') {
                                                            const otherReasonText = $('#otherReasonText').val();
                                                            if (otherReasonText) {
                                                                rejectReuploadReasons.push(otherReasonText);
                                                            }
                                                        } else {
                                                            rejectReuploadReasons.push($(this).next('label').text());
                                                        }
                                                    });

                                                    fetch('../backends/admin/update_status.php', {
                                                            method: 'POST',
                                                            headers: {
                                                                'Content-Type': 'application/json'
                                                            },
                                                            body: JSON.stringify({
                                                                ApplicationID: applicationId,
                                                                Status: actionType === 'approve' ? 'Approved' : 'Rejected',
                                                                IsReject: actionType === 'reject' ? 1 : 0,
                                                                RejectReuploadReasons: rejectReuploadReasons
                                                            })
                                                        })
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            if (data.success) {
                                                                alert(`Status updated to ${actionType === 'approve' ? 'Approved' : 'Rejected'} successfully!`);
                                                                location.reload();
                                                            } else {
                                                                alert('Failed to update status: ' + (data.error || 'Unknown error.'));
                                                            }
                                                            confirmationModalPending.hide();
                                                        })
                                                        .catch(error => {
                                                            console.error('Error:', error);
                                                            confirmationModalPending.hide();
                                                        });
                                                }
                                            });
                                        </script>

                                        <!-- Confirmation Modal for Status Toggle -->
                                        <div class="modal fade" id="confirmationModalAccepted" tabindex="-1" aria-labelledby="confirmationModalLabelAccepted" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="confirmationModalLabelAccepted">Confirm Status Change</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p id="confirmationMessageAccepted">Are you sure you want to proceed?</p>
                                                        <input type="hidden" id="modalBusinessId">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-primary" id="confirmButtonAccepted">Confirm</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Archive Confirmation Modal -->
                                        <div class="modal fade" id="archiveModal" tabindex="-1" aria-labelledby="archiveModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="archiveModalLabel">Confirm Archive</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to archive this account?
                                                        <input type="hidden" id="archiveBusinessId">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-danger" id="confirmArchiveBtn">Confirm</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                let actionType = '';
                                                let businessId = '';
                                                let status = '';

                                                const approvedBusinesses = <?php echo json_encode($approvedBusinesses); ?>;

                                                function displayApprovedBusinesses() {
                                                    const table = $('#acceptedBusinessesTable').DataTable({
                                                        columnDefs: [{
                                                            orderable: false,
                                                            targets: [3, 4]
                                                        }],
                                                        order: [
                                                            [0, 'desc']
                                                        ], // Sort first column (Date Registered) in descending order
                                                        drawCallback: function() {
                                                            attachEventListeners();
                                                        }
                                                    });

                                                    table.clear();

                                                    approvedBusinesses.forEach(business => {
                                                        const row = `
                <tr>
                    <td>${business['Date Registered']}</td>
                    <td>${business['BusinessType']}</td>
                    <td>${business['BusinessName']}</td>
                    <td>
                        <label class="switch">
                            <input class="switch-input" type="checkbox" ${business['BusinessStatus'] == 'Active' ? 'checked' : ''} data-business-id="${business['AccountID']}">
                            <div class="switch-button">
                                <span class="switch-button-left">Inactive</span>
                                <span class="switch-button-right">Active</span>
                            </div>
                        </label>
                    </td>
                    <td>
                        <button class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#viewbusinessinfo" data-business='${JSON.stringify(business)}'>
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-danger m-1" data-business-id="${business['AccountID']}" ${business['BusinessStatus'] == 'Inactive' ? '' : 'disabled'}>
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </td>
                </tr>
            `;
                                                        table.row.add($(row));
                                                    });

                                                    table.draw();
                                                }

                                                function attachEventListeners() {
                                                    // Use event delegation
                                                    $('#acceptedBusinessesTable').off('change', '.switch-input').on('change', '.switch-input', function(event) {
                                                        const toggle = this;
                                                        businessId = toggle.dataset.businessId;
                                                        status = toggle.checked ? 'Active' : 'Inactive';
                                                        actionType = 'toggle';

                                                        $('#confirmationMessageAccepted').text(`Are you sure you want to set this business to ${status}?`);
                                                        $('#modalBusinessId').val(businessId);

                                                        const originalCheckedState = toggle.checked;
                                                        toggle.checked = !originalCheckedState; // Revert temporarily

                                                        const modal = new bootstrap.Modal(document.getElementById('confirmationModalAccepted'));
                                                        modal.show();

                                                        // Handle confirmation
                                                        $('#confirmButtonAccepted').off('click').on('click', function() {
                                                            toggle.checked = originalCheckedState;
                                                            handleStatusUpdate(businessId, status, toggle);
                                                            modal.hide();
                                                        });

                                                        // Handle cancellation
                                                        $('.btn-close, .btn-secondary', '#confirmationModalAccepted').off('click').on('click', function() {
                                                            toggle.checked = !originalCheckedState;
                                                            modal.hide();
                                                        });
                                                    });
                                                }

                                                function handleStatusUpdate(businessId, status, toggle) {
                                                    fetch('../backends/admin/active_inactive.php', {
                                                            method: 'POST',
                                                            headers: {
                                                                'Content-Type': 'application/json'
                                                            },
                                                            body: JSON.stringify({
                                                                id: businessId,
                                                                status: status
                                                            })
                                                        })
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            if (!data.success) {
                                                                alert('Failed to update status');
                                                                toggle.checked = !toggle.checked;
                                                            } else {
                                                                $(`.btn-danger[data-business-id="${businessId}"]`).prop('disabled', status === 'Active');
                                                            }
                                                        })
                                                        .catch(error => {
                                                            console.error('Error:', error);
                                                            alert('Failed to update status');
                                                            toggle.checked = !toggle.checked;
                                                        });
                                                }

                                                displayApprovedBusinesses();
                                            });
                                        </script>

                                        <!-- REJECTED BUSINESS -->
                                        <div class="tab-pane fade" id="pills-rejected" role="tabpanel" aria-labelledby="pills-rejected-tab" tabindex="0">
                                            <div class="table-responsive">
                                                <table id="rejectedBusinessesTable" class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Date Registered</th>
                                                            <th scope="col">Type of Business</th>
                                                            <th scope="col">Business Name</th>
                                                            <th scope="col">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                const rejectedBusinesses = <?php echo json_encode($rejectedBusinesses); ?>;

                                                function displayRejectedBusinesses() {
                                                    const table = $('#rejectedBusinessesTable').DataTable({
                                                        columnDefs: [{
                                                                orderable: false,
                                                                targets: 3
                                                            } // Disable sorting on the "Actions" column
                                                        ],
                                                        order: [
                                                            [0, 'desc']
                                                        ], // Sort first column (Date Registered) in descending order
                                                    });
                                                    table.clear(); // Clear the table

                                                    rejectedBusinesses.forEach(business => {
                                                        const row = `
                    <tr>
                        <td>${business['Date Registered']}</td>
                        <td>${business['BusinessType']}</td>
                        <td>${business['BusinessName']}</td>
                        <td>
                            <button class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#viewbusinessinfo" data-business='${JSON.stringify(business)}'>
                                <i class="bi bi-eye"></i>
                            </button>
                        </td>
                    </tr>
                `;
                                                        table.row.add($(row));
                                                    });

                                                    table.draw();
                                                }

                                                displayRejectedBusinesses(); // Display all businesses on page load
                                            });
                                        </script>



                                        <!-- Archive Confirmation Modal -->
                                        <div class="modal fade" id="archiveModal" tabindex="-1" aria-labelledby="archiveModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="archiveModalLabel">Confirm Archive</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to archive this account?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-danger" id="confirmArchiveBtn">Confirm</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Return Confirmation Modal -->
                                        <div class="modal fade" id="returnConfirmationModal" tabindex="-1" aria-labelledby="returnConfirmationModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="returnConfirmationModalLabel">Confirm Return</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to return this business to active status?
                                                        <input type="hidden" id="returnBusinessId">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-success" id="confirmReturnBtn">Confirm</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- archived business -->
                                        <div class="tab-pane fade" id="pills-archived" role="tabpanel" aria-labelledby="pills-archived-tab" tabindex="0">
                                            <div class="table-responsive">
                                                <table id="archivedBusinessesTable" class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Date Registered</th>
                                                            <th scope="col">Type of Business</th>
                                                            <th scope="col">Business Name</th>
                                                            <th scope="col">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                const archivedBusinesses = <?php echo json_encode($archivedBusinesses); ?>;

                                                function displayArchivedBusinesses() {
                                                    const table = $('#archivedBusinessesTable').DataTable({
                                                        columnDefs: [{
                                                                orderable: false,
                                                                targets: 3
                                                            } // Disable sorting on the "Actions" column
                                                        ],
                                                        order: [
                                                            [0, 'desc']
                                                        ], // Sort first column (Date Registered) in descending order
                                                    });
                                                    table.clear(); // Clear the table

                                                    archivedBusinesses.forEach(business => {
                                                        const row = `
                    <tr>
                        <td>${business['Date Registered']}</td>
                        <td>${business['BusinessType']}</td>
                        <td>${business['BusinessName']}</td>
                        <td>
                            <button class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#viewbusinessinfo" data-business='${JSON.stringify(business)}'>
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-success m-1" data-business-id="${business['AccountID']}"><i class="bi bi-arrow-clockwise"></i></button>
                        </td>
                    </tr>
                `;
                                                        table.row.add($(row));
                                                    });

                                                    table.draw();
                                                    attachEventListeners();
                                                }

                                                function attachEventListeners() {
                                                    document.querySelectorAll('.btn-success[data-business-id]').forEach(function(button) {
                                                        button.addEventListener('click', function(event) {
                                                            const businessId = this.dataset.businessId;
                                                            returnBusinessId.value = businessId;
                                                            returnModal.show();
                                                        });
                                                    });
                                                }

                                                displayArchivedBusinesses(); // Display all businesses on page load

                                                const returnModal = new bootstrap.Modal(document.getElementById('returnConfirmationModal'));
                                                const confirmReturnBtn = document.getElementById('confirmReturnBtn');
                                                const returnBusinessId = document.getElementById('returnBusinessId');

                                                confirmReturnBtn.addEventListener('click', function() {
                                                    const businessId = returnBusinessId.value;
                                                    fetch('../backends/admin/return_business.php', {
                                                            method: 'POST',
                                                            headers: {
                                                                'Content-Type': 'application/x-www-form-urlencoded'
                                                            },
                                                            body: 'business_id=' + encodeURIComponent(businessId)
                                                        })
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            if (data.success) {
                                                                alert('Business returned to active status successfully.');
                                                                location.reload(); // Refresh the page to update the status
                                                            } else {
                                                                alert('Failed to return business: ' + data.error);
                                                            }
                                                            returnModal.hide();
                                                        })
                                                        .catch(error => {
                                                            console.error('Error:', error);
                                                            alert('Failed to return business.');
                                                            returnModal.hide();
                                                        });
                                                });

                                                document.getElementById('returnConfirmationModal').addEventListener('hidden.bs.modal', function() {
                                                    const backdrops = document.querySelectorAll('.modal-backdrop');
                                                    backdrops.forEach(backdrop => {
                                                        backdrop.parentNode.removeChild(backdrop);
                                                    });
                                                });
                                            });
                                        </script>


                                        <!-- Expired Business Permit -->
                                        <div class="tab-pane fade show" id="pills-expired" role="tabpanel" aria-labelledby="pills-expired-tab" tabindex="0">
                                            <div class="table-responsive">
                                                <table id="expiredBusinessesTable" class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Date Registered</th>
                                                            <th scope="col">Type of Business</th>
                                                            <th scope="col">Business Name</th>
                                                            <th scope="col">Actions</th>
                                                            <th scope="col">Business Permit Remark</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Data will be populated here by JavaScript -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                function fetchExpiredBusinesses() {
                                                    $.ajax({
                                                        url: '../../backends/admin/fetch_expired_businesses.php',
                                                        method: 'GET',
                                                        dataType: 'json',
                                                        success: function(response) {
                                                            var tbody = $('#expiredBusinessesTable tbody');
                                                            tbody.empty(); // Clear existing rows

                                                            response.forEach(function(business) {
                                                                var remark = '';
                                                                if (business.reuploadDate) {
                                                                    remark = '<span class="text-success fw-bold">Uploaded New</span>';
                                                                } else if (business.PermitExpDate < new Date().toISOString().split('T')[0]) {
                                                                    remark = '<span class="text-danger fw-bold">Expired Permit</span>';
                                                                } else {
                                                                    remark = '<span class="text-warning fw-bold">Expired Soon</span>';
                                                                }

                                                                var row = `
                            <tr>
                                <td>${business['Date Registered']}</td>
                                <td>${business['BusinessType']}</td>
                                <td>${business['BusinessName']}</td>
                                <td>
                                    ${business.reuploadDate ? `<button class="btn btn-success m-1" data-bs-toggle="modal" data-bs-target="#ResubmitModal" data-application-id="${business.ApplicationID}">Check Update</button>` : ''}
                                </td>
                                <td>${remark}</td>
                            </tr>
                        `;
                                                                tbody.append(row);
                                                            });

                                                            if ($.fn.DataTable.isDataTable('#expiredBusinessesTable')) {
                                                                $('#expiredBusinessesTable').DataTable().destroy();
                                                            }

                                                            $('#expiredBusinessesTable').DataTable({
                                                                columnDefs: [{
                                                                        orderable: false,
                                                                        targets: 3
                                                                    }, // Disable sorting for the "Actions" column
                                                                    {
                                                                        searchable: false,
                                                                        targets: 3
                                                                    } // Disable searching for the "Actions" column
                                                                ],
                                                                order: [
                                                                    [4, 'desc'], // Sort by the "Business Permit Remark" column in ascending order
                                                                    [0, 'desc'] // Then sort by the "Date Registered" column in descending order
                                                                ]
                                                            });
                                                        },
                                                        error: function() {
                                                            alert('Failed to fetch expired businesses.');
                                                        }
                                                    });
                                                }

                                                fetchExpiredBusinesses(); // Fetch expired businesses on page load

                                                $('#ResubmitModal').on('show.bs.modal', function(event) {
                                                    var button = $(event.relatedTarget);
                                                    var applicationId = button.data('application-id');

                                                    $.ajax({
                                                        url: '../../backends/admin/fetch_expired_businesses.php',
                                                        method: 'POST',
                                                        data: {
                                                            applicationId: applicationId
                                                        },
                                                        success: function(response) {
                                                            var data = JSON.parse(response);
                                                            var reuploadDate = new Date(data.reuploadDate);
                                                            var formattedDate = reuploadDate.toLocaleDateString('default', {
                                                                year: 'numeric',
                                                                month: 'long',
                                                                day: 'numeric'
                                                            });
                                                            var permitExpDate = new Date(data.PermitExpDate);
                                                            var formattedPermitExpDate = permitExpDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
                                                            var newPermitExpDate = new Date(data.newPermitDate);
                                                            var formattedNewPermitExpDate = newPermitExpDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD

                                                            $('#reuploadDate').text('Re-upload Date: ' + formattedDate);
                                                            $('#oldBusinessPermitImage').attr('src', '../../businessowner/uploadsapp/' + data.BusinessPermitImage);
                                                            $('#oldPermitExpDate').val(formattedPermitExpDate);
                                                            $('#newBusinessPermitImage').attr('src', '../../businessowner/uploadsapp/newPermit/' + data.newPermitImage);
                                                            $('#newPermitExpDate').val(formattedNewPermitExpDate);

                                                            // Add application ID to the Accept button
                                                            $('#acceptButton').data('application-id', applicationId);

                                                            // Add application ID to the Reject button
                                                            $('#RenewalRejected').data('application-id', applicationId);
                                                        },
                                                        error: function() {
                                                            alert('Failed to fetch business details.');
                                                        }
                                                    });
                                                });

                                                // Show confirmation modal on Accept button click
                                                $('#acceptButton').on('click', function() {
                                                    var applicationId = $(this).data('application-id');
                                                    $('#confirmRenewalApproveButton').data('application-id', applicationId);
                                                    $('#RenewalApproveModal').modal('show');
                                                });

                                                // Handle Confirm button click in the confirmation modal
                                                $('#confirmRenewalApproveButton').on('click', function() {
                                                    var applicationId = $(this).data('application-id');

                                                    $.ajax({
                                                        url: '../../backends/admin/update_permit_status.php',
                                                        method: 'POST',
                                                        data: {
                                                            applicationId: applicationId
                                                        },
                                                        success: function(response) {
                                                            alert('Business permit status updated successfully.');
                                                            $('#RenewalApproveModal').modal('hide');
                                                            $('#ResubmitModal').modal('hide');
                                                            fetchExpiredBusinesses(); // Refresh the table
                                                        },
                                                        error: function() {
                                                            alert('Failed to update business permit status.');
                                                        }
                                                    });
                                                });
                                            });
                                        </script>

                                        <!--Expiration Business Permit Modal -->
                                        <div class="modal fade" id="ResubmitModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ResubmitModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="ResubmitModalLabel">Business Permit Re-upload</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row d-flex justify-content-around">
                                                            <p id="reuploadDate">Re-upload Date: </p>
                                                            <!-- New Business Permit -->
                                                            <div class="col-lg-5 col-12 bg-success-subtle rounded mb-2">
                                                                <div class="row">
                                                                    <h3 class="fw-bold text-success text-center py-2">New Business Permit</h3>

                                                                    <div class="col-12 mb-3">
                                                                        <h5>New Business Permit Uploaded</h5>
                                                                        <img id="newBusinessPermitImage" src="../img/businessowner-img/majayjay falls.JPG" class="img-fluid" alt="">
                                                                    </div>
                                                                    <div class="col-12 mb-3">
                                                                        <label for="exampleFormControlInput1" class="form-label"> New Business Permit Expiration Date</label>
                                                                        <input type="text" class="form-control shadow" id="newPermitExpDate" placeholder="" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Old Business Permit -->
                                                            <div class="col-lg-5 col-12 bg-secondary-subtle rounded mb-2">
                                                                <div class="row">
                                                                    <h3 class="fw-bold text-danger text-center py-2">Old Business Permit</h3>
                                                                    <div class="col-12 mb-3">
                                                                        <h5>Old Business Permit Uploaded</h5>
                                                                        <img id="oldBusinessPermitImage" src="../img/businessowner-img/dalitiwan resort.jpg" class="img-fluid" alt="">
                                                                    </div>
                                                                    <div class="col-12 mb-3">
                                                                        <label for="oldPermitExpDate" class="form-label"> Old Business Permit Expiration Date</label>
                                                                        <input type="text" class="form-control shadow" id="oldPermitExpDate" placeholder="" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#RejectPermitModal" data-business='RejectPermitModal'>Reject</button>
                                                        <button type="button" class="btn btn-success" id="acceptButton">Accept</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Confirmation Modal -->
                                        <div class="modal fade" id="RenewalApproveModal" tabindex="-1" aria-labelledby="RenewalApproveModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="RenewalApproveModalLabel">Confirm Accept</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to accept this business permit?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-success" id="confirmRenewalApproveButton">Confirm</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal for Business Permit Re-upload pag nireject -->
                                        <div class="modal fade" id="RejectPermitModal" tabindex="-1" aria-labelledby="RejectPermitModal" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="RejectPermitModal">Confirm your Rejection</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p id=" ">Please check the reason why you want to reject this.</p>

                                                        <div id="rejectReuploadReasons">
                                                            <div>
                                                                <input type="checkbox" id="checkbox1" name="checkbox1">
                                                                <label for="checkbox1">Business permit is expired</label>
                                                            </div>
                                                            <div>
                                                                <input type="checkbox" id="checkbox2" name="checkbox2">
                                                                <label for="checkbox2">Image is not clear</label>
                                                            </div>
                                                            <div>
                                                                <input type="checkbox" id="checkbox3" name="checkbox3">
                                                                <label for="checkbox3">Not a legit business</label>
                                                            </div>
                                                            <div id="otherReasonReject">
                                                                <textarea id="otherReasonText" placeholder="Please specify the other reason" style="width: 100%; height: 100px;"></textarea>
                                                            </div>
                                                        </div>
                                                        <p class="text-secondary mb-0 pb-0" style="font-size:12px;"> <span class="fw-bold">Note:</span> Email will be sent to the business owner once you reject this. They can still reupload correct business permit.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-danger" id="RenewalRejected" data-application-id="">Confirm Rejection</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Rejection Confirmation Modal -->
                                        <div class="modal fade" id="RenewalRejectModal" tabindex="-1" aria-labelledby="RenewalRejectModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="RenewalRejectModalLabel">Confirm Rejection</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to reject this business permit renewal?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-danger" id="confirmRenewalRejectButton">Confirm</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Script to hide and show the other reason text area when the checkbox is checked -->
                                        <script>
                                            // Show rejection confirmation modal on Reject button click
                                            $('#RenewalRejected').on('click', function() {
                                                var applicationId = $(this).data('application-id');
                                                $('#confirmRenewalRejectButton').data('application-id', applicationId);
                                                $('#RenewalRejectModal').modal('show');
                                            });

                                            // Handle Confirm Rejection button click in the confirmation modal
                                            $('#confirmRenewalRejectButton').on('click', function() {
                                                var applicationId = $(this).data('application-id');
                                                console.log('Application ID:', applicationId);
                                                var reasons = [];

                                                // Collect both checkbox and textarea reasons
                                                $('#rejectReuploadReasons input[type="checkbox"]:checked, #otherReasonText').each(function() {
                                                    if ($(this).is('textarea')) {
                                                        let textValue = $(this).val().trim();
                                                        if (textValue) {
                                                            reasons.push(textValue);
                                                        }
                                                    } else {
                                                        reasons.push($(this).next('label').text());
                                                    }
                                                });

                                                $.ajax({
                                                    url: '../../backends/admin/reject_permit.php',
                                                    method: 'POST',
                                                    data: {
                                                        applicationId: applicationId,
                                                        reasons: reasons
                                                    },
                                                    success: function(response) {
                                                        console.log(response);
                                                        alert('Business permit renewal rejected successfully.');
                                                        $('#RenewalRejectModal').modal('hide');
                                                        $('#RejectPermitModal').modal('hide');
                                                        $('#ResubmitModal').modal('hide');
                                                        // Clear the textarea
                                                        $('#otherReasonText').val('');
                                                        fetchExpiredBusinesses();
                                                    },
                                                    error: function(xhr, status, error) {
                                                        console.error(xhr.responseText);
                                                        alert('Failed to reject business permit renewal.');
                                                    }
                                                });
                                            });
                                        </script>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- Close .card -->
        </div> <!-- Close .col-lg-12 -->
    </div> <!-- Close .row -->
    </div> <!-- Close .container-fluid -->
    </main>

    <!-- View modal -->
    <div class="modal fade" id="viewbusinessinfo" tabindex="-1" aria-labelledby="viewbusinessinfo" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">Business Registration</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mt-2 fs-6 fw-bold text-center">Business Information</p>
                    <ul>
                        <li id="businessName">Business Name: </li>
                        <li id="businessType">Type of Business: </li>
                        <li id="businessContact">Contact #: </li>
                        <li id="businessEmail">Email: </li>
                        <li id="businessAddress">Business Address: </li>
                        <li id="permitExpDate">Permit Expiration Date: </li>
                    </ul>
                    <div class="text-center">
                        <button id="viewImgBtn" class="btn btn-primary text-center">View Business Permit</button>
                    </div>
                    <p class="mt-4 fs-6 fw-bold text-center">Registrant Information</p>
                    <ul>
                        <li id="registrantName">Full Name: </li>
                        <li id="registrantEmail">Email: </li>
                        <li id="registrantContact">Contact #: </li>
                    </ul>
                    <div id="imageContainer" class="text-center mt-3" style="display: none;">
                        <img id="businessPermitImage" src="" alt="Business Permit" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Placeholder for business list -->
    <div id="businessList"></div>

    <script>
        $(document).ready(function() {
            // Fetch pending businesses on page load
            $.ajax({
                url: '../backends/admin/fetch_pending_businesses.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response); // Debugging line to log the response
                    var businesses = response;
                    businesses.forEach(function(business) {
                        var button = $('<button>')
                            .addClass('btn btn-primary')
                            .text('View ' + business.BusinessName)
                            .data('business', business)
                            .attr('data-bs-toggle', 'modal')
                            .attr('data-bs-target', '#viewbusinessinfo');

                        $('#businessList').append(button); // Assuming you have a div with id="businessList"
                    });
                }
            });

            // Show business info in the modal when the button is clicked
            $('#viewbusinessinfo').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var business = button.data('business');
                var modal = $(this);

                modal.find('#businessName').text('Business Name: ' + business.BusinessName);
                modal.find('#businessType').text('Type of Business: ' + business.BusinessType);
                modal.find('#businessContact').text('Contact #: ' + business.BusinessContactNumber);
                modal.find('#businessEmail').text('Email: ' + business.BusinessEmail);
                modal.find('#businessAddress').text('Business Address: ' + business.BusinessAddress);

                // Format the expiration date
                var permitExpDate = new Date(business.PermitExpDate);
                var formattedDate = permitExpDate.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                modal.find('#permitExpDate').text('Permit Expiration Date: ' + formattedDate);

                var registrantName = business.RegistrantFirstName + ' ' + business.RegistrantMiddleName + ' ' + business.RegistrantLastName;
                modal.find('#registrantName').text('Full Name: ' + registrantName);
                modal.find('#registrantEmail').text('Email: ' + business.RegistrantEmail);
                modal.find('#registrantContact').text('Contact #: ' + business.RegistrantContact);

                $('#viewImgBtn').off('click').on('click', function() {
                    $('#businessPermitImage').attr('src', '../../businessowner/uploadsapp/' + business.BusinessPermitImage);
                    $('#imageContainer').show();

                    // Initialize image viewer
                    var viewer = new ImageViewer($('#businessPermitImage')[0]);
                });
            });

            // Reset image container when the modal is hidden
            $('#viewbusinessinfo').on('hide.bs.modal', function() {
                $('#imageContainer').hide();
                $('#businessPermitImage').attr('src', '');
            });
        });
    </script>
    <a href="#" class="theme-toggle">
        <i class="fa-regular fa-sun"></i>
        <i class="fa-regular fa-moon"></i>
    </a>

    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/admin.js"></script>
</body>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const button = document.getElementById('viewPdfBtn');

        button.addEventListener('click', () => {
            // Replace 'path/to/your.pdf' with the actual path to your PDF file
            const pdfPath = 'path/to/your.pdf';

            // Open the PDF file in a new tab
            window.open(pdfPath, '_blank');
        });
    });
</script>

</html>