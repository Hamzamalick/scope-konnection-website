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
    e.preventDefault();
    const target = document.querySelector(link.getAttribute("href"));
    if (target) {
      target.scrollIntoView({ behavior: "smooth" });
    }

    // Close mobile menu after click
    navLinks.classList.remove("active");
    menuToggle.classList.remove("active");
  });
});

// Contact Form Handling
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
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                if (data.trim() === 'success') {
                    // Show thank you message and hide form
                    signupForm.style.display = 'none';
                    thankYouMessage.style.display = 'block';
                    
                    // Scroll to thank you message
                    thankYouMessage.scrollIntoView({ 
                        behavior: 'smooth',
                        block: 'center'
                    });
                } else {
                    throw new Error(data || 'Unknown error occurred');
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
    
    // Add interactive effects to form inputs
    const formInputs = document.querySelectorAll('.form-group input, .form-group textarea');
    
    formInputs.forEach(input => {
        // Add focus effect
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
        
        // Initialize focused state if input has value
        if (input.value) {
            input.parentElement.classList.add('focused');
        }
    });
});
