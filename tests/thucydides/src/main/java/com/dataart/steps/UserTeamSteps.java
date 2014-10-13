package com.dataart.steps;

import com.dataart.pages.TeamPage;
import java.awt.AWTException;
import java.awt.Robot;
import java.awt.event.KeyEvent;
import java.io.IOException;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import net.thucydides.core.annotations.Step;
import net.thucydides.core.steps.ScenarioSteps;
import org.junit.Assert;
import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.interactions.Actions;

public class UserTeamSteps extends ScenarioSteps{
	TeamPage teamPage;
        private String tmp;
	@Step
	public void the_user_is_on_the_teams_page(){
		teamPage.open();
	}
//	@Step
//	public void user_click_on_create_a_new_team_button(){
//		teamPage.clickOn(teamPage.createTeamButton);
//	}
	@Step
	public void verify_is_on_the_Team_Page() {
		teamPage.waitForTitleToAppear(TeamPage.TEAMS_PAGE_TITLE);
	}
        
        @Step
	public void click_Export_to_CSV_and_Choose_For_Checking_System() {
		Actions builder = new Actions(getDriver());
		builder.moveToElement(teamPage.exportDropdownList).click().perform();
		waitABit(1000);
		teamPage.element(teamPage.exportForCheckingSystemItem).waitUntilVisible();
		waitABit(1000);
		
	}
        
        @Step
	public void click_Export_to_CSV_and_Choose_For_Registration() {
		Actions builder = new Actions(getDriver());
		builder.moveToElement(teamPage.exportDropdownList).click().perform();
		waitABit(1000);
		teamPage.element(teamPage.exportForRegistrationItem).waitUntilVisible();
		waitABit(1000);

	}
        
