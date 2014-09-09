Story: Manage teams for icpc.org.ua
 
Narrative: 
In order to be able to manage teams for icpc.org.ua
As a user
I want to be able to create a new team for icpc.org.ua under coach role

Scenario: As a coach i want to create a new team with three memebers
Given the user is signed in with coa1@mailinator.com 123456
Given the user is on the Teams page
When user click on create a new team button
When user enter team name
When user enter team members
When user click save button
Then user should see created team in the table
