# paypal_with_user_account_payment
OAuth get payee ID  and integrate checkout with different account payee to products


Let say you have a marketplace where you have suppliers that publish products, those suppliers can get payed directly to paypal once a user make the checkout. Instead of the owner receive the money and then pay the supplier, each supplier can get payed directly on checkout by the user. First they need to login into there paypal and get verified, once they are verified you can store there PAYEE ID and other information provided by paypal API. Once they are verified you can handle the payment by passing the total amoount and the payee ID so they get payed directly on items they own. 





THE HTML PART IS THE BUTTON WHERE YOUR USER OAUTH TO START GETTING PAYED USING PAYPAL. THIS METHOD WILL REDIRECT THE USER TO LOGIN ONCE HE LOGIN AND AGREE HE WILL BE REDIRECTED TO A PAGE THAT YOUR SET, AFTER THIS PAYPAL WILL SEND YOU INFORMATION ABOUT THE USER. WITH THIS INFORMATION, YOU CAN USE IT TO MAKE A PAYMENT DIRECLY TO THE USER 






