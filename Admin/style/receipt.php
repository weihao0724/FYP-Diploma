<?php Header ("Content-type: text/css; charset=utf-8");?>
@charset "utf-8";

.invoice-box {
	max-width: 800px;
	margin: auto;
	padding: 30px;
	border: 1px solid #eee;
	box-shadow: 0 0 10px rgba(0, 0, 0, .15);
	font-size: 16px;
	line-height: 24px;
	font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
	color: #555;
}

.receipt-title
{
	text-align: center;
	width: 100%;
}

.heading-title
{
	background: #eee;
	border-bottom: 1px solid #ddd;
	font-weight: bold;
	text-align: center;
	width: 200em;
}

.invoice-box table {
	width: 100%;
	line-height: inherit;
	text-align: left;
}

.cus-address
{
	width: 100em;
}

.invoice-box table td {
	padding: 5px;
	vertical-align: top;
}

.invoice-box table tr.top table td {
	padding-bottom: 20px;
}

.invoice-box table tr.top table td.title {
	font-size: 45px;
	line-height: 45px;
	color: #333;
}

.invoice-box table tr.top table td.address {
	padding-top: 1.2em;
	text-align: left;
	width: 70%;
}

.invoice-box table tr.top table td.invoice-details {
	text-align: left;
	font-size: 14px;
	width: 20%;
}

.invoice-box table tr.information table td {
	padding-bottom: 40px;
}

.invoice-box table tr.heading td {
	background: #eee;
	border-bottom: 1px solid #ddd;
	font-weight: bold;
}

.invoice-box table tr.details td {
	padding-bottom: 20px;
}

.invoice-box table tr.item td{
	border-bottom: 1px solid #eee;
}

.invoice-box table tr.item.last td {
	border-bottom: none;
}

.invoice-box table tr.total td:nth-child(2) {
	border-top: 2px solid #eee;
	font-weight: bold;
}

@media only screen and (max-width: 600px) {
	.invoice-box table tr.top table td {
		width: 100%;
		display: block;
		text-align: center;
	}

	.invoice-box table tr.information table td {
		width: 100%;
		display: block;
		text-align: center;
	}
}

/** RTL **/
.rtl {
	direction: rtl;
	font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
}

.rtl table {
	text-align: right;
}

.rtl table tr td:nth-child(2) {
	text-align: left;
}

.num
{
	width: 4%;
	text-align: right;
}

.items
{
	width: 50%;
	text-align: center;
}

.qty
{
	width: 5%;
	text-align: center;
}

.price
{
	width: 15%;
	text-align: center;
}

.invoice-box table tr.content th {
	background: #eee;
	border-bottom: 1px solid #ddd;
	font-weight: bold;
}

.item .table-num
{
	text-align: center;
}

.item .table-items
{
	text-align: left;
}

.item .table-qtys
{
	text-align: center;
}

.item .table-amount
{
	padding-left: 6%;
}