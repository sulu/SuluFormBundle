# Changelog

## 1.0.0-RC6

 - ENHANCEMENT #186    Increase mailchimp list limit from 10 to 100
 - BUGFIX      #185    Fix hidding of untranslated forms and form fields
 - BUGFIX      #184    Add fixes for Grammar of static form documentation
 - FEATURE     #183    Add tests running on php 7.3
 - BUGFIX      #182    Fix compatibility with doctrine/orm ^2.6

## 1.0.0-RC5

 - BUGFIX      #185    Fix hidding of untranslated forms and form fields
 - ENHANCEMENT #177    Added grunt-cli to package.json
 - BUGFIX      #175    Fixed form on a shadow pages
 - BUGFIX      #173    Fixed missing `sulu_form.navigation_provider.template` service
 - FEATURE     #172    Added formdata parameter to getNotifySubject function in FormConfigurationFactory
 - FEATURE     #167    Added possibility to change mailchimp subscribe status

## 1.0.0-RC4

 - FEATURE     #158    Add deletion for dynamic entries
 - BUGFIX      #156    Fix static form handling after refractoring
 - BUGFIX      #150    Fix implement dropzone documentation
 - ENHANCEMENT #147    Improve upgrade errors for 0.2.0 version
 - BUGFIX      #146    Fix sulu_form_get_by_id twig extension

## 1.0.0-RC3

 - BUGFIX      #145    Fix form template structure and move submit label
 - BUGFIX      #144    Avoid normalize keys for dynamic width and ajax templates configuration
 - ENHANCEMENT #143    Remove unused parameter dynamic default view
 - BUGFIX      #142    Render placeholder only with value and upate ChoiceTrait
 - BUGFIX      #141    Activate save button on block add
 - ENHANCEMENT #140    Disable csrf token protection when recaptcha field is used
 - BUGFIX      #137    Add minimum requirement for twig
 - HOTFIX      #135    Fix exception on page when form was deleted
 - HOTFIX      #136    Fix default value for choice form types and placeholder

## 1.0.0-RC2

 - BUGFIX      #132    Fix boolean values in list
 - FEATURE     #132    Add id to search fields in form and dynamic list
 - ENHANCEMENT #131    Add created date to list view
 - BUGFIX      #130    Fixed csv export for big results
 - FEATURE     #129    Add disabled field type configuration

## 1.0.0-RC1

 - BUGFIX      #126    Fixed handle of medias in email template
 - BUGFIX      #125    Fixed attachment for medias in email
 - FEATURE     #124    Fixed date field in list view
 - ENHANCEMENT #122    Update french translations

## 0.4.0

 - FEATURE     #118    Add phpstan analyzer with level 2
 - FEATURE     #116    Fixed unkown parameter secret by using kernel.secret parameter
 - FEATURE     #115    Fixed grid width around submit button
 - FEATURE     #114    Fixed grid row around submit button
 - FEATURE     #113    Fixed last width when next has no place
 - FEATURE     #109    Add symfony 3 to test runs
 - FEATURE     #108    Add widths to bundle configuration
 - FEATURE     #107    Add title automatically to new added block
 - FEATURE     #106    Add grouped types to admin blocks
 - ENHANCEMENT #105    Add functional api tests
 - FEATURE     #104    Add search to dynamic list
 - ENHANCEMENT #103    Add test setup 
 - HOTFIX      #120    Fix database update for 0.2 version in UPGRADE.md

## 0.3.2

 - HOTFIX     #102    Fixed error when form is loaded without structure in request
 - HOTFIX     #101    Fixed mail receiver for website form
 - HOTFIX     #100    Add mail configuration to documentation

## 0.3.1

 - HOTFIX      #99    Removed unused function "getReceiverTypes"

## 0.3.0

 - BUGFIX      #98    Fixed Dutch translations
 - FEATURE     #83    Refractor static and dynamic form handling for symfony 3 compatibility
 - FEATURE     #91    Added Dutch translations
 
