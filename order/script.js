"use strict";

// element
const payAmountBtn = document.querySelector("#payAmount");
const decrementBtn = document.querySelectorAll("#decrement");
const quantityElem = document.querySelector("#quantity");
const incrementBtn = document.querySelectorAll("#increment");
const priceElem = document.querySelectorAll("#price");
const subtotalElem = document.querySelector("#subtotal");
const taxElem = document.querySelector("#tax");
const totalElem = document.querySelector("#total");
const quantitiesInput = document.querySelector("#quantities"); 

quantitiesInput.value = quantityElem.textContent;


for (let i = 0; i < incrementBtn.length; i++) {
  let lastIndex = i;

  incrementBtn[i].addEventListener("click", function () {
    let increment = Number(this.previousElementSibling.textContent);
    increment++;
    this.previousElementSibling.textContent = increment;

    quantitiesInput.value = increment;
    totalCalc(lastIndex);
  });

  decrementBtn[i].addEventListener("click", function () {
    let decrement = Number(this.nextElementSibling.textContent);
    decrement <= 1 ? 1 : decrement--;

    this.nextElementSibling.textContent = decrement;

    quantitiesInput.value = decrement;
    totalCalc(lastIndex);
  });
}

const formatCurrency = new Intl.NumberFormat("id-ID", {
  style: "currency",
  currency: "IDR",
  minimumFractionDigits: 2,
  maximumFractionDigits: 2,
});

const totalCalc = function (index) {
  const taxRate = 0.05;
  let subtotal = 0;
  let totalTax = 0;
  let total = 0;

  for (let i = 0; i < priceElem.length; i++) {
    const priceString = priceElem[i].textContent;
    const priceNumeric = parseFloat(priceString.replace(/[^\d.-]+/g, ""));
    subtotal += Number(quantityElem.textContent) * priceNumeric; 
  }

  subtotalElem.textContent = formatCurrency.format(subtotal);

  totalTax = subtotal * taxRate;

  taxElem.textContent = formatCurrency.format(totalTax);

  total = subtotal + totalTax;

  totalElem.textContent = formatCurrency.format(total);
  payAmountBtn.textContent = formatCurrency.format(total);

  document.querySelector('#total_payment').value = total;
  document.querySelector('#tax_value').value = totalTax;
  document.querySelector('#quantity').value = quantityElem.textContent;

  document.querySelector('#quantities').value = quantityElem.textContent;
};

totalCalc(0);

const paymentForm = document.querySelector('#paymentForm');
paymentForm.addEventListener('submit', function (event) {

  totalCalc(0);
  event.preventDefault(); 
});
