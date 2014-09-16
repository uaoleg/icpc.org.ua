package com.dataart.jbehave;

import com.dataart.pages.LoginPage;
import com.dataart.steps.UserDocsSteps;
import com.dataart.steps.UserImportSteps;
import com.dataart.steps.UserLoginSteps;
import com.dataart.steps.UserNewsSteps;
import com.dataart.steps.UserPasswordResetSteps;
import com.dataart.steps.UserProfileSteps;
import com.dataart.steps.UserQASteps;
import com.dataart.steps.UserRegistrationSteps;
import com.dataart.steps.UserTeamSteps;
import com.dataart.utils.CheckGmail;
import com.dataart.utils.Vars;
import java.awt.AWTException;

import java.io.IOException;
import java.net.MalformedURLException;
import java.util.concurrent.TimeUnit;

import junit.framework.Assert;
import net.thucydides.core.annotations.ManagedPages;
import net.thucydides.core.annotations.Steps;
import net.thucydides.core.pages.Pages;
import static net.thucydides.core.steps.StepData.withTestDataFrom;
import net.thucydides.core.steps.StepFactory;
import static net.thucydides.core.webdriver.ThucydidesWebDriverSupport.getDriver;

import org.jbehave.core.annotations.BeforeScenario;
import org.jbehave.core.annotations.Given;
import org.jbehave.core.annotations.Then;
import org.jbehave.core.annotations.When;
import org.openqa.selenium.By;
import org.openqa.selenium.interactions.Actions;

public class GeneralSteps {

	@ManagedPages
	Pages pages;

	@Steps
	UserRegistrationSteps userreg;

	@Steps
	UserLoginSteps user;

	@Steps
	UserImportSteps userimport;

	@Steps
	UserPasswordResetSteps userpasswordreset;

	@Steps
	UserProfileSteps userprofile;

	@Steps
	UserNewsSteps usernews;

	@Steps
	UserQASteps userqa;

	@Steps
	UserDocsSteps userdoc;
	@Steps
	UserTeamSteps userteam;

	@Given("the user is on the Login page")
	public void givenTheUserIsOnTheLoginPage() {
		user.is_on_the_login_page();

	}

	@BeforeScenario
	public void setUp() {
		// Actions builder = new Actions(getDriver());
		// getDriver().manage().timeouts().implicitlyWait(10, TimeUnit.SECONDS);
		// builder.moveToElement(getDriver().findElement(By.xpath("//li[@class='dropdown dropup language-select']"))).build().perform();
		// builder.moveToElement(
		// getDriver()
		// .findElement(
		// By.xpath("//*[contains(@class, 'dropdown dropup language-select')]//*[@data-lang='en']"))).click().perform();
		pages.getDriver().manage().deleteAllCookies();
		pages.getDriver().manage().window().maximize();
		pages.getDriver().manage().timeouts()
				.implicitlyWait(15, TimeUnit.SECONDS);
		CheckGmail.deleteConfirmationMail(Vars.GMAIL_EMAIL, Vars.GMAIL_PASS);

	}

	@When("the user enters name: $userName and password: $password and click the 'login' button")
	public void whenTheUserEnterLoginAndPassword(String userName,
			String password) {
		user.enter(userName, password);                
		user.click_login_button();

	}

	@Then("user should see a page title $message")
	public void userShouldSeeAPageTitleMessage(String message) {

		user.should_see_a_page_title(message);

	}

	@Then("user should see invalid flash message $message")
	public void userShouldSeeAFlashMessage(String message) {

		user.should_see_invalid_flash_message(message);

	}

	@When("the user click the login button")
	public void clickLoginButton() {

		user.click_login_button();
	}

	@Then("user loged out")
	public void clickLogoutLink() {

		user.click_logout_link();
	}

	@When("the user enters name: $username and click the 'login' button")
	public void userEntersLoginAndClicksButton(String userName) {
		user.enter(userName, "");
		user.click_login_button();
	}

	@When("the user enters password: $password and click the 'login' button")
	public void userEntersPasswordAndClicksButton(String password) {
		user.enter("", password);
		user.click_login_button();
	}

	@When("the user click on the Register now link")
	public void the_user_click_on_the_Register_now_link() {
		user.click_on_the_Register_now_link();
	}

