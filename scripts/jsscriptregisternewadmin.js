//Resets form and removes the picture preview.
function ResetForm() {
    document.getElementById("formregister").reset();
    
    var preview = document.getElementById("photopreview");
    preview.src = "";
    preview.style.display = "none";

    document.getElementById("firstname").focus();
}