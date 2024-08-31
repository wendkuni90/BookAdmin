document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('librarianForm');
    const nameInput = document.getElementById('librarianName');
    const telInput = document.getElementById('librarianTel');
    const mailInput = document.getElementById('librarianMail');
    const librarySelect = document.getElementById('librarySelect');
    const submitButton = document.getElementById('submitButton');
    const modal = document.getElementById('previewModal');
    const closeButton = document.querySelector('.close-button');
    const confirmButton = document.getElementById('confirmButton');
    const cancelButton = document.getElementById('cancelButton');

    submitButton.addEventListener('click', function(event) {
        event.preventDefault();
        
        // Remplir les informations du modal avec les valeurs du formulaire
        document.getElementById('previewLibrarianName').textContent = nameInput.value;
        document.getElementById('previewLibrarianTel').textContent = telInput.value;
        document.getElementById('previewLibrarianMail').textContent = mailInput.value;
        document.getElementById('previewLibraryName').textContent = librarySelect.options[librarySelect.selectedIndex].text;

        // Afficher le modal
        modal.style.display = "flex";
    });

    closeButton.addEventListener('click', function() {
        modal.style.display = "none";
    });

    confirmButton.addEventListener('click', function() {
        modal.style.display = "none";
        form.submit(); // Soumettre le formulaire après confirmation
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
