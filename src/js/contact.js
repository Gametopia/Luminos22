// src/js/contact.js
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("contactForm");
  const successMessage = document.getElementById("formSuccess");
  const errorMessage = document.getElementById("formError");

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const message = document.getElementById("message").value.trim();

    if (!name || !email || !message) {
      errorMessage.textContent = "Vul alstublieft alle verplichte velden in.";
      return;
    }

    try {
      const response = await fetch("sendContact.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ name, email, phone, message }),
      });

      const result = await response.json();

      if (response.ok && result.success) {
        successMessage.style.display = "block";
        errorMessage.textContent = "";
        form.reset();
      } else {
        errorMessage.textContent = result.error || "Er is een fout opgetreden.";
      }
    } catch (err) {
      errorMessage.textContent = "Verbinding met de server mislukt.";
    }
  });
});
