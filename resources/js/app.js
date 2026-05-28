// resources/js/app.js
// Sonara — Vanilla JS enhancements for Laravel

// Navbar scroll
window.addEventListener('scroll', () => {
  const navbar = document.getElementById('navbar');
  if (navbar) navbar.classList.toggle('scrolled', window.scrollY > 20);
});

// Mobile menu
const hamburger = document.getElementById('hamburger-btn');
const mobileMenu = document.getElementById('mobile-menu');
if (hamburger && mobileMenu) {
  hamburger.addEventListener('click', () => mobileMenu.classList.toggle('open'));
  // Close on outside click
  document.addEventListener('click', (e) => {
    if (!hamburger.contains(e.target) && !mobileMenu.contains(e.target)) {
      mobileMenu.classList.remove('open');
    }
  });
}

// Toast auto dismiss
const toast = document.getElementById('toast');
if (toast) {
  setTimeout(() => toast.classList.remove('show'), 3500);
}

// Pricing toggle (for pricing page)
window.setPricingMode = function(mode, btn) {
  document.querySelectorAll('.toggle-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('[data-price]').forEach(el => {
    el.textContent = '$' + el.dataset[mode];
  });
};

// AJAX add to cart (optional enhancement - keeps user on page)
document.querySelectorAll('.ajax-cart-form').forEach(form => {
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const res = await fetch(form.action, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ qty: 1 }),
    });
    if (res.ok) {
      const data = await res.json();
      // Update cart badge
      const badge = document.querySelector('.cart-badge');
      if (badge) badge.textContent = data.cart_count;
      // Show toast
      showToast(data.message);
    }
  });
});

function showToast(msg) {
  let toast = document.getElementById('toast');
  if (!toast) {
    toast = document.createElement('div');
    toast.id = 'toast';
    toast.innerHTML = '<span id="toast-msg"></span>';
    document.body.appendChild(toast);
  }
  document.getElementById('toast-msg').textContent = msg;
  toast.classList.add('show');
  clearTimeout(window._toastTimer);
  window._toastTimer = setTimeout(() => toast.classList.remove('show'), 3000);
}
