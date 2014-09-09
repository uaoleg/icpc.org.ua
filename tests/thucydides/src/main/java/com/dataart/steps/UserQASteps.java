package com.dataart.steps;

import org.junit.Assert;


import org.openqa.selenium.By;
import org.openqa.selenium.Keys;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.Select;

import com.dataart.model.News;
import com.dataart.model.Tag;
import com.dataart.pages.QaPage;
import com.dataart.utils.Table;
import com.dataart.utils.Vars;

import net.thucydides.core.annotations.Step;
import net.thucydides.core.steps.ScenarioSteps;

public class UserQASteps extends ScenarioSteps {
	QaPage qaPage;
	Tag newtag = new Tag();
	News news = new News();

	@Step
	public void is_on_the_qa_page() {

		qaPage.open();
	}
	@Step
	public void user_click_on_manage_tabs_button(){
		qaPage.clickOn(qaPage.manageTagsButton);
		qaPage.waitForTitleToAppear(Vars.QA_TITLE);
	}
	@Step
	public void user_click_on_create_tab_button(){
		qaPage.clickOn(qaPage.createTagButton);
		qaPage.waitForTitleToAppear(Vars.QA_CREATE_TAB_TITLE);
	}
	@Step
	public void user_enter_title_field(){
		newtag.setTitle("java"+(int) (Math.random() * 10000 + 1));
		qaPage.titleTagField.clear();
		qaPage.typeInto(qaPage.titleTagField, newtag.getTitle());
		
	}
	@Step
	public void user_enter_description_field(){
		newtag.setDescription("Some description"+(int) (Math.random() * 10000 + 1));
		qaPage.descriptionTagField.clear();
		qaPage.typeInto(qaPage.descriptionTagField, newtag.getDescription());
	}
	@Step
	public void user_click_save_button(){
		
		qaPage.clickOn(qaPage.saveButton);
	}
	@Step
	public void user_should_see_a_new_tag_with_name_and_description(){
		
		Assert.assertTrue(Table.isTagNameExistInTable(qaPage.tagsTable, newtag.getTitle()));
		Assert.assertTrue(Table.isTagDescriptionExistInTable(qaPage.tagsTable, newtag.getDescription()));
		
	}
	@Step
	public void user_click_on_delete_button(){
	 double pre = Table.getRowsNumber(qaPage.tagsTable);	 
		qaPage.clickOn(qaPage.deleteButtonList.get(0));
		waitABit(200);
		qaPage.clickOn(qaPage.confirmButton);
		waitABit(200);
		getDriver().navigate().refresh();
	 double post = Table.getRowsNumber(qaPage.tagsTable);	
	 Assert.assertTrue(pre>post);
	}
	@Step
	public void user_click_edit_button(){
		qaPage.clickOn(qaPage.editButtonList.get(0));
		waitABit(200);
		
	}
	@Step
	public void user_should_see_a_new_tag_with_name(){
		
		Assert.assertTrue(Table.isTagNameExistInTable(qaPage.tagsTable, newtag.getTitle()));
				
	}
	@Step
	public void user_should_see_warrning(String message){
		Assert.assertEquals(message,qaPage.warrningMessage.getText());
	}
	
	@Step
	public void user_click_on_ask_question_button(){
		qaPage.clickOn(qaPage.askQuestionButton);
		qaPage.waitForTitleToAppear(Vars.ASK_QA_TITLE);
	}
        @Step
	public void user_click_on_ask_question_button_nowait(){
		qaPage.clickOn(qaPage.askQuestionButton);
		
	}
        
	@Step
	public void user_enter_the_title() {
		news.setTitle("This is a new question "+ (int) (Math.random() * 10000 + 1));
		qaPage.titleField.clear();
		qaPage.typeInto(qaPage.titleField, news.getTitle());
	}
	@Step
	public void user_enter_body(){
		news.setBody("This is a new body"+ (int) (Math.random() * 10000 + 1));	

		WebElement frame = getDriver().findElement(By.
				tagName("iframe"));
		qaPage.getDriver().switchTo().frame(frame);
		WebElement memo = getDriver().findElement(By.cssSelector("body"));
		memo.click();
		memo.clear();
		memo.sendKeys(news.getBody());
		getDriver().switchTo().defaultContent();
		waitABit(200);
	}
	@Step
	public void user_choose_teg_registration(String tag){
		waitABit(500);
		new Select(getDriver().findElement(By.xpath("//select[@class='select2-offscreen']"))).selectByValue(tag);
		waitABit(1000);
		
	}
	@Step
	public void user_click_save_question_button(){
		qaPage.clickOn(qaPage.saveQuestionButton);		
		waitABit(500);
	}
	@Step
	public void should_see_created_question(){
		System.out.println(news.getTitle());
		System.out.println(qaPage.titleHeader.getText());
		Assert.assertEquals(news.getBody(), qaPage.bodyHeader.getText());
		Assert.assertTrue(qaPage.titleHeader.getText().contains(news.getTitle()));
		
	}
	@Step
	public void user_should_see_the_warrning_messages(int number){
		Assert.assertTrue(qaPage.warrningMessages.size()==number);
	}
	@Step
	public void user_click_post_answer_button(){
		qaPage.clickOn(qaPage.postAnswer);
		
	}
	@Step
	public void user_should_see_posted_answer(){
		Assert.assertEquals(news.getBody(), qaPage.answersList.get(0).getText());
	}
	
	@Step
	public void user_click_on_the_first_question(){
		qaPage.clickOn(qaPage.listOfQuestions.get(0));
	}
	@Step
	public void user_click_Edit_link_to_edit_question(){
		qaPage.clickOn(qaPage.editLink);

	}
	
}
