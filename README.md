# check_dup_contact_record
Checks for duplicate Ontraport contact record based on name and IP address.

Put the script on your PHP-enabled webserver and then reference it from an Ontraport webhook.
Use the Trigger: "Contact is created". 
Data to send to the webhook using the POST webhook method:
fn=[First Name]&ln=[Last Name]&ip=[IP Address]

The author of this script assumes no liability related to the use of this script.
