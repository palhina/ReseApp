// 入力文字数カウント
function updateCharacterCount(textarea) {
    const maxLength = textarea.maxLength;
    const currentLength = textarea.value.length;
    const countElement = document.getElementById("length");
    countElement.textContent = currentLength;
}