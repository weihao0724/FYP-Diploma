@charset "utf-8";
<?php Header ("Content-type: text/css; charset=utf-8");?>
/*body content css*/
.main-body
{
    background-color: white;
    padding: 4.5em 1em 0 26%; 
    border: 1px solid #ddd; 
    border-radius: 10px; 
    width: 72.5%;
    font-family: Roboto-Regular, sans-serif;
}

.main-body h6
{
	color: rgba(0,0,0,0.8);
	font-family: Avenir;
	font-size: 20px;
	margin-bottom: 1em;
}

@media (max-height: 911.9999px)
{
	.heightmargin
	{
		margin-top: 2em;
	}
	.middle 
	{
		color: black;
		font-family: Product-Re;
		transition: .5s ease;
		opacity: 0;
		position: absolute;
		top: 12em;
		left: 59vw;
		transform: translate(-50%, -50%);
		text-align: center;
		z-index: 1;
	}
	.profile-pic
	{
		height: 0;
		width: 0;
		margin-left: 40.5%;
	}
	
	.profile-pic .admin-pic
	{
		border: 1px solid rgba(0,0,0,0.3);
		align-content: center;
		background-repeat: no-repeat;
		background-size: 150px 150px;
		border-radius: 50%;
		height: 7.5em;
		width: 7.5em;
		background-position: center;
		color: transparent;
		position: relative;
		margin: 60px auto 10px 60px;
		transform: translate(-50%, -50%);
		z-index: 0;
	}
	.profile-name
	{
		margin-top: 15%;
		margin-right: 6.3%;
	}
}

@media (min-height: 912px)
{
	.heightmargin
	{
		margin-top: 10%;
	}
	.middle 
	{
		color: black;
		font-family: Product-Re;
		transition: .5s ease;
		opacity: 0;
		position: absolute;
		top: 28%;
		left: 60.5%;
		transform: translate(-50%, -50%);
		text-align: center;
		z-index: 1;
	}
	.profile-pic
	{
		height: 7.0em;
		width: 7em;
		margin-left: 43.3%;
	}
	
	.profile-pic .admin-pic
	{
		border: 1px solid rgba(0,0,0,0.3);
		align-content: center;
		background-repeat: no-repeat;
		background-size: 150px 150px;
		border-radius: 50%;
		height: 9em;
		width: 9em;
		background-position: center;
		color: transparent;
		position: relative;
		margin: 60px auto 10px 60px;
		transform: translate(-50%, -50%);
		z-index: 0;
	}
	.profile-name
	{
		margin-right: 5%;
	}
}

body
{
	z-index: -1;
}

.profile 
{
    background-color: white;
    padding: 4.5em 0 0 27.5%; 
    border: 1px solid #ddd; 
    border-radius: 10px; 
    width: 72.5%;
    font-family: Roboto-Regular, sans-serif;
	z-index: -2;
}

.hidden
{
	display: none;
}

.dash-content, .dash-content p
{
	z-index: -1;
}

.profile-title
{
	text-align: center;
}

.profile-text
{
	float: left;
	margin-left: 10%;
}

.profile-pic:hover .admin-pic
{
	opacity: 0.2;
}

.profile-pic:hover .middle
{
	opacity: 1;
}

.table-icon
{
	color: grey;
}

.profile-left
{
    float: left;
    margin: 2em 0 30px 8%;
    width: 350px;
    border-radius: 10px;
}

.profile-right
{
    float: right;
    margin: 2em 11% 30px 0;
    width: 350px;
    border-radius: 10px;
}

.addform .show-data
{
	margin-left: 0.3em;
	width: 17em !important;
	height: 1.8em !important;
	border: none;
	outline: none;
	background: none;
	font-size: 1em !important;
}

.addform span
{
	font-size: 0.8em; 
	color: grey;
	font-family: Product-Re;
}

.show-col
{
	width: 17em !important;
	height: 1.5em !important;
	border-bottom: 2px solid rgba(0,0,0,0.3);
}

.button
{
	margin-left: 12em;
}

.edit-button
{
	margin-left: 11em;
}

.show-img
{
	width: 10em;
	height: 10em;
}

.add-back-btn
{
	margin-left: 5em;
	width: 5em;
}

.valid-pass
{
	font-size: 0.8em; 
	color: red;
	font-family: Product-Re;
}