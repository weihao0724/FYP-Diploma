// JavaScript Document
function add_product()
{
	var x = document.getElementById("show-table");
	var y = document.getElementById("add-product");
	if (x.style.display === "none")
		{
			x.style.display = "block";
			y.style.display = "none";
		}
	else 
		{
			x.style.display = "none";
			y.style.display = "block";
		}
}

function show_list()
{
	var x = document.getElementById("show-table");
	var y = document.getElementById("add-product");
	if (x.style.display === "none")
		{
			x.style.display = "none";
			y.style.display = "block";
		}
	else 
		{
			x.style.display = "block";
			y.style.display = "none";
		}
}