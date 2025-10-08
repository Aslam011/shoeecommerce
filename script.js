 HEAD
document.addEventListener("DOMContentLoaded", () => {
  // Elements
  const form = document.getElementById("registrationForm");
  const fullNameInput = document.getElementById("fullName");
  const emailInput = document.getElementById("email");
  const phoneInput = document.getElementById("phone");
  const otpInput = document.getElementById("otp");
  const sendOtpBtn = document.getElementById("sendOtpBtn");
  const passwordInput = document.getElementById("password");
  const togglePasswordBtn = document.querySelector(".toggle-password");
  const confirmPasswordInput = document.getElementById("confirmPassword");

  // Error message elements
  const fullNameError = document.getElementById("fullNameError");
  const emailError = document.getElementById("emailError");
  const phoneError = document.getElementById("phoneError");
  const otpError = document.getElementById("otpError");
  const passwordError = document.getElementById("passwordError");
  const confirmPasswordError = document.getElementById("confirmPasswordError");

  let generatedOtp = null;

  // Utility function to clear error messages
  function clearErrors() {
    fullNameError.textContent = "";
    emailError.textContent = "";
    phoneError.textContent = "";
    otpError.textContent = "";
    passwordError.textContent = "";
    confirmPasswordError.textContent = "";
  }

  // Validate Full Name (non-empty)
  function validateFullName() {
    if (fullNameInput.value.trim() === "") {
      fullNameError.textContent = "Full Name is required.";
      return false;
    }
    fullNameError.textContent = "";
    return true;
  }

  // Validate Email via regex and input's validity
  function validateEmail() {
    if (emailInput.validity.typeMismatch || emailInput.value.trim() === "") {
      emailError.textContent = "Please enter a valid email address.";
      return false;
    }
    emailError.textContent = "";
    return true;
  }

  // Validate phone: 10 digits starting with 6-9
  function validatePhone() {
    const phoneVal = phoneInput.value.trim();
    const phonePattern = /^[6-9]\d{9}$/;
    if (!phonePattern.test(phoneVal)) {
      phoneError.textContent = "Phone number must start with 6-9 and be 10 digits.";
      return false;
    }
    phoneError.textContent = "";
    return true;
  }

  // Validate OTP: 6 digits and matches generated OTP
  function validateOtp() {
    if (!generatedOtp) {
      otpError.textContent = "Please send OTP first.";
      return false;
    }
    if (otpInput.value.trim() === "") {
      otpError.textContent = "OTP is required.";
      return false;
    }
    if (!/^\d{6}$/.test(otpInput.value.trim())) {
      otpError.textContent = "OTP must be exactly 6 digits.";
      return false;
    }
    if (otpInput.value.trim() !== generatedOtp) {
      otpError.textContent = "Invalid OTP. Please try again.";
      return false;
    }
    otpError.textContent = "";
    return true;
  }

  // Validate Password length >=6 characters
  function validatePassword() {
    if (passwordInput.value.length < 6) {
      passwordError.textContent = "Password must be at least 6 characters.";
      return false;
    }
    passwordError.textContent = "";
    return true;
  }

  // Validate Confirm Password match
  function validateConfirmPassword() {
    if (confirmPasswordInput.value !== passwordInput.value) {
      confirmPasswordError.textContent = "Passwords do not match.";
      return false;
    }
    confirmPasswordError.textContent = "";
    return true;
  }

  // Toggle password visibility
  togglePasswordBtn.addEventListener("click", () => {
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      togglePasswordBtn.innerHTML = "&#128065;"; // eye icon (you can change)
    } else {
      passwordInput.type = "password";
      togglePasswordBtn.innerHTML = "&#128065;"; // eye icon
    }
  });

  // Send OTP functionality (mock)
  sendOtpBtn.addEventListener("click", () => {
    if (!validatePhone()) {
      alert("Please enter a valid phone number before sending OTP.");
      return;
    }

    // Mock OTP generation: random 6 digit number as string
    generatedOtp = Math.floor(100000 + Math.random() * 900000).toString();
    alert(`Your OTP is: ${generatedOtp} (Mocked sending)`);

    otpInput.disabled = false;
    otpInput.value = "";
    otpInput.focus();
    otpError.textContent = "";
  });

  // On form submit
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    clearErrors();

    const isFullNameValid = validateFullName();
    const isEmailValid = validateEmail();
    const isPhoneValid = validatePhone();
    const isOtpValid = validateOtp();
    const isPasswordValid = validatePassword();
    const isConfirmPasswordValid = validateConfirmPassword();

    if (
      isFullNameValid &&
      isEmailValid &&
      isPhoneValid &&
      isOtpValid &&
      isPasswordValid &&
      isConfirmPasswordValid
    ) {
      alert("Account created successfully!");
      form.reset();
      otpInput.disabled = true;
      generatedOtp = null;
    }
  });

  // Optional: Keyboard Enter triggers submit if form valid

