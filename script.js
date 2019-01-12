//Validace registračního formuláře
function validateRegisterForm() {
	var email = document.forms["registerForm"]["email"].value;
	var password = document.forms["registerForm"]["password"].value;
	var passwordAgain = document.forms["registerForm"]["passwordAgain"].value;
	//Pokud není něco vyplněno nebo je heslo krátké
	if(email === "") {
		alert("Vyplňte prosím email.");
		return false;
	}
	if(password === "") {
		alert("Zadejte prosím heslo.");
		return false;
	}
	else if(password.length < 5){
		alert("Heslo musí být delší než 5 znaků.");
		return false;
	}
	if(password !== passwordAgain){
		alert("Zadaná hesla se neshodují.");
		return false;
	}
}

//Validace loginu
function validateLoginForm() {
    var email = document.forms["loginForm"]["email"].value;
    var password = document.forms["loginForm"]["password"].value;
    if (email === "") {
        alert("Vyplňte prosím email.");
        return false;
    }
    if (password === "") {
        alert("Zadejte prosím heslo.");
        return false;
    }
}





//Smooth scrollování
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        if(window.location.href.indexOf('map') !== -1){
        	return;
        }

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});


