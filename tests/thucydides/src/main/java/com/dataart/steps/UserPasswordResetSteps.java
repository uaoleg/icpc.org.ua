package com.dataart.steps;

import net.thucydides.core.annotations.Step;
import net.thucydides.core.pages.Pages;
import net.thucydides.core.steps.ScenarioSteps;

import org.junit.Assert;

import com.dataart.pages.PasswordResetPage;

public class UserPasswordResetSteps extends ScenarioSteps{
	public UserPasswordResetSteps(Pages pages) {
		super(pages);

	}
	PasswordResetPage passwordResetPage;

	
	@Step
	public void is_user_on_the_password_reset_page(){
		passwordResetPage.open();		
		passwordResetPage.shouldBeDisplayed();
		
	}
	@Step
	public void user_click_on_reset_password_button(){
		passwordResetPage.clickOn(passwordResetPage.resetButton);
	}

	@Step
	public void user_should_see_email_warrning_message(String message){
		passwordResetPage.waitForAnyTextToAppear(message);
		Assert.assertEquals(message,passwordResetPage.getEmailErrorMessage());
	}
	@Step
	public void user_should_see_capcha_warrning_message(String message){
		passwordResetPage.waitForAnyTextToAppear(message);
		Assert.assertEquals(message,passwordResetPage.getCapchaErrorMessage());
	}
	@Step
	public void user_enter_email(String email){
		passwordResetPage.enterEmail(email);
	}
}
