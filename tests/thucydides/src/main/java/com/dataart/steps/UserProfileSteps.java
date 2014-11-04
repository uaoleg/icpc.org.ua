package com.dataart.steps;


import net.thucydides.core.annotations.Step;
import net.thucydides.core.annotations.StepGroup;
import net.thucydides.core.steps.ScenarioSteps;

import com.dataart.model.User;
import com.dataart.pages.ProfilePage;
import com.dataart.utils.Vars;

import org.apache.log4j.helpers.Loader;
import org.junit.Assert;
import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.support.ui.ExpectedConditions;

public class UserProfileSteps extends ScenarioSteps{

	ProfilePage profilePage;
	User additionalInfo = new User();	
	@Step
	public void user_move_to_general_info_tab(){
		profilePage.clickOn(profilePage.mainInfoTab);
		Assert.assertTrue(profilePage.compatibleWithUrl(Vars.MAININFO_URL));
				
	}
	@Step
	public void user_enter_current_password(String password){
		profilePage.waitFor(ExpectedConditions.visibilityOf(profilePage.currentPasswordField));
		profilePage.typeInto(profilePage.currentPasswordField, password);
	}
	@Step
	public void user_enter_new_password(String password){
		profilePage.waitFor(ExpectedConditions.visibilityOf(profilePage.passwordField));
		profilePage.typeInto(profilePage.passwordField, password);
	}
	@Step
	public void user_repeate_new_password(String password){
		profilePage.waitFor(ExpectedConditions.visibilityOf(profilePage.passwordRepeatField));
		profilePage.typeInto(profilePage.passwordRepeatField, password);
	}
	@Step
	public void user_click_change_password_button(){
		profilePage.waitFor(ExpectedConditions.visibilityOf(profilePage.changePasswordButton));
		profilePage.clickOn(profilePage.changePasswordButton);
		
		profilePage.waitForWithRefresh();
	}
	@Step
	public void user_should_see_sucess_message(String message){
		profilePage.waitFor(ExpectedConditions.visibilityOf(profilePage.successAlert));
		Assert.assertEquals(profilePage.getSuccessMessage(),message);
	}
	
