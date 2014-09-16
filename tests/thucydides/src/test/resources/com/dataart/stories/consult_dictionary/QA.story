Story: Manage QA functionality for icpc.baylor.edu
 
Narrative: 
In order to be able to manage QA functionality
As a user
I want to be able to manage QA functionality, manage tags, create questions...

Scenario: As admin i want to be able to create Tag
Given the user is signed in with admin@icpc.org.ua e3r4t5
Given the user is on the QA page
When user click on manage tabs button
When user click on create tab button
When user enter title field
When user enter description field
When user click save button
Then user should see a new tag with name and description

Scenario: As admin i want to be able to delete Tag
Given the user is signed in with admin@icpc.org.ua e3r4t5
Given the user is on the QA page
When user click on manage tabs button
Then user click on delete button and should see that tag is deleted

Scenario: As admin i want to be able to cteate Tag without description
Given the user is signed in with admin@icpc.org.ua e3r4t5
Given the user is on the QA page
When user click on manage tabs button
When user click on create tab button
When user enter title field
When user click save button
Then user should see a new tag with name

Scenario: As admin i want to be able to edit Tag
Given the user is signed in with admin@icpc.org.ua e3r4t5
Given the user is on the QA page
When user click on manage tabs button
When user click on create tab button
When user enter title field
When user enter description field
When user click save button
When user click edit button
When user enter title field
When user enter description field
When user click save button
Then user should see a new tag with name and description

Scenario: As admin i want to be able to see warrning when i cteate Tag without title and description 
Given the user is signed in with admin@icpc.org.ua e3r4t5
Given the user is on the QA page
When user click on manage tabs button
When user click on create tab button
When user click save button
Then user should see warrning message Name cannot be blank.

Scenario: As admin i want to be able to see warrning when i cteate Tag without title and with description 
Given the user is signed in with admin@icpc.org.ua e3r4t5
Given the user is on the QA page
When user click on manage tabs button
When user click on create tab button
When user enter description field
When user click save button
Then user should see warrning message Name cannot be blank.

Scenario: As Unregistered user i should be able to be sent on Login page when click on Ask question button 
Given the user is on the QA page
When user click on ask question button
Then user should be sent to Login page

Scenario: As student i want to be able to ask a new question form Q&A menu
Given the user is signed in with stuone@mailinator.com 123456
Given the user is on the QA page
When user click on ask question button
When user enter title
When user enter body
When user choose teg registration
When user click save question button
Then user should see created question with correct title,body,tag

Scenario: As student i want to be able to see warrning messages whan i creat question on Q&A menu and all filds are empty
Given the user is signed in with stuone@mailinator.com 123456
Given the user is on the QA page
When user click on ask question button
When user click save question button
Then user should see 3 warrning messages

Scenario: As student i want to be able to see warrning messages whan i creat question on Q&A menu and enter only title
Given the user is signed in with stuone@mailinator.com 123456
Given the user is on the QA page
When user click on ask question button
When user enter title
When user click save question button
Then user should see 2 warrning messages

Scenario: As student i want to be able to see warrning messages whan i creat question on Q&A menu and enter only title and body
Given the user is signed in with stuone@mailinator.com 123456
Given the user is on the QA page
When user click on ask question button
When user enter title
When user enter body
When user click save question button
Then user should see 1 warrning messages

Scenario: As student i want to be able to ask question on Q&A page and add post answers to it
Given the user is signed in with stuone@mailinator.com 123456
Given the user is on the QA page
When user click on ask question button
When user enter title
When user enter body
When user choose teg registration
When user click save question button
When user enter body
When user click post answer button
Then user should see posted answer

Scenario: As student i want to be able to edit first question from Q&A page
Given the user is signed in with stuone@mailinator.com 123456
Given the user is on the QA page
When user click on the first question
When user click Edit link to edit question
When user enter title
When user enter body
When user choose teg news
When user click save question button
Then user should see created question with correct title,body,tag

