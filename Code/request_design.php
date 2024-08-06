<?php
include_once("header.php");

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: sign_in_page.php");
    exit();
}
?>

<main>
    <div class="design_request_container">
        <h3 class="design_request_title">Request a Specific Design</h3>
        <form id="design_form" action="process_design_request.php" method="post" enctype="multipart/form-data">
            <div class="form_group">
                <label for="request_description" id="request_design_label">Description:</label>
                <textarea name="request_description" id="request_description" required></textarea>
            </div>
            <div class="form_group">
                <label for="design_photo" id="request_design_label">Upload Photo:</label>
                <div id="drop_area">Drag & Drop Files Here</div>
                <input type="file" name="design_photo" id="design_photo" accept="image/*" required hidden>
                <p id="file_info"></p>
            </div>
            <input type="submit" value="Submit Request" class="submit_button">
        </form>
    </div>
</main>

<?php 
include_once("footer.html");
?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let dropArea = document.getElementById('drop_area');
    let fileInput = document.getElementById('design_photo');
    let fileInfo = document.getElementById('file_info');

    dropArea.addEventListener('dragover', (event) => {
        event.preventDefault();
        dropArea.style.borderColor = 'orange';
    });

    dropArea.addEventListener('dragleave', () => {
        dropArea.style.borderColor = '#ddd';
    });

    dropArea.addEventListener('drop', (event) => {
        event.preventDefault();
        dropArea.style.borderColor = '#ddd';
        let files = event.dataTransfer.files;
        fileInput.files = files;
        fileInfo.textContent = `File: ${files[0].name}`;
    });

    dropArea.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', () => {
        fileInfo.textContent = `File: ${fileInput.files[0].name}`;
    });
});
</script>
