package com.dataart.pages;

import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;

import net.thucydides.core.annotations.At;
import net.thucydides.core.annotations.DefaultUrl;
import net.thucydides.core.annotations.findby.FindBy;
import net.thucydides.core.pages.PageObject;
import net.thucydides.core.pages.WebElementFacade;

@DefaultUrl("http://acc.icpc.org.ua/user/me")
@At("http://acc.icpc.org.ua/user/me")
public class ProfilePage extends PageObject{
	
	@FindBy(xpath="//li/a[@href='/user/me']")
	public WebElementFacade mainInfoTab;
	@FindBy(id="currentPassword")
	public WebElementFacade currentPasswordField;
	@FindBy(id="password")
	public WebElementFacade passwordField;
	@FindBy(id="passwordRepeat")
	public WebElementFacade passwordRepeatField;
	@FindBy(css=".btn.btn-lg.btn-primary.btn-save-password")
	public WebElementFacade changePasswordButton;
	@FindBy(css=".alert.alert-success")
	public WebElementFacade successAlert;
	@FindBy(css=".btn.btn-lg.btn-primary.js-save")
	public WebElementFacade saveButton;
	@FindBy(css=".btn.btn-lg.btn-warning")
	public WebElementFacade importButton;
	
	@FindBy(css=".help-block")	
	public WebElementFacade errorMessageForPasswordChange;
	
	@FindBy(id="phoneHome")
	public WebElementFacade phoneHome;
	@FindBy(id="phoneMobile")
	public WebElementFacade phoneMobile;
	@FindBy(id="dateOfBirth")
	public WebElementFacade dateOfBirth;
	@FindBy(id="skype")
	public WebElementFacade skype;
	@FindBy(id="acmNumber")
	public WebElementFacade acmNumber;
	@FindBy(id="studyField")
	public WebElementFacade studyField;
	@FindBy(id="speciality")
	public WebElementFacade speciality;
	@FindBy(id="faculty")
	public WebElementFacade faculty;
	@FindBy(id="group")
	public WebElementFacade group;
	@FindBy(id="schoolAdmissionYear")
	public WebElementFacade schoolAdmissionYear;
	@FindBy(id="course")	
	public WebElementFacade course;
	@FindBy(id="document")
	public WebElementFacade document;
	@FindBy(css=".help-block")
	public List<WebElement> warrningList;
	
	
	public void cleanAdditionalFields(){
		phoneHome.clear();
		phoneMobile.clear();
		dateOfBirth.clear();
		skype.clear();
		acmNumber.clear();
		studyField.clear();
		speciality.clear();
		faculty.clear();
		group.clear();
		schoolAdmissionYear.clear();
		course.clear();
		document.clear();
		
	}
	
	
	
	
	
	public String getSuccessMessage(){
		
		return successAlert.getText();
	}
	
	public String getErrorMessage(){
		return errorMessageForPasswordChange.getText();
	}
	
	public void chooseProfileTab(String tab){
		getDriver().findElement(By.xpath(".//*[@id='main']//li/a[contains(@href,'"+tab+"')]")).click();
		
	}
	
	
}
