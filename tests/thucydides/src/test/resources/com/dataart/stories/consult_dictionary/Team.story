Story: Manage teams for icpc.org.ua
 
Narrative: 
In order to be able to manage teams for icpc.org.ua
As a user
I want to be able to create a new team for icpc.org.ua under coach role

Scenario: As a unregistered user i want to be able toget to the Teams page
Given the user is on the News page
When user clicks on the Team link
Then user should be sent to Team page

Scenario: As a coach i want to create a new team with three members
Given the user is signed in with coa1@mailinator.com 123456
Given the user is on the Teams page
When user click on create a new team button
Then user enter team name
Then user enter team members
Then user click save button
Then user should see created team in the table

Scenario: As a coach i want to delete previously created team
Given the user is signed in with coa1@mailinator.com 123456
Given the user is on the Teams page
When user clicks on earlier created team name
Then user clicks on delete button and confirms deletion
Then user can see that team is deleted from the list

Scenario: As a coordinator i want to be able to download list of teams suited for checking system
Given the user is signed in with coord1@mailinator.com 123456
Given the user is on the Teams page
When user click on Export to CSV button and chooses For checking system item
Then user is able to download for checking system csv doc

Scenario: As a coordinator i want to be able to download list of teams suited for registration
Given the user is signed in with coord1@mailinator.com 123456
Given the user is on the Teams page
When user click on Export to CSV button and chooses For registration item
Then user is able to download for registration csv doc

Scenario: As a user i want to be able to get to team profile when i'm clicking on team name in Team list
Given the user is signed in with coa1@mailinator.com 123456
Given the user is on the Teams page
When user clicks on first team in the list
Then user is on the profile page of the team

Scenario: As a user i want to be able to get to coach profile when i'm clicking on coach name in Team list
Given the user is signed in with coa1@mailinator.com 123456
Given the user is on the Teams page
When user clicks on first coach name in the list
Then user is on the profile page of the coach

Scenario: As a user i want to be able to get to student profile when i'm clicking on one of students' name in Team list
Given the user is signed in with coa1@mailinator.com 123456
Given the user is on the Teams page
When user clicks on first student name in the list
Then user is on the profile page of the student

Scenario: As a user i want to be able to sort teams in list by team name
Given the user is on the Teams page
When user enters team name in sorting field
Then user can see table sorted by this team name

Scenario: As a user i want to be able to sort teams in list by university name
Given the user is on the Teams page
When user enters university name in sorting field
Then user can see table sorted by this university name