	@When("the user click on the swich language button and choose $Русский")
	public void userClickOnTheSwichLanguageButtonAndChoose(String language) {

		user.click_on_the_swich_language_button_and_choose(language);
	}

	@Then("user should see the header $header")
	public void userShouldSeeTheHeader(String header) {

		user.user_should_see_the_header(header);
	}

	@When("the user click on the DA link")
	public void userClicksOnDALink() {
		user.user_clicks_on_DA_link();
	}

	@Then("user should be sent to DataArt page")
	public void verifyDAPage() {
		user.verify_DA_page();
	}

	@When("the user click on the GitHub link")
	public void userClicksOnGitHubLink() {
		user.user_clicks_on_GitHub_link();
	}

	@Then("user should be sent to GitHub's project page")
	public void verifyGithubPage() {
		user.verify_GitHub_page();
	}

	@When("the user click on the Twitter link")
	public void userClicksOnTwitterLink() {
		user.user_clicks_on_Twitter_link();
	}

	@Then("user should be sent to Twitter's project page")
	public void verifyTwitterPage() {
		user.verify_Twitter_page();
	}

	@Then("user should see correct project's email")
	public void verifyProjectEmail() {
		user.verify_project_email();
	}

	@Given("the user is on the Registration page")
	public void givenTheUserIsOnTheRegisterPage() {
		userreg.is_on_the_registration_page();

	}

	@When("enter all correct credentials")
	public void enterAllCorrectCredentials() {
		userreg.enter_all_correct_credentials();

	}

	@When("user click Sign up")
	public void clickSignUp() {
		userreg.click_Sign_up();
	}

	@Then("user should see the E-mail confirmation message $message")
	public void userShouldSeeTheEMailConfirmationMessage(String message) {

		userreg.user_should_see_the_E_mail_confirmation_message(message);
	}

	@Then("user should see $7 warrning messages about blank fields")
	public void userShouldSeeTheWarrningMessagesAboutBlankFields(int number) {

		userreg.user_should_see_the_warrning_messages_about_blank_fields(number);
	}

	@Then("user should see the Resend email button")
	public void userShouldSeeTheResendEmailButton() {

		userreg.user_should_see_the_Resend_email_button();
	}

	@When("enter all correct credentials form file source")
	public void userEnterAllCorrectCredentialsFormFileSource() throws Throwable {
		StepFactory factory = new StepFactory(pages);
		withTestDataFrom("/RegistrationData.csv").usingFactory(factory)
				.run(userreg).enter_all_correct_credentials_form_file_source();
		// userreg.user_should_see_the_Resend_email_button();
	}

	@When("enter not unique credentials")
	public void userEnterNotUniqueCredentials() {

		userreg.enter_not_unique_credentials();
	}

	@Then("user should see error message $message")
	public void userShouldSeeErrorMessage(String message) {
		userreg.user_should_see_DBerror_message(message);
	}

	@When("user enter all correct credentials")
	public void userEnterAllCorrectCredentials() {
		userreg.user_enter_all_correct_credentials();
	}

	@When("user check his emailbox $email $password and click on the confirmation link")
	public void userCheckHisEmailbox(String email, String password) {
		userreg.user_check_his_emailbox_and_click_on_the_confirmation_link(
				email, password);
	}

	@Then("user should see the verified E-mail confirmation message $message")
	public void userShouldSeeTheVerifiedEmailConfirmationMessage(String message) {
		userreg.user_should_see_the_verified_Email_confirmation_message(message);
	}

	@When("user click on go to login page link")
	public void userClickOnGoToLoginPageLink() {
		userreg.user_click_on_go_to_login_page_link();
	}

	@Then("user click on Resend email button and check email")
	public void user_click_Sign_up() {
		userreg.user_click_on_Resend_email_button();
	}

	@When("user click on the button for import from baylor website")
	public void userClickOnTheButtonForImportFromBaylorWebsite() {
		userreg.user_click_on_the_button_for_import_from_baylor_website();
	}

	@When("user close the baylor popup window")
	public void userCloseThePopupWindow() {
		userimport.user_close_the_baylor_popup_window();
	}

	@Then("user should be on the registration page")
	public void userShouldBeOnTheRegistrationPage() {
		userreg.user_should_be_on_the_registration_page();
	}

