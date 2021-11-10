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
			$(".settings-option").fadeIn("slow", ).css("display","inline-block");
		}, 500)
		isExpanded = !isExpanded;
		console.log("Expanded")
	}
}