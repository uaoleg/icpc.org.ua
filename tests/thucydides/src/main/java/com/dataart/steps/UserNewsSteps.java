package com.dataart.steps;

import net.thucydides.core.annotations.Step;
import net.thucydides.core.steps.ScenarioSteps;

import org.apache.log4j.helpers.Loader;
import org.junit.Assert;
import org.junit.Before;
import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;



import com.dataart.model.News;
import com.dataart.pages.NewsPage;

public class UserNewsSteps extends ScenarioSteps {

	NewsPage newsPage;
	News news = new News();		
			
	
	@Step
	public void user_go_to_news_menu() {
		newsPage.goToNews();
		//News news = new News();
		//news.setTitle("5 Popular Open Source Test Management Tools "+ (int) (Math.random() * 10000 + 1));
		//news.setBody(" As a substitute to the multiple applications that have been designed to manage either one or two steps of the testing process, QA teams are now dependent on the various test management tools. "
		//		+ (int) (Math.random() * 10000 + 1));	
	}

	@Step
	public void user_click_on_add_news_button() {
		newsPage.clickOn(newsPage.addNewsButton);
	}

	@Step
	public void user_enter_the_title() {
		news.setTitle("5 Popular Open Source Test Management Tools "+ (int) (Math.random() * 10000 + 1));
		newsPage.titleField.clear();
		newsPage.typeInto(newsPage.titleField, news.getTitle());
	}

	@Step
	public void user_enter_enter_the_body() {
		news.setBody("As a substitute to the multiple applications that have been designed to manage either one or two steps of the testing process, QA teams are now dependent on the various test management tools. "
				+ (int) (Math.random() * 10000 + 1));	

		WebElement frame = getDriver().findElement(By.
				tagName("iframe"));
		newsPage.getDriver().switchTo().frame(frame);
		WebElement memo = getDriver().findElement(By.cssSelector("body"));
		memo.click();
		memo.clear();
		memo.sendKeys(news.getBody());
		getDriver().switchTo().defaultContent();
		newsPage.saveNewsButton.click();
		waitABit(500);
		
	}
	@Step
	public void user_click_on_save_news_button(){
		newsPage.saveNewsButton.click();
		
		
	}
	@Step
	public void user_click_on_publish_button(){
		newsPage.clickOn(newsPage.publishButton);
	}
	@Step
	public void user_should_see_created_news_on_the_top_of_news_page(){
		System.out.println(newsPage.getFirstNewsTitle());
		System.out.println(news.getTitle());
		Assert.assertEquals(news.getTitle(),newsPage.getFirstNewsTitle()); 
	
	}
	
	@Step
	public void user_should_not_see_published_news_on_the_top_of_news_page(){
		Assert.assertFalse((news.getTitle()).equals(newsPage.getFirstNewsTitle())); 
	}
	@Step
	public void user_choose_a_picture(String name){
		//newsPage.upload("src/test/resources/images2.jpg").to(newsPage.pictureForNews);		
		
		newsPage.loadImage();
		//newsPage.pictureForNews.sendKeys(Loader.getResource("images2.jpg").getFile().substring(1).replace('/','\\'));
		
	}
	@Step
	public void user_click_on_hide_button_on_the_news_page(){
		waitABit(2000);	
		newsPage.clickOn(newsPage.hideNewsList);
	}
	@Step
	public void user_click_on_publish_button_on_the_news_page(){
		waitABit(2000);
		newsPage.clickOn(newsPage.publishNewsList);
	}
	@Step
	public void user_click_preview_link(){
		newsPage.clickOn(newsPage.previewLink);
		waitABit(2000);
	}
	@Step
	public void user_should_see_a_new_page_with_news_title(){
		newsPage.goToNewWindow();
		Assert.assertEquals(news.getTitle(),newsPage.getNewsTitle());
		
	}
	@Step
	public void user_click_on_the_first_edit_link(){
		Assert.assertTrue((newsPage.editList.get(0)).isDisplayed());
		newsPage.clickOn(newsPage.editList.get(0));
	}
	@Step
	public void user_click_on_the_news_title(){
		newsPage.clickOn(newsPage.titleNewsList.get(0));
		waitABit(500);
	}
	@Step
	public void user_should_see_a_title_and_news_body(){
	
	System.out.println(news.getTitle()+"=========="+newsPage.getNewsTitle());	
	System.out.println(news.getBody()+"=========="+newsPage.getNewsBody());
	
	Assert.assertEquals(news.getTitle(),newsPage.getNewsTitle());
	Assert.assertEquals(news.getBody(),newsPage.getNewsBody());
	}
}
