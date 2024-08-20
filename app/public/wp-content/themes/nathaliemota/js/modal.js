//**Popup */
document.addEventListener('DOMContentLoaded', function() {
    const closeButton = document.querySelector('.popup-close');
    const popupOverlay = document.querySelector('.popup');
    const menuContactItems = document.querySelectorAll('.menu-item-contact a'); 
    const ctaContact = document.getElementById('ctaContact');

    function openPopup(refPhoto = null) {
        if (refPhoto) {
            const refPhotoField = document.querySelector('input[id="reference"]');
            if (refPhotoField) {
                refPhotoField.value = refPhoto;
            }
        }
        popupOverlay.style.display = 'flex';
        document.body.classList.add('popup-open');
    }

    function closePopup() {
        popupOverlay.style.display = 'none';
        document.body.classList.remove('popup-open');
    }

    if (menuContactItems) { 
        menuContactItems.forEach(function(menuContact){
            menuContact.addEventListener('click', function(event) {          
                event.preventDefault();
                document.getElementById('menu-modal').classList.remove('show');
                document.querySelectorAll('.modal_burger').forEach(function(burgerButtonItem){
                    burgerButtonItem.classList.remove('close');   
                });
                openPopup();
            });
        });
    }

    if (ctaContact) {
        ctaContact.addEventListener('click', function() {
            const refPhoto = ctaContact.getAttribute('data-ref-photo');
            openPopup(refPhoto);
        });

        // Ajout du pré-remplissage de la référence photo dans le formulaire Contact
        const refPhotoFieldInForm = document.getElementById('referencePhoto');
        if (refPhotoFieldInForm) {
            const refPhoto = ctaContact.getAttribute('data-ref-photo');
            if (refPhoto) {
                refPhotoFieldInForm.value = refPhoto;
            }
        }
    }

    if (closeButton) {
        closeButton.addEventListener('click', closePopup);
    }

    popupOverlay.addEventListener('click', function(event) {
        if (event.target === popupOverlay) {
            closePopup();
        }
    });
});
