
// Change quantity with +/- buttons
function changeQty(btn, change) {
  const qtyControl = btn.closest('.qty-control');
  const input = qtyControl.querySelector('.qty-input');
  let currentVal = parseInt(input.value) || 1;
  let newVal = currentVal + change;
  if (newVal < 1) newVal = 1;
  if (newVal > 99) newVal = 99;
  input.value = newVal;
  input.dispatchEvent(new Event('change'));
}

function updateQty(input) {
  let val = parseInt(input.value);
  if (isNaN(val) || val < 1) input.value = 1;
  if (val > 99) input.value = 99;
  const form = input.closest('form');
  if (form) {
    const updateBtn = form.querySelector('.update-btn');
    if (updateBtn) updateBtn.disabled = false;
  }
}
