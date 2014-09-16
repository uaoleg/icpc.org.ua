package com.dataart.pages;

import java.util.List;

import net.thucydides.core.annotations.At;
import net.thucydides.core.annotations.DefaultUrl;
import net.thucydides.core.pages.PageObject;
import net.thucydides.core.pages.WebElementFacade;

import org.openqa.selenium.By;
import org.openqa.selenium.Keys;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.interactions.Actions;
import org.openqa.selenium.support.FindBy;

import com.dataart.model.User;
import com.dataart.utils.CheckGmail;
import com.dataart.utils.DBClean;
import com.dataart.utils.Vars;

@DefaultUrl("http://acc.icpc.org.ua/auth/signup")
@At("http://acc.icpc.org.ua/auth/signup")
public class RegistrationPage extends PageObject {

	@FindBy(name = "firstNameUk")
	WebElementFacade firstName;
	@FindBy(name = "middleNameUk")
	WebElementFacade middleName;
	@FindBy(name = "lastNameUk")
	WebElementFacade lastName;
	@FindBy(name = "email")
	WebElementFacade email;
	@FindBy(name = "password")
	WebElementFacade password;
	@FindBy(name = "passwordRepeat")
	WebElementFacade passwordRepeat;

	@FindBy(css = ".btn.btn-default")
	List<WebElement> userrole;

	@FindBy(css = ".dropdown-menu.pull-right>li>a")
	List<WebElement> coordinatorList;

	@FindBy(css = ".caption")
	WebElement coordinatorRole;

	@FindBy(css = ".select2-chosen")
	WebElementFacade schoolList;
	@FindBy(name = "recaptchaIgnore")
	WebElementFacade recaptchaIgnore;
	@FindBy(name = "rulesAgree")
	WebElementFacade rulesAgree;

	@FindBy(xpath = "//*[@id='main']//p[1]")
	WebElementFacade confirmMessage;
	@FindBy(css = ".signup.btn.btn-primary.btn-lg")
	WebElementFacade signUpButton;

	@FindBy(css = ".help-block")
	List<WebElementFacade> listOfWarrnings;
	@FindBy(css = ".btn.btn-primary.btn-resend-email")
	WebElementFacade resendButton;
	@FindBy(css = ".help-block")
	WebElementFacade errorDBmessage;
	@FindBy(css=".panel-heading")
	WebElementFacade emailVerifiedMessage;
	@FindBy(css=".panel-body>a")
	WebElementFacade linkToLoginPage;
	@FindBy(css=".btn.btn-lg.btn-warning")
	WebElementFacade baylorImportButton;
	
	

	public String getPageTitle() {

		System.out.println(getTitle());
		return getTitle();
	}

