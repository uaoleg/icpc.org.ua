Story: Registration to icpc.org.ua
 
Narrative: 
In order to be able to create a new users with different roles
As a user
I want to be able to register new users

Scenario: As user i want to be able to register and log into new accout
Given the user is on the Registration page
When user enter all correct credentials
And user click Sign up
When user check his emailbox myicpctest@gmail.com 123myicpctest and click on the confirmation link
Then user should see the verified E-mail confirmation message Email verified successfully!
When user click on go to login page link
When the user enters name: myicpctest@gmail.com and password: 123myicpctest and click the 'login' button
Then user should see a page title Additional User - ICPC
Then user loged out

Scenario: As user i want to be able to resend an email again after registration
Given the user is on the Registration page
When user enter all correct credentials
And user click Sign up
Then user click on Resend email button and check email 

Scenario: As user i want to be able to see E-mail confirmation message when i register with correct credentials	
Given the user is on the Registration page
When enter all correct credentials
And user click Sign up
Then user should see the E-mail confirmation message You have signed up successfully. We have sent an email confirmation link to your email.

Scenario: As user i want to be able to see 7 warrning message about blank fields when i register without any credentials
Given the user is on the Registration page
When user click Sign up
Then user should see 7 warrning messages about blank fields

Scenario: As user i want to be able to see E-mail confirmation message when i register with correct credentials are taken form CSV file
Given the user is on the Registration page
When enter all correct credentials form file source

Scenario: As user i want to be able to see Resend email button when i register with correct credentials	
Given the user is on the Registration page
When enter all correct credentials
And user click Sign up
Then user should see the Resend email button

Scenario: As user i want to be able to see error message if i am registering with not unique credentials
Given the user is on the Registration page
When enter not unique credentials
And user click Sign up
Then user should see error message Email is not unique in DB.