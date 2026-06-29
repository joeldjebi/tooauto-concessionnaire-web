const paymentMethod = document.getElementById("payment-method");
const mobileMoneyForm = document.getElementById("mobile-money-form");
const cardForm = document.getElementById("card-form");

paymentMethod.addEventListener("change", function() {
  if (paymentMethod.value === "mobile-money") {
    mobileMoneyForm.style.display = "block";
    cardForm.style.display = "none";
  } else if (paymentMethod.value === "card") {
    mobileMoneyForm.style.display = "none";
    cardForm.style.display = "block";
  }
});
