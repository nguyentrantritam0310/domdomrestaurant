function validateAndFillModal() {
  if (!document.querySelectorAll(".cart-item").length) {
    alert("Giỏ hàng đang trống! Vui lòng thêm sản phẩm trước khi xác nhận.");
    return;
  }
  var isValid = true;

  var name = document.getElementById("name");
  var phone = document.getElementById("phone");
  var email = document.getElementById("email");
  var address = document.getElementById("address");

  var nameError = document.getElementById("name-error");
  var phoneError = document.getElementById("phone-error");
  var emailError = document.getElementById("email-error");
  var addressError = document.getElementById("address-error");

  nameError.innerText = "";
  phoneError.innerText = "";
  emailError.innerText = "";
  addressError.innerText = "";

  if (!name.value.trim()) {
    nameError.innerText = "Họ tên không được bỏ trống.";
    isValid = false;
  } else if (!name.value.match(name.pattern)) {
    nameError.innerText = "Tên phải bắt đầu bằng chữ cái. Vui lòng nhập lại.";
    isValid = false;
  }

  if (!phone.value.trim()) {
    phoneError.innerText = "Số điện thoại không được bỏ trống.";
    isValid = false;
  } else if (!phone.value.match(phone.pattern)) {
    phoneError.innerText =
      "Số điện thoại bắt đầu bằng 0 và gồm 10 chữ số hoặc +84 và gồm 11 chữ số. Trừ 00 vầ +840 Vui lòng nhập lại.";
    isValid = false;
  }

  if (!email.value.trim()) {
    emailError.innerText = "Email không được bỏ trống.";
    isValid = false;
  } else if (!email.value.match(email.pattern)) {
    emailError.innerText =
      "Email phải có định dạng abc@gmail.com. Vui lòng nhập lại.";
    isValid = false;
  }

  if (!address.value.trim()) {
    addressError.innerText = "Địa chỉ không được bỏ trống.";
    isValid = false;
  } else if (!address.value.match(address.pattern)) {
    addressError.innerText =
      "Địa chỉ phải bắt đầu bằng chữ số hoặc chữ cái. Vui lòng nhập lại.";
    isValid = false;
  }

  if (isValid) {
    fillModal(name.value, phone.value, email.value, address.value);
    var modal = new bootstrap.Modal(document.getElementById("checkoutModal"));
    modal.show();
  }
}

function validateStore() {
  var store = document.getElementById("store");
  var storeError = document.getElementById("store-error");
  storeError.innerText = "";
  if (store.value === "") {
    storeError.innerText = "Vui lòng chọn cửa hàng.";
  } else {
    var checkoutModalElement = document.getElementById("checkoutModal");
    var checkoutModal = bootstrap.Modal.getInstance(checkoutModalElement);
    checkoutModal.hide();

    var payModal = new bootstrap.Modal(document.getElementById("payModal"));
    payModal.show();
  }
}

function checkPaymentMethod() {
  var paymentMethods = document.getElementsByName("payment_method");
  var selectedMethod = null;

  for (var i = 0; i < paymentMethods.length; i++) {
    if (paymentMethods[i].checked) {
      selectedMethod = paymentMethods[i].value;
      break;
    }
  }

  if (!selectedMethod) {
    var errorMessage = document.getElementById("payment-error");
    if (errorMessage) {
      errorMessage.textContent = "Vui lòng chọn phương thức thanh toán!";
    }
  } else {
    var errorMessage = document.getElementById("payment-error");
    if (errorMessage) {
      errorMessage.textContent = "";
    }

    var payModalElement = document.getElementById("payModal");
    if (payModalElement) {
      var payModal = bootstrap.Modal.getInstance(payModalElement);
      payModal.hide();
    }
    var ttpayModalElement = document.getElementById("ttpayModal");
    if (ttpayModalElement) {
      var ttpayModal = new bootstrap.Modal(ttpayModalElement);
      ttpayModal.show();
    }
  }
}

function fillModal(name, phone, email, address) {
  document.getElementById("modalName").innerText = name;
  document.getElementById("modalPhone").innerText = phone;
  document.getElementById("modalEmail").innerText = email;
  document.getElementById("modalAddress").innerText = address;
}

document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("confirmPay").addEventListener("click", function () {
    document.querySelector("form").submit();
  });
});

document.getElementById("promotionID").addEventListener("change", function () {
  let selectedOption = this.options[this.selectedIndex];
  let discountPercentage = parseFloat(selectedOption.getAttribute("data-p-d"));
  let maxDiscountAmount = parseFloat(
    selectedOption.getAttribute("data-max-discount")
  );
  let totalAmount = parseFloat(
    document.getElementById("totalAmount").innerText.replace(/,/g, "")
  );

  if (!isNaN(discountPercentage)) {
    let discountAmount = totalAmount * (discountPercentage / 100);
    if (discountAmount > maxDiscountAmount) {
      discountAmount = maxDiscountAmount;
    }

    let finalAmount = totalAmount - discountAmount;

    const formatNumber = (num) => {
      return new Intl.NumberFormat("en-US", {
        style: "decimal",
        maximumFractionDigits: 0,
      }).format(num);
    };

    document.getElementById("discountAmount").innerText =
      formatNumber(discountAmount);
    document.getElementById("finalAmount").innerText =
      formatNumber(finalAmount);

    document.getElementById("hiddenDiscountAmount").value =
      discountAmount.toFixed(0);
    document.getElementById("hiddenFinalAmount").value = finalAmount.toFixed(0);
  }
});
