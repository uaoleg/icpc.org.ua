package com.dataart.pages;

import java.util.List;

import net.thucydides.core.annotations.At;
import net.thucydides.core.annotations.DefaultUrl;
import net.thucydides.core.annotations.findby.FindBy;
import net.thucydides.core.pages.PageObject;
import net.thucydides.core.pages.WebElementFacade;

import org.openqa.selenium.WebElement;

@DefaultUrl("http://acc.icpc.org.ua/auth/passwordReset")
@At("http://acc.icpc.org.ua/auth/passwordReset")
public class PasswordResetPage extends PageObject {

	@FindBy(css = ".form-control")
	public WebElementFacade emailField;
	@FindBy(css = ".btn.btn-primary.reset-password")
	public WebElementFacade resetButton;
	@FindBy(css = ".help-block")
	public List<WebElement> errorList;

	public void clickOnResetButton() {
		$(resetButton).click();
	}

	public String getEmailErrorMessage() {
		return errorList.get(0).getText();
	}

	public String getCapchaErrorMessage() {
		return errorList.get(1).getText();

	}

	public void enterEmail(String email) {
		emailField.type(email);
	}
}