## 0.2.3

 - HOTFIX      #96    Fixed permission problem for template file

## 0.2.2

 - BUGFIX      #90    Fixed form data tab pagination
 - BUGFIX      #90    Fixed form data csv export
 - ENHANCEMENT #90    Use full width in form data tab
 - BUGFIX      #90    Fixed back to list in form data tab
 - BUGFIX      #90    Fixed translation for form data tab name

## 0.2.1

 - BUGFIX     #88    Fixed get locale in dynamic controller

## 0.2.0

 - FEATURE     #80    Added type name to dynamic entity and cleanup title provider
 - FEATURE     #79    Added dynamic list to form itself
 - BUGFIX      #78    Fixed form serialization with receivers
 - BUGFIX      #77    Fixed ckeditor problem with sulu link
 - ENHANCEMENT #76    Rename placeholder field to example
 - ENHANCEMENT #74    Added blameableinterface to dynamic entity
 - FEATURE     #71    Added possibility to change the submit button text
 - ENHANCEMENT #73    Deprecate static forms and update documentation
 - BUGFIX      #72    Fixed add and remove a field of same type at same time
 - FEATURE     #63    Added possibility to use form content type in other modules
 - ENHANCEMENT #60    Added `sulu_admin.email` as default mail address and show them as placeholder in form template

## 0.1.0

 - ENHANCEMENT #59    Added correct composer dependencies
 - FEATURE     #57    Added basic theme for dynamic forms
 - FEATURE     #56    Added daterange to csv export overlay for sulu 1.5
 - BUGFIX      #55    Fixed dynamic list factory with hidden fields
 - BUGFIX      #54    Fixed date type default value
 - ENHANCEMENT #52    Update sulu from `alexander-schranz/sulu-form-bundle` from commit `c110e72e44a58a0f53428c153e405124695506f6`
 - BUGFIX      #52    Fixed form preview request analyzer
 - BUGFIX      #52    Fixed second date field type
 - BUGFIX      #52    Fixed missing translation and documentation
 - ENHANCEMENT #52    Added missing documentation
 - BUGFIX      #52    Fixed success email not sent to email in data json
 - BUGFIX      #52    Fixed missing uniqueness in form fields table
 - BUGFIX      #52    Fixed permission denied on fields action
 - FEATURE     #52    Added toggler to set email as replyTo
 - BUGFIX      #52    Fixed exception controller redirect
 - BUGFIX      #52    Fixed form select by using native select
 - FEATURE     #52    Added media collection strategy tree
 - FEATURE     #52    Added support to add dynamic list to article bundle
 - BUGFIX      #52    Fixed csv export for bool values
 - ENHANCEMENT #52    Fixed sort on dynamic list and removed search
 - FEATURE     #52    Added dynamic form list and export
 - FEATURE     #20    Added additional receivers for sending notification as CC or BCC
 - ENHANCEMENT #23    Fixed composer json links and description
 - BUGFIX      #16    Fixed setting of entity value in dynamic which represents an array
 - ENHANCEMENT #13    Added dynamic type pool service for enabling custom form field types
 - ENHANCEMENT #10    Update sulu from `alexander-schranz/sulu-form-bundle` from commit `c16a04b15fe320c039064de05ddaef9d087dbc6f`
 - BUGFIX      #10    Fixed permission problem on false locale
 - BUGFIX      #10    Fixed limitation of content type select
 - FEATURE     #10    Added options for attachment validation
 - BUGFIX      #10    Fixed multiple choices to text type columns
 - BUGFIX      #10    Fixed naming of mailchimp parameters
 - FEATURE     #3     Added short title to fields
 - FEATURE     #2     Changed title field for labels to texteditor
 - ENHANCEMENT #-     Updated namespaces and rename table names
 - ENHANCEMENT #-     Forked from `alexander-schranz/sulu-form-bundle` from commit `36a7cd11562ed0c9f64752b37707cc2771e0baca`

