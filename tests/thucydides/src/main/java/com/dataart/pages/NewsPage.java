package com.dataart.pages;

import java.util.List;
import java.util.Set;

import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.WebElement;

import com.gargoylesoftware.htmlunit.javascript.host.Document;

import net.thucydides.core.annotations.At;
import net.thucydides.core.annotations.DefaultUrl;
import net.thucydides.core.annotations.findby.FindBy;
import net.thucydides.core.pages.PageObject;
import net.thucydides.core.pages.WebElementFacade;

@DefaultUrl("http://acc.icpc.org.ua")
@At("http://acc.icpc.org.ua")
public class NewsPage extends PageObject {

	@FindBy(xpath = "//*[@class='nav navbar-nav']/li/a")
	List<WebElement> mainMenuList;
	@FindBy(css = ".btn.btn-success.btn-lg")
	public WebElementFacade addNewsButton;
	@FindBy(css = "#uploadNewsImages")
	public WebElement uploadImage;
	@FindBy(xpath = "//input[@name='title']")
	public WebElementFacade titleField;
	@FindBy(css = ".cke_editable.cke_editable_themed.cke_contents_ltr>p")
	public WebElementFacade memoField;
	@FindBy(css = ".btn.btn-primary.save-news.btn-lg.pull-left")
	public WebElementFacade saveNewsButton;
	@FindBy(css = ".btn.btn-success.btn-lg")
	public WebElementFacade publishButton;
	@FindBy(xpath = "//*[@id='main']//h2/a[1]")
	public List<WebElement> newsTitles;
	@FindBy(xpath = "//*[@id='main']//button[@data-status='0']")
	public WebElementFacade hideNewsList;
	@FindBy(xpath = "//*[@id='main']//button[@data-status='1']")
	public WebElement publishNewsList;
	@FindBy(css = ".page-header.clearfix>small>a")
	public WebElementFacade previewLink;

	@FindBy(xpath = "//input[@type='file']")
	public WebElementFacade pictureForNews;
	@FindBy(xpath = "//*[@id='main']/div/div[4]/h1")
	public WebElementFacade newsTitle;
	@FindBy(xpath = "//*[@id='main']/div/p[2]")
	public WebElementFacade newsBody;
	@FindBy(css = ".btn.btn-link")
	public List<WebElement> editList;
	@FindBy(xpath = "//h2[@class='news-title']/a[contains(@href,'/news/view')]")
	public List<WebElement> titleNewsList;

	public void goToNews() {
		mainMenuList.get(0).click();
	}

	public void goToNewWindow() {
		String parentWindow = getDriver().getWindowHandle();
		Set<String> handles = getDriver().getWindowHandles();
		for (String windowHandle : handles) {
			if (!windowHandle.equals(parentWindow)) {
				getDriver().switchTo().window(windowHandle);

			}
		}
	}

	public String getFirstNewsTitle() {
		return newsTitles.get(0).getText();
	}

	public String getNewsTitle() {
		
		return newsTitle.getText();
	}

	public String getNewsBody() {
		
		return newsBody.getText();
	}

	public void loadImage() {

		((JavascriptExecutor) getDriver())
				.executeScript("$r=document.evaluate(\""
						+ "//div[@class='moxie-shim moxie-shim-html5']"
						+ "\", document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue; $r.style = \"position: absolute; top: 0px; left: 0px; width: 129px; height: 34px; overflow: hidden; z-index: 0;\";");

		System.out.println(pictureForNews.isCurrentlyVisible());
		upload("src/test/resources/images2.jpg").to(pictureForNews);
	}
}
