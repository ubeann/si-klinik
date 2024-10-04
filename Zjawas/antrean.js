function showDropdown() {
    document.querySelector('.dropdown-menu').style.display = 'block';
  }
  
  document.addEventListener('click', function(event) {
    if (!event.target.classList.contains('dropbtn') && !event.target.classList.contains('dropdown-menu')) {
      document.querySelector('.dropdown-menu').style.display = 'none';
    }
  });