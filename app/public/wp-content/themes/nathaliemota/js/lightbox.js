document.addEventListener('DOMContentLoaded', function() {
    console.log('Script loaded');

    const lightbox = document.querySelector('.lightbox');
    const overlayLightbox = document.querySelector('.overlay-lightbox');
    const lightboxImage = document.querySelector('.middle-image');
    const lightboxCategory = document.getElementById('lightbox-category');
    const lightboxReference = document.getElementById('lightbox-reference');
    const lightboxClose = document.querySelector('.lightbox_close');
    const lightboxPrev = document.querySelector('.lightbox_prev');
    const lightboxNext = document.querySelector('.lightbox_next');
    let currentIndex = 0;

    function getImages() {
        return Array.from(document.querySelectorAll('.photo')).map(photo => {
            const src = photo.getAttribute('data-href');
            const category = photo.getAttribute('data-category');
            const reference = photo.getAttribute('data-reference');
            // Ne retourner l'image que si elle a tous les attributs requis
            if (src && category && reference) {
                return { src, category, reference };
            } else {
                console.warn('Image with missing attributes found:', photo);
                return null;
            }
        }).filter(image => image !== null); // Filtrer les images nulles
    }

    function openLightbox(index) {
        console.log('Opening lightbox for index:', index);
        const images = getImages();
        if (images.length === 0) {
            console.error('No valid images found');
            return;
        }
        if (index < 0 || index >= images.length) {
            console.error('Index out of bounds:', index);
            return;
        }
        currentIndex = index;
        const { src, category, reference } = images[currentIndex];
        lightboxImage.src = src;
        lightboxCategory.textContent = `Catégorie: ${category}`;
        lightboxReference.textContent = `Référence: ${reference}`;
        lightbox.style.display = 'flex';
        overlayLightbox.style.display = 'flex';
    }

    function closeLightbox() {
        console.log('Closing lightbox');
        lightbox.style.display = 'none';
        overlayLightbox.style.display = 'none'; 
    }

    function showPrevImage() {
        const images = getImages();
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1;
        openLightbox(currentIndex);
    }

    function showNextImage() {
        const images = getImages();
        currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0;
        openLightbox(currentIndex);
    }

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('fullscreen')) {
            e.preventDefault();
            const photos = document.querySelectorAll('.photo');
            const index = Array.from(photos).indexOf(e.target.closest('.photo'));
            console.log('Fullscreen icon clicked:', index);
            openLightbox(index);
        }
    });

    lightboxClose.addEventListener('click', closeLightbox);
    lightboxPrev.addEventListener('click', showPrevImage);
    lightboxNext.addEventListener('click', showNextImage);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeLightbox();
        } else if (e.key === 'ArrowLeft') {
            showPrevImage();
        } else if (e.key === 'ArrowRight') {
            showNextImage();
        }
    });
});
