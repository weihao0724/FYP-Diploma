<?php Header ("Content-type: text/css; charset=utf-8");?>
@charset "utf-8";

*
{
	padding: 0;
	margin: 0;
	box-sizing: border-box;
}

@font-face
{
    font-family: Product-Re;
    src: url("fonts/Product Sans Regular.ttf");
}

@font-face
{
    font-family: Merriweather;
    src: url("fonts/Merriweather-Bold.ttf");
}

@font-face
{
    font-family: Roboto-Regular;
    src: url("fonts/Roboto-Regular.ttf");
}

body 
{
	margin: 0;
	font-family: Merriweather, sans-serif;
	background-color: rgb(249, 249, 250);
	overflow: none;
}
/*responsive view for PC and mobile*/
@media screen and (min-width : 720px)
{
	.login-panel
	{
		margin: 4% auto;
		box-sizing: border-box;
		width: 35em;
		height: 40em;
		font-size: 0.8em;
		background-color: white;
		box-shadow: 0 2px 4px 0 rgba(0,0,0,.3);
		border-radius: 10px;
		padding-top: 8em;
	}
}

@media screen and (max-width : 719.9999px)
{
	.login-panel
	{
		margin: 4% auto;
		box-sizing: border-box;
		width: 98%;
		height: 40em;
		font-size: 0.8em;
		background-color: white;
		box-shadow: 0 2px 4px 0 rgba(0,0,0,.3);
		border-radius: 10px;
		padding-top: 8em;
	}
}
/*end of responsive*/
/*login panel*/
.login-panel h1
{
	font-family: Merriweather, sans-serif;
	font-size: 2em;
	color: rgb(8, 2, 98);
}

/*form css*/
.form-panel
{
	max-width: 30em;
}

.login-form
{
	display: flex;
	justify-content: center;
	align-items: center;
	text-align: center;
}

.login-form form
{
	width: 80%;
	margin-top: 7%;
}

.login-form .input-div
{
	position: relative;
    display: grid;
    grid-template-columns: 7% 93%;
    margin: 25px 0;
    padding: 5px 0;
    border-bottom: 2px solid #d9d9d9;
}

.icon
{
	color: #999;
	display: flex;
	justify-content: center;
	align-items: center;
}

.icon i
{
	transition: 0.3s;
}

.login-form .input-div.mail
{
	margin-top: 0;
	margin-bottom: 0;
}

.input-div > div
{
	position: relative;
	height: 45px;
	margin-bottom: 0;
}

.input-div > div > h5
{
	position: absolute;
	left: 10px;
	top: 50%;
	transform: translateY(-50%);
	color: #999;
	font-size: 18px;
	transition: 0.3s;
	font-family: Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, "sans-serif";
}

.input-div:before, .input-div:after
{
	content: '';
	position: absolute;
	bottom: -2px;
	width: 0%;
	height: 2px;
	background: linear-gradient(to left, #00dbde, #fc00ff, #00dbde);
	transition: 0.4s;
}

.input-div:before
{
	right: 50%;
}

.input-div:after
{
	left: 50%;
}

.input-div.focus:before, .input-div.focus:after
{
	width: 50%;
}

.input-div.focus > div > h5
{
	top: -5px;
	font-size: 12px;
	color: #414141;
}

.input-div.focus > .icon > i
{
	color: rgb(86, 134, 233);
}

.input-div > div > input
{
	position: absolute;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
	border: none;
	outline: none;
	background: none;
	padding: 0.5rem 0.7rem 0;
	font-size: 1.2rem;
	color: #555;
	font-family: sans-serif,Impact, Haettenschweiler, "Franklin Gothic Bold", "Arial Black", "sans-serif";
}

.input-div.pass
{
	margin-bottom: 4px;
}

.help-block {
	display: block;
	margin-top: 0;
	margin-bottom: 0;
	float: left;
	color: #B60003;
	font-size: 12px;
	font-family: Roboto-Regular;
}
/*end of form css*/

/*button*/
.login-button
{
	width: 5em;
	height: 2.8em;
	text-align: center;
}

.button-warp
{
	width: 80%;
	display: block;
	position: relative;
	z-index: 1;
	border-radius: 25px;
	overflow: hidden;
	margin: 0 auto;
	box-shadow: 0 5px 30px 0px rgba(3, 216, 222, 0.2);
}

.login-button-warp
{
	position: absolute;
	z-index: -1;
	width: 300%;
	height: 100%;
	background: linear-gradient(to right, #00dbde, #fc00ff, #00dbde, #fc00ff);
	top: 0;
	left: -100%;
	transition: all 0.4s;
}

.login-button
{
	font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, "sans-serif";
	font-size: 16px;
	color: #fff;
	line-height: 1.2;
	text-transform: uppercase;
	display: flex;
	justify-content: center;
	align-items: center;
	padding: 0 20px;
	width: 100%;
	height: 50px;
}

.button-warp:hover .login-button-warp
{
	left: 0;
}
/*end of button*/
/*show password attributes*/
.showpass
{
	float: right;
	margin-bottom: 0;
}

.show-pass
{
	float: left;
	margin-top: 1px;
}

.show-text
{
	float: left;
	margin-top: 1px;
	margin-left: 0.3em;
	font-family: Roboto-Regular;
	font-size: 12px;
	color: rgba(0,0,0,0.7);
}
/*end of show password*/
/*forgot password attributes*/
button
{
	outline: none !important;
	background: transparent;
	border: none;
}

button:hover
{
	cursor: pointer;
}

.forgot-pw
{
	color: red;
	font-size: 0.8em;
	float: right;
	margin-top: 8px;
	margin-bottom: 10px;
	padding-left: 70%;
}

.forgot-pw:hover
{
	color: #0025DA;
}
/*end of attributes*/

/*top logo bar*/
.show-top
{
	height: 4.9em;
	background-color: #121212;
}

.weblogo
{
	float: left;
	padding: 0.15em 2em 0;
	font-size: 18px;
	line-height: 20px;
}

.weblogo img
{
	height: 4em;
	width: 4em;
}
/*end of logo bar*/

.forgot-email
{
	width: 27em;
	height: 3em;
}

.forgot-submit
{
	width: 8em;
	height: 2em;
	float: right;
}

.forgot-back
{
	width: 7em;
	height: 2em;
	float: left;
}

#valid-pass
{
	font-size: 1em;
	color: red;
	font-family: Product-Re;
	float: left;
}

.change-pw
{
	width: 10em;
	height: 2em;
}