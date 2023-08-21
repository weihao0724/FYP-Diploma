<?php Header ("Content-type: text/css; charset=utf-8");?>
@charset "utf-8";
/* CSS Document */
/*main body*/
.main-body
{
    background-color: white;
    padding: 4.5em 1em 0 26%; 
    border: 1px solid #ddd; 
    border-radius: 10px; 
    width: 72.5%;
    font-family: Roboto-Regular, sans-serif;
}

.main-receipt
{
    background-color: white;
    padding: 4.5em 2% 0 23%; 
    border: 1px solid #ddd; 
    border-radius: 10px; 
    width: 74.7%;
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
.cate-table, .order-table
{
	width: 95%;
	border-collapse: separate;
	border: 1px solid rgba(128,128, 128 ,0.7);
	border-spacing: 0 17px;
}

.cate-table .table-id
{
	width: 10%;
}

.cate-table .table-name
{
	width: 20%;
}

.cate-table .table-price
{
	width: 10%;
}

.cate-table .table-pay
{
	width: 10%;
}

.cate-table .table-ship
{
	width: 30%;
}

.table-action
{
	text-align: center;
	width: 9%;
}

.table-edit, .table-del
{
	text-align: center;
}

.table-con
{
	text-align: center;
}

.cate-table .part-id, .part-name, .part-price
{
	text-align: center;
}

.table-icon
{
	color: grey;
}

.table-del, .table-edit
{
	text-align: center;
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
	width:10em;
	vertical-align:top;
	font-size: 1em; 
	color: rgba(0,0,0,0.8);
	font-family: Product-Re;
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

.addfrm .cate-name, .cate-desc
{
	margin-left: 8.2em;
}

.image
{
	margin-left: 8em;
}

.img-section
{
	float: right;
	margin-right: 5em;
}

.img
{
	margin: auto;
	text-align: center;
}

.img-section .show-img
{	
	width: 10em;
}

.img-caption
{
	text-align: center;
	font-size: .9em;
	width: 25em;
	margin-top: 1em;
}

.show-left
{
	float: left;
	width: 35%;
}

.show-right
{
	margin-right: 10em;
	float: right;
	width: 35%;
}

.order-table .table-id
{
	width: 15%;
}

.order-table .table-name
{
	width: 50%;
}

.order-table .table-qty
{
	width: 10%;
}

.order-table .table-price
{
	width: 20%;
}

#details
{
	width: 95%;
	border-collapse: collapse;
	border: 1px solid rgba(128,128, 128 ,0.7);
	border-spacing: 0 17px;
}

#details img
{
	height: 5em;
	width: 5em;
}

.col-width
{
	width: 15%;
}

.show-payment
{
	font-size: 1em;
}

.main-body button
{
	margin-top: 5%;
	float: right;
	margin-right: 5%;
}