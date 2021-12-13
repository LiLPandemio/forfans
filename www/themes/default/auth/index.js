$(".settings-option").hide()
const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
	container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
	container.classList.remove("right-panel-active");
});
var isExpanded = false;
const toggleSettings = () => {
	if (isExpanded) {
		$(".settings-option").fadeOut()
		$("#sitecontrollers").addClass("site-controllers")
		$("#sitecontrollers").removeClass("site-controllers-expanded")
		isExpanded = !isExpanded;
		console.log("Shrinked")
	} else {
		$("#sitecontrollers").addClass("site-controllers-expanded")
		$("#sitecontrollers").removeClass("site-controllers")
		setTimeout(() => {
			$(".settings-option").fadeIn("slow",).css("display", "inline-block");
		}, 500)
		isExpanded = !isExpanded;
		console.log("Expanded")
	}
}
function do_login() {
	let email = $("#login_email").val();
	let password = $("#login_password").val();
	$.post(siteURL+"api/login", { "username": email, "password": password },)
		.done(function (data) {
			let response = data.response;
			if (response !== "WrongCredentials") {
				document.cookie = "token=" + response;
				window.location.replace(siteURL+"home");
			} else {
				alert("Tus credenciales son incorrectas :c")
			}
		}).fail(function (xhr, status, error) {
			console.log(status);
		});
}
function getToken () {
	cookie = document.cookie.split('; ').reduce((prev, current) => {
		const [name, ...value] = current.split('=');
		prev[name] = value.join('=');
		return prev;
	}, {});
	return cookie.token;
}