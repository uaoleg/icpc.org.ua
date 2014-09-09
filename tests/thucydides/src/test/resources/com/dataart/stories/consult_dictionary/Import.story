Story: Import from icpc.baylor.edu
 
Narrative: 
In order to be able to user my credentials from icpc.baylor.edu
As a user
I want to be able to import my user profile from icpc.baylor.edu to registration form

Scenario: As user i want to be able to close pop-up window on the import page 
Given the user is on the Registration page
When user click on the button for import from baylor website
When user close the baylor popup window
Then user should be on the registration page

Scenario: As user i want to be able to import my profile info from icpc.baylor.edu to registration form
Given the user is on the Registration page
When user click on the button for import from baylor website
When user enter credentials 111@mailinator.com 123456
And click import button
Then user should see that all fields are filled 111@mailinator.com

Scenario: As user i want to see error message when i do not enter credentials and click import
Given the user is on the Registration page
When user click on the button for import from baylor website
And click import button
Then user will be able see error message Email or password is invalid

Scenario: As user i want to see error message when i enter correct email, wrong password and click import
Given the user is on the Registration page
When user click on the button for import from baylor website
When user enter credentials 111@mailinator.com dsfgdfsghsgf
And click import button
Then user will be able see error message Email or password is invalid