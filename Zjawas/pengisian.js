  function checkForm() {
    var nama = document.getElementById("nama").value;
    var email = document.getElementById("email").value;
    // add more fields to check here
    
    if (nama == "" || email == "") {
      alert("Please fill in all fields!");
      return false;
    } else {
      return true;
    }
  }
