
PAYMENT MODULE : ZAAKPAY
---------------------------
Allows you to use Zaakpay payment gateway with X-Cart.

INSTALLATION PROCEDURE
--------------------------

-	Ensure you have latest version of X-Cart installed ,
-	Execute the following query in your backend (database)

1.	INSERT INTO `xcart_ccprocessors` (`module_name`, `type`, `processor`, `template`, `param01`, `param02`,
`param03`, `param04`, `param05`, `param06`, `param07`, `param08`, `param09`, `disable_ccinfo`, `background`,
`testmode`, `is_check`, `is_refund`, `c_template`, `paymentid`, `cmpi`, `use_preauth`, `preauth_expire`,
`has_preauth`, `capture_min_limit`, `capture_max_limit`) VALUES ('Zaakpay', 'C', 'cc_zaakpay.php', 'cc_zaakpay.tpl',
'', '', '', '', 'INR', '', '', '', '', 'Y', 'N', 'N', 'Y', '', '23', '0', '', '', '0', 'Y', '0%', '0%');

2.	INSERT INTO xcart_languages VALUES ('en','lbl_cc_zaakpay_merchant_id','Merchant ID','Labels');

3.	INSERT INTO xcart_languages VALUES ('en','lbl_cc_zaakpay_secret_key','Secret Key','Labels');

4.	INSERT INTO xcart_languages VALUES ('en','lbl_cc_zaakpay_mode','Mode','Labels');	

-	Extract the downloaded zip file , there you can see two folders called payment and skin ,
-	Copy and Paste the two folders into the xcart root folder and merge it.

CONFIGURATION
-----------------

-	Login to the administrator area of X-Cart ,
-	Choose Settings -> Payment methods , under the Payment gateways dropdown box select Zaakpay and click Add ,
-	Once it gets added you can see Zaakpay in the recently added list, click Configure
-	Fill in the details at the settings panel and click Update,
- 	Go back to the payment gateways page and check the Zaakpay payment gateway checkbox and click Apply Changes,

Now you can make your payment securely through Zaakpay by selecting Zaakpay as the Payment Method at the Checkout stage.

