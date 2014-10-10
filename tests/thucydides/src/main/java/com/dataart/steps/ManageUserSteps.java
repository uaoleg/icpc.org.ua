package com.dataart.steps;



import org.junit.Assert;
import org.openqa.selenium.interactions.Actions;
import org.openqa.selenium.support.ui.ExpectedConditions;

import com.dataart.pages.ManageUserPage;
import com.dataart.utils.Vars;

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
	public void user_click_activate_on_the_first_item_from_the_list() {

		waitABit(1000);
		manageUser.click_on_ActivateStatus("myicpctest@gmail.com");

	}

	@Step
	public void user_should_see_status(String status) {

		if (status.equals("Approved")) {
			Assert.assertEquals(status, manageUser.approvedStatus.getText());
		} else {
			Assert.assertEquals(status, manageUser.notapprovedStatus.getText());
		}

	}
	@Step
	public void user_enter_into_search_field(String email){
		manageUser.waitFor(ExpectedConditions.elementToBeClickable(manageUser.emailSearchField));
		manageUser.typeInto(manageUser.emailSearchField, email);
		manageUser.waitFor(ExpectedConditions.textToBePresentInElement(manageUser.emailCell, email));
	}
	@Step
	public void user_should_see_correct_search_result_in_the_table(String email){
		
		manageUser.waitFor(ExpectedConditions.textToBePresentInElement(manageUser.emailCell, email));
		Assert.assertEquals(email, manageUser.emailCell.getText());
	}
	
	@Step
	public void user_click_on_the_name(){
			
		manageUser.waitFor(ExpectedConditions.elementToBeClickable(manageUser.nameCell));
		manageUser.clickOn(manageUser.nameCell);
	}
	@Step
	public void user_should_see_corespondent_information_about_himself() {

		manageUser.waitFor(ExpectedConditions.textToBePresentInElement(manageUser.userName, Vars.ADMINSNAME));
		
		Assert.assertEquals(Vars.ADMINSNAME, manageUser.userName.getText());
		Assert.assertEquals(Vars.ADMINSUNIV, manageUser.userUniver.getText());
		Assert.assertEquals(Vars.ADMINSEMAIL, manageUser.userEmail.getText());
		
	}
	
	@Step
	public void user_chooses_from_drop_down_menu_Active(String item){
		
		manageUser.waitFor(ExpectedConditions.elementToBeClickable(manageUser.selectStatus));
		manageUser.selectFromDropdown(manageUser.selectStatus, item);
		manageUser.waitFor(ExpectedConditions.textToBePresentInElement(manageUser.selectStatus, item));
	}
	@Step
	public void user_should_see_only_users_with_button(String item){
		manageUser.waitFor(ExpectedConditions.elementToBeClickable(manageUser.selectStatus));
		Assert.assertTrue(manageUser.checkUserStatus(item));
		
	}
}