document.addEventListener("DOMContentLoaded", () => {
  // Elements
  const form = document.getElementById("registrationForm");
  const fullNameInput = document.getElementById("fullName");
  const emailInput = document.getElementById("email");
  const phoneInput = document.getElementById("phone");
  const otpInput = document.getElementById("otp");
  const sendOtpBtn = document.getElementById("sendOtpBtn");
  const passwordInput = document.getElementById("password");
  const togglePasswordBtn = document.querySelector(".toggle-password");
  const confirmPasswordInput = document.getElementById("confirmPassword");

  // Error message elements
  const fullNameError = document.getElementById("fullNameError");
  const emailError = document.getElementById("emailError");
  const phoneError = document.getElementById("phoneError");
  const otpError = document.getElementById("otpError");
  const passwordError = document.getElementById("passwordError");
  const confirmPasswordError = document.getElementById("confirmPasswordError");

  let generatedOtp = null;

  // Utility function to clear error messages
  function clearErrors() {
    fullNameError.textContent = "";
    emailError.textContent = "";
    phoneError.textContent = "";
    otpError.textContent = "";
    passwordError.textContent = "";
    confirmPasswordError.textContent = "";
  }

  // Validate Full Name (non-empty)
  function validateFullName() {
    if (fullNameInput.value.trim() === "") {
      fullNameError.textContent = "Full Name is required.";
      return false;
    }
    fullNameError.textContent = "";
    return true;
  }

  // Validate Email via regex and input's validity
  function validateEmail() {
    if (emailInput.validity.typeMismatch || emailInput.value.trim() === "") {
      emailError.textContent = "Please enter a valid email address.";
      return false;
    }
    emailError.textContent = "";
    return true;
  }

  // Validate phone: 10 digits starting with 6-9
  function validatePhone() {
    const phoneVal = phoneInput.value.trim();
    const phonePattern = /^[6-9]\d{9}$/;
    if (!phonePattern.test(phoneVal)) {
      phoneError.textContent = "Phone number must start with 6-9 and be 10 digits.";
      return false;
    }
    phoneError.textContent = "";
    return true;
  }

  // Validate OTP: 6 digits and matches generated OTP
  function validateOtp() {
    if (!generatedOtp) {
      otpError.textContent = "Please send OTP first.";
      return false;
    }
    if (otpInput.value.trim() === "") {
      otpError.textContent = "OTP is required.";
      return false;
    }
    if (!/^\d{6}$/.test(otpInput.value.trim())) {
      otpError.textContent = "OTP must be exactly 6 digits.";
      return false;
    }
    if (otpInput.value.trim() !== generatedOtp) {
      otpError.textContent = "Invalid OTP. Please try again.";
      return false;
    }
    otpError.textContent = "";
    return true;
  }

  // Validate Password length >=6 characters
  function validatePassword() {
    if (passwordInput.value.length < 6) {
      passwordError.textContent = "Password must be at least 6 characters.";
      return false;
    }
    passwordError.textContent = "";
    return true;
  }

  // Validate Confirm Password match
  function validateConfirmPassword() {
    if (confirmPasswordInput.value !== passwordInput.value) {
      confirmPasswordError.textContent = "Passwords do not match.";
      return false;
    }
    confirmPasswordError.textContent = "";
    return true;
  }

  // Toggle password visibility
  togglePasswordBtn.addEventListener("click", () => {
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      togglePasswordBtn.innerHTML = "&#128065;"; // eye icon (you can change)
    } else {
      passwordInput.type = "password";
      togglePasswordBtn.innerHTML = "&#128065;"; // eye icon
    }
  });

  // Send OTP functionality (mock)
  sendOtpBtn.addEventListener("click", () => {
    if (!validatePhone()) {
      alert("Please enter a valid phone number before sending OTP.");
      return;
    }

    // Mock OTP generation: random 6 digit number as string
    generatedOtp = Math.floor(100000 + Math.random() * 900000).toString();
    alert(`Your OTP is: ${generatedOtp} (Mocked sending)`);

    otpInput.disabled = false;
    otpInput.value = "";
    otpInput.focus();
    otpError.textContent = "";
  });

  // On form submit
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    clearErrors();

    const isFullNameValid = validateFullName();
    const isEmailValid = validateEmail();
    const isPhoneValid = validatePhone();
    const isOtpValid = validateOtp();
    const isPasswordValid = validatePassword();
    const isConfirmPasswordValid = validateConfirmPassword();

    if (
      isFullNameValid &&
      isEmailValid &&
      isPhoneValid &&
      isOtpValid &&
      isPasswordValid &&
      isConfirmPasswordValid
    ) {
      alert("Account created successfully!");
      form.reset();
      otpInput.disabled = true;
      generatedOtp = null;
    }
  });

  // Optional: Keyboard Enter triggers submit if form valid
 ae3509d26b152da62cc8c1f681d77d502539bbc1
});