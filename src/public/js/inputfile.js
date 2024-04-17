// 選択したファイル名表示
function displayFileName(input) {
    const fileNameDisplay = document.getElementById("file-name");
    if (input.files && input.files[0]) {
        fileNameDisplay.textContent = input.files[0].name;
    }
}