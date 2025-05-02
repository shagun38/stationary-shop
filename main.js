// banner
window.onload = function() {
    const banner = document.getElementById('offerBanner');

    setInterval(() => {
        banner.classList.toggle('active-banner');
    }, 1500); // Change every 1.5 seconds
}

// brands
window.onload = function() {

    const carousel = document.getElementById('brandCarousel');

    setInterval(() => {
        const firstItem = carousel.firstElementChild;

        const clone = firstItem.cloneNode(true);
        carousel.appendChild(clone); 
        carousel.removeChild(firstItem); 

    }, 2000); 
}

//newsletter
window.onload = function() {

    const form = document.getElementById('newsletterForm');
    const emailInput = document.getElementById('emailInput');
    const successMessage = document.getElementById('successMessage');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); 
        if (emailInput.value.trim() !== "") {
            successMessage.style.display = "block";
            form.reset(); 
        }
    });

};
