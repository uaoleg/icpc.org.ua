package com.dataart.steps;

import junit.framework.Assert;

import org.openqa.selenium.interactions.Actions;

import com.dataart.pages.ManageUserPage;

import net.thucydides.core.annotations.Step;
import net.thucydides.core.steps.ScenarioSteps;

public class ManageUserSteps extends ScenarioSteps {

	ManageUserPage manageUser;
	
	@Step
	public void user_go_to_menu_Coaches() {

		Actions builder = new Actions(getDriver());		
		builder.moveToElement(manageUser.usersLink.get(1)).click().perform();
		waitABit(1000);
		manageUser.element(manageUser.usersLink.get(1)).waitUntilVisible();
		waitABit(1000);
		builder.moveToElement(manageUser.coaches).click().perform();
	}
	@Step
	public void user_click_activate_on_the_first_item_from_the_list(){
			
		waitABit(1000);
		manageUser.click_on_ActivateStatus("myicpctest@gmail.com");
	
	}
	@Step
	public void user_should_see_status(String status){
		
		Assert.assertEquals(status, manageUser.approvedStatus.getText());
		
	}


}
