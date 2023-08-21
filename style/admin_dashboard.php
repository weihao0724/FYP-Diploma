@charset "utf-8";
<?php Header ("Content-type: text/css; charset=utf-8");?>
/*body content css*/
@media (max-height: 911.9999px)
{
	.main-body 
	{
		background-color: white;
		padding: 4.5em 1em 0 20%; 
		border: 1px solid #ddd; 
		border-radius: 10px; 
		width: 78.5%;
		font-family: Roboto-Regular, sans-serif;
		z-index: -2;
	}
	.chart-left
	{
		float: left;
		width: 40%;
		margin-left: 8%;
	}
	.chart-right
	{
		float: right;
		width: 38%;
		margin-right: 1%;
	}
}

@media (min-height: 912px)
{
	.main-body 
	{
		background-color: white;
		padding: 4.5em 1em 0 10%; 
		border: 1px solid #ddd; 
		border-radius: 10px; 
		width: 78.5%;
		font-family: Roboto-Regular, sans-serif;
		z-index: -2;
	}
	.chart-left
	{
		float: left;
		width: 41%;
		margin-left: 5%;
	}
	.chart-right
	{
		float: right;
		width: 40%;
	}
}

.dash-content, .dash-content p
{
	z-index: -1;
}

.main-body img
{
	align-content: center;
    background-repeat: no-repeat;
	background-size: 150px 150px;
	border-radius: 50%;
	height: 6em;
    width: 6em;
    background-position: center;
    color: transparent;
    margin: 50px auto 10px auto;
	float: right;
}

.menu_left
{
    float: left;
    margin: 2em 0 2em 5%;
    width: 30%;
    height: 20%;
    border: 1px solid rgba(0,0,0,0.2);
    border-radius: 10px;
}

.menu_right
{
    float: right;
    margin: 2em 8% 2em 0;
    width: 30%;
    height: 20%;
    border: 1px solid rgba(0,0,0,0.2);
    border-radius: 10px;
}

.menu_content
{
    margin: 20px 0 0 20px;
    font-family: 'Product-Re';
}

.menu_content .content
{
    font-size: 14px;
    color: rgba(0,0,0,0.5);
    font-weight: bold;
}

.menu_content .content_link
{
	font-family: 'Product-Re';
    font-size: 15.5px;
    color:rgba(117,170,241,1.00);
    text-decoration: none;
}

.update_content
{
    margin-left: 10%;
    font-family: 'Product-Re';
    font-size: 14px;
}

.update_tag i span
{
    font-size: 14px;
    font-family: 'Product-Re';
}

.navi-product
{
	margin-right: 0;
}

.navi-support
{
	right: 0;
}

.family
{
    margin-top: 5%;
    width: 100%;
    font-family: 'Product-Re';
}

