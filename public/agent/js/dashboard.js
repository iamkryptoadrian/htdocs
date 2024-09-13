function copyToClipboard() {
    var copyText = document.getElementById("generated-url");
    navigator.clipboard
        .writeText(copyText.value)
        .then(function () {
            alert("Copied the URL: " + copyText.value);
        })
        .catch(function (error) {
            alert("Failed to copy the URL: " + error);
        });
}