	public void enterCredentials() {
		//db clean
		try {
			DBClean.deleteEmailFromDB("email=Den");
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		User user = new User();

		user.setFirstNameField("Vasya");
		user.setMiddleNameField("Vasiliy");
		user.setLastNameField("Vasilievich");
		user.setEmailField("Den" + (int) (Math.random() * 10000 + 1)
				+ "@mail.ru");
		user.setPasswordField("123123123");
		user.setPasswordRepeatField("123123123");
		user.setRole("student");
		user.setSchool("дн");

		$(firstName).type(user.getFirstNameField());
		$(middleName).type(user.getMiddleNameField());
		$(lastName).type(user.getLastNameField());
		$(email).type(user.getEmailField());
		$(password).type(user.getPasswordField());
		$(passwordRepeat).type(user.getPasswordRepeatField());
		Actions builder = new Actions(getDriver());
		builder.moveToElement(schoolList).click().build().perform();
		$(getDriver().findElement(By.xpath("//*[@id='select2-drop']//input")))
				.type(user.getSchool());
		waitForAnyTextToAppear(user.getSchool());

		$(getDriver().findElement(By.xpath("//*[@id='select2-drop']//input")))
				.sendKeys(Keys.ENTER);

		$(recaptchaIgnore).click();
		$(rulesAgree).click();
	}

	public void clickSignUp() {

		$(signUpButton).click();
		try {
			Thread.sleep(1000);
		} catch (InterruptedException e) {

			e.printStackTrace();
		}
	}

	public String getConfirmationMessage() {
		return confirmMessage.getText();
	}

	public int getNumberOfWarrnings() {
		System.out.println("List siz is: "+listOfWarrnings.size());
		return listOfWarrnings.size();
	}

	public boolean isResendButtonExist() {
		return element(resendButton).isVisible();

	}

	public void enterCredentialsFromCSV(String firstNameField,
			String middleNameField, String lastNameField, String emailField,
			String passwordField, String passwordRepeatField,
			String studentRoleField, String schoolField) {

		$(firstName).sendKeys(firstNameField);
		$(middleName).sendKeys(middleNameField);
		$(lastName).sendKeys(lastNameField);
		// $(email).sendKeys(emailField);
		$(email).sendKeys(
				"Den" + (int) (Math.random() * 10000 + 1) + "@mail.ru");
		$(password).sendKeys(passwordField);

		$(passwordRepeat).sendKeys(passwordRepeatField);

		// choose different roles
		if (studentRoleField.equals("student")) {

		} else if (studentRoleField.equals("coach")) {
			userrole.get(1).click();

		} else if (studentRoleField.equals("coordinator_ukraine")) {
			coordinatorRole.click();
			coordinatorList.get(0).click();
		} else if (studentRoleField.equals("coordinator_region")) {

			coordinatorRole.click();
			coordinatorList.get(1).click();
		} else if (studentRoleField.equals("coordinator_state")) {

			coordinatorRole.click();
			coordinatorList.get(2).click();
		}

		Actions builder = new Actions(getDriver());

		builder.moveToElement(schoolList).click().build().perform();
		$(getDriver().findElement(By.xpath("//*[@id='select2-drop']//input")))
				.type("дн");
		waitForAnyTextToAppear("дн");

		$(getDriver().findElement(By.xpath("//*[@id='select2-drop']//input")))
				.sendKeys(Keys.ENTER);

		$(recaptchaIgnore).click();
		$(rulesAgree).click();
		$(signUpButton).click();
		try {
			Thread.sleep(2000);
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		if (firstNameField != null) {
			getDriver().get("http://acc.icpc.org.ua/auth/signup");
		} else {
			getDriver().close();
		}

	}

	public void enterNotUniqueCredentials() {

		User user = new User();

		user.setFirstNameField("Vasya");
		user.setMiddleNameField("Vasiliy");
		user.setLastNameField("Vasilievich");
		user.setEmailField("stuone@mailinator.com");
		user.setPasswordField("1253456");
		user.setPasswordRepeatField("1253456");
		user.setRole("student");
		user.setSchool("дн");

		$(firstName).type(user.getFirstNameField());
		$(middleName).type(user.getMiddleNameField());
		$(lastName).type(user.getLastNameField());
		$(email).type(user.getEmailField());
		$(password).type(user.getPasswordField());
		$(passwordRepeat).type(user.getPasswordRepeatField());
		Actions builder = new Actions(getDriver());
		builder.moveToElement(schoolList).click().build().perform();
		$(getDriver().findElement(By.xpath("//*[@id='select2-drop']//input")))
				.type(user.getSchool());
		waitForAnyTextToAppear(user.getSchool());

		$(getDriver().findElement(By.xpath("//*[@id='select2-drop']//input")))
				.sendKeys(Keys.ENTER);

		$(recaptchaIgnore).click();
		$(rulesAgree).click();
	}

	public String getErrorDBMessage() {
		waitForAllTextToAppear("Email is not unique in DB.");
		return errorDBmessage.getText();
	}

	public void userEnterAllCorrectCredentials() {
		//clean DB
		try {
			DBClean.deleteEmailFromDB("email=myicpc");
		} catch (Exception e) {
			
			e.printStackTrace();
		}
		User user = new User();

		user.setFirstNameField("Олег");
		user.setMiddleNameField("Шевченко");
		user.setLastNameField("Семенович");
		user.setEmailField("myicpctest@gmail.com");
		user.setPasswordField("123myicpctest");
		user.setPasswordRepeatField("123myicpctest");
		user.setRole("student");
		user.setSchool("дн");

		$(firstName).type(user.getFirstNameField());
		$(middleName).type(user.getMiddleNameField());
		$(lastName).type(user.getLastNameField());
		$(email).type(user.getEmailField());
		$(password).type(user.getPasswordField());
		$(passwordRepeat).type(user.getPasswordRepeatField());
		Actions builder = new Actions(getDriver());
		builder.moveToElement(schoolList).click().build().perform();
		$(getDriver().findElement(By.xpath("//*[@id='select2-drop']//input")))
				.type(user.getSchool());
		waitForAnyTextToAppear(user.getSchool());

		$(getDriver().findElement(By.xpath("//*[@id='select2-drop']//input")))
				.sendKeys(Keys.ENTER);

		$(recaptchaIgnore).click();
		$(rulesAgree).click();
	}

	public void checkGmailAndGetLink(String email, String password) {

		try {
			Thread.sleep(5000);
		} catch (InterruptedException e) {
			System.out.println("Time out!");
			e.printStackTrace();
		}
		getDriver().get(
				CheckGmail.waitConfirmEmailLink(email, password));
	}


	public String getEmailVirifiedMessage(){
		return emailVerifiedMessage.getText();
	}
	public void clickOnLoginLink(){
		
		linkToLoginPage.click();
		waitForAbsenceOf(".panel-body>a");
	}
	public boolean clickResndButton(){
		//delete an email before resend
		CheckGmail.deleteConfirmationMail(Vars.GMAIL_EMAIL, Vars.GMAIL_PASS);
		waitABit(2000);
		$(resendButton).click();
		waitABit(500);
		//return CheckGmail.checkConfirmationMail(Vars.GMAIL_EMAIL, Vars.GMAIL_PASS);
		return CheckGmail.waitBeforeConfirmEmailLinkCheck(Vars.GMAIL_EMAIL, Vars.GMAIL_PASS);
	}
	public void clickOnBaylorButton(){
		$(baylorImportButton).click();
	}
	public String getEmailFromField(){
		System.out.println(email.getAttribute("value"));
		return $(email).getAttribute("value");
	}
	
}
