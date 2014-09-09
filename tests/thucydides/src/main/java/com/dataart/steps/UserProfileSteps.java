package com.dataart.steps;

import junit.framework.Assert;
import net.thucydides.core.annotations.Step;
import net.thucydides.core.annotations.StepGroup;
import net.thucydides.core.steps.ScenarioSteps;

import com.dataart.model.User;
import com.dataart.pages.ProfilePage;
import com.dataart.utils.Vars;

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
		profilePage.typeInto(profilePage.currentPasswordField, password);
	}
	@Step
	public void user_enter_new_password(String password){
		profilePage.typeInto(profilePage.passwordField, password);
	}
	@Step
	public void user_repeate_new_password(String password){
		profilePage.typeInto(profilePage.passwordRepeatField, password);
	}
	@Step
	public void user_click_change_password_button(){
		profilePage.clickOn(profilePage.changePasswordButton);
		
		profilePage.waitForWithRefresh();
	}
	@Step
	public void user_should_see_sucess_message(String message){
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
		additionalInfo.setDistrictField("IT");
		additionalInfo.setOcupationField("developer");
		additionalInfo.setFacultyField("Information technology");
		additionalInfo.setGroupField("KS-03");
		additionalInfo.setSchool("1985");
		additionalInfo.setCourseField("2");
		additionalInfo.setSerialField("AK564646456");
		//clean fiels
		profilePage.cleanAdditionalFields();
		
		//enter data
		profilePage.typeInto(profilePage.phoneHome, additionalInfo.getHomePhoneField());
		profilePage.typeInto(profilePage.phoneMobile, additionalInfo.getMobilePhoneField());
		profilePage.typeInto(profilePage.dateOfBirth, additionalInfo.getBirthdayField());
		profilePage.typeInto(profilePage.skype, additionalInfo.getSkypeField());
		profilePage.typeInto(profilePage.acmNumber, additionalInfo.getAcmField());
		profilePage.typeInto(profilePage.studyField, additionalInfo.getDistrictField());
		profilePage.typeInto(profilePage.speciality, additionalInfo.getOcupationField());
		profilePage.typeInto(profilePage.faculty, additionalInfo.getFacultyField());
		profilePage.typeInto(profilePage.group,additionalInfo.getGroupField());
		profilePage.typeInto(profilePage.schoolAdmissionYear, additionalInfo.getSchool());
		profilePage.typeInto(profilePage.course, additionalInfo.getCourseField());
		profilePage.typeInto(profilePage.document,additionalInfo.getSerialField());
		
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
		Assert.assertEquals(additionalInfo.getDistrictField(), profilePage.studyField.getAttribute("value"));
		Assert.assertEquals(additionalInfo.getOcupationField(), profilePage.speciality.getAttribute("value"));
		Assert.assertEquals(additionalInfo.getFacultyField(), profilePage.faculty.getAttribute("value"));
		Assert.assertEquals(additionalInfo.getGroupField(), profilePage.group.getAttribute("value"));
		Assert.assertEquals(additionalInfo.getSchool(), profilePage.schoolAdmissionYear.getAttribute("value"));
		Assert.assertEquals(additionalInfo.getCourseField(), profilePage.course.getAttribute("value"));
		Assert.assertEquals(additionalInfo.getSerialField(), profilePage.document.getAttribute("value"));
	}
	@Step
	public void user_should_see_warrning_messages_about_blank_fields(){
		Assert.assertTrue(profilePage.warrningList.size()>0);
	}

}
