import.meta.glob([
  '../images/**',
  '../fonts/**',
]);

// Theme functionality (Alpine.js handles most interactions now)
document.addEventListener('DOMContentLoaded', function() {
  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });

  // Newsletter form handling
  const newsletterForms = document.querySelectorAll('form[action*="newsletter_signup"]');
  newsletterForms.forEach(form => {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      const email = formData.get('email');
      
      if (email && validateEmail(email)) {
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Subscribing...';
        submitBtn.disabled = true;
        
        // Simulate API call (replace with actual newsletter service)
        setTimeout(() => {
          alert('Thank you for subscribing!');
          submitBtn.textContent = originalText;
          submitBtn.disabled = false;
          this.reset();
          
          // Close modal if it exists
          if (window.Alpine) {
            Alpine.store('modals', { newsletterModal: false });
          }
        }, 1000);
      } else {
        alert('Please enter a valid email address.');
      }
    });
  });

  // Search form enhancements
  const searchInputs = document.querySelectorAll('input[type="search"]');
  searchInputs.forEach(input => {
    input.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        this.blur();
        // Close search modal if Alpine.js is available
        if (window.Alpine) {
          Alpine.store('modals', { searchModal: false });
        }
      }
    });
  });

  // Image lazy loading fallback (for browsers without native support)
  if ('IntersectionObserver' in window) {
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const img = entry.target;
          img.src = img.dataset.src;
          img.removeAttribute('data-src');
          imageObserver.unobserve(img);
        }
      });
    });

    images.forEach(img => imageObserver.observe(img));
  }
});

// Email validation helper
function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}

// Scroll to top functionality (for back-to-top button)
if (typeof window !== 'undefined') {
  window.scrollToTop = function() {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  };
}

// Global Alpine.js data and methods
document.addEventListener('alpine:init', () => {
  if (window.Alpine) {
    Alpine.store('theme', {
      stickyHeaderOffset: 50,
    });

    Alpine.store('modals', {
      searchModal: false,
      newsletterModal: false,
    });
  }
});
