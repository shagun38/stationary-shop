document.addEventListener("DOMContentLoaded", () => {
    // Banner toggle
    const banner = document.getElementById('offerBanner');
    if (banner) {
        setInterval(() => {
            banner.classList.toggle('active-banner');
        }, 1500);
    }

    // Brand carousel
    const carousel = document.getElementById('brandCarousel');
    if (carousel) {
        setInterval(() => {
            const firstItem = carousel.firstElementChild;
            if (firstItem) {
                const clone = firstItem.cloneNode(true);
                carousel.appendChild(clone);
                carousel.removeChild(firstItem);
            }
        }, 2000);
    }

    // Newsletter form
    const form = document.getElementById('newsletterForm');
    if (form) {
        const emailInput = document.getElementById('emailInput');
        const successMessage = document.getElementById('successMessage');
        form.addEventListener('submit', event => {
            event.preventDefault();
            if (emailInput.value.trim() !== "") {
                successMessage.style.display = "block";
                form.reset();
            }
        });
    }

    // Add-to-cart buttons
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            updateQuantity(id, 'add', button);
        });
    });

    // Quantity controls
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const wrapper = btn.closest('.qty-controls');
            const id = wrapper.dataset.id;
            const action = btn.classList.contains('plus') ? 'add' : 'remove';
            updateQuantity(id, action, wrapper);
        });
    });
});

// Quantity logic
function updateQuantity(id, action, element) {
    fetch('cart-handler.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}&action=${action}`
    })
    .then(res => res.text())
    .then(response => {
        const trimmed = response.trim();

        if (trimmed === "login_required") {
            window.location.href = "login.php";
            return;
        }

        const qty = parseInt(trimmed);

        if (!isNaN(qty)) {
            if (qty === 0) {
                location.reload();
            } else {
                if (element.classList.contains('add-to-cart-btn')) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'qty-controls';
                    wrapper.setAttribute('data-id', id);
                    wrapper.innerHTML = `
                        <button class="qty-btn minus">-</button>
                        <span class="qty-display">${qty}</span>
                        <button class="qty-btn plus">+</button>
                    `;
                    element.replaceWith(wrapper);
                    attachQtyListeners(wrapper);
                } else {
                    const display = element.querySelector('.qty-display');
                    if (display) display.textContent = qty;
                }
            }
        } else {
            console.warn("Non-numeric server response:", trimmed);
        }
    })
    .catch(err => {
        console.error("Fetch error:", err);
    });
}

function attachQtyListeners(container) {
    container.querySelector('.plus').addEventListener('click', () => {
        const id = container.dataset.id;
        updateQuantity(id, 'add', container);
    });

    container.querySelector('.minus').addEventListener('click', () => {
        const id = container.dataset.id;
        updateQuantity(id, 'remove', container);
    });
}


function validatePassword() {
    const password = document.getElementById('new_password').value;
    const confirm = document.getElementById('confirm_password').value;

    const hasUpper = /[A-Z]/.test(password);
    const hasLower = /[a-z]/.test(password);
    const hasDigit = /\d/.test(password);
    const hasSpecial = /[\W_]/.test(password);
    const isLong = password.length >= 8;

    if (password !== confirm) {
        alert("Passwords do not match.");
        return false;
    }

    if (!hasUpper || !hasLower || !hasDigit || !hasSpecial || !isLong) {
        alert("Password must be at least 8 characters and include uppercase, lowercase, number, and special character.");
        return false;
    }

    return true;
}
