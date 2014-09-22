Scenario: As a coach i want to create a new team with three members
Given the user is signed in with coa1@mailinator.com 123456
Given the user is on the Teams page
When user click on create a new team button
Then user enter team name
Then user enter team members
Then user click save button
Then user should see created team in the table