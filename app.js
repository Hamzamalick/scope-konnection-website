const menuToggle = document.getElementById("menuToggle");
const navLinks = document.querySelector(".nav-links");

menuToggle.addEventListener("click", () => {
  menuToggle.classList.toggle("active");
  navLinks.classList.toggle("active");
});

// Animations
const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("show");
      }
    });
  },
  {
    threshold: 0.2,
  }
);

document.querySelectorAll(".fade-up").forEach((section) => {
  observer.observe(section);
});

document.querySelectorAll(".nav-links a").forEach((link) => {
  link.addEventListener("click", (e) => {
    // Only prevent default for anchor links that start with #
    if (link.getAttribute("href").startsWith("#")) {
      e.preventDefault();
      const target = document.querySelector(link.getAttribute("href"));
      if (target) {
        target.scrollIntoView({ behavior: "smooth" });
      }

      // Close mobile menu after click
      if (navLinks) navLinks.classList.remove("active");
      if (menuToggle) menuToggle.classList.remove("active");
    }
  });
});

// Form handling
document.addEventListener('DOMContentLoaded', function() {
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Basic form validation
      const firstName = document.getElementById('first_name');
      const secondName = document.getElementById('second_name');
      const email = document.getElementById('email');
      const message = document.getElementById('message');
      
      if (!firstName.value || !secondName.value || !email.value || !message.value) {
        alert('Please fill in all required fields.');
        return;
      }
      
      if (!isValidEmail(email.value)) {
        alert('Please enter a valid email address.');
        return;
      }
      
      // Submit form via AJAX
      submitForm(this);
    });
  }
});

function isValidEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}

function submitForm(form) {
  const formData = new FormData(form);
  const submitBtn = form.querySelector('button[type="submit"]');
  const originalText = submitBtn.textContent;
  
  // Show loading state
  submitBtn.textContent = 'Sending...';
  submitBtn.disabled = true;
  
  fetch('form-handler.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    if (data === 'success') {
      alert('Thank you for your message! We will get back to you soon.');
      form.reset();
    } else {
      alert('Error: ' + data);
    }
  })
  .catch(error => {
    alert('Sorry, there was an error sending your message. Please try again.');
    console.error('Error:', error);
  })
  .finally(() => {
    // Reset button state
    submitBtn.textContent = originalText;
    submitBtn.disabled = false;
  });
}
