Story: Manage and activate users permitions for icpc.org.ua
 
Narrative: 
In order to be able to manage user permitions
As a user
I want to be able to set user permitions



Scenario: As admin i want to be able to find user info by email from List of users
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user go to menu Coaches
When user enter into search field myicpctest@gmail.com
Then user should see correct search result in the table myicpctest@gmail.com