	@StepGroup
	public void the_user_changs_password_back(){
		user_move_to_general_info_tab();
		user_enter_current_password("1234567");
		user_enter_new_password("123456");
		user_repeate_new_password("123456");
		user_click_change_password_button();
	}
	@Step
	public void user_should_see_error_field_message(String message){
		Assert.assertEquals(message, profilePage.getErrorMessage());
	}
	@Step
	public void user_go_to_additional_tab(String tab){
		profilePage.chooseProfileTab(tab);
		waitABit(500);
	}
	@Step
	public void user_enter_additional_info(){
		//prepare data
		additionalInfo.setHomePhoneField("7776655");
		additionalInfo.setMobilePhoneField("0678974558");
		additionalInfo.setBirthdayField("2001-05-15");
		additionalInfo.setSkypeField("myskype");
		additionalInfo.setAcmField("123123213AC");
                additionalInfo.setPositionField("engineer");
                additionalInfo.setofficeAddressField("12 AC Belleview Bay");
                additionalInfo.setPhoneworkField("223322223");
                additionalInfo.setFaxField("333222333");
                
//		additionalInfo.setDistrictField("IT");
//		additionalInfo.setOcupationField("developer");
//		additionalInfo.setFacultyField("Information technology");
//		additionalInfo.setGroupField("KS-03");
//		additionalInfo.setSchool("1985");
//		additionalInfo.setCourseField("2");
//		additionalInfo.setSerialField("AK564646456");
		//clean fiels
		profilePage.cleanAdditionalFields();
		
		//enter data
		profilePage.typeInto(profilePage.phoneHome, additionalInfo.getHomePhoneField());
		profilePage.typeInto(profilePage.phoneMobile, additionalInfo.getMobilePhoneField());
		profilePage.typeInto(profilePage.dateOfBirth, additionalInfo.getBirthdayField());
		profilePage.typeInto(profilePage.skype, additionalInfo.getSkypeField());
		profilePage.typeInto(profilePage.acmNumber, additionalInfo.getAcmField());
                profilePage.typeInto(profilePage.position, additionalInfo.getPositionField());
		profilePage.typeInto(profilePage.phoneMobile, additionalInfo.getMobilePhoneField());
		profilePage.typeInto(profilePage.dateOfBirth, additionalInfo.getBirthdayField());
		profilePage.typeInto(profilePage.skype, additionalInfo.getSkypeField());
		profilePage.typeInto(profilePage.acmNumber, additionalInfo.getAcmField());
                profilePage.typeInto(profilePage.position, additionalInfo.getPositionField());
                profilePage.typeInto(profilePage.officeAddress, additionalInfo.getOfficeaddressField());
                profilePage.typeInto(profilePage.phoneWork, additionalInfo.getPhoneworkField());
                profilePage.typeInto(profilePage.fax, additionalInfo.getFaxField());
//		profilePage.typeInto(profilePage.studyField, additionalInfo.getDistrictField());
//		profilePage.typeInto(profilePage.speciality, additionalInfo.getOcupationField());
//		profilePage.typeInto(profilePage.faculty, additionalInfo.getFacultyField());
//		profilePage.typeInto(profilePage.group,additionalInfo.getGroupField());
//		profilePage.typeInto(profilePage.schoolAdmissionYear, additionalInfo.getSchool());
//		profilePage.typeInto(profilePage.course, additionalInfo.getCourseField());
//		profilePage.typeInto(profilePage.document,additionalInfo.getSerialField());
		
	}
	@Step
	public void click_save_button(){
		profilePage.clickOn(profilePage.saveButton);
	}
	@Step
	public void user_should_see_filled_fields(){
		
		Assert.assertEquals(additionalInfo.getHomePhoneField(), profilePage.phoneHome.getAttribute("value"));
		Assert.assertEquals(additionalInfo.getMobilePhoneField(), profilePage.phoneMobile.getAttribute("value"));
		Assert.assertEquals(additionalInfo.getBirthdayField(), profilePage.dateOfBirth.getAttribute("value"));
		Assert.assertEquals(additionalInfo.getSkypeField(), profilePage.skype.getAttribute("value"));
		Assert.assertEquals(additionalInfo.getAcmField(), profilePage.acmNumber.getAttribute("value"));
                Assert.assertEquals(additionalInfo.getPositionField(), profilePage.position.getAttribute("value"));
		Assert.assertEquals(additionalInfo.getOfficeaddressField(), profilePage.officeAddress.getAttribute("value"));
		Assert.assertEquals(additionalInfo.getPhoneworkField(), profilePage.phoneWork.getAttribute("value"));
		Assert.assertEquals(additionalInfo.getFaxField(), profilePage.fax.getAttribute("value"));               
//		Assert.assertEquals(additionalInfo.getDistrictField(), profilePage.studyField.getAttribute("value"));
//		Assert.assertEquals(additionalInfo.getOcupationField(), profilePage.speciality.getAttribute("value"));
//		Assert.assertEquals(additionalInfo.getFacultyField(), profilePage.faculty.getAttribute("value"));
//		Assert.assertEquals(additionalInfo.getGroupField(), profilePage.group.getAttribute("value"));
//		Assert.assertEquals(additionalInfo.getSchool(), profilePage.schoolAdmissionYear.getAttribute("value"));
//		Assert.assertEquals(additionalInfo.getCourseField(), profilePage.course.getAttribute("value"));
//		Assert.assertEquals(additionalInfo.getSerialField(), profilePage.document.getAttribute("value"));
	}
	@Step
	public void user_should_see_warrning_messages_about_blank_fields(){
		Assert.assertTrue(profilePage.warrningList.size()>0);
	}
	@Step
	public void user_upload_a_new_photo(){
		profilePage.waitFor(ExpectedConditions.elementToBeClickable(profilePage.uploadBtn));
		//JavascriptExecutor executor = (JavascriptExecutor)getDriver();
		//executor.executeScript("arguments[0].style.display='block';", getDriver().findElement(By.xpath("//input[@type='file']")));
		getDriver().findElement(By.xpath("//*[@id='uploadContainer']//input[@type='file']")).sendKeys(Loader.getResource("images2.jpg").getFile().substring(1).replace('/','\\'));		
		//profilePage.waitFor(ExpectedConditions.visibilityOf(profilePage.profilePhoto));	
		
		profilePage.saveButton.click();
	}
	
	@Step
	public void user_should_see_uploaded_photo(){
		profilePage.waitForAnyRenderedElementOf(By.xpath("//img[contains(@src,'/user/photo/id')]"));
		Assert.assertTrue(profilePage.profilePhoto.isDisplayed());
	}
	@Step
	public void user_upload_a_new_file(String fileName){
		profilePage.waitFor(ExpectedConditions.elementToBeClickable(profilePage.uploadBtn));		
		//((JavascriptExecutor)getDriver()).executeScript("arguments[0].checked = true;", getDriver().findElement(By.xpath("//*[@id='uploadContainer']//input[@type='file']")));
		getDriver().findElement(By.xpath("//*[@id='uploadContainer']//input[@type='file']")).sendKeys(Loader.getResource(fileName).getFile().substring(1).replace('/','\\'));
		
	}
	@Step
	public void user_should_see_extension_error_message(String message){
		profilePage.waitFor(ExpectedConditions.textToBePresentInElement(profilePage.extensionError, message));		
		Assert.assertEquals(message,profilePage.extensionError.getText());
	}
	@Step
	public void user_should_see_a_message(String message){
		profilePage.waitFor(ExpectedConditions.elementToBeClickable(profilePage.alertMessage.get(0)));		
		
		Assert.assertEquals(message,profilePage.alertMessage.get(0).getText());
	}
	
	@Step
	public void user_should_see_a_message_alert(String message){
		profilePage.waitFor(ExpectedConditions.elementToBeClickable(profilePage.alertMessage.get(0)));		
		String s=profilePage.alertMessage.get(0).getText();	
		String s1= s.substring(0,53)+s.substring(54);
		Assert.assertEquals(message,s1);
	}

}
