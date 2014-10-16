package com.dataart.steps;

import net.thucydides.core.annotations.Step;
import net.thucydides.core.steps.ScenarioSteps;

import org.junit.Assert;
import org.openqa.selenium.By;
import org.openqa.selenium.interactions.Actions;
import org.openqa.selenium.support.ui.ExpectedConditions;

import com.dataart.pages.ResultsPage;
import com.dataart.utils.Vars;

public class UserResultsSteps extends ScenarioSteps {

	ResultsPage resultsPage;

	@Step
	public void the_user_is_on_the_results_page() {
		resultsPage.open();
	}

	@Step
	public void user_click_on_the_results_menu() {

		resultsPage.clickOn(resultsPage.teamsMenu);
		Assert.assertEquals(Vars.RESULTSPAGE, resultsPage.getDriver()
				.getCurrentUrl());
	}

	@Step
	public void user_click_on_upload_result_button() {
		resultsPage.waitFor(ExpectedConditions
				.elementToBeClickable(resultsPage.uploadResultsBtn));
		resultsPage.clickOn(resultsPage.uploadResultsBtn);
		resultsPage.waitFor(ExpectedConditions
				.elementToBeClickable(resultsPage.chooseFileBtn));

	}

	@Step
	public void user_choose_area(String area) {

		if (area.equals("ukraine")) {
			resultsPage.clickOn(resultsPage.areaList.get(0));
		} else if (area.equals("center")) {
			resultsPage.clickOn(resultsPage.areaList.get(1));

		} else if (area.equals("dnipropetrovsk")) {
			resultsPage.clickOn(resultsPage.areaList.get(2));
		}
		resultsPage.waitFor(ExpectedConditions
				.elementToBeClickable(resultsPage.enableUpload));
		resultsPage.clickOn(resultsPage.enableUpload);
		resultsPage.waitFor(ExpectedConditions.visibilityOf(resultsPage.resultTable));
	}
	@Step
	public void user_should_see_uploaded_table_with_results(){
		
		Assert.assertTrue(resultsPage.resultTable.isDisplayed());
	}
	@Step
	public void user_close_the_modal_window(){
		resultsPage.clickOn(resultsPage.closeDialog);
		resultsPage.waitFor(ExpectedConditions.invisibilityOfElementLocated(By.xpath("//*[@id='uploadModal']/div[@class='modal-dialog']")));
	}
	@Step
	public void user_should_not_see_a_modal_window(){
		Assert.assertFalse(resultsPage.isElementVisible(By.xpath("//*[@id='uploadModal']/div[@class='modal-dialog']")));
		
	}
	@Step
	public void user_should_see_disable_upload_button(){
		System.out.println(resultsPage.uploadBtn.getAttribute("disabled"));
		Assert.assertTrue((resultsPage.uploadBtn.getAttribute("disabled")).equals("true"));
	}
}
