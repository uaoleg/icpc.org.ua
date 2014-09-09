package com.dataart.pages;

import java.util.Set;
import java.util.concurrent.TimeUnit;

import net.thucydides.core.annotations.At;
import net.thucydides.core.annotations.DefaultUrl;
import net.thucydides.core.annotations.findby.FindBy;
import net.thucydides.core.pages.PageObject;
import net.thucydides.core.pages.WebElementFacade;

import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.interactions.Actions;

@DefaultUrl("http://acc.icpc.org.ua/auth/login")
@At("http://acc.icpc.org.ua/auth/login")
public class LoginPage extends PageObject {

	@FindBy(xpath = "//input[@type='email']")
	WebElementFacade userNameTextField;

	@FindBy(xpath = "//input[@type='password']")
	WebElementFacade passwordTextField;

	@FindBy(xpath = "//button[@type='submit']")
	WebElementFacade loginButton;

	@FindBy(css = ".welcome")
	WebElementFacade welcomeMsg;

	@FindBy(css = ".alert.alert-danger")
	WebElementFacade flashMsg;

	@FindBy(css = ".form-group>b>a")
	WebElementFacade registerLink;

	@FindBy(xpath = "html/body/nav/div/div/ul[2]/li/a")
	WebElementFacade chooseLang;

	@FindBy(xpath = "//*[@id='main']//td[2]")
	WebElementFacade pageHeader;

	@FindBy(xpath = "//*[@id='main']//a[contains(@href,'/auth/logout')]")
	public WebElementFacade logOut;

	@FindBy(xpath = "//*[@href='https://github.com/uaoleg/icpc.org.ua']")
	WebElementFacade githubLink;

	@FindBy(xpath = "//*[@href='http://www.dataart.ua']")
	WebElementFacade daLink;

	@FindBy(xpath = "//*[@href='https://twitter.com/IcpcOrgUa']")
	WebElement twitterLink;

	@FindBy(xpath = "//*[@href='mailto:info@icpc.org.ua']")
	WebElementFacade mailtoLink;
	@FindBy(css=".form-group>a")
	WebElementFacade forgetPasswordLink;
	@FindBy(css=".navbar-text>a")
	public WebElementFacade profileLink;

	public final static String DA_PAGE_TITLE = "DataArt - разработка программного обеспечения на заказ. Вакансии программиста, работа для программиста в Петербурге, Воронеже.";

	public static final String GITHUB_PAGE_TITLE = "uaoleg/icpc.org.ua · GitHub";

	public static final String TWITTER_PAGE_TITLE = "icpc.org.ua (IcpcOrgUa) on Twitter";

	public static final String MAILTO_LINK_TEXT = "info@icpc.org.ua";
        
      

	public void enterLoginAndPassword(String userName, String password) {

		$(userNameTextField).sendKeys(userName);
		//
		$(passwordTextField).sendKeys(password);

	}

	public void clickLogin() {
		loginButton.click();

	}

	public void dataartLinkClick() {
		$(daLink).click();
	}

	public void githubLinkClick() {
		$(githubLink).click();
	}

	public void twitterLinkClick() {
		$(twitterLink).click();
	}

	public void clickOnRegisterLink() {
		registerLink.click();
	}
	

	public String getWelcomeMessage() {

		return welcomeMsg.getText();

	}

	public String getHearer() {

		return $(pageHeader).getText();
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

	public String getInvalidFlashMessage() {

		System.out.println(flashMsg.getText());
		return flashMsg.getText();

	}

	public String getPageTitle() {

		System.out.println(this.getTitle());
		return this.getTitle();
	}

	public void chooseLanguage(String language) {

		Actions builder = new Actions(getDriver());
		getDriver().manage().timeouts().implicitlyWait(10, TimeUnit.SECONDS);
		builder.moveToElement(chooseLang).build().perform();
		builder.moveToElement(
				getDriver()
						.findElement(
								By.xpath("//*[contains(@class, 'dropdown dropup language-select')]//*[@data-lang='"
										+ language + "']"))).click().perform();

	}

	public String getEmailLinkTest() {
		return mailtoLink.getText();

	}
	
	public void clickOnForgetLink(){
		Actions builder = new Actions(getDriver());
		getDriver().manage().timeouts().implicitlyWait(10, TimeUnit.SECONDS);
		builder.moveToElement(forgetPasswordLink).click().perform();
	}

}
