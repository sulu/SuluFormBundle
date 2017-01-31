# Changelog

## dev-develop

 - BUGFIX      #132   Fixed missing uniqueness in form fields table
 - BUGFIX      #131   Fixed permission denied on fields action
 - FEATURE     #130   Added toggler to set email as replyTo
 - BUGFIX      #111   Fixed exception controller redirect
 - BUGFIX      #125   Fixed form select by using native select
 - FEATURE     #118   Added media collection strategy tree
 - FEATURE     #124   Added support to add dynamic list to article bundle
 - BUGFIX      #123   Fixed csv export for bool values
 - ENHANCEMENT #122   Fixed sort on dynamic list and removed search 
 - FEATURE     #121   Added dynamic form list and export
 - BUGFIX      #120   Fixed permission problem on false locale
 - BUGFIX      #117   Fixed limitation of content type select
 - FEATURE     #115   Added options for attachment validation
 - BUGFIX      #114   Fixed multiple choices to text type columns
 - BUGFIX      #113   Fixed naming of mailchimp parameters
 - BUGFIX      #112   Fixed id of serialized dynamic array
 - BUGFIX      #106   Fixed datefield and add birthday option
 - ENHANCEMENT #105   Added new form layout
 - FEATURE     #102   Added recaptcha support with EWZRecaptchaBundle
 - ENHANCEMENT #101   Change mail settings options to toggler
 - FEATURE     #100   Added page based list output
 - BUGFIX      #99    Fixed csrf token esi for varnish
 - BUGFIX      #97    Fixed edit symbol on list
 - BUGFIX      #96    Fix inversedBy value at FormField#form property 
 - FEATURE     #92    Clean up the backend view
 - FEATURE     #92    Added last flag for grid and update documentation
 - BUGFIX      #85    Fixed MailChimp-Key parameter in FormController 

## 1.0.0-RC4

 - BUGFIX      #80    Fixed getCustomerDeactivateMails and getNotifyDeactivateMails Method
 - BUGFIX      #79    Fixed resolver of configureOptions in AbstractType

## 1.0.0-RC3

 - FEATURE     #74    Added mailchimp field type (requires https://github.com/drewm/mailchimp-api)
 - BUGFIX      #76    Fixed csrf token generation in esi
 - BUGFIX      #75    Fixed csrf token generation for dynamic form
 - FEATURE     #73    Added type sort after translation function
 
## 1.0.0-RC2
 
 - BUGFIX      #70    Fixed token esi response header
 - BUGFIX      #71    Fixed customer emails for dynamic forms
 - FEATURE     #68    Added checkboxes to deactivate notify and success emails
 - FEATURE     #67    Added sixths widths to fields
 - BUGFIX      #66    Fixed that dynamic is related to a form
 - BUGFIX      #65    Unlimited title column and changed string to text
