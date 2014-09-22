package com.dataart.steps;

import com.dataart.pages.TeamPage;
import java.awt.AWTException;
import java.awt.Robot;
import java.awt.event.KeyEvent;
import java.io.IOException;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.logging.Level;
import java.util.logging.Logger;

import net.thucydides.core.annotations.Step;
import net.thucydides.core.steps.ScenarioSteps;
import org.openqa.selenium.interactions.Actions;

public class UserTeamSteps extends ScenarioSteps{
	TeamPage teamPage;
	@Step
	public void the_user_is_on_the_teams_page(){
		teamPage.open();
	}
	@Step
	public void user_click_on_create_a_new_team_button(){
		teamPage.clickOn(teamPage.createTeamButton);
	}
	@Step
	public void verify_is_on_the_Team_Page() {
		teamPage.waitForTitleToAppear(TeamPage.TEAMS_PAGE_TITLE);
	}
        
        @Step
	public void click_Export_to_CSV_and_Choose_For_Checking_System() {
		Actions builder = new Actions(getDriver());
		builder.moveToElement(teamPage.exportDropdownList).click().perform();
		waitABit(1000);
		teamPage.element(teamPage.exportForTrackingSystemItem).waitUntilVisible();
		waitABit(1000);
//		builder.moveToElement(teamPage.exportForTrackingSystemItem).click()
//				.perform();
	}
        
        @Step
	public void click_Export_to_CSV_and_Choose_For_Registration() {
		Actions builder = new Actions(getDriver());
		builder.moveToElement(teamPage.exportDropdownList).click().perform();
		waitABit(1000);
		teamPage.element(teamPage.exportForRegistrationItem).waitUntilVisible();
		waitABit(1000);
//		builder.moveToElement(teamPage.exportForTrackingSystemItem).click()
//				.perform();
	}
        
        @Step
	public int is_Exported_For_checking_system_doc_avaible_by_URL() throws MalformedURLException,
			IOException {
		// String USER_AGENT = "Mozilla/5.0";
		// URL u = new URL(el.getAttribute("href"));
		// System.out.println(u);
		// HttpURLConnection huc = (HttpURLConnection) u.openConnection();
		// huc.setRequestMethod("GET");
		// huc.setRequestProperty("User-Agent", USER_AGENT);
		// huc.setRequestProperty("Accept-Language", "en-US,en;q=0.5");
		// huc.setDoOutput(true);
		// DataOutputStream wr = new DataOutputStream(huc.getOutputStream());
		// wr.flush();
		// wr.close();
		//
		// int responseCode = huc.getResponseCode();
		// System.out.println("\nSending 'GET' request to URL : " + u);
		// // System.out.println("Post parameters : " + urlParameters);
		// System.out.println("Response Code : " + responseCode);
		// return responseCode;
		URL u = new URL(teamPage.exportForTrackingSystemItem.getAttribute("href"));
                System.out.println(u);
		HttpURLConnection huc = (HttpURLConnection) u.openConnection();
		huc.setRequestMethod("GET");
		huc.setRequestProperty("User-Agent", "Mozilla/5.0");
		huc.setRequestProperty("Accept-Language", "en-US,en;q=0.5");
		huc.connect();
		System.out.println(huc.getResponseCode());
		return huc.getResponseCode();

	}
        
        @Step
	public int is_Exported_For_Registration_doc_avaible_by_URL() throws MalformedURLException,
			IOException {
		// String USER_AGENT = "Mozilla/5.0";
		// URL u = new URL(el.getAttribute("href"));
		// System.out.println(u);
		// HttpURLConnection huc = (HttpURLConnection) u.openConnection();
		// huc.setRequestMethod("GET");
		// huc.setRequestProperty("User-Agent", USER_AGENT);
		// huc.setRequestProperty("Accept-Language", "en-US,en;q=0.5");
		// huc.setDoOutput(true);
		// DataOutputStream wr = new DataOutputStream(huc.getOutputStream());
		// wr.flush();
		// wr.close();
		//
		// int responseCode = huc.getResponseCode();
		// System.out.println("\nSending 'GET' request to URL : " + u);
		// // System.out.println("Post parameters : " + urlParameters);
		// System.out.println("Response Code : " + responseCode);
		// return responseCode;
		URL u = new URL(teamPage.exportForRegistrationItem.getAttribute("href"));
                System.out.println(u);
		HttpURLConnection huc = (HttpURLConnection) u.openConnection();
		huc.setRequestMethod("GET");
		huc.setRequestProperty("User-Agent", "Mozilla/5.0");
		huc.setRequestProperty("Accept-Language", "en-US,en;q=0.5");
		huc.connect();
		System.out.println(huc.getResponseCode());
		return huc.getResponseCode();

	}
        
        @Step
        public void user_Clicks_on_Create_Team_Button(){
            teamPage.createTeamButton.click();
        }
        
        @Step
        public void user_Enters_Team_Name(){
            teamPage.teamNameField.sendKeys("testteam");
        }
        
        @Step
        public void user_Clicks_Save_Team_Button(){
            teamPage.saveTeamButton.click();
        }
        
        @Step
	public void adding_New_Students_to_Team() {
            
            teamPage.addStudentsField.click();	
		try {
			Robot robot = new Robot();
			robot.keyPress(KeyEvent.VK_ENTER);
			robot.keyRelease(KeyEvent.VK_ENTER);
			waitABit(500);
			robot.keyPress(KeyEvent.VK_ENTER);
			robot.keyRelease(KeyEvent.VK_ENTER);
                        waitABit(500);
			robot.keyPress(KeyEvent.VK_ENTER);
			robot.keyRelease(KeyEvent.VK_ENTER);
		} catch (AWTException ex) {
			Logger.getLogger(UserDocsSteps.class.getName()).log(Level.SEVERE,
					null, ex);
		}
                Actions builder = new Actions(getDriver());
//                
//		builder.moveToElement(teamPage.addStudentsField).click().perform();
//		waitABit(500);
//		teamPage.element(teamPage.firstStudentOption).waitUntilVisible();
//                builder.moveToElement(teamPage.firstStudentOption).click().perform();
//		waitABit(500);
//                builder.moveToElement(teamPage.addStudentsField).click().perform();
//                teamPage.element(teamPage.secondStudentOption).waitUntilVisible();
//                builder.moveToElement(teamPage.secondStudentOption).click().perform();
//                waitABit(500);
//                builder.moveToElement(teamPage.addStudentsField).click().perform();
//                teamPage.element(teamPage.thirdStudentOption).waitUntilVisible();
//                builder.moveToElement(teamPage.thirdStudentOption).click().perform();
//                waitABit(500);
//		builder.moveToElement(teamPage.exportForTrackingSystemItem).click()
//				.perform();
                
	}
        @Step
       public void is_Team_in_Table(){    

        }
		
	}
        
       
                

