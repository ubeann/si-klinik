document.addEventListener("DOMContentLoaded", function () {
    // List of doctor names to be displayed in the dropdown
    const doctors = [
        "Dr. Tri Sulistiyono Sp.KK",
        "Drg. Ernawati Sp.ORT",
        "Dr. Sari Wahyu Ningtum Sp.S",
        "Dr. Nugroho Sp.B"
    ];

    // Grab the dropdown content container (doctor list) from the DOM
    const doctorList = document.getElementById("doctor-list");

    // Dynamically create <a> elements for each doctor and append them to the dropdown content
    doctors.forEach(doctor => {
        const doctorItem = document.createElement("a");  // Create a new anchor element for the doctor
        doctorItem.textContent = doctor;                 // Set the text to the doctor's name
        doctorList.appendChild(doctorItem);              // Append the doctor item to the dropdown content
    });

    // Toggle the visibility of the doctor list dropdown and search input when the dropdown button is clicked
    document.getElementById("doctor-btn").addEventListener("click", function () {
        // Toggle visibility of doctor list
        document.getElementById("doctor-list").classList.toggle("show");
        // Toggle visibility of the search input
        document.getElementById("doctor-search").classList.toggle("show");
    });

    // Handle the search input to filter doctor names based on user input
    const searchInput = document.getElementById("doctor-search");

    // Add event listener to trigger the filter logic when user types in the search input
    searchInput.addEventListener("keyup", function () {
        const filter = searchInput.value.toLowerCase();  // Convert the search query to lowercase
        const doctorItems = doctorList.getElementsByTagName("a");  // Get all <a> elements inside the doctor list

        // Loop through the doctor list items and filter based on the search query
        Array.from(doctorItems).forEach(item => {
            const txtValue = item.textContent || item.innerText;  // Get the text content of each doctor item
            // Show or hide the doctor item depending on whether it matches the search query
            item.style.display = txtValue.toLowerCase().indexOf(filter) > -1 ? "" : "none";
        });
    });

    // Close the dropdown and hide the search input if the user clicks outside of the dropdown
    window.onclick = function(event) {
        // Check if the click target is not the dropdown button or the search input
        if (!event.target.matches('.dropbtn') && !event.target.matches('.search-input')) {
            // Get all elements with the class "dropdown-content"
            var dropdowns = document.getElementsByClassName("dropdown-content");

            // Loop through all dropdowns and remove the "show" class to hide the open dropdown
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }

            // Hide the search input when clicking outside
            document.getElementById("doctor-search").classList.remove("show");
        }
    }
});