	@When("user enter credentials $email $password")
	public void user_enter_correct_credentials(String email, String password) {
		userimport.user_enter_credentials(email, password);
	}

	@When("click import button")
	public void userClickImportButton() {
		userimport.click_import_button();
	}

	@Then("user should see that all fields are filled $data")
	public void userShouldSeeThatAllFieldsAreFilled(String data) {
		userreg.user_should_see_that_all_fields_are_filled(data);

	}

	@Then("user will be able see error message $message")
	public void userShouldSeeBaylorErrorMessage(String message) {
		userimport.user_should_see_error_message_on_popup(message);
	}

	@When("the user click on the ? link")
	public void theUserClickOnTheForgetPasswordlink() {
		user.the_user_click_on_the_forget_password_link();
	}

	@Given("the user is on the Password reset page")
	public void givenTheUserIsOnThePasswordResetPage() {
		userpasswordreset.is_user_on_the_password_reset_page();

	}

	@When("user click on Reset password button")
	public void userClickOnResetPasswordButton() {
		userpasswordreset.user_click_on_reset_password_button();
	}

	@Then("user should see email warrning message $message")
	public void userShouldSeeEmailWarrningMessage(String message) {
		userpasswordreset.user_should_see_email_warrning_message(message);
	}

	@Then("user should see capcha warrning message $message")
	public void userShouldSeeCapchaWarrningMessage(String message) {
		userpasswordreset.user_should_see_capcha_warrning_message(message);
	}

	@When("user enter an email $email")
	public void userEnterAnEmail(String email) {
		userpasswordreset.user_enter_email(email);
	}

	@Given("the user is signed in with $userName $password")
	public void theUserIsSignedInWith(String userName, String password) {

		user.the_user_is_signed_in_with(userName, password);
	}

	@When("user move to general info tab")
	public void userMoveToGeneralInfoTab() {
		userprofile.user_move_to_general_info_tab();
	}

	@When("user enter current password $password")
	public void userEnterCurrentPassword(String password) {
		userprofile.user_enter_current_password(password);
	}

	@When("user enter new password $password")
	public void userEnterNewPassword(String password) {
		userprofile.user_enter_new_password(password);

	}

	@When("user repeate new password $password")
	public void userRepeateNewPassword(String password) {
		userprofile.user_repeate_new_password(password);
	}

	@When("user click change password button")
	public void userClickChangePassword() {
		userprofile.user_click_change_password_button();
	}

	@Then("user should see sucess message $message")
	public void userShouldSeeSucessMessage(String message) {
		userprofile.user_should_see_sucess_message(message);
	}

	@Then("the user changes the password back")
	public void theUserChangesThePasswordBack() {
		userprofile.the_user_changs_password_back();
	}

	@Then("user should see error field message $message")
	public void userShouldSeeErorFieldMessage(String message) {
		userprofile.user_should_see_error_field_message(message);
	}

	@When("user go to news menu")
	public void userGoToNewsMenu() {
		usernews.user_go_to_news_menu();
	}

	@When("user click on add news button")
	public void userClickOnAddNewsButton() {
		usernews.user_click_on_add_news_button();
	}

	@When("user enter the title")
	public void userEnterTheTitle() {
		usernews.user_enter_the_title();
	}

	@When("user enter the body and click save news")
	public void userEnterTheBody() {
		usernews.user_enter_enter_the_body();
	}

	@When("user click on publish button")
	public void userClickOnPublishButton() {
		usernews.user_click_on_publish_button();
	}

	@Then("user should see created news on the top of news page")
	public void userShouldSeeCreatedNewsOnTheTopOfNewsPage() {
		usernews.user_should_see_created_news_on_the_top_of_news_page();
	}

	@When("user choose a picture to load $name")
	public void userChooseAPictureToLoad(String name) {
		usernews.user_choose_a_picture(name);
	}

	@Then("user should not see published news on the top of news page")
	public void userShouldNotSeePublishedNewsOnTheTopOfNewsPage() {
		usernews.user_should_not_see_published_news_on_the_top_of_news_page();
	}

	@When("user click on hide button on the news page")
	public void userClickOnHideButtonOnTheNewsPage() {
		usernews.user_click_on_hide_button_on_the_news_page();
	}

	@When("user click on publish button on the news page")
	public void userClickOnPublishButtonOnTheNewsPage() {
		usernews.user_click_on_publish_button_on_the_news_page();
	}

