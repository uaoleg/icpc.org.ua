Story: Manageing user profile for icpc.org.ua
 
Narrative: 
In order to be able to manage user profile
As a user
I want to be able to set user settings for icpc.org.ua

Scenario: As a user i want to be able to change my password log in with new credentials and back my old password
Given the user is signed in with olegstud@mailinator.com 123456
When user move to general info tab
When user enter current password 123456
When user enter new password 1234567
When user repeate new password 1234567
When user click change password button
Then user should see sucess message Your password has been successfully changed
Then user loged out
Given the user is signed in with olegstud@mailinator.com 1234567
Then user should see a page title Additional User - ICPC
Then the user changes the password back
Then user loged out

Scenario: As a user i want to see error message field when i don't enter any password fields and click reset password button
Given the user is signed in with olegstud@mailinator.com 123456
When user move to general info tab
When user click change password button
Then user should see error field message Password is incorrect

Scenario: As a user i want to see error message field when i don't enter any password fields except current password and click reset password button
Given the user is signed in with olegstud@mailinator.com 123456
When user move to general info tab
When user enter current password 123456
When user click change password button
Then user should see error field message Password length should be greater or equal than 6.

Scenario: As a user i want to see error message field when i don't enter any password fields except correct, new password and click reset password button
Given the user is signed in with olegstud@mailinator.com 123456
When user move to general info tab
When user enter current password 123456
When user enter new password 1234567
When user click change password button
Then user should see error field message Password is not confirmed.

Scenario: As user i want to be able to change my additional info on additional english page (/me/uk/en)
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user go to user profile
When user go to additional tab /en
When user enter additional info
And click save button
Then user loged out
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user go to user profile
When user go to additional tab /en
Then user should see filled fields

Scenario: As user i want to be able to see warrning messages about empty fields if user doesn't enrer any info.
Given the user is signed in with olegstud@mailinator.com 123456
When user go to user profile
When user go to additional tab /en
And click save button
Then user should see warrning messages about blank fields

Scenario: As a user i want to be abble to upload a new user photo
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user move to general info tab
When user upload a new photo
Then user should see uploaded photo

Scenario: As a user i want to be abble to see error message when user upload not a photo (*.doc, *.xls)
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user move to general info tab
When user upload a new file TestDoc.doc
Then user should see extension error message File extension error.

Scenario: As a user i want to be abble to see warning message about filling additonal info in profile if user profile info is not filled
Given the user is signed in with olegstud@mailinator.com 123456
Then user should see a message Please fill in your additional info in ukrainian and english languages

Scenario: As a user i want to be abble to see warning message about status approving
Given the user is signed in with admin@icpc.org.ua e3r4t5
Then user should see a message alert Warning! Your coordinator status is not approved yet!coord1 coord1 can approve your status.

