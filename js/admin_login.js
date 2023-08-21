/*let the title change position when click on input box*/
const inputs = document.querySelectorAll(".input");

function addcl()
{
	let parent = this.parentNode.parentNode;
	parent.classList.add("focus");
}

function remcl()
{
	let parent = this.parentNode.parentNode;
	if(this.value == ""){
		parent.classList.remove("focus");
	}
}

inputs.forEach(input => {
	input.addEventListener("focus", addcl);
	input.addEventListener("blur", remcl);
});

/*show password*/
function showpass() 
{
	var x = document.getElementById("input-pass");
	if (x.type === "password") 
		{
			x.type = "text";
		} 
	else 
		{
			x.type = "password";
		}
}