@charset "utf-8";
<?php Header ("Content-type: text/css; charset=utf-8");?>
/* CSS Document */
session_start();
@font-face
{
    font-family: Roboto-Regular;
    src: url("fonts/Roboto-Regular.ttf");
}

@font-face
{
    font-family: Product-Re;
    src: url("fonts/Product Sans Regular.ttf");
}

@font-face
{
	font-family: Avenir;
	src: url("fonts/AvenirNextLTPro-Regular.otf");
}

body
{
	background-color: #121212;
	font-family: Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, "sans-serif";
	color: black;
	z-index: -1;
	height: 52em;
}

.credit
{
	color: white;
	font-size: 12px;
	text-align: center;
	font-family: Consolas, "Andale Mono", "Lucida Console", "Lucida Sans Typewriter", Monaco, "Courier New", "monospace";
	margin: 2px 0;
}
/*start css of navigation panel*/
#navbar 
{
	background-color: #121212;
	position: fixed;
	top: 0;
	width: 100%;
	height: 4.9em;
	display: block;
	transition: top 0.4s;
	z-index: 1;
}
/*menu icon*/
#navbar .container 
{
	display: inline-block;
	cursor: pointer;
	float: right;
	margin: 1.5em 1.9em 1.5em 1.5em;
}

#navbar .bar1, .bar2, .bar3 
{
	width: 1.6em;
	height: 1.3px;
	background-color: rgb(242, 242, 242);
	margin: 5.2px 0;
	transition: 0.45s;
}

#navbar .change .bar1 
{
	-webkit-transform: rotate(-45deg) translate(-9px, 6px);
	transform: rotate(-45deg) translate(-5px, 5px);
}

#navbar .change .bar2 {opacity: 0;}

#navbar .change .bar3 
{
	-webkit-transform: rotate(45deg) translate(-8px, -8px);
	transform: rotate(45deg) translate(-4.5px, -4px);
}

.dropdown
{
    width: 38px;
    height: 45px;
    float: right;  
    border: none;
    background-color: transparent;
	margin-right: 1.5em;
}

.dropdown-content 
{
    position: absolute;
	display: none;
	right: 11px;
	top: 4.875em;
    background-color: rgb(242, 242, 242);
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 50;
}

.dropdown-content a 
{
    float: none;
    color: black;
    padding: 11px 16px;
    text-decoration: none;
    display: block;
    text-align: left; 
	background-color: rgb(242, 242, 242);
    font-family: 'Roboto-Regular', sans-serif;
}

.dropdown-text
{
	font-size: 1.1em;
	list-style: none;
	margin-left: 5px;
	font-weight: lighter;
    font-family: Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, "sans-serif";
}

.navbar-icon
{
	vertical-align: top;
}

.dropdown-content a:hover 
{
    background-color: #ddd;
}

.show
{
    position: absolute;
    display: block;
}
/*end menu icon*/
/*logo css*/
#navbar .weblogo img
{
	height: 4em;
	width: 4em;
}

#navbar .weblogo
{
	float: left;
	padding: 0.15em 2em 0 1.5em;
	font-size: 18px;
	line-height: 20px;
}

#navbar .weblogo:hover, .weblogo:focus
{
	text-decoration: none;
}
/*end logo css*/
/*end css of navigation panel*/
/*dashboard*/
.side-navbar 
{
    border:1px solid #ddd; 
    width: 20%; 
	background-color: rgb(242, 242, 242);
	border-bottom-left-radius: 10px;
    padding-bottom: 30px;
    float: left;
    font-family: Roboto-Regular, sans-serif;
	font-weight: 500;
	margin-top: 0;
}

@media (max-height: 911.9999px)
{
	.main-body
	{
		height: 47.4em;
	}
	.navheight
	{
		height: 50em;
	}
}

@media (min-height: 912px)
{
	.main-body
	{
		height: 61em;
	}
	.navheight
	{
		height: 61em;
	}
}

.navi-title
{
	font-weight: 300;
}

.side-navi
{
	margin-top: 8em;
}

.icon-google
{
	font-size: 1.7em;
	display: inline-flex;
	vertical-align: top;
	margin-left: 0.2em;
}

.side-navi-menu
{
	height: 1.5em;
}

.text
{
    font-size: 1.1em;
	list-style: none;
	margin-left: 1em;
	font-weight: lighter;
    font-family: Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, "sans-serif";
}

.side-navi-menu:hover {
    background-color: #ddd;
    cursor: pointer;
    border-radius: 0 50px 50px 0;
}

.side-navi .authority
{
	margin-top: 2em;
}

.side-navbar a
{
	float: none;
    color: black;
    text-decoration: none;
    display: block;
    text-align: left;
    min-width: 25%;
	margin: 0.4em;
	padding: 4%;
	height: 1.65em;
}

/*directory effect for side nav*/
.navred{color: rgb(234, 67, 53);}

.navyellow{color: rgb(251, 186, 5);}

.navblue{color: rgb(66, 133, 244);}

.navgreen{color: rgb(52, 168, 83);}

.current
{
	padding-left: 0.5em;
	color: rgba(65, 105, 225, 0.85);
	font-weight: 600;
}

.dir
{
    background-color: rgb(207, 215, 239);
    border-radius: 0 50px 50px 0;
}
/*end of directory effect*/

.pages
{
	padding-right: 10px;
}

.curPage
{
	font-weight: bold;
	font-size: 16px;
}

.has-error input
{
	color: #a94442;
	border-color: #a94442;
	box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
}

.has-error input:focus
{
	border-color: #843534;
	box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #ce8483;
}