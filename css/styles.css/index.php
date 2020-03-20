<?php 
header('Content-type: text/css');
$primary_color = '#' . filter_input(INPUT_GET, 'primary');
?>
/*@import url(https://fonts.googleapis.com/css?family=News+Cycle);*/

@font-face {
    font-family: 'News Cycle';
    src: url('NewsCycle-Regular.ttf');
}

* { box-sizing: border-box; }

html, body {
  overflow-x: hidden;
}

a {
  text-decoration: none;
}

h1, h2, h3, h4, h5, h6 {
  color: <?= $primary_color ?>;
  font-family: 'News Cycle', sans-serif;
  font-weight: normal;
}

p {
  color: #555;
  font-size: 16px;
}

.clear{
  clear: both;
}

#store-category {
  text-transform: uppercase;
}

.row {
    width: 100%;
    padding: 5px 0;
}

.row:after {
  content: " ";
  display: block;
  height: 0;
  clear: both;
}

.c10 {
  float: left;
  width: 10%;
}

.c20 {
  float: left;
  width: 20%;
}

.c30 {
  float: left;
  width: 30%;
}

.c40 {
  float: left;
  width: 40%;
}

.c50 {
  float: left;
  width: 50%;
}

.c60 {
  float: left;
  width: 60%;
}

.c80 {
  float: left;
  width: 80%;
}

#wrapper {
  width: 960px;
  width: 100%;
  margin: 0 auto;
}

#header-links {
  height: 50px;
  width: 100%;
  padding: 20px 0;
}

#header-links div {
  float: right;
}

#header-links a {
  color: #888888;
  font-size: 14px;
  padding: 0 15px;
}

.description {
    padding-top: 16px;
    padding-left: 16px;
}
.description td {
    padding-top: 4px;
    vertical-align: top;
}

.description td:nth-child(2) {
    position: relative;
    left: 75px;
}

#additional-options {
    margin-top: 8px;
    max-width: 100%;
}

#nav #nav-links a {
  color: #EEE;
  font-size: 12px;
  font-family: 'News Cycle', sans-serif;
  padding-left: 12px;
  background: url(../../images/nav-marker.png) no-repeat 0 5px;
}

#nav #nav-links a:hover, #nav #nav-links a.active {
  color: <?= $primary_color ?>;
}

#nav div {
  height: 125px;
  float: left;
}

#nav #logo {
  width: 220px;
  width: 227px;
  text-align: center;
}

#nav #logo img {
  height: 100%;
}

#nav #nav-links {
  width: 740px;
  width: calc(100% - 227px);
  background: #343434;
  padding: 30px 5px;
}

#nav #nav-links ul {
  color: #EEE;
  list-style-type: none;
  width: 750px;
  margin: 0;
  padding: 0;
}

#nav #nav-links li {
  float: left;
  height: 48px;
  margin-right: 6px;
}

#logo {
  background: <?= $primary_color ?>;
}

#search {
  display: inline-block;
  text-align: center;
  width: 227px;
  background: #F2F2F2;
  padding: 20px;
  padding-bottom: 10px;
  border: 1px solid <?= $primary_color ?>;
  border-top: 0;
}

#search input {
  float: left;
  height: 30px;
  background: #FCFCFC;
  border: 1px solid #222;
  outline: 0;
}

#search-category-wrapper{
  text-align: left;
}

.chosen-container, #search-category {
    margin: 8px 0;
    color: #A9A9A9;
}

#search input[type=text] {
  width: 105px;
  color: #222;
  padding: 5px;
  border-right: 0;
}
#search input[type=submit] {
  width: 70px;
  color: #555;
  font-size: 14px;
  font-family: 'News Cycle', sans-serif;
  border-left: 0;
}

#search input[type=number] {
    width: 47%;
    margin-top: 8px;
    margin-right: 3%;
    padding: 5px;
}
#search select {
    margin-top: 8px;
    width: 175px;
}

