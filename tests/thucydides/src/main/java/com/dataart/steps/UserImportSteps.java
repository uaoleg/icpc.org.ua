package com.dataart.steps;

import junit.framework.Assert;

import com.dataart.model.User;
import com.dataart.pages.ImportPage;
import com.dataart.utils.Vars;
import com.sun.jersey.api.client.Client;
import com.sun.jersey.api.client.WebResource;

import net.thucydides.core.annotations.Step;
import net.thucydides.core.pages.Pages;
import net.thucydides.core.steps.ScenarioSteps;

public class UserImportSteps extends ScenarioSteps{
	public UserImportSteps(Pages pages) {
		super(pages);

	}
	ImportPage importPage;
	@Step
	public void user_close_the_baylor_popup_window(){
		importPage.closeBaylorWindow();
		importPage.waitForTextToDisappear(Vars.BAYLOR_HEADER);
		
	}
	@Step
	public void user_enter_credentials(String email,String password){
		importPage.enterCredential(email, password);
	}
	@Step
	public void click_import_button(){
		importPage.clickImport();
		waitABit(10000);
		
	}
	@Step
	public void user_should_see_error_message_on_popup(String message){
		Assert.assertEquals(message,importPage.getErrorMessage());
	}
	
}
