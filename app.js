const menuToggle = document.getElementById("menuToggle");
const navLinks = document.querySelector(".nav-links");

menuToggle.addEventListener("click", () => {
  menuToggle.classList.toggle("active");
  navLinks.classList.toggle("active");
});

// ANimations
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
    e.preventDefault();
    const target = document.querySelector(link.getAttribute("href"));
    target.scrollIntoView({ behavior: "smooth" });

    // Optional: close mobile menu after click
    document.querySelector(".nav-links").classList.remove("active");
    document.getElementById("menuToggle").classList.remove("active");
  });
});
// Form submission handling
document.addEventListener('DOMContentLoaded', function() {
    const signupForm = document.getElementById('signupForm');
    const thankYouMessage = document.getElementById('thankYouMessage');
    
    if (signupForm) {
        signupForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitButton = signupForm.querySelector('.submit-button');
            const originalText = submitButton.textContent;
            submitButton.textContent = 'Sending...';
            submitButton.disabled = true;
            
            // Get form data
            const formData = new FormData(signupForm);
            
            // Send AJAX request
            fetch('process_form.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data === 'success') {
                    // Show thank you message and hide form
                    signupForm.style.display = 'none';
                    thankYouMessage.style.display = 'block';
                    
                    // Scroll to thank you message
                    thankYouMessage.scrollIntoView({ behavior: 'smooth' });
                } else {
                    // Show errors
                    alert('Error: ' + data);
                    submitButton.textContent = originalText;
                    submitButton.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                submitButton.textContent = originalText;
                submitButton.disabled = false;
            });
        });
    }
});
