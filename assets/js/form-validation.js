document.addEventListener("DOMContentLoaded", () => {
  
  const form = document.querySelector(".contact-form");

  if (!form) {
    console.error("Form not found!");
    return;
  }

  form.addEventListener("submit", function(e) {
    let valid = true;
    let errors = [];

    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const message = document.getElementById("message").value.trim();

    if (name.length < 2) {
      valid = false;
      errors.push("Please enter your name.");
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
      valid = false;
      errors.push("Please enter a valid email.");
    }

    const phonePattern = /^\+?[0-9\s\-]{7,15}$/;
    if (phone !== "" && !phonePattern.test(phone)) {
      valid = false;
      errors.push("Please enter a valid phone number.");
    }

    if (message.length < 5) {
      valid = false;
      errors.push("Message should be at least 5 characters.");
    }

    if (!valid) {
      e.preventDefault();
      alert("Please fix the following:\n\n" + errors.join("\n"));
    }
  });

});
