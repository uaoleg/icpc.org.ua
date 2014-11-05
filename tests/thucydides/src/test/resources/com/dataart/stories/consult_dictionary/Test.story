Scenario: As admin i want to be able to navigate to the previous page and back
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user go to news menu
When user click on Newer button
When user click on Older button
Then user should see initial news page
