Story: Manage and activate users permitions for icpc.org.ua
 
Narrative: 
In order to be able to manage user permitions
As a user
I want to be able to set user permitions

Scenario: As user i want to be able to activate a new coache after registration
Given the user is on the Registration page
When user enter all correct credentials coach
And user click Sign up
When user check his emailbox myicpctest@gmail.com 123myicpctest and click on the confirmation link
Then user should see the verified E-mail confirmation message Email verified successfully!
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user go to menu Coaches
When user click Activate on the first item from the list
Then user loged out
Given the user is signed in with myicpctest@gmail.com 123myicpctest
When user move to general info tab
Then user should see status Approved

Scenario: As user i want to be able to see warrning message (Not approved) when a new coache is not activated after registration
Given the user is on the Registration page
When user enter all correct credentials coach
And user click Sign up
When user check his emailbox myicpctest@gmail.com 123myicpctest and click on the confirmation link
Then user should see the verified E-mail confirmation message Email verified successfully!
Given the user is signed in with myicpctest@gmail.com 123myicpctest
When user move to general info tab
Then user should see status Not approved

Scenario: As admin i want to be able to find user info by email from List of users
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user go to menu Coaches
When user enter into search field myicpctest@gmail.com
Then user should see correct search result in the table myicpctest@gmail.com