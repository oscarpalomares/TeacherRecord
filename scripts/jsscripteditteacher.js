//Reset form using DOM content loader.
document.addEventListener("DOMContentLoaded", function() {
    function ResetForm() {
        document.getElementById("formeditteacher").reset();
        var preview = document.getElementById("photo-preview");
        preview.src = "";
        preview.style.display = "none";
        document.getElementById("firstname").focus();
    }
});