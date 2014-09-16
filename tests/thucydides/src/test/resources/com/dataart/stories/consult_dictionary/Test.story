Scenario: As coordinator i want to be able to upload documents to the Regulations section
Given the user is on the Login page
When the user enters name: coord1@mailinator.com and password: 123456 and click the 'login' button
When user clicks on the Docs link and chooses Regulations item
Then user clicks on the Upload Doc button in Regulation section
Then user fills all the fields
Then user chooses file and uploads it
Then user is able to see document in the list
