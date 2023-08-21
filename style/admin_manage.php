@charset "utf-8";
<?php Header ("Content-type: text/css; charset=utf-8");?>
/* CSS Document */
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

/*attribute for category list table*/
.admin-table
{
	width: 95%;
	border-collapse: separate;
	border: 1px solid rgba(128,128, 128 ,0.7);
	border-spacing: 0 17px;
}

.admin-table td
{
	text-align: center;
	font-size: 15px;
}

.admin-table .table-name
{
	width: 14%;
}

.admin-table .table-action
{
	width: 8%;
}

.table-icon
{
	color: grey;

}

.table-edit, .table-del
{
	text-align: center;
}

.table-id
{
	width: 8%;
}

.table-date
{
	width: 12%;
}

.table-email
{
	width: 38%;
}

.table-cont
{
	width: 20%;
}

.main-body .add-btn
{
	height: 2em;
	float: right;
	margin-right: 4em;
	margin-top: 1em;
	cursor: pointer;
}

.hidden
{
	display: none;
}

label
{
	display:inline-block;
	width:200px;
	vertical-align:top;
}

.addform span
{
	font-size: 0.8em; 
	color: red;
	font-family: Product-Re;
}

.has-error .input
{
	border-color: #843534;
	box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
}

.has-error .input:focus
{
	border-color: #843534;
	box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #ce8483;
}

.update-btn
{
	margin-right: 4em;
	margin-top: 1em;
	cursor: pointer;
}

.add-back-btn
{
	float: right;
	margin-right: 10%;
	width: 5em;
}

.show-pass
{
	padding-top: 0.2em;
	margin-left: 15.3em;
	color: rgba(0,0,0,0.5);
}

.show-text
{
	color: black;
}