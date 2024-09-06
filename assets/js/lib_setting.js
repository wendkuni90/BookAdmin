// Fonction pour afficher/masquer le mot de passe
document.querySelectorAll('input[type="password"]').forEach(input => {
    let toggle = document.createElement('span');
    toggle.innerHTML = '🙊';
    toggle.style.cursor = 'pointer';
    toggle.style.position = 'absolute';
    toggle.style.right = '10px';
    toggle.style.top = '50%';
    toggle.style.transform = 'translateY(-50%)';
    
    let wrapper = document.createElement('div');
    wrapper.style.position = 'relative';
    wrapper.style.display = 'inline-block';
    wrapper.style.width = '100%';
    
    input.parentNode.insertBefore(wrapper, input);
    wrapper.appendChild(input);
    wrapper.appendChild(toggle);

    toggle.addEventListener('click', function() {
        if (input.type === 'password') {
            input.type = 'text';
            toggle.innerHTML = '🙈'; // Icône quand le mot de passe est visible
        } else {
            input.type = 'password';
            toggle.innerHTML = '🙊'; // Icône quand le mot de passe est masqué
        }
    });
});

// Fonction pour demander confirmation avant la soumission
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(event) {
        let confirmation = confirm("Voulez-vous vraiment appliquer ces changements?");
        if (!confirmation) {
            event.preventDefault(); // Annule la soumission si l'utilisateur ne confirme pas
        }
    });
});
