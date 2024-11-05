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
  <script src="https://code.jquery.com/jquery-3.7.0.slim.min.js"></script>
  <script src="../wordcounter/jquery.word-and-character-counter.js"></script>
  <link rel="stylesheet" href="../css/admin.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">
</head>

<body>
  <div class="wrapper">
    <?php include '../admin/includes/aside.php'; ?>
    <div class="main">
      <?php include '../admin/includes/navbar.php'; ?>
      <main class="content px-3 py-2">
        <form id="editForm" method="POST" action="../../backends/admin/frontpagecontentslider.php" enctype="multipart/form-data">
          <div class="container-fluid">
            <div class="mb-3">
              <h4 class="">Manage Front Page Contents</h4>
              <button type="button" class="btn btn-warning px-4" onclick="showEditModal()">EDIT</button>
            </div>
          </div>
          <div class="front-page-content">
            <input type="hidden" name="frontpageid" id="contentId">
            <div class="card shadow border-0 mt-3">
              <div class="card-header py-3">
                <h5 class="card-title">Manage Frontpage Descriptions</h5>
              </div>
              <div class="card-body">
                <div class="row mx-4 d-flex justify-content-center align-items-center">
                  <div class="col-lg-10 mb-4">
                    <label for="exampleFormControlTextarea1" class="form-label fw-bold">Text Content</label>
                    <textarea class="form-control shadow" name="description" id="description" placeholder="(Minimum of 50 words)" rows="5" required readonly></textarea>
                    <div id="description-word-count" class="text-end text-muted"></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card shadow border-0 mt-3">
              <div class="card-header py-3">
                <h5 class="card-title">Manage Card Slider</h5>
              </div>
              <div class="card-body">
                <div class="row mx-4 d-flex justify-content-center align-items-center">
                  <div class="col-lg-10 mb-4 shadow border rounded">
                    <div class="card-body">
                      <h4 class="fw-bold text-success my-3">Slider 1</h4>
                      <div class="row d-flex justify-content-evenly">
                        <div class="col-lg-5 col-md-8 col-sm-12">
                          <div class="mb-3 text-center">
                            <p class="fw-bold">Slider Image 1</p>
                            <input name="sliderimage1" type="file" id="slider-image-input-1" style="display: none;" accept="image/*" onchange="uploadImage('slider-image-input-1', 'slider-image-1')" disabled>
                            <label for="slider-image-input-1" class="image-container">
                              <img src="../img/general-img/insert.png" class="rounded img-fluid shadow border" alt="Slider Image 1" id="slider-image-1" width="200" height="200">
                            </label>
                          </div>
                        </div>
                        <div class="col-lg-5 mb-4">
                          <label for="" class="fw-bold">Title</label>
                          <input type="text" name="slider_title_1" id="slider_title_1" placeholder="Slider Title 1" class="form-control shadow my-2" required readonly>
                          <label for="" class="fw-bold mt-3">Short Description</label>
                          <textarea name="slider_content_1" id="slider_content_1" placeholder="Slider Content 1 (Minimum of 25 words)" class="form-control shadow my-2" rows="6" required readonly></textarea>
                          <div id="slider_content_1-word-count" class="text-end text-muted"></div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-10 mb-4 shadow border rounded">
                    <div class="card-body">
                      <h4 class="fw-bold text-success my-3">Slider 2</h4>
                      <div class="row d-flex justify-content-evenly">
                        <div class="col-lg-5 col-md-8 col-sm-12">
                          <div class="mb-3 text-center">
                            <p class="fw-bold">Slider Image 2</p>
                            <input name="sliderimage2" type="file" id="slider-image-input-2" style="display: none;" accept="image/*" onchange="uploadImage('slider-image-input-2', 'slider-image-2')" disabled>
                            <label for="slider-image-input-2" class="image-container">
                              <img src="../img/general-img/insert.png" class="rounded img-fluid shadow border" alt="Slider Image 2" id="slider-image-2" width="200" height="200">
                            </label>
                          </div>
                        </div>
                        <div class="col-lg-5 mb-4">
                          <label for="" class="fw-bold">Title</label>
                          <input type="text" name="slider_title_2" id="slider_title_2" placeholder="Slider Title 2" class="form-control shadow my-2 mb-4" required readonly>
                          <label for="" class="fw-bold">Short Description</label>
                          <textarea name="slider_content_2" id="slider_content_2" placeholder="Slider Content 2 (Minimum of 25 words)" class="form-control shadow my-2" rows="6" required readonly></textarea>
                          <div id="slider_content_2-word-count" class="text-end text-muted"></div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-10 mb-4 shadow border rounded">
                    <div class="card-body">
                      <h4 class="fw-bold text-success my-3">Slider 3</h4>
                      <div class="row d-flex justify-content-evenly">
                        <div class="col-lg-5 col-md-8 col-sm-12">
                          <div class="mb-3 text-center">
                            <p class="fw-bold">Slider Image 3</p>
                            <input name="sliderimage3" type="file" id="slider-image-input-3" style="display: none;" accept="image/*" onchange="uploadImage('slider-image-input-3', 'slider-image-3')" disabled>
                            <label for="slider-image-input-3" class="image-container">
                              <img src="../img/general-img/insert.png" class="rounded img-fluid shadow border" alt="Slider Image 3" id="slider-image-3" width="200" height="200">
                            </label>
                          </div>
                        </div>
                        <div class="col-lg-5 mb-4">
                          <label for="" class="fw-bold">Title</label>
                          <input type="text" name="slider_title_3" id="slider_title_3" placeholder="Slider Title 3" class="form-control shadow my-2" required readonly>
                          <label for="" class="fw-bold">Short Description</label>
                          <textarea name="slider_content_3" id="slider_content_3" placeholder="Slider Content 3 (Minimum of 25 words)" class="form-control shadow my-2" rows="6" required readonly></textarea>
                          <div id="slider_content_3-word-count" class="text-end text-muted"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12 mb-3">
                    <button type="button" class="btn btn-success px-4 me-2" onclick="showSaveModal()" disabled>SAVE</button>
                    <a href="../admin/dashboard.php" class="btn btn-secondary">CANCEL</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </main>

      <a href="#" class="theme-toggle">
        <i class="fa-regular fa-sun"></i>
        <i class="fa-regular fa-moon"></i>
      </a>

      <footer class="footer">
        <div class="container-fluid">
          <div class="row text-muted">
            <div class="col-6 text-start">
              <p class="mb-0"><a href="#" class="text-muted"><strong>HaKingz</strong></a></p>
            </div>
            <div class="col-6 text-end">
              <ul class="list-inline">
                <li class="list-inline-item"><a href="#" class="text-muted">Contact</a></li>
                <li class="list-inline-item"><a href="#" class="text-muted">About Us</a></li>
                <li class="list-inline-item"><a href="#" class="text-muted">Terms</a></li>
                <li class="list-inline-item"><a href="#" class="text-muted">Booking</a></li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <!-- Edit Confirmation Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Confirm Edit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Do you want to edit the content?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="confirmEdit()">Confirm</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Save Confirmation Modal -->
  <div class="modal fade" id="saveModal" tabindex="-1" aria-labelledby="saveModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="saveModalLabel">Confirm Save</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Do you want to save the changes?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="confirmSave()">Confirm</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <script src="../js/admin.js"></script>
  <script>
    const notyf = new Notyf({
      duration: 5000,
      position: {
        x: 'right',
        y: 'top',
      },
    });

    function uploadImage(inputId, imgId) {
      var input = document.getElementById(inputId);
      var img = document.getElementById(imgId);
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          img.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
      }
    }

    function fetchData() {
      fetch('../../backends/admin/get_frontpagecontent.php')
        .then(response => response.json())
        .then(data => {
          if (data.error) {
            notyf.error(data.error);
            return;
          }
          updateContent(data);
        });
    }

    function updateContent(data) {
      document.getElementById('contentId').value = data.frontpageid;
      document.getElementById('description').value = data.description;
      document.getElementById('slider_title_1').value = data.slider_title_1;
      document.getElementById('slider_content_1').value = data.slider_content_1;
      document.getElementById('slider_title_2').value = data.slider_title_2;
      document.getElementById('slider_content_2').value = data.slider_content_2;
      document.getElementById('slider_title_3').value = data.slider_title_3;
      document.getElementById('slider_content_3').value = data.slider_content_3;
      // Set image previews
      if (data.slider_image_1) {
        document.getElementById('slider-image-1').src = '../admin/uploadannounce/' + data.slider_image_1;
      }
      if (data.slider_image_2) {
        document.getElementById('slider-image-2').src = '../admin/uploadannounce/' + data.slider_image_2;
      }
      if (data.slider_image_3) {
        document.getElementById('slider-image-3').src = '../admin/uploadannounce/' + data.slider_image_3;
      }
    }

    function showEditModal() {
      var editModal = new bootstrap.Modal(document.getElementById('editModal'));
      editModal.show();
    }

    function confirmEdit() {
      var editModal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
      editModal.hide();
      enableEditing();
    }

    function enableEditing() {
      document.getElementById('description').readOnly = false;
      document.getElementById('slider_title_1').readOnly = false;
      document.getElementById('slider_content_1').readOnly = false;
      document.getElementById('slider_title_2').readOnly = false;
      document.getElementById('slider_content_2').readOnly = false;
      document.getElementById('slider_title_3').readOnly = false;
      document.getElementById('slider_content_3').readOnly = false;
      document.getElementById('slider-image-input-1').disabled = false;
      document.getElementById('slider-image-input-2').disabled = false;
      document.getElementById('slider-image-input-3').disabled = false;
      document.querySelector('.btn-success').disabled = false;
    }

    function showSaveModal() {
      var saveModal = new bootstrap.Modal(document.getElementById('saveModal'));
      saveModal.show();
    }

    function confirmSave() {
      var saveModal = bootstrap.Modal.getInstance(document.getElementById('saveModal'));
      saveModal.hide();
      submitForm();
    }

    function submitForm() {
      const formData = new FormData(document.getElementById('editForm'));
      fetch(document.getElementById('editForm').action, {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.error) {
            notyf.error(data.error);
          } else {
            notyf.success(data.success);
            updateContent(data);
            disableEditing();
          }
        })
        .catch(error => {
          notyf.error('An error occurred.');
        });
    }

    function disableEditing() {
      document.getElementById('description').readOnly = true;
      document.getElementById('slider_title_1').readOnly = true;
      document.getElementById('slider_content_1').readOnly = true;
      document.getElementById('slider_title_2').readOnly = true;
      document.getElementById('slider_content_2').readOnly = true;
      document.getElementById('slider_title_3').readOnly = true;
      document.getElementById('slider_content_3').readOnly = true;
      document.getElementById('slider-image-input-1').disabled = true;
      document.getElementById('slider-image-input-2').disabled = true;
      document.getElementById('slider-image-input-3').disabled = true;
      document.querySelector('.btn-success').disabled = true;
    }

    document.addEventListener('DOMContentLoaded', function() {
      fetchData();

      // Initialize word counters
      $('#description').counter({
        type: 'word',
        count: 'up',
        goal: 50,
        target: '#description-word-count',
        text: true,
        translation: 'word left max'
      });
      $('#slider_content_1').counter({
        type: 'word',
        count: 'up',
        goal: 25,
        target: '#slider_content_1-word-count',
        text: true,
        translation: 'word left max'
      });
      $('#slider_content_2').counter({
        type: 'word',
        count: 'up',
        goal: 25,
        target: '#slider_content_2-word-count',
        text: true,
        translation: 'word left max'
      });
      $('#slider_content_3').counter({
        type: 'word',
        count: 'up',
        goal: 25,
        target: '#slider_content_3-word-count',
        text: true,
        translation: 'word left max'
      });
    });
  </script>
</body>

</html>