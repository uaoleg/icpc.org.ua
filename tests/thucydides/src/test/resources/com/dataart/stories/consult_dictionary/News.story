Story: Post news for icpc.baylor.edu
 
Narrative: 
In order to be able to post news for all Ukraine
As a user
I want to be able to add news under admin profile

Scenario: As admin i want to be able to add news and publish it
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user go to news menu
When user click on add news button
When user enter the title
When user enter the body and click save news
When user click on publish button
And user go to news menu
Then user should see created news on the top of news page

Scenario: As admin i want to be able to create news, publish and check is it exist on the main page under guest
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user go to news menu
When user click on add news button
When user enter the title
When user enter the body and click save news
When user click on publish button
Then user loged out
Then user should see created news on the top of news page

Scenario: As admin i want to be able to create news, publish and check is it exist on the main page under student
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user go to news menu
When user click on add news button
When user enter the title
When user enter the body and click save news
When user click on publish button
Then user loged out
Given the user is signed in with stuone@mailinator.com 123456
When user go to news menu
Then user should see created news on the top of news page

Scenario: As admin i want to be able to create news,don't publish it and check that it does not exist on the main page under guest
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user go to news menu
When user click on add news button
When user enter the title
When user enter the body and click save news
Then user loged out
Then user should not see published news on the top of news page

Scenario: As admin i want to be able to add news and publish it and hide the news from the news page
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user go to news menu
When user click on add news button
When user enter the title
When user enter the body and click save news
When user click on publish button
And user go to news menu
When user click on hide button on the news page
Then user loged out
Then user should not see published news on the top of news page

Scenario: As admin i want to be able to add news, save it and publish from the news page and check is it exist under guest
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user go to news menu
When user click on add news button
When user enter the title
When user enter the body and click save news
And user go to news menu
When user click on publish button on the news page
Then user loged out
Then user should see created news on the top of news page

Scenario: As admin i want to be able to add news and preview it using the top page link
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user go to news menu
When user click on add news button
When user enter the title
When user enter the body and click save news
When user click preview link
Then user should see a new page with news title

Scenario: As admin i want to be able to edit news
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user go to news menu
When user click on the first edit link
When user enter the title
When user enter the body and click save news
When user click on publish button
And user go to news menu
Then user should see created news on the top of news page

Scenario: As user i want to be able create news and open it from news page by clicking on the title
Given the user is signed in with admin@icpc.org.ua e3r4t5
When user go to news menu
When user click on add news button
When user enter the title
When user enter the body and click save news
When user click on publish button
And user go to news menu
When user click on the news title
Then user should see a title and news body