	@When("user click preview link")
	public void userCclickPreviewLink() {
		usernews.user_click_preview_link();

	}

	@Then("user should see a new page with news title")
	public void userShouldSeeAnewPageWithNewsTitle() {
		usernews.user_should_see_a_new_page_with_news_title();
	}

	@When("user click on the first edit link")
	public void userClickOnTheFirstEditLink() {
		usernews.user_click_on_the_first_edit_link();
	}

	@When("user click on the news title")
	public void userClickOnTheNewsTitle() {
		usernews.user_click_on_the_news_title();
	}

	@Then("user should see a title and news body")
	public void userShouldSeeATitleAndNewsBody() {
		usernews.user_should_see_a_title_and_news_body();
	}

	@When("user go to additional tab $tab")
	public void userGoToAdditionalTab(String tab) {
		userprofile.user_go_to_additional_tab(tab);
	}

	@When("user enter additional info")
	public void userEnterAdditionalInfo() {
		userprofile.user_enter_additional_info();
	}

	@When("click save button")
	public void clickSaveButton() {
		userprofile.click_save_button();
	}

	@When("user go to user profile")
	public void userGoToUserProfile() {
		user.user_go_to_user_profile();
	}

	@Then("user should see filled fields")
	public void user_should_see_filled_fields() {
		userprofile.user_should_see_filled_fields();
	}

	@Then("user should see warrning messages about blank fields")
	public void userShouldSeeWarrningMessagesAboutBlankFields() {
		userprofile.user_should_see_warrning_messages_about_blank_fields();
	}

	@Given("the user is on the QA page")
	public void givenTheUserIsOnTheQaPage() {
		userqa.is_on_the_qa_page();

	}

	@When("user click on manage tabs button")
	public void userClickOnManageTabsButton() {
		userqa.user_click_on_manage_tabs_button();
	}

	@When("user click on create tab button")
	public void userClickOnCreateTabButton() {
		userqa.user_click_on_create_tab_button();
	}

	@When("user enter title field")
	public void userEnterTitleField() {
		userqa.user_enter_title_field();
	}

	@When("user enter description field")
	public void userEnterDescriptionField() {
		userqa.user_enter_description_field();
	}

	@When("user click save button")
	public void userClickSaveButton() {
		userqa.user_click_save_button();

	}

	@Then("user should see a new tag with name and description")
	public void userShouldSeeANewTagWithNameAndDescription() {
		userqa.user_should_see_a_new_tag_with_name_and_description();
	}

	@Then("user click on delete button and should see that tag is deleted")
	public void userClickOnDeleteButton() {
		userqa.user_click_on_delete_button();
	}

	@When("user click edit button")
	public void userClickEditButton() {
		userqa.user_click_edit_button();
	}

	@Then("user should see a new tag with name")
	public void userShouldSeeANewTagWithName() {
		userqa.user_should_see_a_new_tag_with_name();
	}

	@Then("user should see warrning message $message")
	public void userShouldSeeWarrning(String message) {

	}

	@When("user clicks on the Docs link and chooses Regulations item")
	public void userClicksontheDocsLinkandChoosesRegulationItem() {
		userdoc.click_Docs_and_choose_Regulations();
	}
        

	@Then("user is on the Regulations Docs page")
	public void userisontheRegulationsDocsPage() {
		userdoc.is_on_the_Regulation_Page();
	}

	@When("user clicks on the Docs link and chooses Guidance item")
	public void userClicksontheDocsLinkandChoosesGuidanceItem() {
		userdoc.click_Docs_and_choose_Guidance();
	}

	@Then("user is on the Guidance Docs page")
	public void userisontheGuidanceDocsPage() {
		userdoc.is_on_the_Guidance_Page();
	}

	@Then("user clicks on the top document's title")
	public void userClicksontheTopDocumentLink() throws AWTException {
		userdoc.first_doc_link_click();
	}

	@Then("user is able to download that document")
	public void userisAbletoDownloadDoc() throws MalformedURLException,
			IOException {
		Assert.assertEquals(200, userdoc.is_doc_avaible_by_URL());
	}

	@Then("user should be sent to Login page")
	public void userisonLoginPage() {
		user.should_see_a_page_title(Vars.LOGIN_PAGE_TITLE);
	}

