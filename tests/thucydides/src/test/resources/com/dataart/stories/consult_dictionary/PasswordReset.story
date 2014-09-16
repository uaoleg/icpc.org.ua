Story: Password reset for icpc.baylor.edu
 
Narrative: 
In order to be able to reset my account password
As a user
I want to be able to reset my password

Scenario: As user i want to see the error messages when i don't enter any field into reset form
Given the user is on the Password reset page
When user click on Reset password button
Then user should see email warrning message We do not know such a email.
Then user should see capcha warrning message The recaptcha code is incorrect.

Scenario: As user i want to see the error messages when i enter wrong emal and don't enter capcha
Given the user is on the Password reset page
When user enter an email sdfsdf@mail.ru
When user click on Reset password button
Then user should see email warrning message We do not know such a email.
Then user should see capcha warrning message The recaptcha code is incorrect.

Scenario: As user i want to see the error messages when i enter correct email and don't enter capcha
Given the user is on the Password reset page
When user enter an email stuone@mailinator.com
When user click on Reset password button
Then user should see email warrning message The recaptcha code is incorrect.