        @Step
	public int is_Exported_For_checking_system_doc_avaible_by_URL() throws MalformedURLException,
			IOException {

		URL u = new URL(teamPage.exportForCheckingSystemItem.getAttribute("href"));
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
            teamPage.teamNameField.sendKeys(TeamPage.Team_Name);
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
			
                        teamPage.addStudentsField.sendKeys("@");
                        waitABit(500);
                        robot.keyPress(KeyEvent.VK_ENTER);
			robot.keyRelease(KeyEvent.VK_ENTER);
			waitABit(2000);
                        teamPage.addStudentsField.sendKeys("@");
                        waitABit(500);
			robot.keyPress(KeyEvent.VK_ENTER);
			robot.keyRelease(KeyEvent.VK_ENTER);
                        waitABit(2000);
                        teamPage.addStudentsField.sendKeys("@");
                        waitABit(500);
			robot.keyPress(KeyEvent.VK_ENTER);
			robot.keyRelease(KeyEvent.VK_ENTER);
                        waitABit(2000);
//                        robot.keyPress(KeyEvent.VK_ENTER);
//			robot.keyRelease(KeyEvent.VK_ENTER);
//                        waitABit(2000);
//                        robot.keyPress(KeyEvent.VK_ENTER);
//			robot.keyRelease(KeyEvent.VK_ENTER);
//                        waitABit(2000);
		} catch (AWTException ex) {
			Logger.getLogger(UserDocsSteps.class.getName()).log(Level.SEVERE,
					null, ex);
		}

            

                
	}
        @Step
       public void is_Team_in_Table(){  
           getDriver().findElement(By.xpath(TeamPage.TEAM_NAME_IN_TABLE)).isDisplayed();

        }
       
       @Step
       public void user_Clicks_on_Created_Team(){
           teamPage.teamNameinTable.click();
       }
       
       @Step
       public void user_Clicks_on_Delete_Button_and_Confirms_Delete(){
           teamPage.deleteTeamButton.click();
           waitABit(2000);
           try {
			Robot robot = new Robot();
			robot.keyPress(KeyEvent.VK_ENTER);
			robot.keyRelease(KeyEvent.VK_ENTER);
			waitABit(2000);
			
		} catch (AWTException ex) {
			Logger.getLogger(UserDocsSteps.class.getName()).log(Level.SEVERE,
					null, ex);
		}
           
       }
       
       @Step
       public void team_is_not_in_the_List(){
           Assert.assertTrue(getDriver().findElements(By.xpath(TeamPage.TEAM_NAME_IN_TABLE)).isEmpty());
       }
       
       @Step
       public void choose_First_Team_in_List(){
           tmp = getDriver().findElements(By.xpath(TeamPage.TEAM_NAME_IN_TABLE_GENERAL_XPATH)).get(0).getText();
           getDriver().findElements(By.xpath(TeamPage.TEAM_NAME_IN_TABLE_GENERAL_XPATH)).get(0).click();
       }
       
       @Step
       public void is_on_the_Team_Profile_Page(){
           Assert.assertEquals(TeamPage.TEAMS_PROFILE_PAGE_TITLE, getDriver().getTitle());
           getDriver().findElement(By.xpath("//h1[contains(text(), '"+ tmp +"')]")).isDisplayed();
           tmp = null;
       }
       
       @Step
       public void choose_First_Coach_Name_in_List(){
           tmp = getDriver().findElements(By.xpath(TeamPage.COACH_NAME_IN_TABLE_GENERAL_XPATH)).get(0).getText();
           getDriver().findElements(By.xpath(TeamPage.COACH_NAME_IN_TABLE_GENERAL_XPATH)).get(0).click();
       }
       
       @Step
       public void is_on_the_Coach_Profile_Page(){
           Assert.assertEquals(TeamPage.USER_PROFILE_PAGE_TITLE, getDriver().getTitle());
           getDriver().findElement(By.xpath("//h3[contains(text(), '"+ tmp +"')]")).isDisplayed();
           tmp = null;
       }
       
       @Step
       public void choose_First_Student_Name_in_List(){
           tmp = getDriver().findElements(By.xpath(TeamPage.STUDENTS_NAME_IN_TABLE_GENERAL_XPATH)).get(0).getText();
           getDriver().findElements(By.xpath(TeamPage.STUDENTS_NAME_IN_TABLE_GENERAL_XPATH)).get(0).click();
       }
       
       @Step
       public void is_on_the_Student_Profile_Page(){
           Assert.assertEquals(TeamPage.USER_PROFILE_PAGE_TITLE, getDriver().getTitle());
           getDriver().findElement(By.xpath("//h3[contains(text(), '"+ tmp +"')]")).isDisplayed();
           tmp = null;
       }
       
       @Step
       public void input_Team_Name_for_Sorting(){
           String s = getDriver().findElements(By.xpath(TeamPage.TEAM_NAME_IN_TABLE_GENERAL_XPATH)).get(0).getText();
           teamPage.teamNameSortTextfield.sendKeys(s);
           waitABit(1000);
       }
       
       @Step
       public void is_Team_Table_is_Sorted_by_Team_Name(){
           Assert.assertEquals(getDriver().findElements(By.xpath(TeamPage.TEAM_NAME_IN_TABLE_GENERAL_XPATH)).size(), 1);
       }
       
       @Step
       public void input_University_Name_for_Sorting(){
           tmp = getDriver().findElements(By.xpath(TeamPage.UNIVERSITY_NAME_IN_TABLE_GENERAL_XPATH)).get(0).getText();
           teamPage.universityNameSortTextfield.sendKeys(tmp);
           waitABit(1000);
       }
       
       @Step
       public void is_Team_Table_is_Sorted_by_University_Name(){
           List<WebElement> l = getDriver().findElements(By.xpath(TeamPage.UNIVERSITY_NAME_IN_TABLE_GENERAL_XPATH));
           
           for (WebElement a : l){
              if( !a.getText().equals(tmp)){
                  throw new AssertionError("Element get: " +a.getText()+" but should be" + tmp);
              }
           }
       }
       

		
	}
        
       
                

