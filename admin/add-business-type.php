<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}

include "../includes/db.php";

function normalizeInput($input)
{
  return strtolower(trim($input));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_add_type'])) {
  $typeName = normalizeInput($_POST['typeName']);
  if (!empty($typeName)) {
    $stmt = $pdo->prepare('SELECT * FROM businesstype WHERE LOWER(TypeName) = :typeName');
    $stmt->execute(['typeName' => $typeName]);
    if ($stmt->rowCount() == 0) {
      $stmt = $pdo->prepare('INSERT INTO businesstype (TypeName) VALUES (:typeName)');
      $stmt->execute(['typeName' => $_POST['typeName']]);
      $_SESSION['message'] = 'Business type added successfully.';
      $_SESSION['message_type'] = 'success';
    } else {
      $_SESSION['message'] = 'Business type already exists.';
      $_SESSION['message_type'] = 'danger';
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete_type'])) {
  $typeId = $_POST['typeId'];

  $stmt = $pdo->prepare('SELECT * FROM businessinformationform WHERE BusinessTypeID = :typeId');
  $stmt->execute(['typeId' => $typeId]);

  if ($stmt->rowCount() > 0) {
    $_SESSION['message'] = 'Cannot delete business type because it is referenced by other records.';
    $_SESSION['message_type'] = 'warning'; // Set message type to 'warning'
  } else {
    $stmt = $pdo->prepare('DELETE FROM businesstype WHERE BusinessTypeID = :typeId');
    $stmt->execute(['typeId' => $typeId]);
    $_SESSION['message'] = 'Business type deleted successfully.';
    $_SESSION['message_type'] = 'success';
  }

  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}

$stmt = $pdo->query('SELECT * FROM businesstype');
$businessTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <link rel="stylesheet" href="../css/admin.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
</head>

<body>
  <div class="wrapper">
    <?php include '../admin/includes/aside.php'; ?>
    <div class="main">
      <?php include '../admin/includes/navbar.php'; ?>
      <main class="content px-3 py-2">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <div class="card card-custom mb-3">
                <div class="card-header card-header-custom">
                  <h5 class="mb-0">Add Business Type</h5>
                </div>
                <div class="card-body">
                  <form id="addTypeForm" onsubmit="event.preventDefault(); showConfirmationModal('add');">
                    <div class="mb-3">
                      <label for="typeName" class="form-label">Business Type Name</label>
                      <input type="text" class="form-control" id="typeName" name="typeName" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-custom">Add Type</button>
                  </form>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card card-custom mt-3 mt-md-0">
                <div class="card-header card-header-custom">
                  <h5 class="mb-0">Existing Business Types</h5>
                </div>
                <div class="card-body">
                  <table class="table table-custom">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th class="actions-col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($businessTypes as $type) : ?>
                        <tr>
                          <td><?= htmlspecialchars($type['TypeName']); ?></td>
                          <td class="actions-col">
                            <button class="btn btn-danger btn-custom" onclick="showConfirmationModal('delete', <?= $type['BusinessTypeID']; ?>)">Delete</button>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
      <a href="#" class="theme-toggle">
        <i class="fa-regular fa-sun"></i>
        <i class="fa-regular fa-moon"></i>
      </a>
    </div>
  </div>

  <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header modal-header-custom">
          <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="confirmationModalBody">
        </div>
        <div class="modal-footer modal-footer-custom">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <form method="POST" action="" id="confirmationForm">
            <input type="hidden" id="confirmationTypeName" name="typeName">
            <input type="hidden" id="confirmationTypeId" name="typeId">
            <button type="submit" class="btn btn-primary" id="confirmationButton">Confirm</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../js/admin.js"></script>
  <script>
    function showConfirmationModal(action, typeId = null) {
      const modalTitle = document.getElementById('confirmationModalLabel');
      const modalBody = document.getElementById('confirmationModalBody');
      const confirmationButton = document.getElementById('confirmationButton');
      const typeNameInput = document.getElementById('typeName');

      if (action === 'add') {
        modalTitle.textContent = 'Confirm Add Business Type';
        modalBody.textContent = 'Are you sure you want to add this business type?';
        confirmationButton.name = 'confirm_add_type';
        document.getElementById('confirmationTypeName').value = typeNameInput.value;
      } else if (action === 'delete') {
        modalTitle.textContent = 'Confirm Delete Business Type';
        modalBody.textContent = 'Are you sure you want to delete this business type?';
        confirmationButton.name = 'confirm_delete_type';
        document.getElementById('confirmationTypeId').value = typeId;
      }

      const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
      confirmationModal.show();
    }

    document.addEventListener('DOMContentLoaded', function() {
      const notyf = new Notyf({
        duration: 5000,
        position: {
          x: 'right',
          y: 'top',
        },
        types: [{
            type: 'warning',
            background: '#FFD700',
            icon: {
              className: 'fas fa-exclamation-triangle',
              tagName: 'span',
              color: '#000'
            }
          },
          {
            type: 'danger',
            background: '#dc3545',
            icon: {
              className: 'fas fa-times-circle',
              tagName: 'span',
              color: '#fff'
            }
          },
          {
            type: 'success',
            background: '#28a745',
            icon: {
              className: 'fas fa-check-circle',
              tagName: 'span',
              color: '#fff'
            }
          }
        ]
      });

      <?php if (isset($_SESSION['message'])) : ?>
        notyf.open({
          type: '<?php echo htmlspecialchars($_SESSION['message_type']); ?>',
          message: '<?php echo htmlspecialchars($_SESSION['message']); ?>'
        });
        <?php unset($_SESSION['message']); ?>
        <?php unset($_SESSION['message_type']); ?>
      <?php endif; ?>
    });
  </script>
</body>

</html>