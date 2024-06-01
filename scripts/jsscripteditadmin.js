//Resets form and removes the picture preview.
function ResetForm() {
    document.getElementById("formeditadmin").reset();
    var preview = document.getElementById("photo-preview");
    preview.src = "";
    preview.style.display = "none";
    document.getElementById("firstname").focus();
}