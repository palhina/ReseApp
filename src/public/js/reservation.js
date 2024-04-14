// フォーム入力内容の表示
const dateInput = document.getElementById('dateInput');
const timeInput = document.getElementById('timeInput');
const numberInput = document.getElementById('numberInput');

const displayDate = document.getElementById('displayDate');
const displayTime = document.getElementById('displayTime');
const displayNumber = document.getElementById('displayNumber');

dateInput.addEventListener('change', () => {
    displayDate.textContent = dateInput.value;
});

timeInput.addEventListener('change', () => {
    displayTime.textContent = timeInput.value;
});

numberInput.addEventListener('change', () => {
    displayNumber.textContent = numberInput.options[numberInput.selectedIndex].text;
});