#content {
  float: right;
  width: 725px;
  width: calc(99% - 227px);
}

.store-item {
    position: relative;
  display: inline-block;
  width: 210px;
  height: 270px;
  text-align: center;
  margin-left: 20px;
  margin-bottom: 60px;
  border-top: 3px solid <?= $primary_color ?>;
}

.item-name {    
  display: flex;
  align-items: flex-start;
  justify-content: center;
  height: 75px;
  padding-bottom: 5px;
  margin-bottom: 10px;
  font-size: 14px;
  color: #AAA;
}
.item-name:hover {
  color: #888;
}

.price {
  background: <?= $primary_color ?>;
  padding: 5px;
  margin: 5px;
}
.price:hover {
  color: #fff;
}

.add-to-cart {
  color: #000;
  text-decoration: underline;
}
.add-to-cart:hover {
  text-decoration: none;
}

.image-link {
    display: flex;
    align-items: flex-start;
    justify-content: center;
    flex-direction: column;
    margin: 0;
    width: 100%;
    height: 200px;
}

.image-link img {
    
}

img.product-hover-image {
    display: none;
}

.product-thumbs {
    margin-top: 30px;
}

.image-link:hover .product-hover-image {
    display: block;
    position: absolute;
    top: 0;
    background: #fff;
    padding: 5px;
}

#contact-form {
  margin-top: 20px;
}
#contact-form label {
  display: inline-block;
  width: 130px;
  font-size: 14px;
  vertical-align: top;
  margin-left: 10px;
}
#contact-form input {
  margin-bottom: 2px;
}
#contact-form input[type=submit] {
  display: inline-block;
  background: #EEE;
  margin-left: 145px;
  border: 1px solid #AAA;
}
#contact-form textarea {
  width: 199px;
  height: 150px;
}

#dealer-login label {
  display: block;
  color: #555;
}
#dealer-login input {
  margin-bottom: 10px;
}

footer {
  height: 100px;
  margin-top: 150px;
  padding-top: 30px;
  padding-bottom: 20px;

  background: <?= $primary_color ?>;

  font-size: 12px;

  padding-left: 3000px;
  padding-right: 3000px;
  margin-left: -3000px;
  margin-right: -3000px;
}

footer img {
  margin-right: 10px;
}

/*Dealer Preference*/
#dealerNav{
  width: 100%;
  height: 22px;
  margin: 0;
  padding: 0;
}

#dealerNav li{
  display: inline-block;
  margin-right: 10px;
}

#dealerNav li a{
  padding: 3px;
  border: 1px solid #333;
  border-bottom: 0;
}

#dealerBody{
  padding: 2%;
  border: 1px solid #333;
}

#dealerForm{
  width: 75%;
}

.formInput{
  padding-bottom: 18px;
}

.formInput label{
  display: inline-block;
  width: 20%;
}

.formInput input{
  display: inline-block;
  width: 75%;
  margin-left: 2.5%;
}

.formInput.textarea label{
  vertical-align: top
}

.formInput.textarea textarea{
  display: inline-block;
  width: 75%;
  margin-left: 2.5%;
  height: 100px;

}

.formInput.submit input{
  width: auto;
  margin-left: 0;
}
.formInput.submit input.button {
  background: <?= $primary_color ?>;
  border: 0;
  color: #ffffff;
  float: right;
  margin-right: 10px;
  padding: 10px;
}

/*ORDER HISTORY*/
.orderHeader.column {
  float: left;
}

.orderItem{
  margin-bottom: 36px;
}

.orderItem .column{
  float: left;
}

.orderItem .column p{
  font-size: 14px;
  line-height: 16px;
}

.order-detail-table {
    width: 100%;
    border-collapse: collapse;
}

.order-detail-table td {
    border: 1px solid #999;
    padding: 10px;
}

