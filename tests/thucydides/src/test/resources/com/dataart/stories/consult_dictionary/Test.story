Scenario: As user i want to be able to change my additional info on additional english page (/me/uk/en)
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user go to user profile
When user go to additional tab /en
When user enter additional info
And click save button
Then user loged out
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user go to user profile
When user go to additional tab /en
Then user should see filled fields
