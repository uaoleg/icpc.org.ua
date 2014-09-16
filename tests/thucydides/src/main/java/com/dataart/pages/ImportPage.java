package com.dataart.pages;

import org.openqa.selenium.Alert;
import org.openqa.selenium.support.FindBy;

import net.thucydides.core.annotations.DefaultUrl;
import net.thucydides.core.pages.PageObject;
import net.thucydides.core.pages.WebElementFacade;

@DefaultUrl("http://acc.icpc.org.ua/auth/signup")
public class ImportPage extends PageObject{
	@FindBy(id="baylor-modal__email")
	WebElementFacade baylorEmailField;
	@FindBy(id="baylor-modal__password")
	WebElementFacade baylorPasswordField;
	@FindBy(css=".btn.btn-lg.btn-primary.js-baylor-import")
	WebElementFacade importButton;
	@FindBy(css=".close")
	WebElementFacade closeBaylorWindow;
	@FindBy(css=".js-baylor-error-creds.alert.alert-danger")
	WebElementFacade errorMessage;
	
	public void closeBaylorWindow(){
		$(closeBaylorWindow).click();		
	}
	public void enterCredential(String email, String password){
		$(baylorEmailField).clear();
		$(baylorPasswordField).clear();
		$(baylorEmailField).type(email);
		$(baylorPasswordField).type(password);
	}
	public void clickImport(){
		$(importButton).click();
		//Alert alert = getDriver().switchTo().alert();
		//alert.accept();
	}
	
	public String getErrorMessage(){
		return errorMessage.getText();
	}
	
}