	@When("user click on ask question button")
	public void userClickOnAskQuestionButton() {
		userqa.user_click_on_ask_question_button_nowait();
	}

	@When("user enter title")
	public void userEnterTitle() {
		userqa.user_enter_the_title();
	}

	@When("user enter body")
	public void userEnterBody() {
		userqa.user_enter_body();
	}

	@When("user choose teg $registration")
	public void userChooseTegRegistration(String tag) {
		userqa.user_choose_teg_registration(tag);
	}

	@When("user click save question button")
	public void userClickSaveQuestionButton() {
		userqa.user_click_save_question_button();
	}

	@Then("user should see created question with correct title,body,tag")
	public void userShouldSeeCreatedQuestion() {
		userqa.should_see_created_question();
	}

	@Then("user should see $number warrning messages")
	public void userShouldSeeTheWarrningMessages(int number) {
		userqa.user_should_see_the_warrning_messages(number);
	}

	@When("user click post answer button")
	public void userClickPostAnswerButton() {
		userqa.user_click_post_answer_button();
	}

	@Then("user should see posted answer")
	public void userShouldSeePostedAnswer() {
		userqa.user_should_see_posted_answer();
	}

	@When("user click on the first question")
	public void userClickOnTheFirstQuestion() {
		userqa.user_click_on_the_first_question();
	}

	@When("user click Edit link to edit question")
	public void userClickEditLinkToEditQuestion() {
		userqa.user_click_Edit_link_to_edit_question();
	}

	@Given("the user is on the Teams page")
	public void givenTheUserIsOnTheTeamsPage() {

		userteam.the_user_is_on_the_teams_page();

	}

	@When("user click on create a new team button")
	public void userClickOnCreateAnewTeamButton() {
		userteam.user_click_on_create_a_new_team_button();
	}
        
        @Then("user clicks on the Upload Doc button in Regulation section")
	public void userClickOnUploadRegulationDocButton() {
		userdoc.upload_regulation_doc_button_click();
	}
        
        @Then("user clicks on the Upload Doc button in Guidance section")
	public void userClickOnUploadGuidanceDocButton() {
		userdoc.upload_guidance_doc_button_click();
	}
        
        @Then("user fills all the fields")
	public void userFillsAllTheFields() {
		userdoc.fills_all_the_fields();
	}
        
        @Then("user chooses file and uploads it")
	public void userChoosesFileandUploadsIt() throws AWTException {
		userdoc.upload_file_and_click_Save_Document_button();
	}
        
        @Then("user is able to see document in the list")
	public void seeifDocumentIsintheList() {
		userdoc.is_document_in_the_list();
	}
        
        @Then("user clicks on Delete button near the first doc in the list")
	public void userClicksOnDeleteButton() {
		userdoc.delete_first_doc_button_click();
	}
        
        @Then("user confirms deleting")
	public void userConfirmsDeleting() {
		userdoc.cofirm_deleting_of_the_doc();
	}
        
        @Then("user can see that document is deleted from the list")
	public void userCanSeeNoDocInList() {
		userdoc.is_document_not_in_the_list();
	}
        
        @Then("user clicks on the Edit button near the first document in the list")
	public void userClicksOnTheEditButton() {
		userdoc.edit_first_doc_button_click();
	}
        
        @Then("user fills all fields with new correct information")
	public void userFillsAllTheFieldsWithNewInformation() {
		userdoc.fills_all_the_fields_with_new_information();
	}
        
        @Then("user chooses Guidance item on dropdown list")
	public void userchoosesGuidanceItemInDocTypeMenu() {
		userdoc.click_Docs_and_choose_Guidance_in_Edit_Menu();
	}
        
        @Then("user chooses Regulations item on dropdown list")
	public void userchoosesRegulationsItemInDocTypeMenu() {
		userdoc.click_Docs_and_choose_Regulations_in_Edit_Menu();
	}
        
        @Then("user clicks on Save Document button")
	public void userClicksonSaveDocumentButton() {
		userdoc.click_Save_Document_Button();
	}
        
        @Then("user can see document with new info in fields in the list")
	public void userCanSeeEdittedDocInTheList() {
		userdoc.find_Editted_Doc_in_the_LIST();
	}
        
        
        

}
