document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('libraryForm');
    const nameInput = document.getElementById('libraryName');
    const submitButton = document.getElementById('submitButton');
    const modal = document.getElementById('previewModal');
    const closeButton = document.querySelector('.close-button');
    const confirmButton = document.getElementById('confirmButton');
    const cancelButton = document.getElementById('cancelButton');

    submitButton.addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('previewLibraryName').textContent = nameInput.value;

        modal.style.display = "flex";
    });

    closeButton.addEventListener('click', function() {
        modal.style.display = "none";
    });

    confirmButton.addEventListener('click', function() {
        modal.style.display = "none";
        form.submit(); // Soumet le formulaire après confirmation
    });

    cancelButton.addEventListener('click', function() {
        modal.style.display = "none";
    });

    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    });
});
