# check_dup_contact_record
Checks for duplicate Ontraport contact record based on name and IP address.

Steps to implement this script:
1) Change the API Appid and API key in the script to your own.
2) Change the "send to" email address in the script.
3) Put the script on your PHP-enabled webserver.
4) Reference the script from an Ontraport webhook.
i. Use the Trigger: "Contact is created". 
ii. Data to send to the webhook using the POST webhook method:
fn=[First Name]&ln=[Last Name]&ip=[IP Address]

The author of this script assumes no liability related to the use of this script.