#dealerBody .orderHeader.orderID, .orderItem .orderID{ width: 15%; }
#dealerBody .orderHeader.orderDate, .orderItem .orderDate{ width: 25%; }
#dealerBody .orderHeader.orderQuantity, .orderItem .orderQuantity{ width: 10%; }
#dealerBody .orderHeader.orderShipped, .orderItem .orderShipped{ width: 10%; }
#dealerBody .orderHeader.orderStatus, .orderItem .orderStatus{ width: 10%; }
#dealerBody .orderHeader.orderTrackingNo, .orderItem .orderTrackingNo{ width: 20%; }

.orderItem .expandButton{
  cursor: pointer;

  display: block;
  padding: 8px 16px;
  background-color: <?= $primary_color ?>;
  /*background-color: #343434;*/
  

  color: #ffffff;
  font-weight: 700;
}

.orderProducts{
  display: none;
}

.productItem{
  padding: 1% 0;
}

.productImg{ width: 7%; }
.productName{ width: 69%; }
.productQuantity{ width: 12%; }
.productShipped{ width: 12%; }

/*PRODUCT PAGE*/
#shoppingCart{
  text-align: left;
}

#shoppingCart p{
  margin: 0;
  padding: 0;
  font-size: 12px;
}

#shoppingCart .cartItem{
  padding: 6px 0;
}

#shoppingCart .cartItem .name{
  float: left;
  width: 75%;
}

#shoppingCart .cartItem .qty{
  float: right;
  width: 20%;
}

#shoppingCart .cartItem .qty input{
  width: 30px;
  height: auto;
  border: 1px solid #333;
}

#shoppingCart input.cartButton, #shoppingCart a.cartButton{
  float: none;
  display: inline-block;
  width: auto;
  height: auto;
  padding: 4px 8px;
  background-color: <?= $primary_color ?>;
  border: 1px solid #343434;

  color: #343434;
  font-family: "News Cycle",sans-serif;
  font-size: 14px;
  font-weight: 700;
  line-height: 16px;
  text-align: center;
  text-decoration: none;
}

.ordered-by {
    position: relative;
    float: right;
    height: 25px;
    background: #fff;
    overflow: hidden;
}

.ordered-by input {
    height: 25px;
    display: block;
}

#productContent, #checkout{
  float: left;
  width: 739px;
  width: 76%;
  padding: 18px;
  position: relative;
}

#productContent .left{
  float: left;
  width: 400px;
  width: 65%;
  padding-left: 5%;
  padding-right: 10px;
}

#productContent .left img{
  max-width: 400px;
  max-height: auto;
}

#productContent .right{
  float: right;
  width: 300px;
  width: 30%;
  padding-left: 10px;
}

.gallery-image {
    position: relative;
    top: 100px;
    border: 1px solid #DDD;
    margin-left: 3px;
    cursor: pointer;
}

/*CHECKOUT*/
/*#checkout is in the product page styles*/
.checkoutItem{
  padding: 4px;
  border: 1px solid #333;
}

.checkoutItem p{
  font-size: 12px;
  line-height: 14px;
}

.checkoutItem .column{
  float: left;
}

.checkoutItem .productName{ width: 60%; }
.checkoutItem .productQty{ width: 10%; }
.checkoutItem .productIndividualPrice{ width: 15%; }
.checkoutItem .productSubTotalPrice{ width: 15%; }

.checkoutItem .productQty input{
  width: 50%;
  padding: 4px;
  background-color: #fff;
  border: 1px solid #333;
  color: #333;
}

#checkoutTotals .buttons{
  float: none;
  display: inline-block;
  width: auto;
  height: auto;
  padding: 4px 8px;
  background-color: <?= $primary_color ?>;
  border: 1px solid #343434;

  color: #343434;
  font-family: "News Cycle",sans-serif;
  font-size: 14px;
  font-weight: 700;
  line-height: 16px;
  text-align: center;
  text-decoration: none;
}

#checkoutTotals .column{
  float: left;
  width: 25%;
  text-align: center;
}

#confirm{
  float: right;
  width: 725px;
}
