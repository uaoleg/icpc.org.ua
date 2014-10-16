Story: Manage Results for icpc.org.ua
 
Narrative: 
In order to be able to manage results for icpc.org.ua
As a user
I want to be able to upload, view results for teems

Scenario: As user i want to be able to upload results for Certer area
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user click on the Results link
When user click on upload result button
When user upload a new file icpc_results_1.html
When user choose area center
Then user should see uploaded table with results

Scenario: As user i want to be able to upload results for Ukraine area
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user click on the Results link
When user click on upload result button
When user upload a new file icpc_results_1.html
When user choose area ukraine
Then user should see uploaded table with results

Scenario: As user i want to be able to upload results for Dnipro area
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user click on the Results link
When user click on upload result button
When user upload a new file icpc_results_1.html
When user choose area dnipropetrovsk
Then user should see uploaded table with results

Scenario: As user i want to be able to upload results for Certer area
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user click on the Results link
When user click on upload result button
When user upload a new file TestDoc.doc
Then user should see extension error message File extension error.

Scenario: As user i want to be able to close a modal window
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user click on the Results link
When user click on upload result button
When user close the modal window
Then user should not see a modal window

Scenario: As user i want to be able to see disable upload button befor file upload
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user click on the Results link
When user click on upload result button
Then user should see disable upload button