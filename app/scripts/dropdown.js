const jsDropdown = document.getElementById("jsDropdown");
function dropdown() {
    jsDropdown.classList.toggle("show-dropdown");
}
document.documentElement.addEventListener
    ("click", function (event) {
        if (!event.target.matches('.darksoul-btn-medium')) {
            if (jsDropdown.classList.contains("show-dropdown")) {
                jsDropdown.classList.toggle("show-dropdown");
            }
        }
    }
    );

// Js - Dropdown - End